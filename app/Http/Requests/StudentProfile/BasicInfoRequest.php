<?php

namespace App\Http\Requests\StudentProfile;

use Illuminate\Foundation\Http\FormRequest;

class BasicInfoRequest extends FormRequest
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
            'birth_day' => 'required|date',
            'birth_place' => 'required|max:100',
            'citizenship' => 'required',
            'civil_status' => 'required',
            'suffix_name' => 'max:5',
            'first_name' => 'required|max:30',
            'gender' => 'required',
            'last_name' => 'required|max:30',
            'middle_name' => 'required|max:30',
            'lrn' => 'max:30',
            'religion' => 'max:30'
        ];
    }
}
