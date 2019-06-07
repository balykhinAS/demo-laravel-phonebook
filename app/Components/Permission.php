<?php

namespace App\Components;

class Permission
{
    const PROFILE_EDIT = 'profile.edit';

    const CONTACTS_INDEX  = 'contacts.index';
    const CONTACTS_EDIT   = 'contacts.edit';
    const CONTACTS_ADD    = 'contacts.add';
    const CONTACTS_DELETE = 'contacts.delete';

    const USERS_INDEX  = 'users.index';
    const USERS_EDIT   = 'users.edit';
    const USERS_ADD    = 'users.add';
    const USERS_DELETE = 'users.delete';

    /**
     * @return array
     */
    public static function all()
    {
        return [
            static::PROFILE_EDIT,

            static::CONTACTS_INDEX,
            static::CONTACTS_EDIT,
            static::CONTACTS_ADD,
            static::CONTACTS_DELETE,

            static::USERS_INDEX,
            static::USERS_EDIT,
            static::USERS_ADD,
            static::USERS_DELETE,
        ];
    }

    /**
     * @return array
     */
    public static function user()
    {
        return [
            static::PROFILE_EDIT,

            static::CONTACTS_INDEX,
        ];
    }
}