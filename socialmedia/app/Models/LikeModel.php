<?php

namespace App\Models;

use CodeIgniter\Model;

class LikeModel extends Model
{
    protected $table = 'likes';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'post_id'];
    protected $useTimestamps = false;

    public function toggleLike(int $userId, int $postId): bool
    {
        $existing = $this->where(['user_id' => $userId, 'post_id' => $postId])->first();

        if ($existing) {
            $this->delete($existing['id']);
            return false;
        }

        $this->insert(['user_id' => $userId, 'post_id' => $postId]);
        return true;
    }

    public function countLikes(int $postId): int
    {
        return $this->where('post_id', $postId)->countAllResults();
    }
}
