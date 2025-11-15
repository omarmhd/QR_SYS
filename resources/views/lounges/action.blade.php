@extends("layouts.app")

@section("content")


<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <!-- Page pre-title -->
        <div class="page-pretitle"> Lounges</div>
        <h2 class="page-title"></h2>
      </div>
      <!-- Page title actions -->
      <div class="col-auto ms-auto d-print-none">
        <div class="btn-list">
          <span class="d-none d-sm-inline">
            <a href="{{route('lounges.index')}}" class="btn btn-1"> Back </a>
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




        <form action="{{ isset($lounge->id) ? route('lounges.update', $lounge->id) : route('lounges.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($lounge->id))
                @method('PUT')
            @endif

            <div class="row row-cards">

                <!-- Tabs for languages -->
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
                                <label class="form-label required">Name ({{ $locale->value}})</label>
                                <input type="text" name="name[{{ $locale->value }}]" class="form-control"
                                       value="{{ old('name.'.$locale->value,$lounge->name[$locale->value] ?? "")}}" required>
                            </div>


                            <div class="mb-3">
                                <label class="form-label required">Excerpt ({{ $locale }})</label>
                                <textarea name="excerpt[{{ $locale }}]" class="form-control" required>{{ old('excerpt.'.$locale->value,$lounge->excerpt[$locale->value] ?? "")}}</textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label required">Description ({{ $locale}})</label>
                                <textarea name="description[{{ $locale }}]" class="form-control" required>{{ old('description.'.$locale->value,$lounge->description[$locale->value] ?? "")}}</textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label required">Terms ({{ $locale }})</label>
                                <div id="terms-wrapper-{{ $locale }}">
                                    @php
                                        $terms = old('terms.'.$locale->value,$lounge->terms[$locale->value] ?? ['']);
                                    @endphp
                                    @foreach($terms as $term)
                                        <div class="input-group mb-2">
                                            <input type="text" name="terms[{{ $locale }}][]" value="{{$term}}" class="form-control" required>
                                            <button type="button" class="btn btn-danger" onclick="this.parentElement.remove()">❌</button>
                                        </div>
                                    @endforeach

                                </div>
                                <button type="button" class="btn btn-outline-primary btn-sm" onclick="addTermInput('{{ $locale }}')">➕ Add</button>
                            </div>

                        </div>
                    @endforeach
                </div>

                <div class="mb-3 col-md-6">
                    <label class="form-label required">Longitude</label>
                    <input type="text" name="longitude" class="form-control" autocomplete="off" value="{{old("longitude",$lounge->longitude)}}">
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label required">Latitude</label>
                    <input type="text" name="latitude" class="form-control" autocomplete="off" value="{{old("latitude",$lounge->latitude)}}">
                </div>


                <div class="mb-3 col-md-6">
                    <label class="form-label required">Open Time</label>
                    <input type="time" name="open_time" class="form-control" data-mask="00:00:00" data-mask-visible="true" placeholder="00:00:00" autocomplete="off" value="{{old("open_time",$lounge->open_time)}}">
                </div>

                <div class="mb-3 col-md-6">
                    <label class="form-label required">Close Time</label>
                    <input type="time" name="close_time" class="form-control" data-mask="00:00:00" data-mask-visible="true" placeholder="00:00:00" autocomplete="off" value="{{old("open_time",$lounge->close_time)}}">
                </div>
                <div class="mb-3">
                    <label class="form-label required">Features</label>
                    <div class="form-selectgroup form-selectgroup-boxes d-flex flex-column">

                        @foreach($features as $feature)
                        <label class="form-selectgroup-item flex-fill">
                            <input type="checkbox" name="features[]" value="{{$feature->id}}" {{in_array($feature->id,$lounge_features ?? []) || in_array($feature->id,old("features") ?? []) ?"checked":""}} class="form-selectgroup-input">
                            <div class="form-selectgroup-label d-flex align-items-center p-3">
                                <div class="me-3">
                                    <span class="form-selectgroup-check"></span>
                                </div>
                                <div class="form-selectgroup-label-content d-flex align-items-center">
                                    <span class="avatar avatar-2 me-3" style="background-image: url({{ asset('storage/'.$feature->icon) }})"> </span>
                                    <div>

                                        <div class="font-weight-medium">{{$feature->name[$locale->value]}}</div>

                                    </div>

                                </div>
                            </div>
                            <div style="margin-top:10px;">
                                <span>Don't see your feature?</span>
                                <a href="{{ route('features.create') }}" style="color:blue; text-decoration:underline;">
                                    Add new Feature
                                </a>
                            </div>
                        </label>

                        @endforeach


                    </div>
                </div>


            </div>

            <div class="row row-cards">



                <div class="mb-3">
                    <label class="form-label">Upload Image</label>
                    <small class="form-text text-muted">
                        It is recommended to upload an image with dimensions 150×100 px.
                    </small>
                    <input type="file" name="image" class="form-control" id="imageInput" accept="image/*">
                    <div class="mt-3">
                        <img id="imagePreview" src="{{ isset($lounge->image) ? asset('storage/' . $lounge->image) : '#' }}"
                             style="max-height: 200px; display: {{ isset($lounge->image) ? 'block' : 'none' }};">
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
                <button type="submit" class="btn btn-primary">
                    {{ $lounge->id ? 'Update' : 'Save' }}
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
            function addTermInput(locale) {
                const wrapper = document.getElementById('terms-wrapper-' + locale);
                const div = document.createElement('div');
                div.className = "input-group mb-2";
                div.innerHTML = `
            <input type="text" name="terms[${locale}][]" class="form-control" required>
            <button type="button" class="btn btn-danger" onclick="this.parentElement.remove()">❌</button>
        `;
                wrapper.appendChild(div);
            }
        </script>




@endpush

