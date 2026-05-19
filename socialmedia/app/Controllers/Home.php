<?php

namespace App\Controllers;

use App\Models\CommentModel;
use App\Models\FollowModel;
use App\Models\LikeModel;
use App\Models\PostModel;
use App\Models\UserModel;

class Home extends BaseController
{
    public function index()
    {
        $postModel = new PostModel();
        $likeModel = new LikeModel();
        $commentModel = new CommentModel();
        $followModel = new FollowModel();
        $userModel = new UserModel();

        $posts = $postModel->getFeedPosts();

        foreach ($posts as &$post) {
            $post['likes_count'] = $likeModel->countLikes((int) $post['id']);
            $post['comments'] = $commentModel->getPostComments((int) $post['id']);
        }

        $userId = (int) session()->get('user_id');

        return view('home/feed', [
            'title' => 'News Feed',
            'posts' => $posts,
            'suggestedUsers' => $userModel->suggestedUsers($userId),
            'followersCount' => $followModel->countFollowers($userId),
            'followingCount' => $followModel->countFollowing($userId),
        ]);
    }
}
