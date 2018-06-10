<?php

namespace ProdeIAW\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TorneoFormRequest extends FormRequest
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
        return [
            'nombre'=>'required|max:100',
            'fechaInicio'=>'required|date',
            'fechaFin'=>'required|date',
            'descripcion'=>'max:512',
            'deporte'=>'required|max:32'
        ];
    }
}
