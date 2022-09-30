<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    protected $redirect = 'userManagement';

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
            'name' => 'required',
            'surname' => 'required',
            'birthdate' => 'required',
            'email' => 'required|email|unique:users',
            'subscriptionId' => 'required|exists:subscriptions,id',
            'password' => 'required|regex:/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/'
        ];
    }

    public function messages() {
        return [
            'password.required' => 'Password must be at least 8 characters long and contain at least one letter and one number.',
            'password.regex' => 'Password must be at least 8 characters long and contain at least one letter and one number.',
            'email.unique' => 'Email already registered.',
            'email.email' => 'Email must be a valid email.'
        ];
    }
}
