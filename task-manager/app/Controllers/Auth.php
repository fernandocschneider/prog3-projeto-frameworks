<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        // Se já estiver logado, redireciona para tasks
        if (session()->get('user_id')) {
            return redirect()->to('/tasks');
        }

        return view('auth/login');
    }

    public function login()
    {
        $email = $this->request->getPost('email');
        $senha = $this->request->getPost('senha');

        // Validação básica
        if (empty($email) || empty($senha)) {
            session()->setFlashdata('error', 'Email e senha são obrigatórios');
            return redirect()->back()->withInput();
        }

        // Tentativa de autenticação
        $user = $this->userModel->authenticate($email, $senha);

        if ($user) {
            // Login bem-sucedido
            session()->set([
                'user_id' => $user['id'],
                'user_nome' => $user['nome'],
                'user_email' => $user['email']
            ]);

            session()->setFlashdata('success', 'Login realizado com sucesso!');
            return redirect()->to('/tasks');
        } else {
            // Login falhou
            session()->setFlashdata('error', 'Email ou senha incorretos');
            return redirect()->back()->withInput();
        }
    }

    public function logout()
    {
        session()->destroy();
        session()->setFlashdata('success', 'Logout realizado com sucesso!');
        return redirect()->to('/');
    }

    public function register()
    {
        return view('auth/register');
    }

    public function create()
    {
        $data = [
            'nome' => $this->request->getPost('nome'),
            'email' => $this->request->getPost('email'),
            'senha' => $this->request->getPost('senha'),
            'confirmar_senha' => $this->request->getPost('confirmar_senha')
        ];

        // Validação da confirmação de senha
        if ($data['senha'] !== $data['confirmar_senha']) {
            session()->setFlashdata('error', 'As senhas não coincidem');
            return redirect()->back()->withInput();
        }

        // Remove a confirmação de senha antes de salvar
        unset($data['confirmar_senha']);

        if ($this->userModel->createUser($data)) {
            session()->setFlashdata('success', 'Usuário criado com sucesso! Faça login para continuar.');
            return redirect()->to('/auth');
        } else {
            session()->setFlashdata('error', 'Erro ao criar usuário. Verifique os dados.');
            return redirect()->back()->withInput();
        }
    }
} 