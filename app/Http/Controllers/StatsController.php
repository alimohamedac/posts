<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Facades\Cache;

class StatsController extends Controller
{
    public function index()
    {
        $stats = Cache::remember('stats', 600, function () {
            $totalUsers = User::count();
            $totalPosts = Post::count();
            $usersWithNoPosts = User::doesntHave('posts')->count();

            return [
                'total_users' => $totalUsers,
                'total_posts' => $totalPosts,
                'users_with_no_posts' => $usersWithNoPosts,
            ];
        });

        return response()->json($stats);
    }
}

