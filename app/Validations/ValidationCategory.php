<?php

namespace App\Validations;

class ValidationCategory
{
    private $erros = [];

    public function validateCategory($data, $model = null, $action = null)
    {
        $category = $model->where('name', $data['name'])->first();

        if (!isset($data['name']) || empty($data['name'])) {
            $this->erros['error-category'] = "Informe o Nome da Categoria!";
        } else if (preg_match('/[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/', $data['name'])) {
            $this->erros['error-category'] = "A Categoria não pode conter número(s)!";
        } else if (strlen($data['name']) > 80) {
            $this->erros['error-category'] = "Tamanho máximo de caracters 80!";
        } else if ($category === true && $action !== 'PUT') {
            $this->erros['error-category'] = "Categoria já Cadastrada!";
        }

        if (!isset($data['description']) || empty($data['description'])) {
            $this->erros['error-description'] = "Informe a Descrição da Categoria!";
        } else if (preg_match('/[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/', $data['description'])) {
            $this->erros['error-description'] = "A Descrição da Categoria não pode conter número(s)!";
        }

        if (!isset($data['slug']) || empty($data['slug'])) {
            $this->erros['error-slug'] = "Informe o Slug da Categoria!";
        } else if (preg_match('/[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/', $data['slug'])) {
            $this->erros['error-slug'] = "O Slug da Categoria não pode conter número(s)!";
        }

        return $this->erros;
    }

    public function validateIdCategory($id, $model)
    {
        $category = $model->where('id', $id)->first();

        if (!is_numeric($id) || $category === null) {
            $this->erros['error-id'] = "Categoria não Encontrada!";
        }

        return $this->erros;
    }

}
