<?php

namespace App\Console\Commands;

use App\Components\Permission;
use App\Models\User;
use Illuminate\Console\Command;

class Permissions extends Command
{
    /**
     * @var string
     */
    protected $signature = 'user:permissions';

    /**
     * @var string
     */
    protected $description = 'Change permissions';

    /**
     *
     */
    public function handle()
    {
        $email = $this->ask('Email');

        /** @var User $user */
        if (!$user = User::where('email', $email)->first()) {
            $this->error('Undefined user with email ' . $email);
            return false;
        }

        try {
            $user->setPermissions(Permission::all())->save();
        } catch (\DomainException $e) {
            $this->error($e->getMessage());
            return false;
        }

        $this->info('Permissions is successfully changed');
        return true;
    }
}
