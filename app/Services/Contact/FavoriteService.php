<?php

namespace App\Services\Contact;

use App\Models\Contact;
use App\Models\User;

class FavoriteService
{
    /**
     * @param int $userId
     * @param int $contactId
     */
    public function add(int $userId, int $contactId)
    {
        $user   = $this->getUser($userId);
        $contact = $this->getContact($contactId);

        $user->addToFavorites($contact->id);
    }

    /**
     * @param int $userId
     * @param int $contactId
     */
    public function remove(int $userId, int $contactId)
    {
        $user   = $this->getUser($userId);
        $contact = $this->getContact($contactId);

        $user->removeFromFavorites($contact->id);
    }

    /**
     * @param int $userId
     * @return User
     */
    private function getUser(int $userId): User
    {
        return User::findOrFail($userId);
    }

    /**
     * @param int $contactId
     * @return Contact
     */
    private function getContact(int $contactId): Contact
    {
        return Contact::findOrFail($contactId);
    }
}
