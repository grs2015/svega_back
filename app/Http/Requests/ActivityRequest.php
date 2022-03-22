<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActivityRequest extends FormRequest
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
            'title' => 'string',
            'subtitle' => 'string',
            'section_title_1' => 'string',
            'section_description_1' => 'string|nullable',
            'section_type_1' => 'boolean',
            'section_title_2' => 'string',
            'section_description_2' => 'string|nullable',
            'section_type_2' => 'boolean',
            'section_title_3' => 'string|nullable',
            'section_description_3' => 'string|nullable',
            'section_type_3' => 'boolean',
            'image' => 'image',
            'tag' => 'array'
            // 'deletedImage' => 'string'
        ];
    }
}
