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
            'sprint' => new SprintResource($this->whenLoaded('currentSprint')),
            'developer' => new DeveloperResource($this->whenLoaded('developer')),
            'status' => $this->status,
            'status_text' => $this->status->label(),
            'duration' => $this->duration,
            'difficulty' => $this->difficulty,
            'humanized_due_date' => optional($this->due_date)->format('d/m/Y H:i'),
        ];
    }
}
