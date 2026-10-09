<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\View\View;

class StoreController extends Controller
{
    public function index(): View
    {
        $stores = User::where('role', 'store')
            ->withCount(['produces as listed_count' => fn ($q) => $q->where('stock', '>', 0)])
            ->orderBy('store_name')
            ->paginate(9);

        return view('buyer.stores', compact('stores'));
    }
}
