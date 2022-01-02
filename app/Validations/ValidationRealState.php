<?php

namespace App\Validations;

class ValidationRealState
{
    private $erros = [];

    public function validateRealState($data, $model = null, $action = null, $imagem = null)
    {
        if (!isset($data['title']) || empty($data['title'])) {
            $this->erros['error-title'] = "Informe o Título do Imóvel!";
        } else if (preg_match('/[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/', $data['title'])) {
            $this->erros['error-title'] = "O Título do Imóvel não pode conter número(s)!";
        } else if (strlen($data['title']) > 80) {
            $this->erros['error-title'] = "Tamanho máximo de caracters 80!";
        }

        if (!isset($data['description']) || empty($data['description'])) {
            $this->erros['error-description'] = "Informe a Descrição do Imóvel!";
        } else if (preg_match('/[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/', $data['description'])) {
            $this->erros['error-description'] = "A Descrição do Imóvel não pode conter número(s)!";
        }

        if (!isset($data['content']) || empty($data['content'])) {
            $this->erros['error-content'] = "Informe o Conteúdo do Imóvel!";
        } else if (strlen($data['content']) > 255) {
            $this->erros['error-content'] = "Tamanho máximo de caracters 255!";
        }

        if (!isset($data['price']) || empty($data['price'])) {
            $this->erros['error-price'] = "Informe o Valor do Imóvel!";
        }

        if (!isset($data['bathrooms']) || empty($data['bathrooms'])) {
            $this->erros['error-bathrooms'] = "Informe a Quantidade de Banheiros do Imóvel!";
        } else if (!is_numeric($data['bathrooms'])) {
            $this->erros['error-bathrooms'] = "A Quantidade de Banheiros do Imóvel deve ser no Formato Numérico!";
        }

        if (!isset($data['bedrooms']) || empty($data['bedrooms'])) {
            $this->erros['error-bedrooms'] = "Informe a Quantidade de Quartos do Imóvel!";
        } else if (!is_numeric($data['bedrooms'])) {
            $this->erros['error-bedrooms'] = "A Quantidade de Quartos do Imóvel deve ser no Formato Numérico!";
        }

        if (!isset($data['property_area']) || empty($data['property_area'])) {
            $this->erros['error-property_area'] = "Informe a Área do Imóvel!";
        } else if (!is_numeric($data['property_area'])) {
            $this->erros['error-property_area'] = "A Área do Imóvel do Imóvel deve ser no Formato Numérico!";
        }

        if (!isset($data['total_property_area']) || empty($data['total_property_area'])) {
            $this->erros['error-total_property_area'] = "Informe o Total da Área do Imóvel!";
        } else if (!is_numeric($data['total_property_area'])) {
            $this->erros['error-total_property_area'] = "O Total da Área do Imóvel do Imóvel deve ser no Formato Numérico!";
        }

        if (!isset($data['slug']) || empty($data['slug'])) {
            $this->erros['error-slug'] = "Informe o Slug da Categoria!";
        } else if (preg_match('/[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/', $data['slug'])) {
            $this->erros['error-slug'] = "O Slug da Categoria não pode conter número(s)!";
        }

        if (isset($data['categories']) && $data['categories'][0] === null) {
            $this->erros['error-categories'] = "Informe a Categoria do Imóvel!";
        }

        if ($imagem !== null) {
            foreach ($imagem as $image) {
                $size = $image->getClientSize();
                $extension = $image->extension();
            }
        }

        if ($imagem === null) {
            $this->erros['error-images'] = "Informe a Imagem do Imóvel!";
        } else if ($size > 23068672) {
            $this->erros['error-images'] = "Tamanho da Imagem Excede o Limite de 22 MB!";
        } else if (array_search($extension, array('bmp' ,'png', 'svg', 'jpeg', 'jpg')) === false) {
            $this->erros['error-images'] = "Imagem Somente png, svg, jpg, pdf, jpeg!";
        }

        return $this->erros;
    }

    public function validateIdRealState($id, $model)
    {
        $realState = $model->where('id', $id)->first();

        if (!is_numeric($id) || $realState === null) {
            $this->erros['error-id'] = "Imóvel não Encontrada!";
        }

        return $this->erros;
    }

}
