<?php

namespace App\Models;

use CodeIgniter\Model;

class PostModel extends Model
{
    protected $table = 'posts';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'content'];
    protected $useTimestamps = false;

    public function getFeedPosts(): array
    {
        return $this->select('posts.*, users.username, users.first_name, users.last_name, users.profile_picture')
            ->join('users', 'users.id = posts.user_id')
            ->orderBy('posts.created_at', 'DESC')
            ->findAll();
    }

    public function getUserPosts(int $userId): array
    {
        return $this->select('posts.*, users.username, users.first_name, users.last_name, users.profile_picture')
            ->join('users', 'users.id = posts.user_id')
            ->where('posts.user_id', $userId)
            ->orderBy('posts.created_at', 'DESC')
            ->findAll();
    }
}
