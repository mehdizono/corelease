<?php

namespace App\Http\Controllers;

use App\Models\Resource;

class CatalogController extends Controller
{
    /**
     * Display a listing of the resources for browsing.
     */
    public function browse()
    {
        $resources = Resource::orderBy('category')->orderBy('name')->paginate(24);

        return view('catalog.catalog', compact('resources'));
    }
}