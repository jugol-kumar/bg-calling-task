<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // apply validation rules for create user
        return [
            'name'        => ['required', 'string', 'min:3', 'max:30'],
            'email'       => ['required','unique:users', 'email:rfc,dns'],
            'password'    => ['required', 'min:6'],
            'image'       => ['nullable', 'image', 'mimes:jpg,png,svg,gif', 'max:1024'],
            'role'        => ['required', 'exists:roles,id']
        ];
    }
    protected function prepareForValidation(): void
    {
        // trim and convert email to lowercase and password hashed
        $this->merge([
            'name' => trim($this->name),
            'email' => strtolower(trim($this->email)),
            'password' => Hash::make($this->password),
        ]);
    }

    public function messages(): array
    {
        // prepare custom message for validation
        return [
            'name.required' => 'Please provide an user name.',
            'image.image' => 'Please provide an valid image',
            'role.exists' => 'Your selected role is not valid.'
            // more custom validation rules messages
        ];
    }

}
