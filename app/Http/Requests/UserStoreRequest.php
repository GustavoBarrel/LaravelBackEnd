<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function authorize(): bool
    {
        return true;
    }


    public function rules()
    {
        return [
            'email' => 'required|email|string|max:250|unique:users,email',
            'password' => 'required|string|min:8|max:250',
            'token' => 'required|numeric',
        ];
    }

    public function attributes()
    {
        return [
            'email' => 'E-mail',
            'password' => 'Senha',
            'token' => 'Token',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'O campo :attribute é obrigatório.',
            'email.email' => 'Por favor, insira um :attribute válido.',
            'email.max' => 'O :attribute não pode ter mais de 250 caracteres.',
            'email.unique' => 'Este :attribute já está em uso. Por favor, insira outro.',

            'password.required' => 'O campo :attribute é obrigatório.',
            'password.min' => 'A :attribute deve ter pelo menos 8 caracteres.',
            'password.max' => 'A :attribute não pode ter mais de 250 caracteres.',

            'token.required' => 'O campo :attribute é obrigatório.',
            'token.size' => 'O :attribute deve ter exatamente 5 caracteres.',
        ];
    }


}
