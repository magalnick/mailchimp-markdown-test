<?php

namespace App\Http;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response as BaseResponse;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

/**
 * Class Response
 *
 * Follows JSON API specification: http://jsonapi.org/format
 *
 * @package App\Api
 */

class Response extends BaseResponse
{
    /**
     * @param array $data
     * @param int $code
     * @return BaseResponse
     *
     * Note that the return array must be associative (or empty). If it's a
     * standard indexed array, final results will be distorted as the
     * "status" key is added.
     */
    public static function success(array $data = [], $code = 0): BaseResponse
    {
        $ret['data']   = $data;
        $ret['status'] = 'success';
        return response($ret, self::validateCode($code));
    }

    /**
     * @param string $error
     * @param int $code
     * @return BaseResponse
     */
    public static function error($error = '', $code = 0): BaseResponse
    {
        if (!is_string($error) || trim($error) === '') {
            return self::error('No error specified', $code);
        }
        $error = trim($error);

        return response(
            [
                'error' => $error,
                'status' => 'error',
            ],
            self::validateCode($code)
        );
    }

    /**
     * @param $code
     * @param int $default
     * @return int
     */
    protected static function validateCode($code, $default = 0): int
    {
        $default = intval($default);
        if (!array_key_exists($default, self::$statusTexts)) {
            $default = self::HTTP_OK;
        }
        if ($default === 0) {
            $default = self::HTTP_OK;
        }

        $code = intval($code);
        if (!array_key_exists($code, self::$statusTexts)) {
            $code = $default;
        }

        return $code;
    }
}
