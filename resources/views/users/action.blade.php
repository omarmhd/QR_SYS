@extends("layouts.app")

@section("content")


<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <!-- Page pre-title -->
        <div class="page-pretitle">Edit User</div>
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


        <form action="{{ isset($user->id) ? route('users.update', $user->id) : route('users.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          @if(isset($user->id))
          @method('PUT')
          @endif

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

              {{-- Name --}}


              <div class="row row-cards">
                <div class="mb-3 col-sm-8 col-md-6">
                  <label class="form-label required">Name</label>
                  <input name="name" type="text" class="form-control"
                    value="{{ old('name', $user->name ?? '') }}">
                </div>

                {{-- email --}}
                <div class="mb-3 col-sm-8 col-md-6">
                  <label class="form-label required">Email</label>
                  <input type="text" name="email" class="form-control"
                    value="{{ old('email', $user->email ?? '') }}">
                </div>


                {{-- phone --}}
                <div class="mb-3 col-sm-8 col-md-6">
                  <label class="form-label required">Phone</label>
                  <input type="number" name="phone" class="form-control"
                    value="{{ old('phone', $user->phone ?? '') }}">
                </div>
                <div class="mb-3 col-sm-8 col-md-6">
                  <label class="form-label required">DOB</label>
                  <input type="date" name="dob" class="form-control"
                    value="{{ old('dob', $user->dob ?? '') }}">
                </div>

                {{-- Currency --}}
                <div class="mb-3 col-sm-8 col-md-6">
                  <label class="form-label required">Plans</label>
                  <select name="plan_id" class="form-control">
                    @foreach ($plans as $plan)
                    <option value="{{$plan->id}}" {{old('plan_id', $user->plan_id ?? '') == $plan->id ? 'selected' : ''}}>{{$plan->name["en"]}}</option>

                    @endforeach


                  </select>
                </div>



                <div class="mb-3 col-sm-8 col-md-6">
                  <label class="form-label required">Approval Status</label>
                  <select name="approval_status" class="form-control">
                    @foreach (\App\ApprovalStatus::cases() as $status )
                            <option value="{{ $status->value }}"
                                {{ old('status', $user->approval_status ?? '') == $status->value ? 'selected' : '' }}>
                                {{ ucfirst($status->name) }}
                            </option>

                    @endforeach
                  </select>
                </div>



                <div class="mb-3 col-sm-8 col-md-6">
                  <label class="form-label required">Subscription Status</label>
                                      <select name="subscription_status" class="form-control">

                            <option value="0"
                                {{ old('subscription_status', $user->subscription_status ?? '') == 1 ? 'selected' : '' }}>
                              Yes
                            </option>

                                                        <option value="1"
                                {{ old('subscription_status', $user->subscription_status ?? '') == 0 ? 'selected' : '' }}>
                                No
                              </option>
                                      </select>

                </label>
                </div>

                <div class="card-footer text-end">
                  <button type="submit" class="btn btn-primary">
                    {{ isset($user->id) ? 'Update User' : 'Create User' }}
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
