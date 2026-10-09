<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Produce;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProduceController extends Controller
{
    public function index(Request $request): View
    {
        $produces = $request->user()->produces()
            ->when($request->q, fn ($q, $term) => $q->where('name', 'like', "%{$term}%"))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('store.produce.index', compact('produces'));
    }

    public function create(): View
    {
        return view('store.produce.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->user()->produces()->create($this->validated($request));

        return redirect()->route('store.produce.index')->with('success', 'Produce listed successfully.');
    }

    public function edit(Request $request, Produce $produce): View
    {
        $this->authorizeOwner($request, $produce);

        return view('store.produce.edit', compact('produce'));
    }

    public function update(Request $request, Produce $produce): RedirectResponse
    {
        $this->authorizeOwner($request, $produce);
        $produce->update($this->validated($request));

        return redirect()->route('store.produce.index')->with('success', 'Produce updated.');
    }

   public function destroy(Request $request, Produce $produce): RedirectResponse
{
    $this->authorizeOwner($request, $produce);

    if (\App\Models\Order::where('produce_id', $produce->id)->exists()) {
        return back()->withErrors(['order' => 'This produce has orders and cannot be deleted. Set its stock to 0 instead.']);
    }

    $produce->delete();

    return redirect()->route('store.produce.index')->with('success', 'Produce removed.');
}

    private function authorizeOwner(Request $request, Produce $produce): void
    {
        abort_unless($produce->store_id === $request->user()->id, 403);
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'category' => ['required', Rule::in(Produce::CATEGORIES)],
            'price' => ['required', 'numeric', 'min:0.01', 'max:99999999'],
            'unit' => ['required', Rule::in(Produce::UNITS)],
            'stock' => ['required', 'integer', 'min:0', 'max:1000000'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);
    }
}
