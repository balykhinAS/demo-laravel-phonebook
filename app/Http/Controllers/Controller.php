<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Gate;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function callAction($method, $parameters)
    {
        if (method_exists($this, 'accessActions')) {
            $access = $this->accessActions();

            $permission = $access[$method] ?? ($access['*'] ?? null);

            if ($permission) {
                if (!Gate::allows('check-access', $permission)) {
                    abort(403);
                }
            }
        }

        return parent::callAction($method, $parameters);
    }
}
