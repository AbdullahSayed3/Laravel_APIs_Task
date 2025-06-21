<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Traits\ApiResponse; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\PostRequest;


class PostController extends Controller
{
    use ApiResponse; 

    public function index(Request $request)
    {
        $user = $request->user();
        $posts = $user->posts()->orderByDesc('pinned')->paginate(10);

        return $this->success([
            'data' => PostResource::collection($posts),
            'meta' => [
                'current_page' => $posts->currentPage(),
                'last_page' => $posts->lastPage(),
                'per_page' => $posts->perPage(),
                'total' => $posts->total(),
            ],
            'links' => [
                'first' => $posts->url(1),
                'last' => $posts->url($posts->lastPage()),
                'next' => $posts->nextPageUrl(),
                'prev' => $posts->previousPageUrl(),
            ],
        ], 'Posts retrieved successfully');
    }

    public function store(PostRequest $request)
    {
  

        $imagePath = null;
        if ($request->hasFile('cover_image')) {
            $imagePath = $request->file('cover_image')->store('cover_images', 'public');
        }

        $post = $request->user()->posts()->create([
            'title' => $request->title,
            'body' => $request->body,
            'cover_image' => $imagePath,
            'pinned' => $request->pinned,
        ]);

        if ($request->has('tags')) {
            $post->tags()->attach($request->tags);
        }

        return $this->success(new PostResource($post), 'Post created successfully', 201);
    }

    public function show(Post $post)
    {
        if ($post->user_id !== request()->user()->id) {
            return $this->error('Unauthorized', 403);
        }

        return $this->success(new PostResource($post), 'Post retrieved successfully');
    }

    public function update(PostRequest $request, Post $post)
    {
        if ($post->user_id !== $request->user()->id) {
            return $this->error('Unauthorized', 403);
        }
        
   
        if ($request->hasFile('cover_image')) {
            if ($post->cover_image) {
                Storage::disk('public')->delete($post->cover_image);
            }
            $imagePath = $request->file('cover_image')->store('cover_images', 'public');
            $post->cover_image = $imagePath;
        }

        $post->fill($request->except(['cover_image', 'tags']));

        if ($request->has('tags')) {
            $post->tags()->sync($request->tags);
        }

        $post->save();

        return $this->success(new PostResource($post), 'Post updated successfully');
    }

    public function destroy(Post $post)
    {
        if ($post->user_id !== request()->user()->id) {
            return $this->error('Unauthorized', 403);
        }

        $post->delete();

        return $this->success(null, 'Post deleted successfully');
    }

    public function showDeleted(Request $request)
    {
        $user = $request->user();
        $deletedPosts = $user->posts()->onlyTrashed()->get();

        return $this->success(PostResource::collection($deletedPosts), 'Deleted posts retrieved successfully');
    }

    public function restore($id)
    {
        $post = Post::onlyTrashed()
            ->where('id', $id)
            ->where('user_id', request()->user()->id)
            ->firstOrFail();

        $post->restore();

        return $this->success(new PostResource($post), 'Post restored successfully');
    }
}
