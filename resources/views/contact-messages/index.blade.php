@extends("layouts.app")

@section("content")

      <div class="page-header d-print-none">
          <div class="container-xl">
            <div class="row g-2 align-items-center">
              <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">Contact Messages</div>
                <h2 class="page-title"></h2>
              </div>
              <!-- Page title actions -->
              <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                  <span class="d-none d-sm-inline">
                    <!-- <a href="#" class="btn btn-1"> New  </a> -->
                  </span>
                    <!--
                  <a href="#" class="btn btn-primary btn-5 d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modal-report">
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
                      class="icon icon-2"
                    >
                      <path d="M12 5l0 14" />
                      <path d="M5 12l14 0" />
                    </svg>
                  Request
                  </a>
-->
                  <a
                    href="#"
                    class="btn btn-primary btn-6 d-sm-none btn-icon"
                    data-bs-toggle="modal"
                    data-bs-target="#modal-report"
                    aria-label="Create new report"
                  >
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
                      class="icon icon-2"
                    >
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

        <div class="page-body">
          <div class="container-xl">

          <div class="row row-deck row-cards">
            <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Contact Requests</h3>
                  </div>

                    <div class="card-body border-bottom py-3">
                      <div class="table-responsive">


                          <table id="data-table" class="table table-selectable card-table table-vcenter text-nowrap datatable">
                               <thead>
                            <tr>
                              <th class="w-1">
                               #
                                <!-- Download SVG icon from http://tabler.io/icons/icon/chevron-up -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-sm icon-thick icon-2">
                                  <path d="M6 15l6 -6l6 6"></path>
                                </svg>
                              </th>
                              <th>User Name</th>
                              <th>User Email</th>
                              <th>Title</th>
                              <th>Message</th>
                              <th>Submission date</th>
                                <th>Action</th>

                            </tr>
                          </thead>

                          <tbody>
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
                    </div>

                </div>
              </div>
          </div>
          </div>
        </div>

        @endsection


      @push("js")
      @include("contact-messages._datatable")
      @include("layouts.modals.message")
      <script>
          $(document).on("click", ".show-message", function (e) {
              e.preventDefault();
              $("#fullMessage").text($(this).data("message"));
              $("#modal-message .name").text($(this).data("name"));
          });
      </script>
      @endpush
