<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Produce;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PriceController extends Controller
{
    public function index(): View
    {
        $prices = Produce::query()
            ->where('stock', '>', 0)
            ->select('name', 'unit',
                DB::raw('MIN(price) as min_price'),
                DB::raw('ROUND(AVG(price), 2) as avg_price'),
                DB::raw('MAX(price) as max_price'),
                DB::raw('COUNT(DISTINCT store_id) as store_count'))
            ->groupBy('name', 'unit')
            ->orderBy('name')
            ->get()
            ->each(function ($row) {
                $row->cheapest = Produce::with('store')
                    ->where('name', $row->name)->where('unit', $row->unit)->where('stock', '>', 0)
                    ->orderBy('price')->first();
            });

        return view('buyer.prices', compact('prices'));
    }
}
