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
      <aside class="navbar navbar-vertical navbar-expand-lg" data-bs-theme="dark">
        <div class="container-fluid">
          <!-- BEGIN NAVBAR TOGGLER -->
          <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#sidebar-menu"
            aria-controls="sidebar-menu"
            aria-expanded="false"
            aria-label="Toggle navigation"
          >
            <span class="navbar-toggler-icon"></span>
          </button>
          <!-- END NAVBAR TOGGLER -->
          <!-- BEGIN NAVBAR LOGO -->
          <div class="navbar-brand navbar-brand-autodark">
            <a href=".">
              <svg xmlns="http://www.w3.org/2000/svg" width="110" height="32" viewBox="0 0 232 68" class="navbar-brand-image">
                <path
                  d="M64.6 16.2C63 9.9 58.1 5 51.8 3.4 40 1.5 28 1.5 16.2 3.4 9.9 5 5 9.9 3.4 16.2 1.5 28 1.5 40 3.4 51.8 5 58.1 9.9 63 16.2 64.6c11.8 1.9 23.8 1.9 35.6 0C58.1 63 63 58.1 64.6 51.8c1.9-11.8 1.9-23.8 0-35.6zM33.3 36.3c-2.8 4.4-6.6 8.2-11.1 11-1.5.9-3.3.9-4.8.1s-2.4-2.3-2.5-4c0-1.7.9-3.3 2.4-4.1 2.3-1.4 4.4-3.2 6.1-5.3-1.8-2.1-3.8-3.8-6.1-5.3-2.3-1.3-3-4.2-1.7-6.4s4.3-2.9 6.5-1.6c4.5 2.8 8.2 6.5 11.1 10.9 1 1.4 1 3.3.1 4.7zM49.2 46H37.8c-2.1 0-3.8-1-3.8-3s1.7-3 3.8-3h11.4c2.1 0 3.8 1 3.8 3s-1.7 3-3.8 3z"
                  fill="#066fd1"
                  style="fill: var(--tblr-primary, #066fd1)"
                />
                <path
                  d="M105.8 46.1c.4 0 .9.2 1.2.6s.6 1 .6 1.7c0 .9-.5 1.6-1.4 2.2s-2 .9-3.2.9c-2 0-3.7-.4-5-1.3s-2-2.6-2-5.4V31.6h-2.2c-.8 0-1.4-.3-1.9-.8s-.9-1.1-.9-1.9c0-.7.3-1.4.8-1.8s1.2-.7 1.9-.7h2.2v-3.1c0-.8.3-1.5.8-2.1s1.3-.8 2.1-.8 1.5.3 2 .8.8 1.3.8 2.1v3.1h3.4c.8 0 1.4.3 1.9.8s.8 1.2.8 1.9-.3 1.4-.8 1.8-1.2.7-1.9.7h-3.4v13c0 .7.2 1.2.5 1.5s.8.5 1.4.5c.3 0 .6-.1 1.1-.2.5-.2.8-.3 1.2-.3zm28-20.7c.8 0 1.5.3 2.1.8.5.5.8 1.2.8 2.1v20.3c0 .8-.3 1.5-.8 2.1-.5.6-1.2.8-2.1.8s-1.5-.3-2-.8-.8-1.2-.8-2.1c-.8.9-1.9 1.7-3.2 2.4-1.3.7-2.8 1-4.3 1-2.2 0-4.2-.6-6-1.7-1.8-1.1-3.2-2.7-4.2-4.7s-1.6-4.3-1.6-6.9c0-2.6.5-4.9 1.5-6.9s2.4-3.6 4.2-4.8c1.8-1.1 3.7-1.7 5.9-1.7 1.5 0 3 .3 4.3.8 1.3.6 2.5 1.3 3.4 2.1 0-.8.3-1.5.8-2.1.5-.5 1.2-.7 2-.7zm-9.7 21.3c2.1 0 3.8-.8 5.1-2.3s2-3.4 2-5.7-.7-4.2-2-5.8c-1.3-1.5-3-2.3-5.1-2.3-2 0-3.7.8-5 2.3-1.3 1.5-2 3.5-2 5.8s.6 4.2 1.9 5.7 3 2.3 5.1 2.3zm32.1-21.3c2.2 0 4.2.6 6 1.7 1.8 1.1 3.2 2.7 4.2 4.7s1.6 4.3 1.6 6.9-.5 4.9-1.5 6.9-2.4 3.6-4.2 4.8c-1.8 1.1-3.7 1.7-5.9 1.7-1.5 0-3-.3-4.3-.9s-2.5-1.4-3.4-2.3v.3c0 .8-.3 1.5-.8 2.1-.5.6-1.2.8-2.1.8s-1.5-.3-2.1-.8c-.5-.5-.8-1.2-.8-2.1V18.9c0-.8.3-1.5.8-2.1.5-.6 1.2-.8 2.1-.8s1.5.3 2.1.8c.5.6.8 1.3.8 2.1v10c.8-1 1.8-1.8 3.2-2.5 1.3-.7 2.8-1 4.3-1zm-.7 21.3c2 0 3.7-.8 5-2.3s2-3.5 2-5.8-.6-4.2-1.9-5.7-3-2.3-5.1-2.3-3.8.8-5.1 2.3-2 3.4-2 5.7.7 4.2 2 5.8c1.3 1.6 3 2.3 5.1 2.3zm23.6 1.9c0 .8-.3 1.5-.8 2.1s-1.3.8-2.1.8-1.5-.3-2-.8-.8-1.3-.8-2.1V18.9c0-.8.3-1.5.8-2.1s1.3-.8 2.1-.8 1.5.3 2 .8.8 1.3.8 2.1v29.7zm29.3-10.5c0 .8-.3 1.4-.9 1.9-.6.5-1.2.7-2 .7h-15.8c.4 1.9 1.3 3.4 2.6 4.4 1.4 1.1 2.9 1.6 4.7 1.6 1.3 0 2.3-.1 3.1-.4.7-.2 1.3-.5 1.8-.8.4-.3.7-.5.9-.6.6-.3 1.1-.4 1.6-.4.7 0 1.2.2 1.7.7s.7 1 .7 1.7c0 .9-.4 1.6-1.3 2.4-.9.7-2.1 1.4-3.6 1.9s-3 .8-4.6.8c-2.7 0-5-.6-7-1.7s-3.5-2.7-4.6-4.6-1.6-4.2-1.6-6.6c0-2.8.6-5.2 1.7-7.2s2.7-3.7 4.6-4.8 3.9-1.7 6-1.7 4.1.6 6 1.7 3.4 2.7 4.5 4.7c.9 1.9 1.5 4.1 1.5 6.3zm-12.2-7.5c-3.7 0-5.9 1.7-6.6 5.2h12.6v-.3c-.1-1.3-.8-2.5-2-3.5s-2.5-1.4-4-1.4zm30.3-5.2c1 0 1.8.3 2.4.8.7.5 1 1.2 1 1.9 0 1-.3 1.7-.8 2.2-.5.5-1.1.8-1.8.7-.5 0-1-.1-1.6-.3-.2-.1-.4-.1-.6-.2-.4-.1-.7-.1-1.1-.1-.8 0-1.6.3-2.4.8s-1.4 1.3-1.9 2.3-.7 2.3-.7 3.7v11.4c0 .8-.3 1.5-.8 2.1-.5.6-1.2.8-2.1.8s-1.5-.3-2.1-.8c-.5-.6-.8-1.3-.8-2.1V28.8c0-.8.3-1.5.8-2.1.5-.6 1.2-.8 2.1-.8s1.5.3 2.1.8c.5.6.8 1.3.8 2.1v.6c.7-1.3 1.8-2.3 3.2-3 1.3-.7 2.8-1 4.3-1z"
                  fill-rule="evenodd"
                  clip-rule="evenodd"
                  fill="#4a4a4a"
                />
              </svg>
            </a>
          </div>
          <!-- END NAVBAR LOGO -->
          <div class="navbar-nav flex-row d-lg-none">
            <div class="nav-item d-none d-lg-flex me-3">
              <div class="btn-list">
                <a href="https://github.com/tabler/tabler" class="btn btn-5" target="_blank" rel="noreferrer">
                  <!-- Download SVG icon from http://tabler.io/icons/icon/brand-github -->
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
                    <path
                      d="M9 19c-4.3 1.4 -4.3 -2.5 -6 -3m12 5v-3.5c0 -1 .1 -1.4 -.5 -2c2.8 -.3 5.5 -1.4 5.5 -6a4.6 4.6 0 0 0 -1.3 -3.2a4.2 4.2 0 0 0 -.1 -3.2s-1.1 -.3 -3.5 1.3a12.3 12.3 0 0 0 -6.2 0c-2.4 -1.6 -3.5 -1.3 -3.5 -1.3a4.2 4.2 0 0 0 -.1 3.2a4.6 4.6 0 0 0 -1.3 3.2c0 4.6 2.7 5.7 5.5 6c-.6 .6 -.6 1.2 -.5 2v3.5"
                    />
                  </svg>
                  Source code
                </a>
                <a href="https://github.com/sponsors/codecalm" class="btn btn-6" target="_blank" rel="noreferrer">
                  <!-- Download SVG icon from http://tabler.io/icons/icon/heart -->
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
                    class="icon text-pink icon-2"
                  >
                    <path d="M19.5 12.572l-7.5 7.428l-7.5 -7.428a5 5 0 1 1 7.5 -6.566a5 5 0 1 1 7.5 6.572" />
                  </svg>
                  Sponsor
                </a>
              </div>
            </div>
            <div class="d-none d-lg-flex">
              <div class="nav-item">
                <a href="?theme=dark" class="nav-link px-0 hide-theme-dark" title="Enable dark mode" data-bs-toggle="tooltip" data-bs-placement="bottom">
                  <!-- Download SVG icon from http://tabler.io/icons/icon/moon -->
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
                    class="icon icon-1"
                  >
                    <path d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z" />
                  </svg>
                </a>
                <a href="?theme=light" class="nav-link px-0 hide-theme-light" title="Enable light mode" data-bs-toggle="tooltip" data-bs-placement="bottom">
                  <!-- Download SVG icon from http://tabler.io/icons/icon/sun -->
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
                    class="icon icon-1"
                  >
                    <path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                    <path d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7" />
                  </svg>
                </a>
              </div>
              <div class="nav-item dropdown d-none d-md-flex me-3">
                <a href="#" class="nav-link px-0" data-bs-toggle="dropdown" tabindex="-1" aria-label="Show notifications">
                  <!-- Download SVG icon from http://tabler.io/icons/icon/bell -->
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
                    class="icon icon-1"
                  >
                    <path d="M10 5a2 2 0 1 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" />
                    <path d="M9 17v1a3 3 0 0 0 6 0v-1" />
                  </svg>
                  <span class="badge bg-red"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-end dropdown-menu-card">
                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">Last updates</h3>
                    </div>
                    <div class="list-group list-group-flush list-group-hoverable">
                      <div class="list-group-item">
                        <div class="row align-items-center">
                          <div class="col-auto"><span class="status-dot status-dot-animated bg-red d-block"></span></div>
                          <div class="col text-truncate">
                            <a href="#" class="text-body d-block">Example 1</a>
                            <div class="d-block text-secondary text-truncate mt-n1">Change deprecated html tags to text decoration classes (#29604)</div>
                          </div>
                          <div class="col-auto">
                            <a href="#" class="list-group-item-actions">
                              <!-- Download SVG icon from http://tabler.io/icons/icon/star -->
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
                                class="icon text-muted icon-2"
                              >
                                <path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" />
                              </svg>
                            </a>
                          </div>
                        </div>
                      </div>
                      <div class="list-group-item">
                        <div class="row align-items-center">
                          <div class="col-auto"><span class="status-dot d-block"></span></div>
                          <div class="col text-truncate">
                            <a href="#" class="text-body d-block">Example 2</a>
                            <div class="d-block text-secondary text-truncate mt-n1">justify-content:between ⇒ justify-content:space-between (#29734)</div>
                          </div>
                          <div class="col-auto">
                            <a href="#" class="list-group-item-actions show">
                              <!-- Download SVG icon from http://tabler.io/icons/icon/star -->
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
                                class="icon text-yellow icon-2"
                              >
                                <path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" />
                              </svg>
                            </a>
                          </div>
                        </div>
                      </div>
                      <div class="list-group-item">
                        <div class="row align-items-center">
                          <div class="col-auto"><span class="status-dot d-block"></span></div>
                          <div class="col text-truncate">
                            <a href="#" class="text-body d-block">Example 3</a>
                            <div class="d-block text-secondary text-truncate mt-n1">Update change-version.js (#29736)</div>
                          </div>
                          <div class="col-auto">
                            <a href="#" class="list-group-item-actions">
                              <!-- Download SVG icon from http://tabler.io/icons/icon/star -->
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
                                class="icon text-muted icon-2"
                              >
                                <path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" />
                              </svg>
                            </a>
                          </div>
                        </div>
                      </div>
                      <div class="list-group-item">
                        <div class="row align-items-center">
                          <div class="col-auto"><span class="status-dot status-dot-animated bg-green d-block"></span></div>
                          <div class="col text-truncate">
                            <a href="#" class="text-body d-block">Example 4</a>
                            <div class="d-block text-secondary text-truncate mt-n1">Regenerate package-lock.json (#29730)</div>
                          </div>
                          <div class="col-auto">
                            <a href="#" class="list-group-item-actions">
                              <!-- Download SVG icon from http://tabler.io/icons/icon/star -->
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
                                class="icon text-muted icon-2"
                              >
                                <path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" />
                              </svg>
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="nav-item dropdown">
              <a href="#" class="nav-link d-flex lh-1 p-0 px-2" data-bs-toggle="dropdown" aria-label="Open user menu">
                <span class="avatar avatar-sm" style="background-image: url({{asset('tabler/v1.1.1')}}/static/avatars/000m.jpg)"></span>
                <div class="d-none d-xl-block ps-2">
                  <div>Paweł Kuna</div>
                  <div class="mt-1 small text-secondary">UI Designer</div>
                </div>
              </a>
              <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <a href="#" class="dropdown-item">Status</a>
                <a href="{{asset('tabler/v1.1.1')}}/profile.html" class="dropdown-item">Profile</a>
                <a href="#" class="dropdown-item">Feedback</a>
                <div class="dropdown-divider"></div>
                <a href="{{asset('tabler/v1.1.1')}}/settings.html" class="dropdown-item">Settings</a>
                <a href="{{asset('tabler/v1.1.1')}}/sign-in.html" class="dropdown-item">Logout</a>
              </div>
            </div>
          </div>
          <div class="collapse navbar-collapse" id="sidebar-menu">
            <!-- BEGIN NAVBAR MENU -->
            <ul class="navbar-nav pt-lg-3">
              <li class="nav-item">
                <a class="nav-link" href="{{asset('tabler/v1.1.1')}}/">
                  <span class="nav-link-icon d-md-none d-lg-inline-block">
                    <!-- Download SVG icon from http://tabler.io/icons/icon/home -->
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
                      class="icon icon-1"
                    >
                      <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                      <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                      <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                    </svg>
                  </span>
                  <span class="nav-link-title"> Home </span>
                </a>
              </li>
              <li class="nav-item dropdown">
                <a
                  class="nav-link dropdown-toggle"
                  href="#navbar-base"
                  data-bs-toggle="dropdown"
                  data-bs-auto-close="false"
                  role="button"
                  aria-expanded="false"
                >
                  <span class="nav-link-icon d-md-none d-lg-inline-block">
                    <!-- Download SVG icon from http://tabler.io/icons/icon/package -->
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
                      class="icon icon-1"
                    >
                      <path d="M12 3l8 4.5l0 9l-8 4.5l-8 -4.5l0 -9l8 -4.5" />
                      <path d="M12 12l8 -4.5" />
                      <path d="M12 12l0 9" />
                      <path d="M12 12l-8 -4.5" />
                      <path d="M16 5.25l-8 4.5" />
                    </svg>
                  </span>
                  <span class="nav-link-title"> Interface </span>
                </a>
                <div class="dropdown-menu">
                  <div class="dropdown-menu-columns">
                    <div class="dropdown-menu-column">
                      <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/accordion.html">
                        Accordion
                        <span class="badge badge-sm bg-green-lt text-uppercase ms-auto">New</span>
                      </a>
                      <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/alerts.html"> Alerts </a>
                      <div class="dropend">
                        <a
                          class="dropdown-item dropdown-toggle"
                          href="#sidebar-authentication"
                          data-bs-toggle="dropdown"
                          data-bs-auto-close="false"
                          role="button"
                          aria-expanded="false"
                        >
                          Authentication
                        </a>
                        <div class="dropdown-menu">
                          <a href="{{asset('tabler/v1.1.1')}}/sign-in.html" class="dropdown-item"> Sign in </a>
                          <a href="{{asset('tabler/v1.1.1')}}/sign-in-link.html" class="dropdown-item"> Sign in link </a>
                          <a href="{{asset('tabler/v1.1.1')}}/sign-in-illustration.html" class="dropdown-item"> Sign in with illustration </a>
                          <a href="{{asset('tabler/v1.1.1')}}/sign-in-cover.html" class="dropdown-item"> Sign in with cover </a>
                          <a href="{{asset('tabler/v1.1.1')}}/sign-up.html" class="dropdown-item"> Sign up </a>
                          <a href="{{asset('tabler/v1.1.1')}}/forgot-password.html" class="dropdown-item"> Forgot password </a>
                          <a href="{{asset('tabler/v1.1.1')}}/terms-of-service.html" class="dropdown-item"> Terms of service </a>
                          <a href="{{asset('tabler/v1.1.1')}}/auth-lock.html" class="dropdown-item"> Lock screen </a>
                          <a href="{{asset('tabler/v1.1.1')}}/2-step-verification.html" class="dropdown-item"> 2 step verification </a>
                          <a href="{{asset('tabler/v1.1.1')}}/2-step-verification-code.html" class="dropdown-item"> 2 step verification code </a>
                        </div>
                      </div>
                      <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/badges.html"> Badges </a>
                      <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/blank.html"> Blank page </a>
                      <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/buttons.html"> Buttons </a>
                      <div class="dropend">
                        <a
                          class="dropdown-item dropdown-toggle"
                          href="#sidebar-cards"
                          data-bs-toggle="dropdown"
                          data-bs-auto-close="false"
                          role="button"
                          aria-expanded="false"
                        >
                          Cards
                        </a>
                        <div class="dropdown-menu">
                          <a href="{{asset('tabler/v1.1.1')}}/cards.html" class="dropdown-item"> Sample cards </a>
                          <a href="{{asset('tabler/v1.1.1')}}/card-actions.html" class="dropdown-item">
                            Card actions
                            <span class="badge badge-sm bg-green-lt text-uppercase ms-auto">New</span>
                          </a>
                          <a href="{{asset('tabler/v1.1.1')}}/cards-masonry.html" class="dropdown-item"> Cards Masonry </a>
                        </div>
                      </div>
                      <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/carousel.html"> Carousel </a>
                      <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/colors.html"> Colors </a>
                      <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/datagrid.html"> Data grid </a>
                      <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/dropdowns.html"> Dropdowns </a>
                      <div class="dropend">
                        <a
                          class="dropdown-item dropdown-toggle"
                          href="#sidebar-error"
                          data-bs-toggle="dropdown"
                          data-bs-auto-close="false"
                          role="button"
                          aria-expanded="false"
                        >
                          Error pages
                        </a>
                        <div class="dropdown-menu">
                          <a href="{{asset('tabler/v1.1.1')}}/error-404.html" class="dropdown-item"> 404 page </a>
                          <a href="{{asset('tabler/v1.1.1')}}/error-500.html" class="dropdown-item"> 500 page </a>
                          <a href="{{asset('tabler/v1.1.1')}}/error-maintenance.html" class="dropdown-item"> Maintenance page </a>
                        </div>
                      </div>
                      <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/lists.html"> Lists </a>
                      <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/modals.html"> Modals </a>
                      <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/markdown.html"> Markdown </a>
                    </div>
                    <div class="dropdown-menu-column">
                      <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/navigation.html"> Navigation </a>
                      <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/offcanvas.html"> Offcanvas </a>
                      <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/pagination.html"> Pagination </a>
                      <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/placeholder.html"> Placeholder </a>
                      <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/segmented-control.html">
                        Segmented control
                        <span class="badge badge-sm bg-green-lt text-uppercase ms-auto">New</span>
                      </a>
                      <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/scroll-spy.html">
                        Scroll spy
                        <span class="badge badge-sm bg-green-lt text-uppercase ms-auto">New</span>
                      </a>
                      <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/social-icons.html"> Social icons </a>
                      <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/stars-rating.html"> Stars rating </a>
                      <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/steps.html"> Steps </a>
                      <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/tables.html"> Tables </a>
                      <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/tabs.html"> Tabs </a>
                      <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/tags.html"> Tags </a>
                      <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/toasts.html"> Toasts </a>
                      <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/typography.html"> Typography </a>
                    </div>
                  </div>
                </div>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{asset('tabler/v1.1.1')}}/form-elements.html">
                  <span class="nav-link-icon d-md-none d-lg-inline-block">
                    <!-- Download SVG icon from http://tabler.io/icons/icon/checkbox -->
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
                      class="icon icon-1"
                    >
                      <path d="M9 11l3 3l8 -8" />
                      <path d="M20 12v6a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h9" />
                    </svg>
                  </span>
                  <span class="nav-link-title"> Forms </span>
                </a>
              </li>
              <li class="nav-item dropdown">
                <a
                  class="nav-link dropdown-toggle"
                  href="#navbar-extra"
                  data-bs-toggle="dropdown"
                  data-bs-auto-close="false"
                  role="button"
                  aria-expanded="false"
                >
                  <span class="nav-link-icon d-md-none d-lg-inline-block">
                    <!-- Download SVG icon from http://tabler.io/icons/icon/star -->
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
                      class="icon icon-1"
                    >
                      <path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" />
                    </svg>
                  </span>
                  <span class="nav-link-title"> Extra </span>
                </a>
                <div class="dropdown-menu">
                  <div class="dropdown-menu-columns">
                    <div class="dropdown-menu-column">
                      <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/activity.html"> Activity </a>
                      <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/chat.html"> Chat </a>
                      <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/cookie-banner.html"> Cookie banner </a>
                      <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/empty.html"> Empty page </a>
                      <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/faq.html"> FAQ </a>
                      <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/gallery.html"> Gallery </a>
                      <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/invoice.html"> Invoice </a>
                      <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/job-listing.html"> Job listing </a>
                      <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/license.html"> License </a>
                      <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/logs.html"> Logs </a>
                      <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/marketing/index.html"> Marketing </a>
                      <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/music.html"> Music </a>
                      <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/page-loader.html"> Page loader </a>
                    </div>
                    <div class="dropdown-menu-column">
                      <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/photogrid.html"> Photogrid </a>
                      <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/pricing.html"> Pricing cards </a>
                      <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/pricing-table.html"> Pricing table </a>
                      <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/search-results.html"> Search results </a>
                      <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/settings.html"> Settings </a>
                      <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/signatures.html">
                        Signatures
                        <span class="badge badge-sm bg-green-lt text-uppercase ms-auto">New</span>
                      </a>
                      <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/tasks.html"> Tasks </a>
                      <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/trial-ended.html"> Trial ended </a>
                      <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/uptime.html"> Uptime monitor </a>
                      <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/users.html"> Users </a>
                      <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/widgets.html"> Widgets </a>
                      <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/wizard.html"> Wizard </a>
                    </div>
                  </div>
                </div>
              </li>
              <li class="nav-item active dropdown">
                <a
                  class="nav-link dropdown-toggle"
                  href="#navbar-layout"
                  data-bs-toggle="dropdown"
                  data-bs-auto-close="false"
                  role="button"
                  aria-expanded="true"
                >
                  <span class="nav-link-icon d-md-none d-lg-inline-block">
                    <!-- Download SVG icon from http://tabler.io/icons/icon/layout-2 -->
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
                      class="icon icon-1"
                    >
                      <path d="M4 4m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v1a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" />
                      <path d="M4 13m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v3a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" />
                      <path d="M14 4m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v3a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" />
                      <path d="M14 15m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v1a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" />
                    </svg>
                  </span>
                  <span class="nav-link-title"> Layout </span>
                </a>
                <div class="dropdown-menu show">
                  <div class="dropdown-menu-columns">
                    <div class="dropdown-menu-column">
                      <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/layout-boxed.html"> Boxed </a>
                      <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/layout-combo.html"> Combined </a>
                      <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/layout-condensed.html"> Condensed </a>
                      <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/layout-fluid.html"> Fluid </a>
                      <a class="dropdown-item active" href="{{asset('tabler/v1.1.1')}}/layout-fluid-vertical.html"> Fluid vertical </a>
                      <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/layout-horizontal.html"> Horizontal </a>
                      <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/layout-navbar-dark.html"> Navbar dark </a>
                    </div>
                    <div class="dropdown-menu-column">
                      <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/layout-navbar-overlap.html"> Navbar overlap </a>
                      <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/layout-navbar-sticky.html"> Navbar sticky </a>
                      <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/layout-vertical-right.html"> Right vertical </a>
                      <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/layout-rtl.html"> RTL mode </a>
                      <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/layout-vertical.html"> Vertical </a>
                      <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/layout-vertical-transparent.html"> Vertical transparent </a>
                    </div>
                  </div>
                </div>
              </li>
              <li class="nav-item dropdown">
                <a
                  class="nav-link dropdown-toggle"
                  href="#navbar-plugins"
                  data-bs-toggle="dropdown"
                  data-bs-auto-close="false"
                  role="button"
                  aria-expanded="false"
                >
                  <span class="nav-link-icon d-md-none d-lg-inline-block">
                    <!-- Download SVG icon from http://tabler.io/icons/icon/puzzle -->
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
                      class="icon icon-1"
                    >
                      <path
                        d="M4 7h3a1 1 0 0 0 1 -1v-1a2 2 0 0 1 4 0v1a1 1 0 0 0 1 1h3a1 1 0 0 1 1 1v3a1 1 0 0 0 1 1h1a2 2 0 0 1 0 4h-1a1 1 0 0 0 -1 1v3a1 1 0 0 1 -1 1h-3a1 1 0 0 1 -1 -1v-1a2 2 0 0 0 -4 0v1a1 1 0 0 1 -1 1h-3a1 1 0 0 1 -1 -1v-3a1 1 0 0 1 1 -1h1a2 2 0 0 0 0 -4h-1a1 1 0 0 1 -1 -1v-3a1 1 0 0 1 1 -1"
                      />
                    </svg>
                  </span>
                  <span class="nav-link-title"> Plugins </span>
                </a>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/charts.html"> Charts </a>
                  <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/colorpicker.html"> Color picker </a>
                  <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/datatables.html"> Datatables </a>
                  <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/dropzone.html"> Dropzone </a>
                  <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/inline-player.html"> Inline player </a>
                  <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/lightbox.html"> Lightbox </a>
                  <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/maps.html"> Map </a>
                  <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/map-fullsize.html"> Map fullsize </a>
                  <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/maps-vector.html"> Map vector </a>
                  <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/tinymce.html"> TinyMCE </a>
                </div>
              </li>
              <li class="nav-item dropdown">
                <a
                  class="nav-link dropdown-toggle"
                  href="#navbar-addons"
                  data-bs-toggle="dropdown"
                  data-bs-auto-close="false"
                  role="button"
                  aria-expanded="false"
                >
                  <span class="nav-link-icon d-md-none d-lg-inline-block">
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
                      class="icon icon-1"
                    >
                      <path d="M12 5l0 14" />
                      <path d="M5 12l14 0" />
                    </svg>
                  </span>
                  <span class="nav-link-title"> Addons </span>
                </a>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/icons.html"> Icons </a>
                  <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/emails.html"> Emails </a>
                  <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/flags.html"> Flags </a>
                  <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/illustrations.html"> Illustrations </a>
                  <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/payment-providers.html"> Payment providers </a>
                </div>
              </li>
              <li class="nav-item dropdown">
                <a
                  class="nav-link dropdown-toggle"
                  href="#navbar-help"
                  data-bs-toggle="dropdown"
                  data-bs-auto-close="false"
                  role="button"
                  aria-expanded="false"
                >
                  <span class="nav-link-icon d-md-none d-lg-inline-block">
                    <!-- Download SVG icon from http://tabler.io/icons/icon/lifebuoy -->
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
                      class="icon icon-1"
                    >
                      <path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                      <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                      <path d="M15 15l3.35 3.35" />
                      <path d="M9 15l-3.35 3.35" />
                      <path d="M5.65 5.65l3.35 3.35" />
                      <path d="M18.35 5.65l-3.35 3.35" />
                    </svg>
                  </span>
                  <span class="nav-link-title"> Help </span>
                </a>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="https://tabler.io/docs" target="_blank" rel="noopener"> Documentation </a>
                  <a class="dropdown-item" href="{{asset('tabler/v1.1.1')}}/changelog.html"> Changelog </a>
                  <a class="dropdown-item" href="https://github.com/tabler/tabler" target="_blank" rel="noopener"> Source code </a>
                  <a class="dropdown-item text-pink" href="https://github.com/sponsors/codecalm" target="_blank" rel="noopener">
                    <!-- Download SVG icon from http://tabler.io/icons/icon/heart -->
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
                      class="icon icon-inline me-1 icon-2"
                    >
                      <path d="M19.5 12.572l-7.5 7.428l-7.5 -7.428a5 5 0 1 1 7.5 -6.566a5 5 0 1 1 7.5 6.572" />
                    </svg>
                    Sponsor project!
                  </a>
                </div>
              </li>
            </ul>
            <!-- END NAVBAR MENU -->
          </div>
        </div>
      </aside>
      <!--  END SIDEBAR  -->
      <div class="page-wrapper">
        <!-- BEGIN PAGE HEADER -->
        <div class="page-header d-print-none">
          <div class="container-xl">
            <div class="row g-2 align-items-center">
              <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">Overview</div>
                <h2 class="page-title">Fluid vertical layout</h2>
              </div>
              <!-- Page title actions -->
              <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                  <span class="d-none d-sm-inline">
                    <a href="#" class="btn btn-1"> New view </a>
                  </span>
                  <a href="#" class="btn btn-primary btn-5 d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modal-report">
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
        <!-- END PAGE HEADER -->
        <!-- BEGIN PAGE BODY -->
        <div class="page-body">
          <div class="container-xl">

          <div class="row row-deck row-cards">
            <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Invoices</h3>
                  </div>
                  <div class="card-body border-bottom py-3">
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
                  <div class="table-responsive">
                    <table id="users-table" class="table table-selectable card-table table-vcenter text-nowrap datatable">
                      <thead>
                        <tr>
                          <th class="w-1"><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></th>
                          <th class="w-1">
                           #
                            <!-- Download SVG icon from http://tabler.io/icons/icon/chevron-up -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-sm icon-thick icon-2">
                              <path d="M6 15l6 -6l6 6"></path>
                            </svg>
                          </th>
                          <th>Name</th>
                          <th>Email</th>
                          <th>Phone</th>
                          <th>DOB</th>
                          <th>Plan Name</th>
                          <th>Approval Status</th>
                          <th>Action </th>
                        </tr>
                      </thead>
                      <tbody>
                        <!-- <tr>
                          <td><input class="form-check-input m-0 align-middle table-selectable-check" type="checkbox" aria-label="Select invoice"></td>
                          <td><span class="text-secondary">001401</span></td>
                          <td><a href="invoice.html" class="text-reset" tabindex="-1">Design Works</a></td>
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

                       
                          <td><span class="text-secondary">001403</span></td>
                          <td><a href="invoice.html" class="text-reset" tabindex="-1">New Dashboard</a></td>
                          <td>
                            <span class="flag flag-xs flag-country-de me-2"></span>
                            Bluewolf
                          </td>
                          <td>87952621</td>
                          <td>23 Oct 2017</td>
                          <td><span class="badge bg-warning me-1"></span> Pending</td>
                          <td>$534</td>
                          <td class="text-end">
                            <span class="dropdown">
                              <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport" data-bs-toggle="dropdown">Actions</button>
                              <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#"> Action </a>
                                <a class="dropdown-item" href="#"> Another action </a>
                              </div>
                            </span>
                          </td>
       
                      </tbody>
                    </table>
                  </div>
        
                </div>
              </div>
          </div>
          </div>
        </div>
        <!-- END PAGE BODY -->
        <!--  BEGIN FOOTER  -->
        <footer class="footer footer-transparent d-print-none">
          <div class="container-xl">
            <div class="row text-center align-items-center flex-row-reverse">
              <div class="col-lg-auto ms-lg-auto">
                <ul class="list-inline list-inline-dots mb-0">
                  <li class="list-inline-item"><a href="https://tabler.io/docs" target="_blank" class="link-secondary" rel="noopener">Documentation</a></li>
                  <li class="list-inline-item"><a href="{{asset('tabler/v1.1.1')}}/license.html" class="link-secondary">License</a></li>
                  <li class="list-inline-item">
                    <a href="https://github.com/tabler/tabler" target="_blank" class="link-secondary" rel="noopener">Source code</a>
                  </li>
                  <li class="list-inline-item">
                    <a href="https://github.com/sponsors/codecalm" target="_blank" class="link-secondary" rel="noopener">
                      <!-- Download SVG icon from http://tabler.io/icons/icon/heart -->
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
                        class="icon text-pink icon-inline icon-4"
                      >
                        <path d="M19.5 12.572l-7.5 7.428l-7.5 -7.428a5 5 0 1 1 7.5 -6.566a5 5 0 1 1 7.5 6.572" />
                      </svg>
                      Sponsor
                    </a>
                  </li>
                </ul>
              </div>
              <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                <ul class="list-inline list-inline-dots mb-0">
                  <li class="list-inline-item">
                    Copyright &copy; 2025
                    <a href="." class="link-secondary">Tabler</a>. All rights reserved.
                  </li>
                  <li class="list-inline-item">
                    <a href="{{asset('tabler/v1.1.1')}}/changelog.html" class="link-secondary" rel="noopener"> v1.1.1 </a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </footer>
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
    <script>
      $(document).ready(function() {
            $('#users-table').DataTable({
                processing: true,
                serverSide: false,
            
            });
        });
    </script>

    <!-- END PAGE SCRIPTS -->
  </body>
</html>
