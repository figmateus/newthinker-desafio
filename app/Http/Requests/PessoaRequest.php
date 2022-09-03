<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PessoaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'nome' => 'required|string|min:3',
            'sobrenome' => 'required|string|min:3',
            'idade' => 'required|numeric|min:1',
            'login' => 'required',
            'senha' => 'required|min:3',
            "status" => 'required|numeric|digits_between:1,2'
        ];
    }
}
