<?php

namespace App\Http\Controllers\Api;

use App\Components\Permission;
use App\Http\Requests\Contact\SearchRequest;
use App\Http\Resources\ContactListResource;
use App\Services\Contact\SearchService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    /**
     * @return array
     */
    protected function accessActions()
    {
        return [
            'index' => Permission::CONTACTS_INDEX,
        ];
    }

    public function index(SearchRequest $request, SearchService $search)
    {
        return ContactListResource::collection($search->search($request, Auth::id()))->additional([
            'meta' => [
                'sort'      => $request->get('sort', 'first_name'),
                'direction' => $request->get('direction', 'asc'),
                'favorites' => $request->get('favorites'),
                'search'    => [
                    'first_name'  => $request->input('search.first_name'),
                    'last_name'   => $request->input('search.last_name'),
                    'middle_name' => $request->input('search.middle_name'),
                    'phone'       => $request->input('search.phone'),
                ],
            ],
        ]);
    }
}
