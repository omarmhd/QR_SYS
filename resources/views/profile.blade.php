@extends("layouts.app")

@section("content")


    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle">Profile</div>
                    <h2 class="page-title"></h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
          <span class="d-none d-sm-inline">
            <a href="#" class="btn btn-1"> Back </a>
          </span>


                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">

            <div class="row  row-cards">
                <div class="col-12">

                    <div class="card">

                        <div class="card-body">
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

                            <form method="POST" action="{{ route('profile.update') }}">
                                @csrf


                                    <div class="mb-3">
                                        <label class="form-label text-capitalize">User Name</label>
                                        <input type="text" name="name" value="{{ $admin->name }}" class="form-control" />
                                    </div>

                                <div class="mb-3">
                                    <label class="form-label text-capitalize">Password</label>
                                    <input type="text" name="password" value=""  class="form-control" />
                                </div>

                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection


