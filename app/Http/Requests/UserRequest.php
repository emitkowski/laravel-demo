<?php

namespace App\Http\Requests;

class UserRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->guard('admin');
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
            'email' => 'required|unique:users|max:191',
            'password' => 'required|string|min:6|confirmed'
        ];

        if ($this->isUpdateRequest()) {
            $id = $this->getIdFromPath();
            $rules ['email'] = "required|unique:users,email,{$id},id|max:191";

            if ($this->isPasswordUpdate()) {
                $rules['password'] = 'string|min:6|confirmed';
            } else {
                unset($rules['password']);
            }
        }

        return $rules;
    }
}
