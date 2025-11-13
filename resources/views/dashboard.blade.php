@extends("layouts.app")

@section("content")
    <div class="page-body">
        <div class="container-xl">

            <!-- Header Section -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="welcome-header">
                        <h1 class="display-6 text-gradient">Dashboard Overview</h1>
                        <p class="text-muted">Monitor your system performance and user activities</p>
                    </div>
                </div>
            </div>

            <!-- Main Stats Cards -->
            <div class="row row-deck row-cards mb-5">
                <!-- Welcome & Analytics Card -->
                <div class="col-12 col-lg-8">
                    <div class="card analytics-card">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-7">
                                    <div class="d-flex flex-column h-100">
                                        <h2 class="text-gradient mb-3">Welcome Back, Admin! 👋</h2>
                                        <p class="text-muted mb-4 fs-5">
                                            {{ $stats->pending_users
                                                ? "You have {$stats->pending_users} new requests waiting for review"
                                                : "All caught up! No pending requests"
                                            }}
                                        </p>
                                        <div class="row g-4 mt-auto">
                                            <div class="col-6">
                                                <div class="stat-item">
                                                    <div class="d-flex align-items-center mb-2">
                                                        <div class="stat-indicator bg-success me-2"></div>
                                                        <span class="text-success fw-bold">Approved Users</span>
                                                    </div>
                                                    <h3 class="text-success mb-1">{{$stats->active_users??0}}</h3>
                                                    <div class="progress progress-sm">
                                                        <div class="progress-bar bg-success" style="width: 75%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="stat-item">
                                                    <div class="d-flex align-items-center mb-2">
                                                        <div class="stat-indicator bg-warning me-2"></div>
                                                        <span class="text-warning fw-bold">Pending Requests</span>
                                                    </div>
                                                    <h3 class="text-warning mb-1">{{$stats->pending_users??0}}</h3>
                                                    <div class="progress progress-sm">
                                                        <div class="progress-bar bg-warning" style="width: 78%"></div>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5 text-center">
                                    <div class="illustration-wrapper">
                                        <div class="floating-shapes">
                                            <div class="shape shape-1"></div>
                                            <div class="shape shape-2"></div>
                                            <div class="shape shape-3"></div>
                                        </div>
                                        <svg xmlns="http://www.w3.org/2000/svg" height="180" fill="none" viewBox="0 0 800 600" class="hero-illustration">
                                            <!-- SVG content remains the same -->
                                            <path d="M125.93 300.392C125.93 346.056 174.224 379.274 195.614 416.213C217.61 454.339 222.991 512.425 260.996 534.543C297.935 555.933 350.519 532.034 396.183 532.034C441.848 532.034 494.432 555.945 531.371 534.543C569.376 512.547 574.757 454.339 596.753 416.213C618.143 379.274 666.437 346.165 666.437 300.392C666.437 254.618 618.034 221.509 596.753 184.57C574.757 146.444 569.376 88.2364 531.371 66.2405C494.432 44.8504 441.848 68.7491 396.183 68.7491C350.519 68.7491 297.935 44.8383 260.996 66.2405C222.87 88.2364 217.61 146.444 195.614 184.57C174.224 221.618 125.93 254.727 125.93 300.392Z" fill="#066FD1" opacity="0.02"></path>
                                            <!-- ... باقي الـ SVG ... -->
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Users Card -->
                <div class="col-12 col-lg-4">
                    <div class="card user-stats-card h-100">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-wrapper  bg-opacity-10 me-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="9" cy="7" r="4"></circle>
                                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                    </svg>
                                </div>
                                <span class="text-uppercase small fw-bold text-muted">Total Users</span>
                            </div>
                            <h1 class="display-4  mb-2">{{optional($stats)->total_users??0}}</h1>
                            <div class="mt-auto">
                                <div class="d-flex align-items-center text-success">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
                                        <polyline points="17 6 23 6 23 12"></polyline>
                                    </svg>
                                    <span class="ms-1 small">Increased from last month</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Services Section -->
            <div class="row">
                <div class="col-12">
                    <div class="section-header mb-4">
                        <h3 class="section-title">Services Management</h3>
                        <p class="section-subtitle">Overview of all service requests</p>
                    </div>
                </div>
            </div>

            <div class="row row-cards">
                @foreach($services as $service)
                    <div class="col-sm-6 col-xl-3 mb-4">
                        <div class="card service-card h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="service-icon-wrapper me-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M3 10h18M3 14h18m-9-4v8m-3 0h6"></path>
                                            <rect x="3" y="4" width="18" height="16" rx="2"></rect>
                                        </svg>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="service-name mb-0">{{ $service->name["en"] }}</h6>
                                    </div>
                                </div>
                                <div class="service-stats">
                                    <h2 class="text-primary mb-1">{{ $service->total_requests }}</h2>
                                    <span class="text-muted small">Request{{ $service->total_requests !== 1 ? 's' : '' }}</span>
                                </div>
                                <div class="service-progress mt-3">
                                    <div class="progress">
                                        @php
                                            $percentage = min(100, ($service->total_requests / max(1, $stats->total_users)) * 100);
                                        @endphp
                                        <div class="progress-bar" style="width: {{ $percentage }}%"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent">
                                <a href="{{route('service-requests.index',["service_id"=>$service->id])}}" class="btn btn-sm btn-outline-primary w-100">
                                    View Details
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="m9 18 6-6-6-6"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach

                    <div class="col-sm-6 col-xl-3 mb-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body d-flex flex-column">
                                <h6 class="card-title mb-3">Generate QR Code</h6>
                                <p class="text-muted small mb-3">Enter  expiration in Hours</p>

                                <form id="qr-form" class="mb-3">

                                    <div class="mb-3">
                                        <input type="number" class="form-control form-control" id="qr-expire" placeholder="Expiration (days)" min="1">
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100 generate-btn service-icon-wrapper me-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 18px; height: 18px;">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.5A.75.75 0 014.5 3.75h4.5a.75.75 0 01.75.75v4.5a.75.75 0 01-.75.75h-4.5a.75.75 0 01-.75-.75v-4.5zM3.75 15A.75.75 0 014.5 14.25h4.5a.75.75 0 01.75.75v4.5a.75.75 0 01-.75.75h-4.5a.75.75 0 01-.75-.75v-4.5zM15 3.75A.75.75 0 0014.25 3h-4.5a.75.75 0 00-.75.75v4.5a.75.75 0 00.75.75h4.5a.75.75 0 00.75-.75v-4.5zM19.5 19.5h.008v.008h-.008v-.008zM16.5 15h.008v.008h-.008V15zM15 16.5h.008v.008H15v-.008zM16.5 18h.008v.008h-.008v-.008zM18 16.5h.008v.008H18v-.008zM19.5 15h.008v.008h-.008V15zM18 19.5h.008v.008H18v-.008zM19.5 18h.008v.008h-.008v-.008zM15 19.5h.008v.008H15v-.008z" />
                                        </svg>
                                        Generate
                                        <span class="spinner-border spinner-border-sm ms-2" role="status" aria-hidden="true" style="display:none;"></span>
                                    </button>
                                </form>

                                <div id="qr-result" class="mt-auto text-center" style="display:none;">
                                    <p class="small mb-1">QR Code Generated:</p>
                                    <img src="" id="qr-image" class="img-fluid" alt="QR Code">
                                </div>
                            </div>
                        </div>
                    </div>

            </div>
            <!-- QR Generator Card -->


        </div>
    </div>

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #25384f 0%, #054a8f 100%);
            --success-gradient: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
            --warning-gradient: linear-gradient(135deg, #ffc107 0%, #e0a800 100%);
        }

        .text-gradient {
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .analytics-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            overflow: hidden;
        }

        .analytics-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--primary-gradient);
        }

        .user-stats-card {
            background: white;
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            transition: transform 0.3s ease;
        }

        .user-stats-card:hover {
            transform: translateY(-5px);
        }

        .icon-wrapper {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .service-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.06);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .service-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 40px rgba(0,0,0,0.15);
        }

        .service-icon-wrapper {
            width: 48px;
            height: 48px;
            background: var(--primary-gradient);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .service-name {
            font-weight: 600;
            color: #25384f;
        }

        .service-stats h2 {
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        .quick-actions-card {
            border: none;
            border-radius: 20px;
            background: white;
            box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        }

        .quick-action-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 1.5rem 1rem;
            text-decoration: none;
            color: #6c757d;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .quick-action-item:hover {
            background: #f8f9fa;
            color: #25384f;
            transform: translateY(-2px);
        }

        .action-icon {
            width: 60px;
            height: 60px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 0.75rem;
            color: white;
        }

        .illustration-wrapper {
            position: relative;
            padding: 1rem;
        }

        .floating-shapes {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 1;
        }

        .shape {
            position: absolute;
            border-radius: 50%;
            background: var(--primary-gradient);
            opacity: 0.1;
        }

        .shape-1 {
            width: 80px;
            height: 80px;
            top: 10%;
            right: 10%;
            animation: float 6s ease-in-out infinite;
        }

        .shape-2 {
            width: 40px;
            height: 40px;
            bottom: 20%;
            left: 10%;
            animation: float 4s ease-in-out infinite reverse;
        }

        .shape-3 {
            width: 60px;
            height: 60px;
            top: 50%;
            left: 20%;
            animation: float 5s ease-in-out infinite 1s;
        }

        .hero-illustration {
            position: relative;
            z-index: 2;
            filter: drop-shadow(0 10px 20px rgba(6, 111, 209, 0.2));
        }

        .stat-indicator {
            width: 8px;
            height: 8px;
            border-radius: 50%;
        }

        .section-header {
            padding: 1rem 0;
        }

        .section-title {
            font-weight: 700;
            color: #25384f;
            margin-bottom: 0.5rem;
        }

        .section-subtitle {
            color: #6c757d;
            margin-bottom: 0;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        .progress {
            height: 6px;
            border-radius: 10px;
            background: #e9ecef;
        }

        .progress-bar {
            border-radius: 10px;
            background: var(--primary-gradient);
            transition: width 1s ease-in-out;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .display-4 {
                font-size: 2.5rem;
            }

            .analytics-card .row {
                text-align: center;
            }

            .quick-action-item {
                padding: 1rem 0.5rem;
            }

            .action-icon {
                width: 50px;
                height: 50px;
            }
        }

        /* Dark mode support */
    </style>
@endsection
