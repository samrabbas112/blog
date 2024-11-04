<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class CategoryRequest extends FormRequest
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
        if($this->id) {
            return [
                'name' => 'required|unique:categories,name,' . $this->id
            ];
        } else{
            return [
               'name' => 'required|unique:categories',
            ];
      }

    }

    /**
     * @return string[]
     */
    public  function messages(): array
    {
        return [
            'name.required' => 'Category name is required',
        ];
    }

    /**
     * @param Validator $validator
     * @return mixed
     */
    public function  failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ]));

    }
}
