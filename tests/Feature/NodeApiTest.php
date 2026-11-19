<?php

use App\Models\Node;

test('the public node endpoint returns the graph data needed by the tour', function () {
    $startNode = Node::query()->create([
        'name' => 'entrance',
        'pic_url' => 'pictures/entrance.webp',
        'start' => true,
    ]);
    $nextNode = Node::query()->create([
        'name' => 'hallway',
        'pic_url' => 'pictures/hallway.webp',
        'back_id' => $startNode->id,
    ]);
    $startNode->update(['forward_id' => $nextNode->id]);

    $this->getJson(route('api.nodes.index'))
        ->assertOk()
        ->assertJsonPath('data.0.name', 'entrance')
        ->assertJsonPath('data.0.forward_id', $nextNode->id)
        ->assertJsonPath('data.0.start', true)
        ->assertJsonPath('data.0.pic_url', '/storage/pictures/entrance.webp');
});
