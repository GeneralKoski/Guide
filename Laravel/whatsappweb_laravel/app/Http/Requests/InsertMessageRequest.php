<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InsertMessageRequest extends FormRequest
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
            'chat_id' => ['required', 'integer', 'not_in:7,12'],
            'user_id' => ['required', 'integer'],
            'content' => ['required', 'string', 'max:100'],
        ];
    }
    public function messages()
    {
        return [
            'chat_id.not_in' => 'Messaggi non possono essere inviati nelle chat 7 e 12 perchè non le ho gestite.',
        ];
    }
}