@extends("layouts.app")

@section("content")


<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <!-- Page pre-title -->
        <div class="page-pretitle">Send Notification</div>
        <h2 class="page-title"></h2>
      </div>
      <!-- Page title actions -->
      <div class="col-auto ms-auto d-print-none">
        <div class="btn-list">
          <span class="d-none d-sm-inline">
            <a href="{{route('users.index')}}" class="btn btn-1"> Back </a>
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
        <form action="{{ route('notifications.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="card">
            <div class="card-body">

              {{-- Alerts --}}
              @if ($errors->any())
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

                <ul class="nav nav-tabs mb-3" role="tablist">
                    @foreach($locales as $locale)
                        <li class="nav-item" role="presentation">
                            <a class="nav-link @if ($loop->first) active @endif" data-bs-toggle="tab" href="#tab-{{ $locale }}" role="tab">
                                {{ $locale->label() }}
                            </a>
                        </li>
                    @endforeach
                </ul>

                <div class="tab-content">
                    @foreach($locales as $locale)
                        <div class="tab-pane fade @if ($loop->first) show active @endif" id="tab-{{ $locale }}" role="tabpanel">

                            <!-- Name -->

                            <div class="mb-3">
                                <label class="form-label required">Title ({{ $locale->value}})</label>
                                <input type="text" name="title[{{ $locale->value }}]" class="form-control"
                                       value="" required>
                            </div>


                            <div class="mb-3">
                                <label class="form-label required"> Body({{ $locale }})</label>
                                <textarea name="body[{{ $locale }}]" class="form-control" required></textarea>
                            </div>

                        </div>
                    @endforeach
                </div>
              <div class="row row-cards">





                <div class="card-footer text-end">
                  <button type="submit" class="btn btn-primary">
                    Send Notification
                  </button>
                </div>
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
<script>
  document.getElementById('add-feature-btn').addEventListener('click', function() {
    const wrapper = document.getElementById('features-wrapper');

    const div = document.createElement('div');
    div.classList.add('input-group', 'mb-2');
    div.innerHTML = `
        <input type="text" name="features[]" class="form-control" placeholder="" required>
        <button type="button" class="btn btn-danger" onclick="this.parentElement.remove()">❌</button>
    `;
    wrapper.appendChild(div);
  });
</script>


@endpush
