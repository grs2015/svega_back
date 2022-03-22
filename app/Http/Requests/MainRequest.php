<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MainRequest extends FormRequest
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
            'main_title' => 'string',
            'main_image' => 'image',
            'company_data' => 'string',
            'company_name' => 'string',
            'address' => 'string',
            'phone' => 'string',
            'email' => 'email',
            'website' => 'string',
            'slogan_text' => 'string|nullable',
            'slogan_description' => 'string|nullable'
        ];
    }
}
