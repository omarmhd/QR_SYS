@extends("layouts.app")

@section("content")

    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle">Members</div>
                    <h2 class="page-title"></h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                  <span class="d-none d-sm-inline">

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
    <!-- END PAGE HEADER -->
    <!-- BEGIN PAGE BODY -->
    <div class="page-body">
        <div class="container-xl">
            <!-- Search Bar -->
            <div class="mb-4 no-print">
                <div class="input-icon">
                <span class="input-icon-addon">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path><path d="M21 21l-6 -6"></path></svg>
                </span>
                    <input id="search-input" type="text" class="form-control" placeholder="Search" />
                </div>
            </div>

            <!-- Members Grid -->
            <div id="members-grid" class="row row-cards">
                <!-- Member cards will be injected here by JavaScript -->
            </div>
            <div id="pagination" class="mt-4 d-flex gap-2 justify-content-center align-items-center"></div>

            <div id="no-results" class="card d-none">
                <div class="card-body text-center">
                    <p class="text-muted text-center mt-4">No results found.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- QR Code Modal -->
    <div class="modal modal-blur fade" id="qrCodeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="qrCodeModalTitle"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="qr-code-container" class="printable-section row g-4">
                        <!-- QR Codes will be injected here -->
                    </div>
                </div>
                <div class="modal-footer no-print">
                    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="print-button" onclick="printModalContent()" >
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2"></path><path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4"></path><path d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z"></path></svg>
                        Print
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- History Modal -->
    <div class="modal modal-blur fade" id="historyModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="historyModalTitle"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="history-modal-body">
                    <!-- History content will be injected here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" data-bs-dismiss="modal">close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabler Core JS -->
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/js/tabler.min.js" defer></script>

    <!-- App Logic -->
    <script>

        document.addEventListener('DOMContentLoaded', () => {


            let membersData = [];
            const membersGrid = document.getElementById('members-grid');
            const searchInput = document.getElementById('search-input');
            const noResults = document.getElementById('no-results');
            const qrCodeContainer = document.getElementById('qr-code-container');
            const paginationEl = document.getElementById('pagination');

            const qrCodeModalEl = document.getElementById('qrCodeModal');
            const qrCodeModal = new bootstrap.Modal(qrCodeModalEl);
            const historyModalEl = document.getElementById('historyModal');
            const historyModal = new bootstrap.Modal(historyModalEl);
            let currentPage = 1;

            const fetchMembers = (page = 1, query = '') => {
                fetch(`/memberships?page=${page}&search=${query}`)
                    .then(res => res.json())
                    .then(res => {
                        membersData = res.data;
                        renderMembers(membersData);
                        if (res.last_page <= 1) {
                            paginationEl.classList.add('d-none');
                        } else {
                            paginationEl.classList.remove('d-none');
                            renderPagination(res);
                        }
                    })
                    .catch(err => console.error());
            };


            const renderPagination = (res) => {
                const paginationEl = document.getElementById('pagination');
                paginationEl.innerHTML = '';

                for (let i = 1; i <= res.last_page; i++) {
                    const btn = document.createElement('button');
                    btn.className = `btn btn-xl ${i === res.current_page ? 'btn-primary' : 'btn-light'}`;
                    btn.textContent = i;
                    btn.addEventListener('click', () => fetchMembers(i, searchInput.value));
                    paginationEl.appendChild(btn);
                }
            };

            const renderMembers = (membersToRender) => {
                membersGrid.innerHTML = '';
                if (membersToRender.length === 0) {
                    noResults.classList.remove('d-none');
                    return;
                }
                noResults.classList.add('d-none');

                membersToRender.forEach(member => {
                    // const subscriptionStatus = "6";
                    console.log(member)

                    const card = document.createElement('div');
                    card.className = 'col-md-3 col-lg-3';
                    card.innerHTML = `
                   <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                    <span class="avatar avatar-xl me-3" style="background-image: url('${member.image}')"></span>
                                <div class="flex-grow-1">
                                    <h3 class="card-title mb-1">${member.name}</h3>
                                    <div>
                                  <span class="badge ${member.subscription_status ? "bg-green-lt" : "bg-red-lt"}">
                                    ${member.subscription_status ? "Active" : "Inactive"}
                                  </span></div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <h4 class="subheader mb-2">Subscription details</h4>
                                <div class="mb-2"><span class="badge bg-yellow text-yellow-fg">${member.plan_name}</span></div>
                                <div class="d-flex align-items-center text-muted"><svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z"></path><path d="M16 3v4"></path><path d="M8 3v4"></path><path d="M4 11h16"></path><path d="M11 15h1"></path><path d="M12 15v3"></path></svg><span>Expiration: </span> 17-09-26</div>
                            </div>
                            <div>
                                <h4 class="subheader mb-2">Contact information</h4>
                                <div class="mb-1 d-flex align-items-center text-muted"><svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z"></path><path d="M3 7l9 6l9 -6"></path></svg><a href="mailto:${member.email}" class="text-reset">${member.email}</a></div>
                                <div class="d-flex align-items-center text-muted"><svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2"></path></svg><a href="tel:${member.phone}" class="text-reset">${member.phone}</a></div>
                            </div>

                                           <div class="mt-2">
                                <h4 class="subheader mb-2">guests information</h4>

                                <div class="mb-2"><span class="text-muted text-yellow">Total : ${member.plan?.guest_passes_per_year}</span></div>
                                <div class="mb-2"><span class="text-muted  text-yellow">Coming:  ${member.subscription_data?.coming_guest_passes ?? 0}</span></div>
                                <div class="mb-2"><span class="text-muted  text-yellow">Remaining: ${member.plan?.guest_passes_per_year-(member.subscription_data?.used_guests ?? 0)}</span></div>

                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="d-flex gap-3">
<p class="text-muted mb-0"> <span class="text-dark fw-bold"></span>

</p>
    <p class="text-muted mb-0"><span class="text-dark fw-bold">    </span>

</p>                            </div>
                                <button class="btn btn-ghost-secondary btn-sm view-history-btn" data-member-id="${member.id}" >
                                  <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path><path d="M12 7v5l3 3"></path></svg>
                                </button>
                            </div>
                            <form class="generate-form" data-member-id="${member.id}">
                                <label class="form-label">Generate QR</label>
                                <div class="input-group">
                                    <input type="number"  min="1" max="${member.subscription_data?.coming_guest_passes  ?? 0}" class="form-control visitor-count"       onkeydown="return false;"
  style="max-width: 70px;" required>
                                    <button type="submit" class="btn btn-primary generate-btn">
                                      <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.5A.75.75 0 014.5 3.75h4.5a.75.75 0 01.75.75v4.5a.75.75 0 01-.75.75h-4.5a.75.75 0 01-.75-.75v-4.5zM3.75 15A.75.75 0 014.5 14.25h4.5a.75.75 0 01.75.75v4.5a.75.75 0 01-.75.75h-4.5a.75.75 0 01-.75-.75v-4.5zM15 3.75A.75.75 0 0014.25 3h-4.5a.75.75 0 00-.75.75v4.5a.75.75 0 00.75.75h4.5a.75.75 0 00.75-.75v-4.5zM19.5 19.5h.008v.008h-.008v-.008zM16.5 15h.008v.008h-.008V15zM15 16.5h.008v.008H15v-.008zM16.5 18h.008v.008h-.008v-.008zM18 16.5h.008v.008H18v-.008zM19.5 15h.008v.008h-.008V15zM18 19.5h.008v.008H18v-.008zM19.5 18h.008v.008h-.008v-.008zM15 19.5h.008v.008H15v-.008z" />
                                      </svg>
                                      Generate
                                      <span class="spinner-border spinner-border-sm ms-2" role="status" aria-hidden="true" style="display:none;"></span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
            `;
                    membersGrid.appendChild(card);
                });

                document.querySelectorAll('.generate-form').forEach(form => {

                    const input = form.querySelector('.visitor-count');
                    const button = form.querySelector('.generate-btn');
                    const max = parseInt(input.getAttribute("max")) || 0;

                    if (max === 0) {
                        input.disabled = true;
                        button.disabled = true;
                        input.value = 0;
                    }
                    form.addEventListener('submit', (e) => {
                        e.preventDefault();

                        const memberId = form.dataset.memberId;
                        const count = form.querySelector('.visitor-count').value;
                        const btn = form.querySelector('.generate-btn');
                        const spinner = btn.querySelector('.spinner-border');

                        btn.disabled = true;
                        spinner.style.display = 'inline-block';

                        fetch(`/memberships/${memberId}/generate-qr`, {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                            body: JSON.stringify({ count })
                        })
                            .then(res => res.json())
                            .then(data => {
                                qrCodeContainer.innerHTML = '';

                                if (data.status === false) {
                                    qrCodeContainer.innerHTML = `
                                            <div class="alert alert-danger text-center" role="alert">
                                                ${data.message}
                                            </div>
                                        `;
                                    spinner.style.display = 'none';
                                    btn.disabled = false;
                                    qrCodeModal.show();
                                    return;
                                }
                                data.qr_codes.forEach(code => {
                                    const div = document.createElement('div');


                                    div.className = "col-md-4 text-center";
                                    // div.innerHTML = `<img src="${code}" class="img-fluid mb-2"/><p>${code}</p>`;
                                    div.innerHTML = `
                                            <div class="card">
                                              <div class="card-body text-center p-2">
                                                <img src="${code.qr}" alt="QR Code for visitor ${code.name}" class="img-fluid mb-2" />
                                                <div class="text-muted small">${code.name}</div>
                                              </div>
                                            </div>
                                         `;

                                    qrCodeContainer.appendChild(div);
                                });
                                spinner.style.display = 'none';
                                btn.disabled = false;


                                qrCodeModal.show();
                            })
                            .catch(err => {

                                spinner.style.display = 'none';
                                btn.disabled = false;
                            });
                    });    });
            };

            searchInput.addEventListener('input', () => {
                fetchMembers(1, searchInput.value);
            });

            fetchMembers();


        });

        function printModalContent() {
            const modalContent = document.getElementById('qrCodeModal').innerHTML;

            const printWindow = window.open('', '_blank', 'width=1200,height=800');

            printWindow.document.write(`
        <html>
        <head>
            <title> QR</title>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
            <style>
                body { padding: 20px; font-family: Arial, sans-serif; margin: 0; }
                .card { margin-bottom: 20px; }
                img { max-width: 100%; height: auto; }

                button, .btn { display: none !important; }

                .row { display: flex; flex-wrap: wrap; }


            </style>
        </head>
        <body>
            <div class="container-fluid">
                ${modalContent}
            </div>
        </body>
        </html>
    `);

            printWindow.document.close();
            printWindow.focus();
            printWindow.print();
        }

        document.addEventListener('click', async (e) => {
            const button = e.target.closest('.view-history-btn');
            if (!button) return;

            const memberId = button.dataset.memberId;
            const historyBody = document.getElementById('history-modal-body');
            const title = document.getElementById('historyModalTitle');

            title.textContent = ` History for Member #${memberId}`;

            historyBody.innerHTML = `<div class="text-center py-4">
                                <div class="spinner-border text-primary" role="status"></div>
                                <p class="mt-2 text-muted">Loading...</p>
                             </div>`;

            const historyModal = new bootstrap.Modal(document.getElementById('historyModal'));
            historyModal.show();

            try {
                const res = await fetch(`/memberships/${memberId}/history`);
                if (!res.ok) throw new Error("error");

                const data = await res.json();


                if (data.length === 0) {
                    historyBody.innerHTML = `<p class="text-center text-muted">No results found.</p>`;
                    return;
                }

                let historyHtml = '';
                data.forEach(item => {
                    const formattedDate = new Date(item.date);
                    historyHtml += `
                <div class="card card-sm mb-2">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <div class="fw-bold">${item.date}</div>
                                <div class="text-muted">Total Count: ${item.total_count} </div>
                                <div class="text-muted">Entered Count: ${item.entered_count} </div>
                            </div>
                            <div class="col-auto">
<!--
                                <button class="btn btn-secondary reprint-btn"
                                        data-date="${item.date}"
                                        data-member-id="${memberId}">
                                  Re Print
                                </button>
-->
                            </div>
                        </div>
                    </div>
                </div>
            `;
                });

                historyBody.innerHTML = historyHtml;

            } catch (err) {
                historyBody.innerHTML = `<p class="text-danger text-center">Error in data.</p>`;
                console.error(err);
            }
        });
            document.getElementById('history-modal-body').addEventListener('click', e => {
                if(e.target.classList.contains('reprint-btn')) {
                    const memberId = e.target.dataset.memberId;
                    const dateKey = e.target.dataset.date;
                    const member = mockMembers.find(m => m.id === memberId);

                    const passesToReprint = member.history.filter(p => formatDate(p.generatedAt) === dateKey);
                    const qrUrls = passesToReprint.map(p => p.qrUrl);

                    historyModal.hide();
                    displayQRCodes(qrUrls, member.name);
                }
            });




    </script>

    @endsection

