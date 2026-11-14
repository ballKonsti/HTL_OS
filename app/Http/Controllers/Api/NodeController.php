<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NodeResource;
use App\Models\Node;

class NodeController extends Controller
{
    public function index()
    {
        return NodeResource::collection(Node::orderBy('id')->get());
    }

    public function show(Node $node)
    {
        return new NodeResource($node);
    }
}
