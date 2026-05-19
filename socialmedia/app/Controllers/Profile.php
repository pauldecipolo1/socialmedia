<?php

namespace App\Controllers;

use App\Models\FollowModel;
use App\Models\PostModel;
use App\Models\UserModel;

class Profile extends BaseController
{
    public function show(int $id)
    {
        $userModel = new UserModel();
        $followModel = new FollowModel();
        $user = $userModel->find($id);

        if (! $user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('User not found.');
        }

        return view('profile/profile', [
            'title' => $user['username'] . ' Profile',
            'user' => $user,
            'posts' => (new PostModel())->getUserPosts($id),
            'followersCount' => $followModel->countFollowers($id),
            'followingCount' => $followModel->countFollowing($id),
            'isFollowing' => $followModel->isFollowing((int) session()->get('user_id'), $id),
            'isOwnProfile' => (int) session()->get('user_id') === $id,
        ]);
    }

    public function picture(string $fileName)
    {
        $safeName = basename($fileName);
        $path = WRITEPATH . 'uploads/profile_pictures/' . $safeName;

        if (! is_file($path)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Image not found.');
        }

        return $this->response
            ->setHeader('Content-Type', mime_content_type($path))
            ->setBody(file_get_contents($path));
    }

    public function edit()
    {
        $user = (new UserModel())->find((int) session()->get('user_id'));

        return view('profile/edit_profile', [
            'title' => 'Edit Profile',
            'user' => $user,
        ]);
    }

    public function update()
    {
        $userId = (int) session()->get('user_id');
        $rules = [
            'first_name' => 'required|min_length[2]|max_length[50]',
            'last_name' => 'required|min_length[2]|max_length[50]',
            'birth_date' => 'required|valid_date',
            'sex' => 'required|in_list[Male,Female,Other]',
            'email' => 'required|valid_email|is_unique[users.email,id,' . $userId . ']',
            'bio' => 'permit_empty|max_length[500]',
            'profile_picture' => 'permit_empty|is_image[profile_picture]|mime_in[profile_picture,image/jpg,image/jpeg,image/png]|max_size[profile_picture,2048]',
        ];

        if (! $this->validate($rules)) {
            return view('profile/edit_profile', [
                'title' => 'Edit Profile',
                'user' => (new UserModel())->find($userId),
                'validation' => $this->validator,
            ]);
        }

        $data = [
            'first_name' => trim($this->request->getPost('first_name')),
            'last_name' => trim($this->request->getPost('last_name')),
            'birth_date' => $this->request->getPost('birth_date'),
            'sex' => $this->request->getPost('sex'),
            'email' => filter_var($this->request->getPost('email'), FILTER_SANITIZE_EMAIL),
            'bio' => trim((string) $this->request->getPost('bio')),
        ];

        $image = $this->request->getFile('profile_picture');
        if ($image && $image->isValid() && ! $image->hasMoved()) {
            $newName = $image->getRandomName();
            $image->move(WRITEPATH . 'uploads/profile_pictures', $newName);
            $data['profile_picture'] = $newName;
            session()->set('profile_picture', $newName);
        }

        (new UserModel())->update($userId, $data);
        session()->set([
            'first_name' => $data['first_name'],
        ]);

        return redirect()->to('/profile/' . $userId)->with('success', 'Profile updated successfully.');
    }

    public function followers(int $id)
    {
        return $this->peopleList($id, 'followers');
    }

    public function following(int $id)
    {
        return $this->peopleList($id, 'following');
    }

    private function peopleList(int $id, string $type)
    {
        $user = (new UserModel())->find($id);
        if (! $user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('User not found.');
        }

        $followModel = new FollowModel();

        return view('profile/' . $type, [
            'title' => ucfirst($type),
            'user' => $user,
            'people' => $type === 'followers'
                ? $followModel->getFollowers($id)
                : $followModel->getFollowing($id),
            'type' => $type,
            'isOwnList' => (int) session()->get('user_id') === $id,
        ]);
    }
}
