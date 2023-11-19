<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use App\Enums\StatusEnum;

class StoreTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
    
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:2555'],
            'description' => ['required', 'string'],
            'dateline' => ['required'],
            'status' => ['required', new Enum(StatusEnum::class)],
            'user_id' => ['required'],
            'client_id' => ['required'],
            'project_id' => ['required'],
        ];
    }
}
