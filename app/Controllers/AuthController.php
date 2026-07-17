<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Core\Request;
use App\Services\AuthService;

class AuthController extends BaseController
{
    public function showLogin(Request $request)
    {
        if ((new AuthService())->check()) {
            $this->redirect('/dashboard');
        }

        $this->view('auth/login', [
            'title' => 'Login',
            'error' => $request->query('error'),
        ], 'auth');
    }

    public function login(Request $request)
    {
        $auth = new AuthService();

        if (!$auth->login(
            (string) $request->body('email', ''),
            (string) $request->body('password', '')
        )) {
            $this->redirect('/login?error=' . urlencode('Invalid email or password.'));
        }

        $this->redirect('/dashboard');
    }

    public function showRegister(Request $request)
    {
        if ((new AuthService())->check()) {
            $this->redirect('/dashboard');
        }

        $this->view('auth/register', [
            'title' => 'Register',
            'error' => $request->query('error'),
            'old' => [
                'name' => $request->query('name', ''),
                'email' => $request->query('email', ''),
            ],
        ], 'auth');
    }

    public function register(Request $request)
    {
        $name = (string) $request->body('name', '');
        $email = (string) $request->body('email', '');
        $password = (string) $request->body('password', '');
        $passwordConfirmation = (string) $request->body('password_confirmation', '');

        $result = (new AuthService())->register(
            $name,
            $email,
            $password,
            $passwordConfirmation
        );

        if (!$result['ok']) {
            $query = http_build_query([
                'error' => $result['error'],
                'name' => $name,
                'email' => $email,
            ]);

            $this->redirect('/register?' . $query);
        }

        $this->redirect('/dashboard');
    }

    public function logout()
    {
        (new AuthService())->logout();

        $this->redirect('/login');
    }
}
