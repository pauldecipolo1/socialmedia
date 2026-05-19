<?php

namespace App\Models;

use CodeIgniter\Model;

class FollowModel extends Model
{
    protected $table = 'followers';
    protected $primaryKey = 'id';
    protected $allowedFields = ['follower_id', 'following_id'];
    protected $useTimestamps = false;

    public function isFollowing(int $followerId, int $followingId): bool
    {
        return (bool) $this->where([
            'follower_id' => $followerId,
            'following_id' => $followingId,
        ])->first();
    }

    public function toggleFollow(int $followerId, int $followingId): bool
    {
        $existing = $this->where([
            'follower_id' => $followerId,
            'following_id' => $followingId,
        ])->first();

        if ($existing) {
            $this->delete($existing['id']);
            return false;
        }

        $this->insert([
            'follower_id' => $followerId,
            'following_id' => $followingId,
        ]);

        return true;
    }

    public function countFollowers(int $userId): int
    {
        return $this->where('following_id', $userId)->countAllResults();
    }

    public function countFollowing(int $userId): int
    {
        return $this->where('follower_id', $userId)->countAllResults();
    }

    public function getFollowers(int $userId): array
    {
        return $this->select('users.id, users.username, users.first_name, users.last_name, users.profile_picture, users.bio')
            ->join('users', 'users.id = followers.follower_id')
            ->where('followers.following_id', $userId)
            ->orderBy('followers.created_at', 'DESC')
            ->findAll();
    }

    public function getFollowing(int $userId): array
    {
        return $this->select('users.id, users.username, users.first_name, users.last_name, users.profile_picture, users.bio')
            ->join('users', 'users.id = followers.following_id')
            ->where('followers.follower_id', $userId)
            ->orderBy('followers.created_at', 'DESC')
            ->findAll();
    }
}
