<?php

namespace App\Models;

use CodeIgniter\Model;

class CommentModel extends Model
{
    protected $table = 'comments';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'post_id', 'comment'];
    protected $useTimestamps = false;

    public function getPostComments(int $postId): array
    {
        return $this->select('comments.*, users.username, users.profile_picture')
            ->join('users', 'users.id = comments.user_id')
            ->where('comments.post_id', $postId)
            ->orderBy('comments.created_at', 'ASC')
            ->findAll();
    }
}
