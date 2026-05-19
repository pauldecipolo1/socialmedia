<?php

namespace App\Controllers;

use App\Models\FollowModel;
use App\Models\UserModel;

class Search extends BaseController
{
    public function index()
    {
        $keyword = trim((string) $this->request->getGet('q'));
        $users = [];
        $followModel = new FollowModel();
        $currentUserId = (int) session()->get('user_id');

        if ($keyword !== '') {
            $users = (new UserModel())->searchUsers($keyword, $currentUserId);

            foreach ($users as &$user) {
                $user['is_following'] = $followModel->isFollowing($currentUserId, (int) $user['id']);
            }
        }

        return view('search/results', [
            'title' => 'Search',
            'keyword' => $keyword,
            'users' => $users,
        ]);
    }

    public function suggestions()
    {
        $keyword = trim((string) $this->request->getGet('q'));

        if ($keyword === '') {
            return $this->response->setJSON([]);
        }

        $users = (new UserModel())->searchUsers($keyword, (int) session()->get('user_id'));

        return $this->response->setJSON($users);
    }
}
