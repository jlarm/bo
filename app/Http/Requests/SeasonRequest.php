<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class SeasonRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'uuid' => ['required'],
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'archived' => ['boolean'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
