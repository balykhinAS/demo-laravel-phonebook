<?php

namespace App\Services\User;

use App\Models\User;
use App\Http\Requests\User\SearchRequest;

class SearchService
{
    public function search(SearchRequest $request, $perPage = 20, $page = null)
    {
        $sort      = $request->get('sort', 'name');
        $direction = $request->get('direction', 'asc');

        $query = User::query()->orderBy($sort, $direction);

        $searchInputs = ['name', 'email'];

        foreach ($searchInputs as $input) {
            if ($value = $request->input('search.' . $input)) {
                $query->where($input, 'like', '%' . $value . '%');
            }
        }

        return $query->paginate($perPage, ['*'], 'page', $page);
    }
}