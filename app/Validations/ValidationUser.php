<?php

namespace App\Validations;

class ValidationUser
{
    private $erros = [];

    public function validateUser($data, $model = null, $action = null)
    {
        $email = $model->where('email', $data['email'])->first();

        if (!isset($data['name']) || empty($data['name'])) {
            $this->erros['error-name'] = "É necessário informar o Nome do Usuário!";
        } else if (preg_match('/[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/', $data['name'])) {
            $this->erros['error-name'] = "O Nome do Usuário não pode conter número(s)!";
        } else if (strlen($data['name']) <= 7) {
            $this->erros['error-name'] = "Infome o Nome e o SobreNome do Usuário!";
        }

        if (!isset($data['email']) || empty($data['email'])) {
            $this->erros['error-email'] = "É necessário informar o E-mail do Usuário!";
        } else if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $this->erros['error-email'] = "Informe um E-mail válido!";
        } else if ($email === true && $action !== 'PUT') {
            $this->erros['error-email'] = "O E-mail informado já está cadastrado!";
        }

        if (!isset($data['password']) || empty($data['password'])) {
            $this->erros['error-password'] = "É necessário informar uma Senha para o Usuário!";
        } else if (!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,12}$/', $data['password'])) {
            $this->erros['error-password'] = 'A Senha de deve conter pelo menos um número, uma letra, um caracter especial e entre 8 e 12 Dígitos!';
        }

        if (!isset($data['profile']['phone']) || empty($data['profile']['phone'])) {
            $this->erros['error-phone'] = "É necessário informar o Telefone do Usuário!";
        }

        if (!isset($data['profile']['mobile_phone']) || empty($data['profile']['mobile_phone'])) {
            $this->erros['error-mobile-phone'] = "É necessário informar o Celular do Usuário!";
        }

        return $this->erros;
    }

}
