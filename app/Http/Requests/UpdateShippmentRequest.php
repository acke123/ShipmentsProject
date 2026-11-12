<?php

namespace App\Http\Requests;

use App\Rules\UserClient;
use App\Rules\UserTrucker;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateShippmentRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:128',
            'from_city' => 'required|string|max:64',
            'from_country' => 'required|string|max:64',
            'to_city' => 'required|string|max:64',
            'to_country' => 'required|string|max:64',
            'price' => 'required|integer|min:0',
            'status' => 'required|in:in_progress,unassigned,completed,problem',
            'details' => 'required|string',
            'user_id' => [
                'required',
                new UserTrucker()
            ],
            'client_id' => [
                'required',
                new UserClient()
            ]
        ];
    }
}
