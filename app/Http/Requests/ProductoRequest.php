<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;// se pone en true siempre
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules =  [
            'titulo' => 'required|unique:productos',
            'categoria' => 'required',
            'foto_1' => 'nullable|max:5000|mimes:jpg,png,jpeg',
            'foto_2' => 'nullable|max:5000|mimes:jpg,png,jpeg',
            'foto_3' => 'nullable|max:5000|mimes:jpg,png,jpeg',
            'caracteristicas' => 'required',
            'precio' => 'required|numeric',
            'precio_envio' => 'required|numeric',
            'active' => 'required'
        ];
        return $rules;
    }
    public function attributes()
    {
        return [
            'titulo' => 'titulo'
        ];
    }

    public function messages()
    {
        return [
            'titulo.required' => 'Por favor escriba un titulo',
            'categoria.required' => 'Por favor elija una categoria',
            'foto_1.max' => 'La foto 1 no puede ser mayor a 5 MB',
            'foto_2.max' => 'La foto 2 no puede ser mayor a 5 MB',
            'foto_3.max' => 'La foto 3 no puede ser mayor a 5 MB',
            'foto_1.mimes' => 'La foto 1 debe ser tipo:jpg,png,jpeg',
            'foto_2.mimes' => 'La foto 2 debe ser tipo:jpg,png,jpeg',
            'foto_3.mimes' => 'La foto 3 debe ser tipo:jpg,png,jpeg',
            'caracteristicas.required' => 'Por favor escribe una caracteristica',
            'precio.required' => 'Por favor escriba un precio',
            'precio_envio.required' => 'Por favor escriba un precio de envio',
            'precio.numeric' => 'Por favor escriba un numero',
            'precio_envio.numeric' => 'Por favor escriba un numero',
            'active' => 'Por favor elija un estado del producto'
        ];
    }
}
