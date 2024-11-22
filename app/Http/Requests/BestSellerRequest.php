<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BestSellerRequest extends FormRequest
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
            'author' => 'string',
            'title' => 'string',
            'offset' => ['integer','multiple_of:20'],
            'isbn' => 'array',
            'isbn.*' => ['string', 'regex:/^(\d{10}|\d{13})$/']
        ];
    }

    protected function passedValidation()
    {
        if($this->has('isbn')) {
            $this->merge([
                'isbn' =>  implode(';', $this->input('isbn')),
            ]);
        }
    }
}
