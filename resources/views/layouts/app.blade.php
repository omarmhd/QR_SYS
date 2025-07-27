  <!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Test</title>
    <!-- BEGIN PAGE LEVEL STYLES -->
    <!-- END PAGE LEVEL STYLES -->
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="{{asset('tabler/v1.1.1')}}/dist/css/tabler.min.css?1740918423" rel="stylesheet" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PLUGINS STYLES -->
    <link href="{{asset('tabler/v1.1.1')}}/dist/css/tabler-flags.min.css?1740918423" rel="stylesheet" />
    <link href="{{asset('tabler/v1.1.1')}}/dist/css/tabler-socials.min.css?1740918423" rel="stylesheet" />
    <link href="{{asset('tabler/v1.1.1')}}/dist/css/tabler-payments.min.css?1740918423" rel="stylesheet" />
    <link href="{{asset('tabler/v1.1.1')}}/dist/css/tabler-vendors.min.css?1740918423" rel="stylesheet" />
    <link href="{{asset('tabler/v1.1.1')}}/dist/css/tabler-marketing.min.css?1740918423" rel="stylesheet" />
    <!-- END PLUGINS STYLES -->
    <!-- BEGIN DEMO STYLES -->
     <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>

    <link href="{{asset('tabler/v1.1.1')}}/preview/css/demo.min.css?1740918423" rel="stylesheet" />
    
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <!-- END DEMO STYLES -->
    <!-- BEGIN CUSTOM FONT -->
    <style>
      @import url("https://rsms.me/inter/inter.css");
    </style>
    <!-- END CUSTOM FONT -->
  </head>
  <body class="layout-fluid"> 
    <!-- BEGIN DEMO THEME SCRIPT -->
    <script src="{{asset('tabler/v1.1.1')}}/preview/js/demo-theme.min.js?1740918423"></script>
    <!-- END DEMO THEME SCRIPT -->
    <div class="page">
      <!--  BEGIN SIDEBAR  -->

      @include("layouts.includes._aside")
  
      <!--  END SIDEBAR  -->
      <div class="page-wrapper">
        <!-- BEGIN PAGE HEADER -->
         @yield("content")
   
        <!-- END PAGE BODY -->
        <!--  BEGIN FOOTER  -->

        <!--  END FOOTER  -->
      </div>
    </div>
    <!-- BEGIN PAGE MODALS -->
    <div class="modal modal-blur fade" id="modal-report" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">New report</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">Name</label>
              <input type="text" class="form-control" name="example-text-input" placeholder="Your report name" />
            </div>
            <label class="form-label">Report type</label>
            <div class="form-selectgroup-boxes row mb-3">
              <div class="col-lg-6">
                <label class="form-selectgroup-item">
                  <input type="radio" name="report-type" value="1" class="form-selectgroup-input" checked />
                  <span class="form-selectgroup-label d-flex align-items-center p-3">
                    <span class="me-3">
                      <span class="form-selectgroup-check"></span>
                    </span>
                    <span class="form-selectgroup-label-content">
                      <span class="form-selectgroup-title strong mb-1">Simple</span>
                      <span class="d-block text-secondary">Provide only basic data needed for the report</span>
                    </span>
                  </span>
                </label>
              </div>
              <div class="col-lg-6">
                <label class="form-selectgroup-item">
                  <input type="radio" name="report-type" value="1" class="form-selectgroup-input" />
                  <span class="form-selectgroup-label d-flex align-items-center p-3">
                    <span class="me-3">
                      <span class="form-selectgroup-check"></span>
                    </span>
                    <span class="form-selectgroup-label-content">
                      <span class="form-selectgroup-title strong mb-1">Advanced</span>
                      <span class="d-block text-secondary">Insert charts and additional advanced analyses to be inserted in the report</span>
                    </span>
                  </span>
                </label>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-8">
                <div class="mb-3">
                  <label class="form-label">Report url</label>
                  <div class="input-group input-group-flat">
                    <span class="input-group-text"> https://tabler.io/reports/ </span>
                    <input type="text" class="form-control ps-0" value="report-01" autocomplete="off" />
                  </div>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="mb-3">
                  <label class="form-label">Visibility</label>
                  <select class="form-select">
                    <option value="1" selected>Private</option>
                    <option value="2">Public</option>
                    <option value="3">Hidden</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Client name</label>
                  <input type="text" class="form-control" />
                </div>
              </div>
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Reporting period</label>
                  <input type="date" class="form-control" />
                </div>
              </div>
              <div class="col-lg-12">
                <div>
                  <label class="form-label">Additional information</label>
                  <textarea class="form-control" rows="3"></textarea>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <a href="#" class="btn btn-link link-secondary btn-3" data-bs-dismiss="modal"> Cancel </a>
            <a href="#" class="btn btn-primary btn-5 ms-auto" data-bs-dismiss="modal">
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
              Create new report
            </a>
          </div>
        </div>
      </div>
    </div>
    <!-- END PAGE MODALS -->
    <!-- BEGIN PAGE LIBRARIES -->
    <script src="{{asset('tabler/v1.1.1')}}/libs/apexcharts/dist/apexcharts.min.js?1740918423" defer></script>
    <script src="{{asset('tabler/v1.1.1')}}/libs/jsvectormap/dist/jsvectormap.min.js?1740918423" defer></script>
    <script src="{{asset('tabler/v1.1.1')}}/libs/jsvectormap/dist/maps/world.js?1740918423" defer></script>
    <script src="{{asset('tabler/v1.1.1')}}/libs/jsvectormap/dist/maps/world-merc.js?1740918423" defer></script>
    <!-- END PAGE LIBRARIES -->
    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="{{asset('tabler/v1.1.1')}}/dist/js/tabler.min.js?1740918423" defer></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->
    <!-- BEGIN DEMO SCRIPTS -->
    <script src="{{asset('tabler/v1.1.1')}}/preview/js/demo.min.js?1740918423" defer></script>
    <!-- END DEMO SCRIPTS -->
    <!-- BEGIN PAGE SCRIPTS -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    @stack("js")
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  document.addEventListener('submit', function(e) {
    if (e.target.classList.contains('delete-form')) {
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
          e.target.submit();
        }
      });
    }
  });
</script>
@if(session('success'))
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "timeOut": "4000"
            };
            toastr.success("{{ session('success') }}");
        });
    </script>
@endif

@if(session('error'))
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "timeOut": "4000"
            };
            toastr.error("{{ session('error') }}");
        });
    </script>
@endif

    <!-- END PAGE SCRIPTS -->
  </body>
</html>
