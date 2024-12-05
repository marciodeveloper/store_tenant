<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store;

class StoreController extends Controller
{
    public function index($subdomain)
    {
        dd(Store::withoutGlobalScope(\App\Scopes\TenantScope::class)
        ->whereSubdomain($subdomain)->first());
    }
}
