<?php

namespace App\Controllers;

use App\Models\CommentModel;
use App\Models\LikeModel;
use App\Models\PostModel;

class Post extends BaseController
{
    public function create()
    {
        $content = trim((string) $this->request->getPost('content'));

        if ($content === '') {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Post cannot be empty.']);
        }

        if (mb_strlen($content) > 1000) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Post must not exceed 1000 characters.']);
        }

        (new PostModel())->insert([
            'user_id' => session()->get('user_id'),
            'content' => $content,
        ]);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Post created successfully.',
        ]);
    }

    public function like(int $postId)
    {
        $likeModel = new LikeModel();
        $liked = $likeModel->toggleLike((int) session()->get('user_id'), $postId);

        return $this->response->setJSON([
            'status' => 'success',
            'liked' => $liked,
            'likes_count' => $likeModel->countLikes($postId),
        ]);
    }

    public function delete(int $postId)
    {
        $postModel = new PostModel();
        $post = $postModel->find($postId);

        if (! $post) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Post not found.']);
        }

        if ((int) $post['user_id'] !== (int) session()->get('user_id')) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'You can only delete your own posts.']);
        }

        $postModel->delete($postId);

        return $this->response->setJSON(['status' => 'success', 'message' => 'Post deleted successfully.']);
    }

    public function comment(int $postId)
    {
        $comment = trim((string) $this->request->getPost('comment'));

        if ($comment === '') {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Comment cannot be empty.']);
        }

        if (mb_strlen($comment) > 300) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Comment must not exceed 300 characters.']);
        }

        (new CommentModel())->insert([
            'user_id' => session()->get('user_id'),
            'post_id' => $postId,
            'comment' => $comment,
        ]);

        return $this->response->setJSON(['status' => 'success', 'message' => 'Comment added.']);
    }
}
