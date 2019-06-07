<?php

namespace App\Http\Controllers\Cabinet;

use App\Components\Permission;
use App\Services\User\UserService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cabinet\ProfileEditPasswordRequest;
use App\Http\Requests\Cabinet\ProfileEditRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

/**
 * @property UserService $service
 */
class ProfileController extends Controller
{
    private $service;

    /**
     * @param UserService $service
     */
    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    /**
     * @return array
     */
    protected function accessActions()
    {
        return [
            '*' => Permission::PROFILE_EDIT,
        ];
    }

    /**
     * @return View
     */
    public function show(): View
    {
        return view('cabinet.profile.show', [
            'user' => Auth::user(),
        ]);
    }

    /**
     * @return View
     * @throws \Exception
     */
    public function edit(): View
    {
        return view('cabinet.profile.edit', [
            'user' => Auth::user(),
        ]);
    }

    /**
     * @param ProfileEditRequest $request
     * @return RedirectResponse
     */
    public function update(ProfileEditRequest $request): RedirectResponse
    {
        try {
            $this->service->editProfile(Auth::id(), $request);
        } catch (\DomainException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->route('cabinet.profile.show')->with('success', 'updated');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function refreshApiToken(Request $request): RedirectResponse
    {
        try {
            $this->service->refreshToken(Auth::id());
        } catch (\DomainException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->route('cabinet.profile.show')->with('success', 'updated');
    }

    /**
     * @return View
     */
    public function editPassword(): View
    {
        return view('cabinet.profile.change_password');
    }

    /**
     * @param ProfileEditPasswordRequest $request
     * @return RedirectResponse
     */
    public function updatePassword(ProfileEditPasswordRequest $request): RedirectResponse
    {
        try {
            $this->service->updatePasswordProfile(Auth::id(), Auth::guard(), $request);
        } catch (\DomainException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->route('cabinet.profile.show')->with('success', 'updated');
    }
}
