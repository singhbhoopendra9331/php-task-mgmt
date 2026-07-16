<?php

namespace App\Controllers;

use app\core\BaseController;
use app\core\Request;
use app\services\AuthService;

class AuthController extends BaseController
{
    public function showLogin()
    {
        $this->view('auth.login');
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