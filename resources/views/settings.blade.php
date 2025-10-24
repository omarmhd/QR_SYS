@extends("layouts.app")

@section("content")


    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle">Settings</div>
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

                    <form method="POST" action="{{ route('settings.update') }}">
                        @csrf
                        @foreach($settings as $setting)
                            <div class="mb-3">
                                <label class="form-label text-capitalize">{{ str_replace('_', ' ', $setting->key) }}</label>
                                <input type="text" name="{{ $setting->key }}" value="{{ $setting->value }}" class="form-control" />
                            </div>
                        @endforeach


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


