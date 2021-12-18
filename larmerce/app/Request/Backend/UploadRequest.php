<?php

declare(strict_types=1);

namespace App\Request\Backend;

use Hyperf\Validation\Request\FormRequest;

class UploadRequest extends FormRequest
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
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',            
        ];
    }

    public function messages(): array
    {
        return [
            'image.required' => 'Image is required', 
            'image.image' => 'Please upload an image', 
            'image.mimes' => 'The image type must be .jpeg, .png, .jpg',
            'image.max' => 'The image size is over 2MB',
        ];
    }
}
