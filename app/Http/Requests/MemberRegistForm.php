<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MemberRegistForm extends FormRequest
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
            'name' => ['required', 'length_less:20'],
            'password1' => ['required', 'same:password2', 'length_less:8', 'half_alpha_num'],
            'password2' => ['required', 'same:password1', 'length_less:8', 'half_alpha_num'],
            'age' => ['required', 'numeric', 'positive_number'],
            'zip' => ['zip'],
            'address' => ['length_less:50'],
            'tel' => ['half_num_hyphen', 'length_less:20']
        ];
    }
}
