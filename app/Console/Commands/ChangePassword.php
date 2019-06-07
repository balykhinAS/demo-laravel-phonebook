<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\User\UserService;
use Illuminate\Console\Command;

class ChangePassword extends Command
{
    /**
     * @var string
     */
    protected $signature = 'user:change-password';

    /**
     * @var string
     */
    protected $description = 'Change password';

    /**
     * @param UserService $service
     * @return bool
     */
    public function handle(UserService $service)
    {
        $email    = $this->ask('Email');
        $password = $this->ask('Password');

        /** @var User $user */
        if (!$user = User::where('email', $email)->first()) {
            $this->error('Undefined user with email ' . $email);
            return false;
        }

        try {
            $service->updatePassword($user->id, $password);
        } catch (\DomainException $e) {
            $this->error($e->getMessage());
            return false;
        }

        $this->info('Password is successfully changed');
        return true;
    }
}
