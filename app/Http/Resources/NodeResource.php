<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class NodeResource extends JsonResource
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
            'name' => $this->name,
            'pic_url' => $this->pic_url ? Storage::url($this->pic_url) : null,
            'forward_id' => $this->forward_id,
            'back_id' => $this->back_id,
            'left_id' => $this->left_id,
            'right_id' => $this->right_id,
            'node_type' => $this->node_type,
            'department' => $this->department,
            'room_name' => $this->room_name,
            'teacher_name' => $this->teacher_name,
            'teacher_image' => $this->teacher_image ? Storage::url($this->teacher_image) : null,
            'dialogue_text' => $this->dialogue_text,
            'project_images' => collect($this->project_images ?? [])->all(),
            'start' => $this->start,
        ];
    }
}
