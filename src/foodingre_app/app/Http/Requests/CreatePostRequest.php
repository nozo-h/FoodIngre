<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePostRequest extends FormRequest
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
            'foodLabel' => ['required', 'string', 'max:255'],
            'productName' => ['required', 'string', 'max:255'],
            'ingredient' => ['max:1000'],
            'amount' => ['nullable', 'numeric', 'regex:/^\d+(\.\d{1,3})?$/', 'between:0.000, 9999999999.999'],
            'manufacture' => ['required', 'string', 'max:255'],
            'perGrams' => ['nullable','numeric', 'regex:/^\d+(\.\d{1,3})?$/', 'between:0.000, 9999999999.999'],
            'calories' => ['nullable','numeric', 'regex:/^\d+(\.\d{1,3})?$/','between:0.000, 9999999999.999'],
            'proteins' => ['nullable','numeric', 'regex:/^\d+(\.\d{1,3})?$/','between:0.000, 9999999999.999'],
            'fat' => ['nullable', 'numeric', 'regex:/^\d+(\.\d{1,3})?$/', 'between:0.000, 9999999999.999'],
            'carbohydrates' => ['nullable', 'numeric', 'regex:/^\d+(\.\d{1,3})?$/', 'between:0.000, 9999999999.999'],
            'salt' => ['nullable', 'numeric', 'regex:/^\d+(\.\d{1,3})?$/', 'between:0.000, 9999999999.999'],
            'other' => ['max:1000'],
            'remarks' => ['max:1000'],
        ];
    }

    public function messages()
    {
        return [
            'numeric' => ':attributeは数値で指定してください',
            'regex' => ':attributeは小数点3桁以内で指定してください',
            'between' => ':attributeは整数10桁、小数点3桁のゼロ以上の数字で指定してください',
        ];
    }
}
