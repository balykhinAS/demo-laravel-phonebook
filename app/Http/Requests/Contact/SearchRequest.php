<?php

namespace App\Http\Requests\Contact;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SearchRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'sort'      => ['nullable', 'string', Rule::in(['first_name', 'last_name', 'middle_name', 'phone'])],
            'direction' => ['nullable', 'string', Rule::in(['asc', 'desc'])],
            'search.*'  => 'nullable|string',
            'favorites' => 'nullable|boolean',
        ];
    }
}
