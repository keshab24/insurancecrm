<div class="form-row align-items-center" id="option_{{ $id }}">
    <div class="col-12 col-md-5">
        <div class="form-group">
            <label for="company_{{ $id }}" class="font-weight-bold">Companies</label>
            <select
                id="company_{{ $id }}"
                name="companies[]"
                class="custom-select search-select"
                onchange="findProducts({{ $id }})"
                required
            >
                <option selected disabled>Select a company</option>
                @foreach($companies as $company)
                    <option
                        value="{{ $company->id }}"
                        data-products="{{ $company->products }}"
                    >
                        {{ $company->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-12 col-md-5">
        <div class="form-group">
            <label for="product_{{ $id }}" class="font-weight-bold">Policies</label>
            <select id="product_{{ $id }}" name="products[]" class="custom-select search-select"  required>
                <option selected disabled>Select a product</option>
            </select>
        </div>
    </div>

    <div class="col-12 col-md-2">
        <button
            class="btn btn-danger mt-2 w-100"
            data-id="{{ $id }}"
            onclick="removeRow({{ $id }})"
        >Remove Row
        </button>
    </div>
</div>
