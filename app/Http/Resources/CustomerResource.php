<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if (is_null($this->resource) || (is_array($this->resource) && empty($this->resource))) {
            return [];
        }

        return [
            "name" => $this->name,
            "email" => $this->email
        ];
    }
}
