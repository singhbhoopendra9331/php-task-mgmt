<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Core\Request;
use App\Services\AuthService;

class AuthController extends BaseController
{
    public function showLogin()
    {
        $this->view('auth/login', [
            'title' => 'Login',
        ], 'auth');
    }

    public function login(Request $request)
    {
        $auth = new AuthService();

        if (!$auth->login(
            $request->body('email'),
            $request->body('password')
        )) { 
            return $this->redirect('/login');
        }

        $this->redirect('/dashboard');
    }

    public function logout()
    {
        (new AuthService())->logout();

        $this->redirect('/login');
    }
}