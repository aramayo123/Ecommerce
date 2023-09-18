<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ComentarioRequest extends FormRequest
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
            'comentario' => 'required|min:10',
            'estrellas' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'comentario.required' => 'Por favor coloque un comentario',
            'comentario.required' => 'El comentario no puede ser menor a 10 caracteres',
            'estrellas.required' => 'Por favor valore con alguna estrella',
        ];
    }
}
