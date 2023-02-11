<?php

namespace App\Http\Requests\StaffProfile;

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
            'birth_day' => ['required'],
            'birth_place' => ['required'],
            'blood_type' => ['required'],
            'citizenship' => ['required'],
            'civil_status' => ['required'],
            'extension_name' => 'max:5',
            'first_name' => ['required', 'max:30'],
            'gender' => ['required'],
            'height_m' => ['required', 'numeric'],
            'last_name' => ['required', 'max:30'],
            'middle_name' => ['required', 'max:30'],
            'weight_kg' => ['required', 'numeric']

        ];
    }
}
