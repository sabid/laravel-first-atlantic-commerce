<?php

namespace Jordanbain\FirstAtlanticCommerce\API;

use App\Exceptions\InvalidParameterException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class AbstractAPI
{
    private const HTTPS = 'https://';
    private const PRODUCTION = 'staging.ptranz.com/api/', STAGING = 'TBD.ptranz.com/api/';


    protected string $powerTranzID;
    protected string $powerTranzPassword;
    protected bool $isStaging;

    public function __construct(string $powerTranzID, string $powerTranzPassword, bool $isStaging)
    {
        $this->powerTranzID = $powerTranzID;
        $this->powerTranzPassword = $powerTranzPassword;
        $this->isStaging = $isStaging;
    }

    /**
     * Http client instance with headers
     *
     * @param array $headers
     * @return PendingRequest
     */
    public function Http(array $headers)
    {
        return Http::withHeaders(
            Arr::collapse([
                $headers,
                [
                    'PowerTranz-PowerTranzId' => $this->powerTranzID,
                    'PowerTranz-Password' => $this->powerTranzPassword,
                ],
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
            SELF::Http($headers)->get($validated['url'], $validated['params'])
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
     */
    public function post(string $path, array $params, array $headers, array $rules = [])
    {
        $validated = $this->validation($path, $params, $rules);

        return $this->decodeResponse(
            SELF::Http($headers)->post($validated['url'], $validated['params'])
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
        if ($response->failed()) $response->throw();
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
        $url = ($this->isStaging) ? SELF::STAGING : SELF::PRODUCTION;

        if (empty($rules)) return ['url' => SELF::HTTPS . $url . $path, 'params' => $params];

        $validator = Validator::make($params, $rules);

        if ($validator->fails()) throw new InvalidParameterException(implode("; ", $validator->errors()->all()), 1);

        return [
            'url' => SELF::HTTPS . $url . $path,
            'params' => $validator->validated()
        ];
    }
}
