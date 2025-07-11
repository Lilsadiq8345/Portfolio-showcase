<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
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
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|in:Frontend,Backend,Database',
            'code_link' => 'nullable|url',
            'live_link' => 'nullable|url',
            'thumbnail' => 'nullable|string', // Assuming base64 or a path
            'visibility' => 'required|in:public,private',
            'progress' => 'required|integer|min:0|max:100',
            'skills' => 'sometimes|array',
            'skills.*' => 'integer|exists:skills,id',
        ];
    }
}
