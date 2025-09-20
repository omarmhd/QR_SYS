@extends("layouts.app")

@section("content")


<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <!-- Page pre-title -->
        <div class="page-pretitle"> Plans</div>
        <h2 class="page-title"></h2>
      </div>
      <!-- Page title actions -->
      <div class="col-auto ms-auto d-print-none">
        <div class="btn-list">
          <span class="d-none d-sm-inline">
            <a href="{{route('plans.index')}}" class="btn btn-1"> Back </a>
          </span>


          <a
            href="#"
            class="btn btn-primary btn-6 d-sm-none btn-icon"
            data-bs-toggle="modal"
            data-bs-target="#modal-report"
            aria-label="Create new report">
            <!-- Download SVG icon from http://tabler.io/icons/icon/plus -->
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="24"
              height="24"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
              class="icon icon-2">
              <path d="M12 5l0 14" />
              <path d="M5 12l14 0" />
            </svg>
          </a>
        </div>
        <!-- BEGIN MODAL -->
        <!-- END MODAL -->
      </div>
    </div>
  </div>
</div>
<!-- END PAGE HEADER -->
<!-- BEGIN PAGE BODY -->
<div class="page-body">
  <div class="container-xl">

    <div class="row  row-cards">
      <div class="col-12">




  <div class="card">
    <div class="card-body">

      {{-- Alerts --}}
      @if  ($errors->any())
        <div class="alert alert-danger" role="alert">
          <div class="alert-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
              viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
              stroke-linecap="round" stroke-linejoin="round"
              class="icon alert-icon icon-2">
              <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
              <path d="M12 8v4" />
              <path d="M12 16h.01" />
            </svg>
          </div>
          <div>
            <h4 class="alert-heading">Please fix the following:</h4>
            <div class="alert-description">
              <ul class="mb-0">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          </div>
        </div>
      @endif

      {{-- Name --}}


@php
    $locales = \App\LocaleEnum::cases();
@endphp


<form action="{{ isset($plan->id) ? route('plans.update', $plan->id) : route('plans.store') }}" method="POST" enctype="multipart/form-data">
  @csrf
  @if(isset($plan->id))
    @method('PUT')
  @endif

  <div class="row row-cards">
    <!-- Name Field (Multi-language) -->
    <div class="mb-3 col-sm-8 col-md-12">
        <label class="form-label required">Name / Nom</label>
        <ul class="nav nav-tabs" role="tablist">
            @foreach($locales as $locale)
                <li class="nav-item">
                    <a class="nav-link @if ($loop->first) active @endif"
                       data-bs-toggle="tab"
                       href="#name-{{ $locale->value }}">
                        {{ $locale->label() }}
                    </a>
                </li>
            @endforeach
        </ul>
        <div class="tab-content">
            @foreach($locales as $locale)

                <div class="tab-pane fade @if ($loop->first) show active @endif" id="name-{{ $locale->value }}" role="tabpanel">
                    <input name="name[{{ $locale->value }}]" type="text" class="form-control"
                          value="{{ old('name.'.$locale->value, $plan->name[$locale->value] ?? '') }}" required>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Price Field (Single) -->


    <!-- Guest Passes Field (Single) -->
    <div class="mb-3 col-sm-8 col-md-4">
        <label class="form-label required">Guest Passes</label>
        <input type="number" name="guest_passes_per_year" class="form-control"
              value="{{ old('guest_passes_per_year', $plan->guest_passes_per_year ?? '') }}" required>
    </div>

    <!-- Currency Field (Single) -->
    <div class="mb-3 col-sm-8 col-md-4">
        <label class="form-label required">Currency</label>
        <select name="currency" class="form-control">
            <option value="EUR" {{ old('currency', $plan->currency ?? '') == 'EUR' ? 'selected' : '' }}>EUR</option>
            <option value="USD" {{ old('currency', $plan->currency ?? '') == 'USD' ? 'selected' : '' }}>USD</option>
        </select>
    </div>

    <!-- Billing Type Field (Single) -->
    <div class="mb-3 col-sm-8 col-md-4">
        <label class="form-label required">Billing Type</label>
        <select name="billing_type" class="form-control">
            <option value="day" {{ old('billing_type', $plan->billing_type ?? '') == 'day' ? 'selected' : '' }}>Day</option>
            <option value="month" {{ old('billing_type', $plan->billing_type ?? '') == 'month' ? 'selected' : '' }}>Month</option>
            <option value="year" {{ old('billing_type', $plan->billing_type ?? '') == 'year' ? 'selected' : '' }}>Year</option>
        </select>
    </div>

    <!-- Is Popular Field (Single) -->
    <div class="mb-3 col-sm-8 col-md-2">
        <label class="form-label required">Is Popular</label>
        <label class="form-check form-check-single form-switch" style="padding: 0px">
            <input name="is_popular" class="form-check-input" type="checkbox" style="width:50px; height: 20px;"
                  {{ old('is_popular', $plan->is_popular ?? false) ? 'checked' : '' }}>
        </label>
    </div>



      <div class="mb-3 col-sm-8 col-md-2">
          <label class="form-label required">Hide Price</label>
          <label class="form-check form-check-single form-switch" style="padding: 0px">

              <input name="is_price_hidden" class="form-check-input" type="checkbox" style="width:50px; height: 20px;"
              {{ old('is_price_hidden', $plan->is_price_hidden ?? false) ? 'checked' : '' }}
          </label>
      </div>

      <div class="mb-3 col-sm-8 col-md-4 {{ $plan->is_price_hidden ? 'd-none' : '' }}">
          <label class="form-label">Price</label>
          <input type="text"
                 name="price"
                 class="form-control"
                 value="{{ old('price', $plan->price ?? 0) }}"
              {{ $plan->is_price_hidden ? '' : 'required' }}>
      </div>



      <!-- Features Field (Multi-language) -->
    <div class="mb-3 col-sm-8 col-md-12">
        <label class="form-label required">Features / Fonctionnalités</label>
        <ul class="nav nav-tabs" role="tablist">
            @foreach($locales as $locale)
                <li class="nav-item">
                    <a class="nav-link @if ($loop->first) active @endif"
                       data-bs-toggle="tab"
                       href="#features-{{ $locale->value }}">
                        {{ $locale->label() }}
                    </a>
                </li>
            @endforeach
        </ul>
        <div class="tab-content">
            @foreach($locales as $locale)
                <div class="tab-pane fade @if ($loop->first) show active @endif" id="features-{{ $locale->value }}" role="tabpanel">
                    <div id="features-wrapper-{{ $locale->value }}">
                        @php
                            $features = old('features.'.$locale->value,$plan->features[$locale->value] ?? ['']);
                            @endphp

                        @foreach ($features as $feature)
                            <div class="input-group mb-2">
                                <input type="text" name="features[{{ $locale->value }}][]" class="form-control"
                                      placeholder="" value="{{ $feature }}" required>
                                <button type="button" class="btn btn-danger" onclick="this.parentElement.remove()">❌</button>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="add-feature-btn"
                            onclick="addFeatureField('{{ $locale->value }}')">➕ Add</button>
                </div>
            @endforeach
        </div>
    </div>
</div>


  <div class="card-footer text-end">
      <button type="submit" class="btn btn-primary">
          {{ isset($plan) ? 'Update' : 'Save' }}
      </button>
  </div>

</form>



      </div>
    </div>
  </div>
</div>
</div>
@endsection

@push("js")
<script>
  document.getElementById('imageInput').addEventListener('change', function(event) {
    const preview = document.getElementById('imagePreview');
    const file = event.target.files[0];

    if (file) {
      preview.src = URL.createObjectURL(file);
      preview.style.display = 'block';
    }
  });
</script>

        <script>
            function addFeatureField(locale) {
                const wrapper = document.getElementById('features-wrapper-' + locale);
                const div = document.createElement('div');
                div.className = "input-group mb-2";
                div.innerHTML = `
            <input type="text" name="features[${locale}][]" class="form-control" required>
            <button type="button" class="btn btn-danger" onclick="this.parentElement.remove()">❌</button>
        `;
                wrapper.appendChild(div);
            }


            $("input[name=is_price_hidden]").on("change", function () {
                let priceField = $("input[name=price]").closest(".mb-3");
                if ($(this).is(":checked")) {
                    priceField.addClass("d-none");
                    $("input[name=price]").prop("required", false);
                } else {
                    priceField.removeClass("d-none");
                    $("input[name=price]").prop("required", true);
                }
            });
</script>



@endpush
