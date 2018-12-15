<?php

namespace App\Http\Requests;

class AddressRequest extends Request
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
            'type' => 'required|max:191',
            'address' => 'required|max:191',
            'address2' => 'max:191|nullable',
            'city' => 'required|max:191',
            'state' => 'required|max:2',
            'postal' => 'required|digits:5',
            'postal_additional' => 'digits:4|nullable',
            'country' => 'max:2',
            'phone' => 'max:191',
        ];

        return $rules;
    }

    /**
     * Get the validation messages
     *
     * @return array
     */
    public function messages()
    {
        return [
            'postal.required' => 'The zip code field is required',
            'postal.digits' => 'Zip Code must be valid'
        ];
    }
}
