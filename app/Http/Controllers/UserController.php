<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Components\Permission;
use App\Http\Requests\User\SearchRequest;
use App\Http\Requests\User\UserRequest;
use App\Services\User\UserService;
use App\Services\User\SearchService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * @var UserService
     */
    private $service;

    /**
     * ContactController constructor.
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
            'index'  => Permission::USERS_INDEX,
            'create' => Permission::USERS_ADD,
            'store'  => Permission::USERS_ADD,
            'edit'   => Permission::USERS_EDIT,
            'update' => Permission::USERS_EDIT,
            'delete' => Permission::USERS_DELETE,
        ];
    }

    /**
     * @param SearchRequest $request
     * @param SearchService $search
     * @return View
     */
    public function index(SearchRequest $request, SearchService $search): View
    {
        $sort      = $request->get('sort', 'name');
        $direction = $request->get('direction', 'asc');

        $users = $search->search($request);

        return view('users.index', compact('users', 'sort', 'direction'));
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('users.form', [
            'user' => new User(),
        ]);
    }

    /**
     * @param UserRequest $request
     * @return RedirectResponse
     */
    public function store(UserRequest $request): RedirectResponse
    {
        try {
            $this->service->create($request);
        } catch (\DomainException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->route('users.index')->with('success', 'added');
    }

    /**
     * @param User $user
     * @return View
     */
    public function edit(User $user): View
    {
        return view('users.form', [
            'user'        => $user,
            'permissions' => Permission::all(),
        ]);
    }

    /**
     * @param UserRequest $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(UserRequest $request, User $user): RedirectResponse
    {
        try {
            $this->service->edit($user->id, $request);
        } catch (\DomainException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return back()->with('success', 'updated');
    }

    /**
     * @param $id
     * @return RedirectResponse
     * @throws \Exception
     */
    public function delete($id): RedirectResponse
    {
        try {
            $this->service->delete($id);
        } catch (\DomainException $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('users.index')->with('success', 'deleted');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws \Exception
     */
    public function deleteSelect(Request $request): RedirectResponse
    {
        try {
            foreach ($request->get('select', []) as $id) {
                $this->service->delete($id);
            }
        } catch (\DomainException $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', 'deleted');
    }
}
