<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SeriesFormRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return[
            'nome'=>'required|min:3'
        ];
    }

    public function messages()
    {
        return [
            'required'=>'preenche o campo :attribute porra',
            'nome.min'=>'ta com má vontade é?. Tem que ter pelo menos dois caracteres!'
        ];
    }
}
