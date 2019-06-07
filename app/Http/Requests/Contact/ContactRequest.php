<?php

namespace App\Http\Requests\Contact;

use App\Models\Contact;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property Contact $contact
 */
class ContactRequest extends FormRequest
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
        $unique = '|unique:contacts,phone' . ($this->contact ? ',' . $this->contact->id : '');

        return [
            'first_name'  => 'required|string|min:3|max:255',
            'last_name'   => 'required|string|min:3|max:255',
            'middle_name' => 'required|string|min:3|max:255',
            'phone'       => 'required|string|min:10|max:255|regex:/^\d+$/s' . $unique,
        ];
    }
}
