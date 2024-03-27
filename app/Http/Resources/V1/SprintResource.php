<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SprintResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $title = $this->name.' '.$this->order_num;
        if ($this->is_active) {
            $title .= ' (Active)';
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'title' => $title,
        ];
    }
}
