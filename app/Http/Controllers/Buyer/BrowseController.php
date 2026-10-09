<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Produce;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BrowseController extends Controller
{
    public function index(Request $request): View
    {
        $produces = Produce::with('store')
            ->where('stock', '>', 0)
            ->when($request->q, fn ($q, $t) => $q->where('name', 'like', "%{$t}%"))
            ->when($request->category, fn ($q, $c) => $q->where('category', $c))
            ->when($request->store, fn ($q, $id) => $q->where('store_id', $id))
            ->orderBy('price')
            ->paginate(9)
            ->withQueryString();

        return view('buyer.browse', compact('produces'));
    }
}
