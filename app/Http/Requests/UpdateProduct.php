<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProduct extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if(auth()->check()){
            if(auth()->user()->role === 'admin'){
                return true;
            }
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255|unique:product,title,' , $this->product->id,
            'description' => 'required|string',
            'price' => 'required|numeric|max:100000',
            'category_id' => 'required|numeric',
            'image' => 'required|image',
        ];
    }
}
