<?php

namespace App\Services\User;

use App\Models\User;
use App\Http\Requests\Cabinet\ProfileEditPasswordRequest;
use App\Http\Requests\Cabinet\ProfileEditRequest;
use App\Http\Requests\User\UserRequest;
use Illuminate\Contracts\Auth\StatefulGuard;

class UserService
{
    /**
     * @param int $id
     * @param ProfileEditRequest $request
     */
    public function editProfile(int $id, ProfileEditRequest $request)
    {
        $this->getUser($id)->update($request->only([
            'name',
            'email',
        ]));
    }

    /**
     * @param int $id
     * @param StatefulGuard $guard
     * @param ProfileEditPasswordRequest $request
     */
    public function updatePasswordProfile(int $id, StatefulGuard $guard, ProfileEditPasswordRequest $request)
    {
        $user = $this->getUser($id);

        $user->setPassword($request['password'])->save();

        $guard->login($user);
    }

    /**
     * @param UserRequest $request
     * @return User
     */
    public function create(UserRequest $request): User
    {
        return User::new($request['name'], $request['email']);
    }

    /**
     * @param int $id
     * @param UserRequest $request
     * @return bool
     */
    public function edit(int $id, UserRequest $request): bool
    {
        $user = $this->getUser($id);

        $user->fill($request->only([
            'name',
            'email',
        ]));

        if ($request->has('permissions')) {
            $user->setPermissions($request['permissions'] ?? []);
        }

        return $user->save();
    }

    /**
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    public function delete(int $id): bool
    {
        return $this->getUser($id)->delete();
    }

    /**
     * @param int $id
     * @return bool
     */
    public function refreshToken(int $id)
    {
        return $this->getUser($id)->refreshToken()->save();
    }

    /**
     * @param int $id
     * @param string $password
     */
    public function updatePassword(int $id, string $password)
    {
        $this->getUser($id)->setPassword($password)->save();
    }

    /**
     * @param int $id
     * @return User
     */
    protected function getUser(int $id): User
    {
        return User::findOrFail($id);
    }
}
