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

    <link href="{{asset('tabler/v1.1.1')}}/preview/css/demo.min.css?1740918423" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <!-- END DEMO STYLES -->
    <!-- BEGIN CUSTOM FONT -->
    <style>
      @import url("https://rsms.me/inter/inter.css");
      .bg-checked {
          background-color: #d4edda !important; /* أخضر فاتح */
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
{{--                        <div class="nav-item dropdown d-none d-md-flex me-3">--}}
{{--                            <a href="#" class="nav-link px-0" data-bs-toggle="dropdown" tabindex="-1" aria-label="Show app menu" data-bs-auto-close="outside" aria-expanded="false">--}}
{{--                                <!-- Download SVG icon from http://tabler.io/icons/icon/apps -->--}}
{{--                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">--}}
{{--                                    <path d="M4 4m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z"></path>--}}
{{--                                    <path d="M4 14m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z"></path>--}}
{{--                                    <path d="M14 14m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z"></path>--}}
{{--                                    <path d="M14 7l6 0"></path>--}}
{{--                                    <path d="M17 4l0 6"></path>--}}
{{--                                </svg>--}}
{{--                            </a>--}}
{{--                            <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-end dropdown-menu-card">--}}
{{--                                <div class="card">--}}
{{--                                    <div class="card-header">--}}
{{--                                        <div class="card-title">My Apps</div>--}}
{{--                                        <div class="card-actions btn-actions">--}}
{{--                                            <a href="#" class="btn-action">--}}
{{--                                                <!-- Download SVG icon from http://tabler.io/icons/icon/settings -->--}}
{{--                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">--}}
{{--                                                    <path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z"></path>--}}
{{--                                                    <path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"></path>--}}
{{--                                                </svg>--}}
{{--                                            </a>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="card-body scroll-y p-2" style="max-height: 50vh">--}}
{{--                                        <div class="row g-0">--}}
{{--                                            <div class="col-4">--}}
{{--                                                <a href="#" class="d-flex flex-column flex-center text-center text-secondary py-2 px-2 link-hoverable">--}}
{{--                                                    <img src="./static/brands/amazon.svg" class="w-6 h-6 mx-auto mb-2" width="24" height="24" alt="">--}}
{{--                                                    <span class="h5">Amazon</span>--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-4">--}}
{{--                                                <a href="#" class="d-flex flex-column flex-center text-center text-secondary py-2 px-2 link-hoverable">--}}
{{--                                                    <img src="./static/brands/android.svg" class="w-6 h-6 mx-auto mb-2" width="24" height="24" alt="">--}}
{{--                                                    <span class="h5">Android</span>--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-4">--}}
{{--                                                <a href="#" class="d-flex flex-column flex-center text-center text-secondary py-2 px-2 link-hoverable">--}}
{{--                                                    <img src="./static/brands/app-store.svg" class="w-6 h-6 mx-auto mb-2" width="24" height="24" alt="">--}}
{{--                                                    <span class="h5">Apple App Store</span>--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-4">--}}
{{--                                                <a href="#" class="d-flex flex-column flex-center text-center text-secondary py-2 px-2 link-hoverable">--}}
{{--                                                    <img src="./static/brands/apple-podcast.svg" class="w-6 h-6 mx-auto mb-2" width="24" height="24" alt="">--}}
{{--                                                    <span class="h5">Apple Podcast</span>--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-4">--}}
{{--                                                <a href="#" class="d-flex flex-column flex-center text-center text-secondary py-2 px-2 link-hoverable">--}}
{{--                                                    <img src="./static/brands/apple.svg" class="w-6 h-6 mx-auto mb-2" width="24" height="24" alt="">--}}
{{--                                                    <span class="h5">Apple</span>--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-4">--}}
{{--                                                <a href="#" class="d-flex flex-column flex-center text-center text-secondary py-2 px-2 link-hoverable">--}}
{{--                                                    <img src="./static/brands/behance.svg" class="w-6 h-6 mx-auto mb-2" width="24" height="24" alt="">--}}
{{--                                                    <span class="h5">Behance</span>--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-4">--}}
{{--                                                <a href="#" class="d-flex flex-column flex-center text-center text-secondary py-2 px-2 link-hoverable">--}}
{{--                                                    <img src="./static/brands/discord.svg" class="w-6 h-6 mx-auto mb-2" width="24" height="24" alt="">--}}
{{--                                                    <span class="h5">Discord</span>--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-4">--}}
{{--                                                <a href="#" class="d-flex flex-column flex-center text-center text-secondary py-2 px-2 link-hoverable">--}}
{{--                                                    <img src="./static/brands/dribbble.svg" class="w-6 h-6 mx-auto mb-2" width="24" height="24" alt="">--}}
{{--                                                    <span class="h5">Dribbble</span>--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-4">--}}
{{--                                                <a href="#" class="d-flex flex-column flex-center text-center text-secondary py-2 px-2 link-hoverable">--}}
{{--                                                    <img src="./static/brands/dropbox.svg" class="w-6 h-6 mx-auto mb-2" width="24" height="24" alt="">--}}
{{--                                                    <span class="h5">Dropbox</span>--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-4">--}}
{{--                                                <a href="#" class="d-flex flex-column flex-center text-center text-secondary py-2 px-2 link-hoverable">--}}
{{--                                                    <img src="./static/brands/ever-green.svg" class="w-6 h-6 mx-auto mb-2" width="24" height="24" alt="">--}}
{{--                                                    <span class="h5">Ever Green</span>--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-4">--}}
{{--                                                <a href="#" class="d-flex flex-column flex-center text-center text-secondary py-2 px-2 link-hoverable">--}}
{{--                                                    <img src="./static/brands/facebook.svg" class="w-6 h-6 mx-auto mb-2" width="24" height="24" alt="">--}}
{{--                                                    <span class="h5">Facebook</span>--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-4">--}}
{{--                                                <a href="#" class="d-flex flex-column flex-center text-center text-secondary py-2 px-2 link-hoverable">--}}
{{--                                                    <img src="./static/brands/figma.svg" class="w-6 h-6 mx-auto mb-2" width="24" height="24" alt="">--}}
{{--                                                    <span class="h5">Figma</span>--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-4">--}}
{{--                                                <a href="#" class="d-flex flex-column flex-center text-center text-secondary py-2 px-2 link-hoverable">--}}
{{--                                                    <img src="./static/brands/github.svg" class="w-6 h-6 mx-auto mb-2" width="24" height="24" alt="">--}}
{{--                                                    <span class="h5">GitHub</span>--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-4">--}}
{{--                                                <a href="#" class="d-flex flex-column flex-center text-center text-secondary py-2 px-2 link-hoverable">--}}
{{--                                                    <img src="./static/brands/gitlab.svg" class="w-6 h-6 mx-auto mb-2" width="24" height="24" alt="">--}}
{{--                                                    <span class="h5">GitLab</span>--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-4">--}}
{{--                                                <a href="#" class="d-flex flex-column flex-center text-center text-secondary py-2 px-2 link-hoverable">--}}
{{--                                                    <img src="./static/brands/google-ads.svg" class="w-6 h-6 mx-auto mb-2" width="24" height="24" alt="">--}}
{{--                                                    <span class="h5">Google Ads</span>--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-4">--}}
{{--                                                <a href="#" class="d-flex flex-column flex-center text-center text-secondary py-2 px-2 link-hoverable">--}}
{{--                                                    <img src="./static/brands/google-adsense.svg" class="w-6 h-6 mx-auto mb-2" width="24" height="24" alt="">--}}
{{--                                                    <span class="h5">Google AdSense</span>--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-4">--}}
{{--                                                <a href="#" class="d-flex flex-column flex-center text-center text-secondary py-2 px-2 link-hoverable">--}}
{{--                                                    <img src="./static/brands/google-analytics.svg" class="w-6 h-6 mx-auto mb-2" width="24" height="24" alt="">--}}
{{--                                                    <span class="h5">Google Analytics</span>--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-4">--}}
{{--                                                <a href="#" class="d-flex flex-column flex-center text-center text-secondary py-2 px-2 link-hoverable">--}}
{{--                                                    <img src="./static/brands/google-cloud.svg" class="w-6 h-6 mx-auto mb-2" width="24" height="24" alt="">--}}
{{--                                                    <span class="h5">Google Cloud</span>--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-4">--}}
{{--                                                <a href="#" class="d-flex flex-column flex-center text-center text-secondary py-2 px-2 link-hoverable">--}}
{{--                                                    <img src="./static/brands/google-drive.svg" class="w-6 h-6 mx-auto mb-2" width="24" height="24" alt="">--}}
{{--                                                    <span class="h5">Google Drive</span>--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-4">--}}
{{--                                                <a href="#" class="d-flex flex-column flex-center text-center text-secondary py-2 px-2 link-hoverable">--}}
{{--                                                    <img src="./static/brands/google-fit.svg" class="w-6 h-6 mx-auto mb-2" width="24" height="24" alt="">--}}
{{--                                                    <span class="h5">Google Fit</span>--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-4">--}}
{{--                                                <a href="#" class="d-flex flex-column flex-center text-center text-secondary py-2 px-2 link-hoverable">--}}
{{--                                                    <img src="./static/brands/google-home.svg" class="w-6 h-6 mx-auto mb-2" width="24" height="24" alt="">--}}
{{--                                                    <span class="h5">Google Home</span>--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-4">--}}
{{--                                                <a href="#" class="d-flex flex-column flex-center text-center text-secondary py-2 px-2 link-hoverable">--}}
{{--                                                    <img src="./static/brands/google-maps.svg" class="w-6 h-6 mx-auto mb-2" width="24" height="24" alt="">--}}
{{--                                                    <span class="h5">Google Maps</span>--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-4">--}}
{{--                                                <a href="#" class="d-flex flex-column flex-center text-center text-secondary py-2 px-2 link-hoverable">--}}
{{--                                                    <img src="./static/brands/google-meet.svg" class="w-6 h-6 mx-auto mb-2" width="24" height="24" alt="">--}}
{{--                                                    <span class="h5">Google Meet</span>--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-4">--}}
{{--                                                <a href="#" class="d-flex flex-column flex-center text-center text-secondary py-2 px-2 link-hoverable">--}}
{{--                                                    <img src="./static/brands/google-photos.svg" class="w-6 h-6 mx-auto mb-2" width="24" height="24" alt="">--}}
{{--                                                    <span class="h5">Google Photos</span>--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-4">--}}
{{--                                                <a href="#" class="d-flex flex-column flex-center text-center text-secondary py-2 px-2 link-hoverable">--}}
{{--                                                    <img src="./static/brands/google-play.svg" class="w-6 h-6 mx-auto mb-2" width="24" height="24" alt="">--}}
{{--                                                    <span class="h5">Google Play</span>--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-4">--}}
{{--                                                <a href="#" class="d-flex flex-column flex-center text-center text-secondary py-2 px-2 link-hoverable">--}}
{{--                                                    <img src="./static/brands/google-shopping.svg" class="w-6 h-6 mx-auto mb-2" width="24" height="24" alt="">--}}
{{--                                                    <span class="h5">Google Shopping</span>--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-4">--}}
{{--                                                <a href="#" class="d-flex flex-column flex-center text-center text-secondary py-2 px-2 link-hoverable">--}}
{{--                                                    <img src="./static/brands/google-teams.svg" class="w-6 h-6 mx-auto mb-2" width="24" height="24" alt="">--}}
{{--                                                    <span class="h5">Google Teams</span>--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-4">--}}
{{--                                                <a href="#" class="d-flex flex-column flex-center text-center text-secondary py-2 px-2 link-hoverable">--}}
{{--                                                    <img src="./static/brands/google.svg" class="w-6 h-6 mx-auto mb-2" width="24" height="24" alt="">--}}
{{--                                                    <span class="h5">Google</span>--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-4">--}}
{{--                                                <a href="#" class="d-flex flex-column flex-center text-center text-secondary py-2 px-2 link-hoverable">--}}
{{--                                                    <img src="./static/brands/instagram.svg" class="w-6 h-6 mx-auto mb-2" width="24" height="24" alt="">--}}
{{--                                                    <span class="h5">Instagram</span>--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-4">--}}
{{--                                                <a href="#" class="d-flex flex-column flex-center text-center text-secondary py-2 px-2 link-hoverable">--}}
{{--                                                    <img src="./static/brands/klarna.svg" class="w-6 h-6 mx-auto mb-2" width="24" height="24" alt="">--}}
{{--                                                    <span class="h5">Klarna</span>--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-4">--}}
{{--                                                <a href="#" class="d-flex flex-column flex-center text-center text-secondary py-2 px-2 link-hoverable">--}}
{{--                                                    <img src="./static/brands/linkedin.svg" class="w-6 h-6 mx-auto mb-2" width="24" height="24" alt="">--}}
{{--                                                    <span class="h5">LinkedIn</span>--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-4">--}}
{{--                                                <a href="#" class="d-flex flex-column flex-center text-center text-secondary py-2 px-2 link-hoverable">--}}
{{--                                                    <img src="./static/brands/mailchimp.svg" class="w-6 h-6 mx-auto mb-2" width="24" height="24" alt="">--}}
{{--                                                    <span class="h5">Mailchimp</span>--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-4">--}}
{{--                                                <a href="#" class="d-flex flex-column flex-center text-center text-secondary py-2 px-2 link-hoverable">--}}
{{--                                                    <img src="./static/brands/medium.svg" class="w-6 h-6 mx-auto mb-2" width="24" height="24" alt="">--}}
{{--                                                    <span class="h5">Medium</span>--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-4">--}}
{{--                                                <a href="#" class="d-flex flex-column flex-center text-center text-secondary py-2 px-2 link-hoverable">--}}
{{--                                                    <img src="./static/brands/messenger.svg" class="w-6 h-6 mx-auto mb-2" width="24" height="24" alt="">--}}
{{--                                                    <span class="h5">Messenger</span>--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-4">--}}
{{--                                                <a href="#" class="d-flex flex-column flex-center text-center text-secondary py-2 px-2 link-hoverable">--}}
{{--                                                    <img src="./static/brands/meta.svg" class="w-6 h-6 mx-auto mb-2" width="24" height="24" alt="">--}}
{{--                                                    <span class="h5">Meta</span>--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-4">--}}
{{--                                                <a href="#" class="d-flex flex-column flex-center text-center text-secondary py-2 px-2 link-hoverable">--}}
{{--                                                    <img src="./static/brands/monday.svg" class="w-6 h-6 mx-auto mb-2" width="24" height="24" alt="">--}}
{{--                                                    <span class="h5">Monday</span>--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-4">--}}
{{--                                                <a href="#" class="d-flex flex-column flex-center text-center text-secondary py-2 px-2 link-hoverable">--}}
{{--                                                    <img src="./static/brands/netflix.svg" class="w-6 h-6 mx-auto mb-2" width="24" height="24" alt="">--}}
{{--                                                    <span class="h5">Netflix</span>--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-4">--}}
{{--                                                <a href="#" class="d-flex flex-column flex-center text-center text-secondary py-2 px-2 link-hoverable">--}}
{{--                                                    <img src="./static/brands/notion.svg" class="w-6 h-6 mx-auto mb-2" width="24" height="24" alt="">--}}
{{--                                                    <span class="h5">Notion</span>--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-4">--}}
{{--                                                <a href="#" class="d-flex flex-column flex-center text-center text-secondary py-2 px-2 link-hoverable">--}}
{{--                                                    <img src="./static/brands/office-365.svg" class="w-6 h-6 mx-auto mb-2" width="24" height="24" alt="">--}}
{{--                                                    <span class="h5">Office 365</span>--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-4">--}}
{{--                                                <a href="#" class="d-flex flex-column flex-center text-center text-secondary py-2 px-2 link-hoverable">--}}
{{--                                                    <img src="./static/brands/opera.svg" class="w-6 h-6 mx-auto mb-2" width="24" height="24" alt="">--}}
{{--                                                    <span class="h5">Opera</span>--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-4">--}}
{{--                                                <a href="#" class="d-flex flex-column flex-center text-center text-secondary py-2 px-2 link-hoverable">--}}
{{--                                                    <img src="./static/brands/paypal.svg" class="w-6 h-6 mx-auto mb-2" width="24" height="24" alt="">--}}
{{--                                                    <span class="h5">PayPal</span>--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-4">--}}
{{--                                                <a href="#" class="d-flex flex-column flex-center text-center text-secondary py-2 px-2 link-hoverable">--}}
{{--                                                    <img src="./static/brands/petreon.svg" class="w-6 h-6 mx-auto mb-2" width="24" height="24" alt="">--}}
{{--                                                    <span class="h5">Patreon</span>--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-4">--}}
{{--                                                <a href="#" class="d-flex flex-column flex-center text-center text-secondary py-2 px-2 link-hoverable">--}}
{{--                                                    <img src="./static/brands/pinterest.svg" class="w-6 h-6 mx-auto mb-2" width="24" height="24" alt="">--}}
{{--                                                    <span class="h5">Pinterest</span>--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-4">--}}
{{--                                                <a href="#" class="d-flex flex-column flex-center text-center text-secondary py-2 px-2 link-hoverable">--}}
{{--                                                    <img src="./static/brands/play-store.svg" class="w-6 h-6 mx-auto mb-2" width="24" height="24" alt="">--}}
{{--                                                    <span class="h5">Play Store</span>--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-4">--}}
{{--                                                <a href="#" class="d-flex flex-column flex-center text-center text-secondary py-2 px-2 link-hoverable">--}}
{{--                                                    <img src="./static/brands/quora.svg" class="w-6 h-6 mx-auto mb-2" width="24" height="24" alt="">--}}
{{--                                                    <span class="h5">Quora</span>--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-4">--}}
{{--                                                <a href="#" class="d-flex flex-column flex-center text-center text-secondary py-2 px-2 link-hoverable">--}}
{{--                                                    <img src="./static/brands/reddit.svg" class="w-6 h-6 mx-auto mb-2" width="24" height="24" alt="">--}}
{{--                                                    <span class="h5">Reddit</span>--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-4">--}}
{{--                                                <a href="#" class="d-flex flex-column flex-center text-center text-secondary py-2 px-2 link-hoverable">--}}
{{--                                                    <img src="./static/brands/shopify.svg" class="w-6 h-6 mx-auto mb-2" width="24" height="24" alt="">--}}
{{--                                                    <span class="h5">Shopify</span>--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-4">--}}
{{--                                                <a href="#" class="d-flex flex-column flex-center text-center text-secondary py-2 px-2 link-hoverable">--}}
{{--                                                    <img src="./static/brands/skype.svg" class="w-6 h-6 mx-auto mb-2" width="24" height="24" alt="">--}}
{{--                                                    <span class="h5">Skype</span>--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-4">--}}
{{--                                                <a href="#" class="d-flex flex-column flex-center text-center text-secondary py-2 px-2 link-hoverable">--}}
{{--                                                    <img src="./static/brands/slack.svg" class="w-6 h-6 mx-auto mb-2" width="24" height="24" alt="">--}}
{{--                                                    <span class="h5">Slack</span>--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-4">--}}
{{--                                                <a href="#" class="d-flex flex-column flex-center text-center text-secondary py-2 px-2 link-hoverable">--}}
{{--                                                    <img src="./static/brands/snapchat.svg" class="w-6 h-6 mx-auto mb-2" width="24" height="24" alt="">--}}
{{--                                                    <span class="h5">Snapchat</span>--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-4">--}}
{{--                                                <a href="#" class="d-flex flex-column flex-center text-center text-secondary py-2 px-2 link-hoverable">--}}
{{--                                                    <img src="./static/brands/soundcloud.svg" class="w-6 h-6 mx-auto mb-2" width="24" height="24" alt="">--}}
{{--                                                    <span class="h5">SoundCloud</span>--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-4">--}}
{{--                                                <a href="#" class="d-flex flex-column flex-center text-center text-secondary py-2 px-2 link-hoverable">--}}
{{--                                                    <img src="./static/brands/spotify.svg" class="w-6 h-6 mx-auto mb-2" width="24" height="24" alt="">--}}
{{--                                                    <span class="h5">Spotify</span>--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-4">--}}
{{--                                                <a href="#" class="d-flex flex-column flex-center text-center text-secondary py-2 px-2 link-hoverable">--}}
{{--                                                    <img src="./static/brands/stripe.svg" class="w-6 h-6 mx-auto mb-2" width="24" height="24" alt="">--}}
{{--                                                    <span class="h5">Stripe</span>--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-4">--}}
{{--                                                <a href="#" class="d-flex flex-column flex-center text-center text-secondary py-2 px-2 link-hoverable">--}}
{{--                                                    <img src="./static/brands/telegram.svg" class="w-6 h-6 mx-auto mb-2" width="24" height="24" alt="">--}}
{{--                                                    <span class="h5">Telegram</span>--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-4">--}}
{{--                                                <a href="#" class="d-flex flex-column flex-center text-center text-secondary py-2 px-2 link-hoverable">--}}
{{--                                                    <img src="./static/brands/tiktok.svg" class="w-6 h-6 mx-auto mb-2" width="24" height="24" alt="">--}}
{{--                                                    <span class="h5">TikTok</span>--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-4">--}}
{{--                                                <a href="#" class="d-flex flex-column flex-center text-center text-secondary py-2 px-2 link-hoverable">--}}
{{--                                                    <img src="./static/brands/tinder.svg" class="w-6 h-6 mx-auto mb-2" width="24" height="24" alt="">--}}
{{--                                                    <span class="h5">Tinder</span>--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-4">--}}
{{--                                                <a href="#" class="d-flex flex-column flex-center text-center text-secondary py-2 px-2 link-hoverable">--}}
{{--                                                    <img src="./static/brands/trello.svg" class="w-6 h-6 mx-auto mb-2" width="24" height="24" alt="">--}}
{{--                                                    <span class="h5">Trello</span>--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-4">--}}
{{--                                                <a href="#" class="d-flex flex-column flex-center text-center text-secondary py-2 px-2 link-hoverable">--}}
{{--                                                    <img src="./static/brands/truth.svg" class="w-6 h-6 mx-auto mb-2" width="24" height="24" alt="">--}}
{{--                                                    <span class="h5">Truth</span>--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-4">--}}
{{--                                                <a href="#" class="d-flex flex-column flex-center text-center text-secondary py-2 px-2 link-hoverable">--}}
{{--                                                    <img src="./static/brands/tumblr.svg" class="w-6 h-6 mx-auto mb-2" width="24" height="24" alt="">--}}
{{--                                                    <span class="h5">Tumblr</span>--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-4">--}}
{{--                                                <a href="#" class="d-flex flex-column flex-center text-center text-secondary py-2 px-2 link-hoverable">--}}
{{--                                                    <img src="./static/brands/twitch.svg" class="w-6 h-6 mx-auto mb-2" width="24" height="24" alt="">--}}
{{--                                                    <span class="h5">Twitch</span>--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-4">--}}
{{--                                                <a href="#" class="d-flex flex-column flex-center text-center text-secondary py-2 px-2 link-hoverable">--}}
{{--                                                    <img src="./static/brands/twitter.svg" class="w-6 h-6 mx-auto mb-2" width="24" height="24" alt="">--}}
{{--                                                    <span class="h5">Twitter</span>--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-4">--}}
{{--                                                <a href="#" class="d-flex flex-column flex-center text-center text-secondary py-2 px-2 link-hoverable">--}}
{{--                                                    <img src="./static/brands/vimeo.svg" class="w-6 h-6 mx-auto mb-2" width="24" height="24" alt="">--}}
{{--                                                    <span class="h5">Vimeo</span>--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-4">--}}
{{--                                                <a href="#" class="d-flex flex-column flex-center text-center text-secondary py-2 px-2 link-hoverable">--}}
{{--                                                    <img src="./static/brands/vk.svg" class="w-6 h-6 mx-auto mb-2" width="24" height="24" alt="">--}}
{{--                                                    <span class="h5">VK</span>--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-4">--}}
{{--                                                <a href="#" class="d-flex flex-column flex-center text-center text-secondary py-2 px-2 link-hoverable">--}}
{{--                                                    <img src="./static/brands/watppad.svg" class="w-6 h-6 mx-auto mb-2" width="24" height="24" alt="">--}}
{{--                                                    <span class="h5">Wattpad</span>--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-4">--}}
{{--                                                <a href="#" class="d-flex flex-column flex-center text-center text-secondary py-2 px-2 link-hoverable">--}}
{{--                                                    <img src="./static/brands/webflow.svg" class="w-6 h-6 mx-auto mb-2" width="24" height="24" alt="">--}}
{{--                                                    <span class="h5">Webflow</span>--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-4">--}}
{{--                                                <a href="#" class="d-flex flex-column flex-center text-center text-secondary py-2 px-2 link-hoverable">--}}
{{--                                                    <img src="./static/brands/whatsapp.svg" class="w-6 h-6 mx-auto mb-2" width="24" height="24" alt="">--}}
{{--                                                    <span class="h5">WhatsApp</span>--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-4">--}}
{{--                                                <a href="#" class="d-flex flex-column flex-center text-center text-secondary py-2 px-2 link-hoverable">--}}
{{--                                                    <img src="./static/brands/wordpress.svg" class="w-6 h-6 mx-auto mb-2" width="24" height="24" alt="">--}}
{{--                                                    <span class="h5">WordPress</span>--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-4">--}}
{{--                                                <a href="#" class="d-flex flex-column flex-center text-center text-secondary py-2 px-2 link-hoverable">--}}
{{--                                                    <img src="./static/brands/xing.svg" class="w-6 h-6 mx-auto mb-2" width="24" height="24" alt="">--}}
{{--                                                    <span class="h5">Xing</span>--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-4">--}}
{{--                                                <a href="#" class="d-flex flex-column flex-center text-center text-secondary py-2 px-2 link-hoverable">--}}
{{--                                                    <img src="./static/brands/yelp.svg" class="w-6 h-6 mx-auto mb-2" width="24" height="24" alt="">--}}
{{--                                                    <span class="h5">Yelp</span>--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-4">--}}
{{--                                                <a href="#" class="d-flex flex-column flex-center text-center text-secondary py-2 px-2 link-hoverable">--}}
{{--                                                    <img src="./static/brands/youtube.svg" class="w-6 h-6 mx-auto mb-2" width="24" height="24" alt="">--}}
{{--                                                    <span class="h5">YouTube</span>--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-4">--}}
{{--                                                <a href="#" class="d-flex flex-column flex-center text-center text-secondary py-2 px-2 link-hoverable">--}}
{{--                                                    <img src="./static/brands/zapier.svg" class="w-6 h-6 mx-auto mb-2" width="24" height="24" alt="">--}}
{{--                                                    <span class="h5">Zapier</span>--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-4">--}}
{{--                                                <a href="#" class="d-flex flex-column flex-center text-center text-secondary py-2 px-2 link-hoverable">--}}
{{--                                                    <img src="./static/brands/zendesk.svg" class="w-6 h-6 mx-auto mb-2" width="24" height="24" alt="">--}}
{{--                                                    <span class="h5">Zendesk</span>--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-4">--}}
{{--                                                <a href="#" class="d-flex flex-column flex-center text-center text-secondary py-2 px-2 link-hoverable">--}}
{{--                                                    <img src="./static/brands/zoom.svg" class="w-6 h-6 mx-auto mb-2" width="24" height="24" alt="">--}}
{{--                                                    <span class="h5">Zoom</span>--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link d-flex lh-1 p-0 px-2" data-bs-toggle="dropdown" aria-label="Open user menu">
                            <span class="avatar avatar-sm" style="background-image: url(./static/avatars/000m.jpg)"> </span>
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
                    <!-- BEGIN NAVBAR MENU -->
{{--                    <ul class="navbar-nav">--}}
{{--                        <li class="nav-item">--}}
{{--                            <a class="nav-link" href="./">--}}
{{--                  <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler.io/icons/icon/home -->--}}
{{--                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">--}}
{{--                      <path d="M5 12l-2 0l9 -9l9 9l-2 0"></path>--}}
{{--                      <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7"></path>--}}
{{--                      <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6"></path></svg></span>--}}
{{--                                <span class="nav-link-title"> Home </span>--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                        <li class="nav-item dropdown">--}}
{{--                            <a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">--}}
{{--                  <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler.io/icons/icon/package -->--}}
{{--                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">--}}
{{--                      <path d="M12 3l8 4.5l0 9l-8 4.5l-8 -4.5l0 -9l8 -4.5"></path>--}}
{{--                      <path d="M12 12l8 -4.5"></path>--}}
{{--                      <path d="M12 12l0 9"></path>--}}
{{--                      <path d="M12 12l-8 -4.5"></path>--}}
{{--                      <path d="M16 5.25l-8 4.5"></path></svg></span>--}}
{{--                                <span class="nav-link-title"> Interface </span>--}}
{{--                            </a>--}}
{{--                            <div class="dropdown-menu">--}}
{{--                                <div class="dropdown-menu-columns">--}}
{{--                                    <div class="dropdown-menu-column">--}}
{{--                                        <a class="dropdown-item" href="./accordion.html">--}}
{{--                                            Accordion--}}
{{--                                            <span class="badge badge-sm bg-green-lt text-uppercase ms-auto">New</span>--}}
{{--                                        </a>--}}
{{--                                        <a class="dropdown-item" href="./alerts.html"> Alerts </a>--}}
{{--                                        <div class="dropend">--}}
{{--                                            <a class="dropdown-item dropdown-toggle" href="#sidebar-authentication" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">--}}
{{--                                                Authentication--}}
{{--                                            </a>--}}
{{--                                            <div class="dropdown-menu">--}}
{{--                                                <a href="./sign-in.html" class="dropdown-item"> Sign in </a>--}}
{{--                                                <a href="./sign-in-link.html" class="dropdown-item"> Sign in link </a>--}}
{{--                                                <a href="./sign-in-illustration.html" class="dropdown-item"> Sign in with illustration </a>--}}
{{--                                                <a href="./sign-in-cover.html" class="dropdown-item"> Sign in with cover </a>--}}
{{--                                                <a href="./sign-up.html" class="dropdown-item"> Sign up </a>--}}
{{--                                                <a href="./forgot-password.html" class="dropdown-item"> Forgot password </a>--}}
{{--                                                <a href="./terms-of-service.html" class="dropdown-item"> Terms of service </a>--}}
{{--                                                <a href="./auth-lock.html" class="dropdown-item"> Lock screen </a>--}}
{{--                                                <a href="./2-step-verification.html" class="dropdown-item"> 2 step verification </a>--}}
{{--                                                <a href="./2-step-verification-code.html" class="dropdown-item"> 2 step verification code </a>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <a class="dropdown-item" href="./avatars.html">--}}
{{--                                            Avatars--}}
{{--                                            <span class="badge badge-sm bg-green-lt text-uppercase ms-auto">New</span>--}}
{{--                                        </a>--}}
{{--                                        <a class="dropdown-item" href="./badges.html"> Badges </a>--}}
{{--                                        <a class="dropdown-item" href="./blank.html"> Blank page </a>--}}
{{--                                        <a class="dropdown-item" href="./buttons.html"> Buttons </a>--}}
{{--                                        <div class="dropend">--}}
{{--                                            <a class="dropdown-item dropdown-toggle" href="#sidebar-cards" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">--}}
{{--                                                Cards--}}
{{--                                            </a>--}}
{{--                                            <div class="dropdown-menu">--}}
{{--                                                <a href="./cards.html" class="dropdown-item"> Sample cards </a>--}}
{{--                                                <a href="./card-actions.html" class="dropdown-item">--}}
{{--                                                    Card actions--}}
{{--                                                    <span class="badge badge-sm bg-green-lt text-uppercase ms-auto">New</span>--}}
{{--                                                </a>--}}
{{--                                                <a href="./cards-masonry.html" class="dropdown-item"> Cards Masonry </a>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <a class="dropdown-item" href="./carousel.html"> Carousel </a>--}}
{{--                                        <a class="dropdown-item" href="./colors.html"> Colors </a>--}}
{{--                                        <a class="dropdown-item" href="./datagrid.html"> Data grid </a>--}}
{{--                                        <a class="dropdown-item" href="./dropdowns.html"> Dropdowns </a>--}}
{{--                                        <div class="dropend">--}}
{{--                                            <a class="dropdown-item dropdown-toggle" href="#sidebar-error" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">--}}
{{--                                                Error pages--}}
{{--                                            </a>--}}
{{--                                            <div class="dropdown-menu">--}}
{{--                                                <a href="./error-404.html" class="dropdown-item"> 404 page </a>--}}
{{--                                                <a href="./error-500.html" class="dropdown-item"> 500 page </a>--}}
{{--                                                <a href="./error-maintenance.html" class="dropdown-item"> Maintenance page </a>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <a class="dropdown-item" href="./lists.html"> Lists </a>--}}
{{--                                        <a class="dropdown-item" href="./modals.html"> Modals </a>--}}
{{--                                    </div>--}}
{{--                                    <div class="dropdown-menu-column">--}}
{{--                                        <a class="dropdown-item" href="./markdown.html"> Markdown </a>--}}
{{--                                        <a class="dropdown-item" href="./navigation.html"> Navigation </a>--}}
{{--                                        <a class="dropdown-item" href="./offcanvas.html"> Offcanvas </a>--}}
{{--                                        <a class="dropdown-item" href="./pagination.html"> Pagination </a>--}}
{{--                                        <a class="dropdown-item" href="./placeholder.html"> Placeholder </a>--}}
{{--                                        <a class="dropdown-item" href="./segmented-control.html">--}}
{{--                                            Segmented control--}}
{{--                                            <span class="badge badge-sm bg-green-lt text-uppercase ms-auto">New</span>--}}
{{--                                        </a>--}}
{{--                                        <a class="dropdown-item" href="./scroll-spy.html">--}}
{{--                                            Scroll spy--}}
{{--                                            <span class="badge badge-sm bg-green-lt text-uppercase ms-auto">New</span>--}}
{{--                                        </a>--}}
{{--                                        <a class="dropdown-item" href="./social-icons.html"> Social icons </a>--}}
{{--                                        <a class="dropdown-item" href="./stars-rating.html"> Stars rating </a>--}}
{{--                                        <a class="dropdown-item" href="./steps.html"> Steps </a>--}}
{{--                                        <a class="dropdown-item" href="./tables.html"> Tables </a>--}}
{{--                                        <a class="dropdown-item" href="./tabs.html"> Tabs </a>--}}
{{--                                        <a class="dropdown-item" href="./tags.html"> Tags </a>--}}
{{--                                        <a class="dropdown-item" href="./toasts.html"> Toasts </a>--}}
{{--                                        <a class="dropdown-item" href="./typography.html"> Typography </a>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </li>--}}
{{--                        <li class="nav-item dropdown">--}}
{{--                            <a class="nav-link dropdown-toggle" href="#navbar-form" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">--}}
{{--                  <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler.io/icons/icon/checkbox -->--}}
{{--                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">--}}
{{--                      <path d="M9 11l3 3l8 -8"></path>--}}
{{--                      <path d="M20 12v6a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h9"></path></svg></span>--}}
{{--                                <span class="nav-link-title"> Forms </span>--}}
{{--                            </a>--}}
{{--                            <div class="dropdown-menu">--}}
{{--                                <a class="dropdown-item" href="./form-elements.html"> Form elements </a>--}}
{{--                                <a class="dropdown-item" href="./form-layout.html">--}}
{{--                                    Form layouts--}}
{{--                                    <span class="badge badge-sm bg-green-lt text-uppercase ms-auto">New</span>--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                        </li>--}}
{{--                        <li class="nav-item dropdown">--}}
{{--                            <a class="nav-link dropdown-toggle" href="#navbar-extra" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">--}}
{{--                  <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler.io/icons/icon/star -->--}}
{{--                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">--}}
{{--                      <path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z"></path></svg></span>--}}
{{--                                <span class="nav-link-title"> Extra </span>--}}
{{--                            </a>--}}
{{--                            <div class="dropdown-menu">--}}
{{--                                <div class="dropdown-menu-columns">--}}
{{--                                    <div class="dropdown-menu-column">--}}
{{--                                        <a class="dropdown-item" href="./activity.html"> Activity </a>--}}
{{--                                        <a class="dropdown-item" href="./chat.html"> Chat </a>--}}
{{--                                        <a class="dropdown-item" href="./cookie-banner.html"> Cookie banner </a>--}}
{{--                                        <a class="dropdown-item" href="./empty.html"> Empty page </a>--}}
{{--                                        <a class="dropdown-item" href="./faq.html"> FAQ </a>--}}
{{--                                        <a class="dropdown-item" href="./gallery.html"> Gallery </a>--}}
{{--                                        <a class="dropdown-item" href="./invoice.html"> Invoice </a>--}}
{{--                                        <a class="dropdown-item" href="./job-listing.html"> Job listing </a>--}}
{{--                                        <a class="dropdown-item" href="./license.html"> License </a>--}}
{{--                                        <a class="dropdown-item" href="./logs.html"> Logs </a>--}}
{{--                                        <a class="dropdown-item" href="./marketing/index.html"> Marketing </a>--}}
{{--                                        <a class="dropdown-item" href="./music.html"> Music </a>--}}
{{--                                        <a class="dropdown-item" href="./page-loader.html"> Page loader </a>--}}
{{--                                    </div>--}}
{{--                                    <div class="dropdown-menu-column">--}}
{{--                                        <a class="dropdown-item" href="./photogrid.html"> Photogrid </a>--}}
{{--                                        <a class="dropdown-item" href="./pricing.html"> Pricing cards </a>--}}
{{--                                        <a class="dropdown-item" href="./pricing-table.html"> Pricing table </a>--}}
{{--                                        <a class="dropdown-item" href="./search-results.html"> Search results </a>--}}
{{--                                        <a class="dropdown-item" href="./settings.html"> Settings </a>--}}
{{--                                        <a class="dropdown-item" href="./signatures.html">--}}
{{--                                            Signatures--}}
{{--                                            <span class="badge badge-sm bg-green-lt text-uppercase ms-auto">New</span>--}}
{{--                                        </a>--}}
{{--                                        <a class="dropdown-item" href="./tasks.html"> Tasks </a>--}}
{{--                                        <a class="dropdown-item" href="./text-features.html">--}}
{{--                                            Text features--}}
{{--                                            <span class="badge badge-sm bg-green-lt text-uppercase ms-auto">New</span>--}}
{{--                                        </a>--}}
{{--                                        <a class="dropdown-item" href="./trial-ended.html"> Trial ended </a>--}}
{{--                                        <a class="dropdown-item" href="./uptime.html"> Uptime monitor </a>--}}
{{--                                        <a class="dropdown-item" href="./users.html"> Users </a>--}}
{{--                                        <a class="dropdown-item" href="./widgets.html"> Widgets </a>--}}
{{--                                        <a class="dropdown-item" href="./wizard.html"> Wizard </a>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </li>--}}
{{--                        <li class="nav-item active dropdown">--}}
{{--                            <a class="nav-link dropdown-toggle" href="#navbar-layout" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">--}}
{{--                  <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler.io/icons/icon/layout-2 -->--}}
{{--                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">--}}
{{--                      <path d="M4 4m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v1a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z"></path>--}}
{{--                      <path d="M4 13m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v3a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z"></path>--}}
{{--                      <path d="M14 4m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v3a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z"></path>--}}
{{--                      <path d="M14 15m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v1a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z"></path></svg></span>--}}
{{--                                <span class="nav-link-title"> Layout </span>--}}
{{--                            </a>--}}
{{--                            <div class="dropdown-menu">--}}
{{--                                <div class="dropdown-menu-columns">--}}
{{--                                    <div class="dropdown-menu-column">--}}
{{--                                        <a class="dropdown-item" href=""> Boxed </a>--}}

{{--                                    <div class="dropdown-menu-column">--}}
{{--                                        <a class="dropdown-item" href=""> Navbar overlap </a>--}}

{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </li>--}}
{{--                        <li class="nav-item dropdown">--}}
{{--                            <a class="nav-link dropdown-toggle" href="#navbar-plugins" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">--}}
{{--                  <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler.io/icons/icon/puzzle -->--}}
{{--                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">--}}
{{--                      <path d="M4 7h3a1 1 0 0 0 1 -1v-1a2 2 0 0 1 4 0v1a1 1 0 0 0 1 1h3a1 1 0 0 1 1 1v3a1 1 0 0 0 1 1h1a2 2 0 0 1 0 4h-1a1 1 0 0 0 -1 1v3a1 1 0 0 1 -1 1h-3a1 1 0 0 1 -1 -1v-1a2 2 0 0 0 -4 0v1a1 1 0 0 1 -1 1h-3a1 1 0 0 1 -1 -1v-3a1 1 0 0 1 1 -1h1a2 2 0 0 0 0 -4h-1a1 1 0 0 1 -1 -1v-3a1 1 0 0 1 1 -1"></path></svg></span>--}}
{{--                                <span class="nav-link-title"> Plugins </span>--}}
{{--                            </a>--}}
{{--                            <div class="dropdown-menu">--}}
{{--                                <a class="dropdown-item" href=""> Charts </a>--}}
{{--                                <a class="dropdown-item" href=""> Color picker </a>--}}
{{--                                <a class="dropdown-item" href=""> Datatables </a>--}}
{{--                                <a class="dropdown-item" href=""> Dropzone </a>--}}
{{--                                <a class="dropdown-item" href=""> Fullcalendar </a>--}}
{{--                                <a class="dropdown-item" href=""> Inline player </a>--}}
{{--                                <a class="dropdown-item" href="."> Lightbox </a>--}}
{{--                                <a class="dropdown-item" href=""> Map </a>--}}
{{--                                <a class="dropdown-item" href=""> Map fullsize </a>--}}
{{--                                <a class="dropdown-item" href=""> Map vector </a>--}}
{{--                                <a class="dropdown-item" href=""> Turbo loader </a>--}}
{{--                                <a class="dropdown-item" href=""> WYSIWYG editor </a>--}}
{{--                            </div>--}}
{{--                        </li>--}}
{{--                        <li class="nav-item dropdown">--}}
{{--                            <a class="nav-link dropdown-toggle" href="#navbar-addons" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">--}}
{{--                  <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler.io/icons/icon/gift -->--}}
{{--                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">--}}
{{--                      <path d="M3 8m0 1a1 1 0 0 1 1 -1h16a1 1 0 0 1 1 1v2a1 1 0 0 1 -1 1h-16a1 1 0 0 1 -1 -1z"></path>--}}
{{--                      <path d="M12 8l0 13"></path>--}}
{{--                      <path d="M19 12v7a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-7"></path>--}}
{{--                      <path d="M7.5 8a2.5 2.5 0 0 1 0 -5a4.8 8 0 0 1 4.5 5a4.8 8 0 0 1 4.5 -5a2.5 2.5 0 0 1 0 5"></path></svg></span>--}}
{{--                                <span class="nav-link-title"> Addons </span>--}}
{{--                            </a>--}}
{{--                            <div class="dropdown-menu">--}}
{{--                                <a class="dropdown-item" href="./icons.html"> Icons </a>--}}
{{--                                <a class="dropdown-item" href="./emails.html"> Emails </a>--}}
{{--                                <a class="dropdown-item" href="./flags.html"> Flags </a>--}}
{{--                                <a class="dropdown-item" href="./illustrations.html"> Illustrations </a>--}}
{{--                                <a class="dropdown-item" href="./payment-providers.html"> Payment providers </a>--}}
{{--                            </div>--}}
{{--                        </li>--}}
{{--                        <li class="nav-item dropdown">--}}
{{--                            <a class="nav-link dropdown-toggle" href="#navbar-help" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">--}}
{{--                  <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler.io/icons/icon/lifebuoy -->--}}
{{--                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">--}}
{{--                      <path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>--}}
{{--                      <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path>--}}
{{--                      <path d="M15 15l3.35 3.35"></path>--}}
{{--                      <path d="M9 15l-3.35 3.35"></path>--}}
{{--                      <path d="M5.65 5.65l3.35 3.35"></path>--}}
{{--                      <path d="M18.35 5.65l-3.35 3.35"></path></svg></span>--}}
{{--                                <span class="nav-link-title"> Help </span>--}}
{{--                            </a>--}}
{{--                            <div class="dropdown-menu">--}}
{{--                                <a class="dropdown-item" href="https://tabler.io/docs" target="_blank" rel="noopener"> Documentation </a>--}}
{{--                                <a class="dropdown-item" href="./changelog.html"> Changelog </a>--}}
{{--                                <a class="dropdown-item" href="https://github.com/tabler/tabler" target="_blank" rel="noopener"> Source code </a>--}}
{{--                                <a class="dropdown-item text-pink" href="https://github.com/sponsors/codecalm" target="_blank" rel="noopener">--}}
{{--                                    <!-- Download SVG icon from http://tabler.io/icons/icon/heart -->--}}
{{--                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-inline me-1 icon-2">--}}
{{--                                        <path d="M19.5 12.572l-7.5 7.428l-7.5 -7.428a5 5 0 1 1 7.5 -6.566a5 5 0 1 1 7.5 6.572"></path>--}}
{{--                                    </svg>--}}
{{--                                    Sponsor project!--}}
{{--                                </a>--}}
{{--                            </div>--}}

{{--                    </ul>--}}
                    <!-- END NAVBAR MENU -->
                </div>
            </div>
        </header>
      <!--  END SIDEBAR  -->
      <div class="page-wrapper">
        <!-- BEGIN PAGE HEADER -->
         @yield("content")

        <!-- END PAGE BODY -->
        <!--  BEGIN FOOTER  -->

        <!--  END FOOTER  -->
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
