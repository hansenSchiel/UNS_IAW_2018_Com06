<?php

namespace ProdeIAW\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EncuentroFormRequest extends FormRequest
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
            'puntosL'=>'required|integer|max:50|min:-1|',
            'puntosV'=>'required|integer|max:50|min:-1|',
            'dia'=>'required',
        ];
    }
}
