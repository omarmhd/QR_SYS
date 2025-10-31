@extends("layouts.app")

@section("content")


<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <!-- Page pre-title -->
        <div class="page-pretitle">{{$service_name["en"]}} Requests</div>
        <h2 class="page-title"></h2>
      </div>
      <!-- Page title actions -->
      <div class="col-auto ms-auto d-print-none">
        <div class="btn-list">


          <a href="{{route('services.create')}}" class="btn btn-primary btn-5 d-none d-sm-inline-block">
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
            Add Service
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
            <h3 class="card-title">{{$service_name["en"]}} Requests Table</h3>
          </div>
          <div class="card-body border-bottom py-3">
                 <div class="table-responsive">
               <table id="data-table" class="table table-selectable card-table table-vcenter text-nowrap datatable">
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
                  <th>Full Name</th>
                    <th>Email</th>
                    <th>Phone</th>

                    <th>Booking Date</th>
                  <th>Booking Time</th>
                  <th>Guest Numbers </th>
                  <th>Cigar Type</th>
                  <th>Notes</th>
                  <th>Created at</th>
                  <th>Action</th>

                </tr>
              </thead>

              <tbody>




              </tbody>
            </table>
          </div>


            <div class="d-flex">


            </div>
          </div>


        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@push("js")
    @include("service_requests._datatable")
@endpush
