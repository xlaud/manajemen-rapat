<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->role === 'admin';
    }

    public function rules(): array
    {
        // mendapatkan user ID dari rute
        $userId = $this->route('user')->id;

        return [
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($userId)],
            'nip' => ['nullable', 'string', Rule::unique('users')->ignore($userId)],
            'password' => 'nullable|string|min:8', // Password opsional saat update
        ];
    }
}