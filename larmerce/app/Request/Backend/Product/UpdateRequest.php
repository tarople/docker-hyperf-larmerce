<?php

declare(strict_types=1);

namespace App\Request\Backend\Product;

use Hyperf\Validation\Request\FormRequest;
use Hyperf\Validation\Rule;

class UpdateRequest extends FormRequest
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
            'title' => [
                'required',
                Rule::unique('collection')->ignore($this->input('collection_id'), 'collection_id'),
            ],
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
