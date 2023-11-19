<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class StoreClientRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'contact_name' => ['required', 'string', 'max:255'],
            'contact_email' => [
                'required', 
                'email', 
                'max:255', 
                Rule::unique('clients')->ignore($this->id)
            ],
            'contact_phone_number' => ['required', 'string', 'max:18'],
            'company_name' => ['required', 'string', 'max:255'],
            'company_address' => ['required', 'string', 'max:255'],
            'company_city' => ['required', 'string', 'max:50'],
            'contact_zip' => ['required', 'string', 'max:10'],
            'company_vat' => ['required', 'integer']
        ];
    }
}
