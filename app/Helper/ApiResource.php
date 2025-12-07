<?php

namespace App\Helper;
use Illuminate\Http\Resources\Json\JsonResource;

class ApiResource
{
    /**
     * Create a standardized JSON response.
     *
     * @param JsonResource $data    The resource data to be returned.
     * @param string       $message The response message.
     * @param int          $status  HTTP status code.
     * @param array        $header  Additional headers.
     * @return \Illuminate\Http\JsonResponse
     */
    public static function setSchema(JsonResource $data, string $message, int $status, array $header = []): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            "status" => $status,
            "message" => $message,
            "data" => $data,
        ], $status, $header);
    }
}
