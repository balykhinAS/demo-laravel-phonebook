<?php

namespace App\Services\Contact;

use App\Http\Requests\Contact\SearchRequest;
use App\Models\Contact;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SearchService
{
    /**
     * @param SearchRequest $request
     * @param int $userId
     * @param int $perPage
     * @param int|null $page
     * @return LengthAwarePaginator
     */
    public function search(SearchRequest $request, int $userId, int $perPage = 20, int $page = null): LengthAwarePaginator
    {
        $sort      = $request->get('sort', 'first_name');
        $direction = $request->get('direction', 'asc');

        $query = Contact::query()->orderBy($sort, $direction);

        $searchInputs = ['first_name', 'last_name', 'middle_name', 'phone'];

        foreach ($searchInputs as $input) {
            if ($value = $request->input('search.' . $input)) {
                $query->where($input, 'like', '%' . $value . '%');
            }
        }

        if ($request->has('favorites')) {
            $query->favoredByUser(Auth::user());
        }

        $query->select('contacts.*', DB::raw('IF(contact_favorites.user_id, 1, 0) AS in_favorites'));

        $query->leftJoin('contact_favorites', function (JoinClause $join) use ($userId) {
            $join->on('contact_favorites.contact_id', '=', 'contacts.id')
                ->where('contact_favorites.user_id', '=', $userId);
        });

        return $query->paginate($perPage, ['*'], 'page', $page);
    }
}
