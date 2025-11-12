  <!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Elunico Management</title>
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
      <link rel="icon" type="image/x-icon" href="/logo_white.png">

    <link href="{{asset('tabler/v1.1.1')}}/preview/css/demo.min.css?1740918423" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <!-- END DEMO STYLES -->
    <!-- BEGIN CUSTOM FONT -->
    <style>
      @import url("https://rsms.me/inter/inter.css");
      .bg-checked {
          background-color: #d4edda !important;
      }
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
        <header class="navbar navbar-expand-md d-none d-lg-flex d-print-none">
            <div class="container-xl">
                <!-- BEGIN NAVBAR TOGGLER -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu" aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <!-- END NAVBAR TOGGLER -->
                <div class="navbar-nav flex-row order-md-last">
                    <div class="d-none d-md-flex">
                        <div class="nav-item">
                            <a href="?theme=dark" class="nav-link px-0 hide-theme-dark" data-bs-toggle="tooltip" data-bs-placement="bottom" aria-label="Enable dark mode" data-bs-original-title="Enable dark mode">
                                <!-- Download SVG icon from http://tabler.io/icons/icon/moon -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                    <path d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z"></path>
                                </svg>
                            </a>
                            <a href="?theme=light" class="nav-link px-0 hide-theme-light" data-bs-toggle="tooltip" data-bs-placement="bottom" aria-label="Enable light mode" data-bs-original-title="Enable light mode">
                                <!-- Download SVG icon from http://tabler.io/icons/icon/sun -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                    <path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                                    <path d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7"></path>
                                </svg>
                            </a>
                        </div>

                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link d-flex lh-1 p-0 px-2" data-bs-toggle="dropdown" aria-label="Open user menu">
                            <span class="avatar avatar-sm" style=""> </span>
                            <div class="d-none d-xl-block ps-2">
                                <div>{{auth()->user()->name}}</div>
                                <div class="mt-1 small text-secondary">{{auth()->user()->role}}</div>
                            </div>
                        </a>


                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <a href="{{route("profile")}}" class="dropdown-item">
                                Profile
                            </a>
                            <a href="#" class="dropdown-item"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                        </div>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
                <div class="collapse navbar-collapse" id="navbar-menu">

                    <!-- END NAVBAR MENU -->
                </div>
            </div>
        </header>
      <!--  END SIDEBAR  -->
      <div class="page-wrapper">
        <!-- BEGIN PAGE HEADER -->
         @yield("content")

->
      </div>
    </div>

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

<script src="https://unpkg.com/just-validate@latest/dist/just-validate.production.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('form').forEach(form => {

        const validator = new JustValidate(form, {
            errorFieldCssClass: 'is-invalid',
            errorLabelStyle: {
                color: '#d63939',
                fontSize: '0.85rem',
                marginTop: '4px'
            }
        });

        form.querySelectorAll('[required]').forEach(field => {
            const selector = field.name ? `[name="${field.name}"]` : `#${field.id}`;
            validator.addField(selector, [
                { rule: 'required', errorMessage: field.dataset.error || 'This field is required' }
            ]);
        });

    validator.onFail(function () {
        const firstErrorField = form.querySelector('.is-invalid');
        if (!firstErrorField) return;

        const tabPane = firstErrorField.closest('.tab-pane');
        if (tabPane) {
            const tabLink = document.querySelector(`.nav-tabs a[href="#${tabPane.id}"]`);
            if (tabLink) {
                new bootstrap.Tab(tabLink).show();
            }
        }

        setTimeout(() => firstErrorField.focus(), 200);
    });


        validator.onSuccess(function () {
            form.submit();
        });

    });

});

document.addEventListener('DOMContentLoaded', () => {
    const currentPath = window.location.pathname;
    const links = document.querySelectorAll('aside .nav-link, aside .dropdown-item');

    links.forEach(link => {
        const href = link.getAttribute('href');

        if (!href || href.startsWith('#') || href.startsWith('javascript:')) return;

        const linkPath = new URL(link.href).pathname;

        if (currentPath === linkPath) {
            link.classList.add('active');

            const parentLi = link.closest('li');
            if (parentLi) parentLi.classList.add('active');

            const dropdown = link.closest('.dropdown');
            if (dropdown) {
                dropdown.classList.add('show');

                const dropdownMenu = dropdown.querySelector('.dropdown-menu');
                if (dropdownMenu) {
                    dropdownMenu.classList.add('show');
                }

                const toggle = dropdown.querySelector('.dropdown-toggle');
                if (toggle) {
                    toggle.classList.add('active');
                    toggle.setAttribute('aria-expanded', 'true');
                }
            }
        }
    });
});



</script>
    <script type="module">
        import { initializeApp } from "https://www.gstatic.com/firebasejs/12.4.0/firebase-app.js";
        import { getFirestore, doc, onSnapshot } from "https://www.gstatic.com/firebasejs/12.4.0/firebase-firestore.js";

        const firebaseConfig = {
            apiKey: "AIzaSyATjv5WrhPlsreYpGrpePMLxR7Z0Ip8L7U",
            authDomain: "qr-lounge-41ad1.firebaseapp.com",
            projectId: "qr-lounge-41ad1",
            storageBucket: "qr-lounge-41ad1.firebasestorage.app",
            messagingSenderId: "53329068541",
            appId: "1:53329068541:web:4ca83669cbec592c2e9994",
            measurementId: "G-HY9VRCRH85"
        };
        const app = initializeApp(firebaseConfig);
        const db = getFirestore(app);
        const countRef = doc(db, "requests", "requests");
        const countElement = document.getElementById('orders-count-realtime');
        const countMes = document.getElementById('messages-count-realtime');
        const countVip = document.getElementById('private-count-realtime');

        if (countElement) {
            onSnapshot(countRef, (docSnapshot) => {
                if (docSnapshot.exists()) {
                    const data = docSnapshot.data();

                    const newCount = data.count || 0;
                    const vipCount = data.count_vip || 0;
                    const messagesCount = data.count_messages || 0;
                    countElement.textContent=newCount
                    countMes.textContent=messagesCount
                    countVip.textContent = vipCount;
                    console.log("Orders count updated:", newCount);
                    console.log("Messages count updated:", messagesCount);

                } else {
                    console.error("Document 'requests/requests' not found. Check path and security rules.");
                    countElement.textContent = 'error in  data';
                }
            }, (error) => {
                console.error("Firebase Realtime Listener Error:", error);
                countElement.textContent = 'fail';
            });
        } else {
            console.error("HTML element with ID 'orders-count-realtime' not found.");
        }
    </script>
  </body>
</html>
