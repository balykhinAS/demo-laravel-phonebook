<?php

namespace App\Services\Contact;

use App\Models\Contact;
use App\Http\Requests\Contact\ContactRequest;

class ContactService
{
    /**
     * @param ContactRequest $request
     * @return Contact
     */
    public function create(ContactRequest $request): Contact
    {
        return Contact::create($request->only([
            'first_name',
            'last_name',
            'middle_name',
            'phone',
        ]));
    }

    /**
     * @param int $id
     * @param ContactRequest $request
     * @return bool
     */
    public function edit(int $id, ContactRequest $request): bool
    {
        return Contact::findOrFail($id)->update($request->only([
            'first_name',
            'last_name',
            'middle_name',
            'phone',
        ]));
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return Contact::findOrFail($id)->delete();
    }
}
