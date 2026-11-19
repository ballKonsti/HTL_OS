<?php

use App\Livewire\Admin\Manager;
use App\Models\Node;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

test('the node editor deletes the selected node and its image', function () {
    Storage::fake('public');
    Storage::disk('public')->put('pictures/entrance.webp', 'image content');

    $node = Node::query()->create([
        'name' => 'entrance',
        'pic_url' => 'pictures/entrance.webp',
    ]);

    Livewire::test(Manager::class)
        ->call('edit', $node->id)
        ->call('deleteNode', $node->id)
        ->assertSet('editingId', null);

    $this->assertDatabaseMissing('nodes', ['id' => $node->id]);
    Storage::disk('public')->assertMissing('pictures/entrance.webp');
});
