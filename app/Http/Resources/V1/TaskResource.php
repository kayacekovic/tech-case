<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'developer' => new DeveloperResource($this->whenLoaded('developer')),
            'status' => $this->status,
            'status_text' => $this->status_text,
            'duration' => $this->duration,
            'difficulty' => $this->difficulty,
            'humanized_created_at' => $this->created_at->format('d.m.Y'),
        ];
    }
}
