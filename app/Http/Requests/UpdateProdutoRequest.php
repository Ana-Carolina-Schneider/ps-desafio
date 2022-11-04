<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProdutoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (auth()->user()->access_level == 0 || auth()->user()->access_level == 1) return true;
        else return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nome_do_produto' => [
                'required', 'min:3',
            ],
            'descricao' => [
                'required', 'max:500',
            ],
            'caminho_imagem' => [
                'required', 'mimes', 'image',
            ],
            'preco' => [
                'required', 'gte:0', 'numeric',
                /*comando: gte - O campo em validação deve ser maior ou igual ao campo fornecido */
            ],
            'quantidade' => [
                'required', 'gte:0', 'numeric',
            ],
            'categoria_id' => [
                'required', 'unique:categoria_id',
            ],
        ];
    }
}
