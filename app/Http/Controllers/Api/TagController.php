<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;

class TagController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $tags = Tag::paginate(10);
        return $this->success([
            'data' => TagResource::collection($tags),
            'meta' => [
                'current_page' => $tags->currentPage(),
                'last_page' => $tags->lastPage(),
                'per_page' => $tags->perPage(),
                'total' => $tags->total(),
            ],
            'links' => [
                'first' => $tags->url(1),
                'last' => $tags->url($tags->lastPage()),
                'next' => $tags->nextPageUrl(),
                'prev' => $tags->previousPageUrl(),
            ],
        ], 'Tags retrieved successfully');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:tags'],
        ]);

        $tag = Tag::create($request->all());

        return $this->success(new TagResource($tag), 'Tag created successfully', 201);
    }

    public function show(Tag $tag)
    {
        return $this->success(new TagResource($tag), 'Tag retrieved successfully');
    }

    public function update(Request $request, Tag $tag)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:tags,name,' . $tag->id],
        ]);

        $tag->update($request->all());

        return $this->success(new TagResource($tag), 'Tag updated successfully');
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();

        return $this->success(null, 'Tag deleted successfully');
    }
}
