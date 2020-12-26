<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductSearchForm extends FormRequest
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
            'max_price' => ['nullable', 'numeric', 'positive_number', 'greater_than_field:min_price'],
            'min_price' => ['nullable', 'numeric', 'positive_number', 'less_than_field:max_price']
        ];
    }
}
