<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Post;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class StatController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $totalUsers = User::count();
        $totalPosts = Post::count();
        $usersWithNoPosts = User::doesntHave('posts')->count();

        return $this->success([
            'total_users' => $totalUsers,
            'total_posts' => $totalPosts,
            'users_with_0_posts' => $usersWithNoPosts,
        ], 'Statistics retrieved successfully');
    }
}
