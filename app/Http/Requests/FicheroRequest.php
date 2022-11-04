<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FicheroRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'description' => 'min:3|max:150',
            'file' => 'required|size:500'
        ];
    }
}
