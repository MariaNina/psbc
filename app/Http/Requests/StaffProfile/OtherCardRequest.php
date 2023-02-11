<?php

namespace App\Http\Requests\StaffProfile;

use Illuminate\Foundation\Http\FormRequest;

class OtherCardRequest extends FormRequest
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
            'staff_type' => 'required',
            'position' => 'required',
            'department' => 'required',
            'agency_employee_no' => 'required|max:30',
            'sss' => 'max:30',
            'tin' => 'max:30',
            'phil_health' => 'max:30',
            'gsis' => 'max:30',
            'pagibig' => 'max:30',
            'is_masteral' => ''
        ];
    }
}
