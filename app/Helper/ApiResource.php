<?php

use Illuminate\Http\Resources\Json\JsonResource;

class ApiResource
{
    public static function setSchema(JsonResource $data, string $masseg , mixed $code, $header = [])
    {
        return response()->json([
            "status" => $code,
            "message" => $masseg,
            "data" => $data,
         ], $code, $header);
    }
}
