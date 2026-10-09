@php $p = $produce ?? null; @endphp

<div class="row g-3 mb-3">
  <div class="col-md-6">
    <label class="form-label-custom" for="name">Produce name</label>
    <input type="text" id="name" name="name" class="form-control-custom" value="{{ old('name', $p?->name) }}"
      placeholder="e.g. Fresh Tomatoes" required>
    @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
  </div>
  <div class="col-md-6">
    <label class="form-label-custom" for="category">Category</label>
    <select id="category" name="category" class="form-select-custom" required>
      @foreach (\App\Models\Produce::CATEGORIES as $c)
        <option value="{{ $c }}" @selected(old('category', $p?->category) === $c)>{{ $c }}</option>
      @endforeach
    </select>
    @error('category') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
  </div>
</div>

<div class="row g-3 mb-3">
  <div class="col-md-4">
    <label class="form-label-custom" for="price">Price (₱)</label>
    <input type="number" step="0.01" min="0.01" id="price" name="price" class="form-control-custom"
      value="{{ old('price', $p?->price) }}" required>
    @error('price') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
  </div>
  <div class="col-md-4">
    <label class="form-label-custom" for="unit">Unit</label>
    <select id="unit" name="unit" class="form-select-custom" required>
      @foreach (\App\Models\Produce::UNITS as $u)
        <option value="{{ $u }}" @selected(old('unit', $p?->unit ?? 'kg') === $u)>{{ $u }}</option>
      @endforeach
    </select>
    @error('unit') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
  </div>
  <div class="col-md-4">
    <label class="form-label-custom" for="stock">Stock available</label>
    <input type="number" min="0" step="1" id="stock" name="stock" class="form-control-custom"
      value="{{ old('stock', $p?->stock) }}" required>
    @error('stock') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
  </div>
</div>

<div class="mb-4">
  <label class="form-label-custom" for="description">Description (optional)</label>
  <textarea id="description" name="description" rows="3" class="form-control-custom"
    placeholder="Freshly harvested, grown without...">{{ old('description', $p?->description) }}</textarea>
  @error('description') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
</div>

<div class="d-flex gap-2">
  <button type="submit" class="btn-custom btn-custom-primary">{{ $p ? 'Save Changes' : 'List Produce' }}</button>
  <a href="{{ route('store.produce.index') }}" class="btn-custom btn-custom-light">Cancel</a>
</div>
