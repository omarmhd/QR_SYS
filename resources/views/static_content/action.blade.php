@extends("layouts.app")

@section("content")


<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <!-- Page pre-title -->
        <div class="page-pretitle">Content Pages</div>
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
<form action="{{ route('static_contents.update') }}" method="POST" enctype="multipart/form-data">
  @csrf
  @method('patch')

  <div class="row row-cards">

    @foreach($contents as $key => $value)
      <div class="col-12">
        <div class="card mb-3">
          <div class="card-header">
            <h3 class="card-title text-capitalize">{{ str_replace('_', ' ', $key) }}</h3>
          </div>
          <div class="card-body">
          <label class="form-label required">Title</label>
            <input class="form-control" type="text" name="titles[{{$key}}]" value="{{$value['title']}}" id="">
            <br>
            <label class="form-label required">Content</label>

            <textarea class="form-control" name="pages[{{ $key }}]" rows="6">{{$value["content"]}}</textarea>
          </div>
        </div>
      </div>
    @endforeach
  </div>

  <div class="card-footer text-end">
    <button type="submit" class="btn btn-primary">Save</button>
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