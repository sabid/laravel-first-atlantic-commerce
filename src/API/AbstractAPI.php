<?php

namespace Jordanbain\FirstAtlanticCommerce\API;

use App\Exceptions\InvalidParameterException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Client;

class AbstractAPI
{
    private const HTTPS = 'https://';
    private const PRODUCTION = 'gateway.ptranz.com/api/', STAGING = 'staging.ptranz.com/api/';

    protected ?string $powerTranzID;
    protected ?string $powerTranzPassword;
    protected bool $isStaging;

    protected bool $authenticationRequired;

    public function __construct(bool $isStaging, ?string $powerTranzID = null, ?string $powerTranzPassword = null)
    {
        $this->isStaging = $isStaging;
        $this->authenticationRequired = $powerTranzID !== null && $powerTranzPassword !== null;
        $this->powerTranzID = $powerTranzID;
        $this->powerTranzPassword = $powerTranzPassword;
    }

    /**
     * Http client instance with headers
     *
     * @param array $headers
     * @return PendingRequest
     */
    public function Http(array $headers)
    {
        /*
        $response = Http::withHeaders([
            'X-First' => 'foo',
            'X-Second' => 'bar'
        ])
        */

        return Http::
            //->dd()
            withHeaders(
                Arr::collapse([
                    $headers,
                    $this->authenticationRequired ?
                        [
                            'PowerTranz-PowerTranzId' => $this->powerTranzID,
                            'PowerTranz-PowerTranzPassword' => $this->powerTranzPassword
                        ]
                        :
                        []
                ])
            );
    }

    /**
     * Send GET request
     *
     * @param string $path
     * @param array $params
     * @param array $rules
     * @param array $headers
     * @return Collection
     */
    public function get(string $path, array $params, array $headers, array $rules = [])
    {
        $validated = $this->validation($path, $params, $rules);

        return $this->decodeResponse(
           $this->Http($headers)->get($validated['url'], $validated['params'])
        );
    }

    /**
     * Send post request
     *
     * @param string $path
     * @param array $params
     * @param array $rules
     * @param array $headers
     * @return Collection
     * @throws GuzzleException
     */
    public function post(string $path, array $params, array $headers, array $rules = [])
    {
        $validated = $this->validation($path, $params, $rules);

        //dd($validated);

        return $this->decodeResponse(
            $this->Http($headers)->post($validated['url'], $validated['params'])
        );
    }

    /**
     * Decode response or return response object on error
     *
     * @param Response $response
     * @return Collection
     * @throws ResponseException
     */
    private function decodeResponse(Response $response)
    {
        if ($response->failed()) {
            $response->throw();
            //dd($response);
        }

        //dd($response->body());

        return $response->collect();
    }

    /**
     * Validate parameters
     *
     * @param string $path
     * @param array $params
     * @param array $rules
     * @return array
     * @throws InvalidParameterException
     */
    private function validation(string $path, array $params, array $rules)
    {

        //dd($rules);

        $url = ($this->isStaging) ? self::STAGING : self::PRODUCTION;

        if (empty($rules)) return ['url' => self::HTTPS . $url . $path, 'params' => $params];

        $validator = Validator::make($params, $rules);

        if ($validator->fails()) throw new InvalidParameterException(implode("; ", $validator->errors()->all()), 1);

        return [
            'url' => self::HTTPS . $url . $path,
            'params' => $validator->validated()
        ];
    }
}
