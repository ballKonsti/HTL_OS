<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'pic_url',
    'forward_id',
    'back_id',
    'left_id',
    'right_id',
    'node_type',
    'department',
    'room_name',
    'teacher_name',
    'teacher_image',
    'dialogue_text',
    'project_images',
    'name',
])]

class Node extends Model
{
    protected function casts(): array
    {
        return [
            'project_images' => 'array',
        ];
    }

    public function forward(): BelongsTo
    {
        return $this->belongsTo(Node::class, 'forward_id');
    }

    public function back(): BelongsTo
    {
        return $this->belongsTo(Node::class, 'back_id');
    }

    public function left(): BelongsTo
    {
        return $this->belongsTo(Node::class, 'left_id');
    }

    public function right(): BelongsTo
    {
        return $this->belongsTo(Node::class, 'right_id');
    }
}
