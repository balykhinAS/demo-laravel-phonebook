<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Services\Contact\FavoriteService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController
{
    private $service;

    /**
     * @param FavoriteService $service
     */
    public function __construct(FavoriteService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Contact $contact
     * @return JsonResponse|RedirectResponse
     */
    public function add(Contact $contact)
    {
        $result = null;

        try {
            $this->service->add(Auth::id(), $contact->id);
            $result = 'success';
        } catch (\DomainException $e) {
            $result = $e->getMessage();
        }

        return request()->ajax()
            ? response()->json(['result' => $result])
            : back()->with('success', $result);
    }

    /**
     * @param Contact $contact
     * @return JsonResponse|RedirectResponse
     */
    public function remove(Contact $contact)
    {
        $result = null;

        try {
            $this->service->remove(Auth::id(), $contact->id);
            $result = 'success';
        } catch (\DomainException $e) {
            $result = $e->getMessage();
        }

        return request()->ajax()
            ? response()->json()
            : back()->with('success', $result);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function addSelect(Request $request): RedirectResponse
    {
        foreach ($request->get('select', []) as $id) {
            try {
                $this->service->add(Auth::id(), $id);
            } catch (\DomainException $e) {
            }
        }

        return back()->with('success', 'added');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function removeSelect(Request $request): RedirectResponse
    {
        foreach ($request->get('select', []) as $id) {
            try {
                $this->service->remove(Auth::id(), $id);
            } catch (\DomainException $e) {
            }
        }

        return back()->with('success', 'deleted');
    }
}
