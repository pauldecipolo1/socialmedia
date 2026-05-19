<?php

namespace App\Controllers;

use App\Models\FollowModel;

class Follow extends BaseController
{
    public function toggle(int $userId)
    {
        $currentUserId = (int) session()->get('user_id');

        if ($currentUserId === $userId) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'You cannot follow yourself.']);
        }

        $followModel = new FollowModel();
        $following = $followModel->toggleFollow($currentUserId, $userId);

        return $this->response->setJSON([
            'status' => 'success',
            'following' => $following,
            'followers_count' => $followModel->countFollowers($userId),
        ]);
    }
}
