<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'username',
        'first_name',
        'last_name',
        'birth_date',
        'sex',
        'email',
        'password',
        'profile_picture',
        'bio',
    ];
    protected $useTimestamps = false;

    public function searchUsers(string $keyword, int $currentUserId): array
    {
        return $this->select('id, username, first_name, last_name, email, profile_picture, bio')
            ->groupStart()
                ->like('username', $keyword)
                ->orLike('first_name', $keyword)
                ->orLike('last_name', $keyword)
                ->orLike('email', $keyword)
            ->groupEnd()
            ->where('id !=', $currentUserId)
            ->orderBy('username', 'ASC')
            ->limit(20)
            ->findAll();
    }

    public function suggestedUsers(int $currentUserId): array
    {
        return $this->select('users.id, users.username, users.first_name, users.last_name, users.profile_picture')
            ->where('users.id !=', $currentUserId)
            ->whereNotIn('users.id', static function ($builder) use ($currentUserId) {
                $builder->select('following_id')
                    ->from('followers')
                    ->where('follower_id', $currentUserId);
            })
            ->orderBy('users.created_at', 'DESC')
            ->limit(5)
            ->findAll();
    }
}
