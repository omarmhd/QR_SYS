@extends("layouts.app")

@section("content")


<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <!-- Page pre-title -->
        <div class="page-pretitle">Features</div>
        <h2 class="page-title"></h2>
      </div>
      <!-- Page title actions -->
      <div class="col-auto ms-auto d-print-none">
        <div class="btn-list">


          <a href="{{route('features.create')}}" class="btn btn-primary btn-5 d-none d-sm-inline-block">
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
            Add Feature
          </a>

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

    <div class="row row-deck row-cards">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Features Table</h3>
          </div>
          <div class="card-body border-bottom py-3">
                 <div class="table-responsive">
            <table id="" class="table table-selectable card-table table-vcenter text-nowrap">
              <thead>
                <tr>
                  <!-- <th class="w-1"><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></th> -->
                  <th class="w-1">
                    #
                    <!-- Download SVG icon from http://tabler.io/icons/icon/chevron-up -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-sm icon-thick icon-2">
                      <path d="M6 15l6 -6l6 6"></path>
                    </svg>
                  </th>
                  <th>Icon</th>
                  <th>Name</th>
                  <th>Action </th>
                </tr>
              </thead>

              <tbody>

                @forelse($features as $feature)
                <tr>
                  <td>
                    {{ $loop->iteration }}
                  </td>
                  <td>
                    @if($feature->icon)
                    <img src="{{ asset('storage/'.$feature->icon) }}" alt="Image" style="max-height: 60px;">
                    @else
                    <span>No icon</span>
                    @endif
                  </td>
                  <td>{{$feature->name["en"]}}</td>
                  <td>
                    {{-- Edit Button --}}
                    <a href="{{ route('features.edit', $feature->id) }}" class="btn btn-bg btn-primary">
                      <svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                        <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                        <path d="M16 5l3 3" />
                      </svg> </a>

                    <form action="{{ route('features.destroy', $feature->id) }}" method="POST" style="display:inline;" class="delete-form">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-bg btn-danger delete-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
                          <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                          <path d="M4 7l16 0" />
                          <path d="M10 11l0 6" />
                          <path d="M14 11l0 6" />
                          <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                          <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                        </svg>
                      </button>
                    </form>
                  </td>

                </tr>
                @empty
                <tr>
                  <td colspan="5" class="text-center">No features found.</td>
                </tr>
                @endforelse
                <!-- <tr>
                          <td><input class="form-check-input m-0 align-middle table-selectable-check" type="checkbox" aria-label="Select invoice"></td>
                          <td><span class="text-secondary">001401</span></td>
                          <td><a href="i3nvoice.html" class="text-reset" tabindex="-1">Design Works</a></td>
                          <td>
                            <span class="flag flag-xs flag-country-us me-2"></span>
                            Carlson Limited
                          </td>
                          <td>87956621</td>
                          <td>15 Dec 2017</td>
                          <td><span class="badge bg-success me-1"></span> Paid</td>
                          <td>$887</td>
                          <td class="text-end">
                            <span class="dropdown">
                              <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport" data-bs-toggle="dropdown">Actions</button>
                              <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#"> Action </a>
                                <a class="dropdown-item" href="#"> Another action </a>
                              </div>
                            </span>
                          </td>
                        </tr> -->



              </tbody>
            </table>
          </div>
            <div class="d-flex">

              <!-- <div class="text-secondary">
                        Show
                        <div class="mx-2 d-inline-block">
                          <input type="text" class="form-control form-control-sm" value="8" size="3" aria-label="Invoices count">
                        </div>
                        entries
                      </div>
                      <div class="ms-auto text-secondary">
                        Search:
                        <div class="ms-2 d-inline-block">
                          <input type="text" class="form-control form-control-sm" aria-label="Search invoice">
                        </div>
                      </div> -->
            </div>
          </div>


        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@push("js")
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  document.querySelectorAll('.delete-form').forEach(form => {
    form.addEventListener('submit', function(e) {
      e.preventDefault();

      Swal.fire({
        title: 'Are you sure?',
        text: "This action cannot be undone!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it'
      }).then((result) => {
        if (result.isConfirmed) {
          form.submit();
        }
      });
    });
  });
</script>


@endpush
