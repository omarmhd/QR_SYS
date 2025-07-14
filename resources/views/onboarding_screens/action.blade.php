@extends("layouts.app")

@section("content")


<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <!-- Page pre-title -->
        <div class="page-pretitle">Onboarding Screens</div>
        <h2 class="page-title"></h2>
      </div>
      <!-- Page title actions -->
      <div class="col-auto ms-auto d-print-none">
        <div class="btn-list">
          <span class="d-none d-sm-inline">
            <a href="#" class="btn btn-1"> Back </a>
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

        <form action="{{ $screen->id ? route('onboarding-screens.update', $screen->id) : route('onboarding-screens.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          @if($screen->id)
          @method('PUT')
          @endif

          <div class="card">
            <div class="card-header">
              <h3 class="card-title">
                {{ $screen->id ? 'Edit OnBoarding Screen' : 'Add New OnBoarding Screen' }}
              </h3>
            </div>
            <div class="card-body">
              <div class="row row-cards">
                <div class="mb-3 col-sm-8 col-md-10">
                  <label class="form-label required">Title</label>
                  <input name="title" type="text" class="form-control"
                    value="{{ old('title', $screen->title) }}">
                </div>
              </div>
              <div class="row row-cards">
                <div class="mb-3 col-sm-8 col-md-10">
                  <label class="form-label required">Description</label>
                  <textarea name="description" class="form-control">{{ old('description', $screen->description) }}</textarea>
                </div>
              </div>
              <div class="row row-cards">



                <div class="mb-3">
                  <label class="form-label">Upload Image</label>
                  <input type="file" name="image" class="form-control" id="imageInput" accept="image/*">
                  <div class="mt-3">
                    <img id="imagePreview" src="{{ isset($screen->image) ? asset('storage/' . $screen->image) : '#' }}"
                      style="max-height: 200px; display: {{ isset($screen->image) ? 'block' : 'none' }};">
                  </div>
                </div>
              </div>
            </div>
            <div class="card-footer text-end">
              <button type="submit" class="btn btn-primary">
                {{ $screen->id ? 'Update' : 'Save' }}
              </button>
            </div>
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


@endpush