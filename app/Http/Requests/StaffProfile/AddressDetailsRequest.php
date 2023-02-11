<?php

namespace App\Http\Requests\StaffProfile;

use Illuminate\Foundation\Http\FormRequest;

class AddressDetailsRequest extends FormRequest
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
            'address' => 'required',
            'zip_code' => 'required',
            'telephone_number' => '',
            'mobile_number' => 'required'
        ];
    }
}
