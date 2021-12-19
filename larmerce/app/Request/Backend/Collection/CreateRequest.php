<?php

declare(strict_types=1);

namespace App\Request\Backend\Collection;

use Hyperf\Validation\Request\FormRequest;

class CreateRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'title' => 'required|unique:collection',
            'slug' => 'required',
            'description' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Email is required',
            'title.unique' => 'Title has been used',
            'slug.required' => 'Slug is required',
            'description.required' => 'Description is required',
        ];
    }
}
