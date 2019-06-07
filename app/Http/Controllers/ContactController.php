<?php

namespace App\Http\Controllers;

use App\Components\Permission;
use App\Models\Contact;
use App\Http\Requests\Contact\ContactRequest;
use App\Http\Requests\Contact\SearchRequest;
use App\Services\Contact\ContactService;
use App\Services\Contact\SearchService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ContactController extends Controller
{
    /**
     * @var ContactService
     */
    private $service;

    /**
     * ContactController constructor.
     *
     * @param ContactService $service
     */
    public function __construct(ContactService $service)
    {
        $this->service = $service;
    }

    /**
     * @return array
     */
    protected function accessActions()
    {
        return [
            'index'        => Permission::CONTACTS_INDEX,
            'create'       => Permission::CONTACTS_ADD,
            'store'        => Permission::CONTACTS_ADD,
            'edit'         => Permission::CONTACTS_INDEX,
            'update'       => Permission::CONTACTS_EDIT,
            'delete'       => Permission::CONTACTS_DELETE,
            'deleteSelect' => Permission::CONTACTS_DELETE,
        ];
    }

    /**
     * @param SearchRequest $request
     * @param SearchService $search
     * @return View
     */
    public function index(SearchRequest $request, SearchService $search): View
    {
        $sort      = $request->get('sort', 'first_name');
        $direction = $request->get('direction', 'asc');

        $contacts = $search->search($request, Auth::id());

        return view('contacts.index', compact('contacts', 'sort', 'direction'));
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('contacts.form', [
            'contact' => new Contact(),
        ]);
    }

    /**
     * @param ContactRequest $request
     * @return RedirectResponse
     */
    public function store(ContactRequest $request): RedirectResponse
    {
        try {
            $this->service->create($request);
        } catch (\DomainException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->route('contacts.index')->with('success', 'added');
    }

    /**
     * @param Contact $contact
     * @return View
     */
    public function edit(Contact $contact): View
    {
        return view('contacts.form', [
            'contact' => $contact,
        ]);
    }

    /**
     * @param ContactRequest $request
     * @param Contact $contact
     * @return RedirectResponse
     */
    public function update(ContactRequest $request, Contact $contact): RedirectResponse
    {
        try {
            $this->service->edit($contact->id, $request);
        } catch (\DomainException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return back()->with('success', 'updated');
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function delete($id): RedirectResponse
    {
        try {
            $this->service->delete($id);
        } catch (\DomainException $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('contacts.index')->with('success', 'deleted');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
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
