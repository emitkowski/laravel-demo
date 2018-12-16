<?php

namespace App\Http\Requests;

class PlayerRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->guard();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'first_name' => 'required|max:191',
            'last_name' => 'required|max:191',
            'team' => 'required',
        ];

        return $rules;
    }
}
