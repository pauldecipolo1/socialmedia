<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function register()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/feed');
        }

        if (strtolower($this->request->getMethod()) === 'post') {
            $rules = [
                'username' => 'required|min_length[3]|max_length[50]|is_unique[users.username]',
                'first_name' => 'required|min_length[2]|max_length[50]',
                'last_name' => 'required|min_length[2]|max_length[50]',
                'birth_date' => 'required|valid_date',
                'sex' => 'required|in_list[Male,Female,Other]',
                'email' => 'required|valid_email|is_unique[users.email]',
                'password' => 'required|min_length[6]',
                'confirm_password' => 'required|matches[password]',
            ];

            if (! $this->validate($rules)) {
                return view('auth/register', [
                    'title' => 'Create Account',
                    'validation' => $this->validator,
                ]);
            }

            $userModel = new UserModel();
            $userModel->insert([
                'username' => trim($this->request->getPost('username')),
                'first_name' => trim($this->request->getPost('first_name')),
                'last_name' => trim($this->request->getPost('last_name')),
                'birth_date' => $this->request->getPost('birth_date'),
                'sex' => $this->request->getPost('sex'),
                'email' => filter_var($this->request->getPost('email'), FILTER_SANITIZE_EMAIL),
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            ]);

            return redirect()->to('/login')->with('success', 'Registration successful. You can now login.');
        }

        return view('auth/register', ['title' => 'Create Account']);
    }

    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/feed');
        }

        if (strtolower($this->request->getMethod()) === 'post') {
            $email = filter_var($this->request->getPost('email'), FILTER_SANITIZE_EMAIL);
            $password = $this->request->getPost('password');

            if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return redirect()->back()->withInput()->with('error', 'Please enter a valid email address.');
            }

            $user = (new UserModel())->where('email', $email)->first();

            if (! $user) {
                return redirect()->back()->withInput()->with('error', 'User not found.');
            }

            if (! password_verify($password, $user['password'])) {
                return redirect()->back()->withInput()->with('error', 'Incorrect password.');
            }

            session()->regenerate();
            session()->set([
                'user_id' => $user['id'],
                'username' => $user['username'],
                'first_name' => $user['first_name'],
                'profile_picture' => $user['profile_picture'],
                'isLoggedIn' => true,
            ]);

            return redirect()->to('/feed')->with('success', 'Welcome back, ' . $user['first_name'] . '!');
        }

        return view('auth/login', ['title' => 'Login']);
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to('/login')->with('success', 'You have been logged out.');
    }
}
