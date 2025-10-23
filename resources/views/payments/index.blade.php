@extends("layouts.app")

@section("content")

      <div class="page-header d-print-none">
          <div class="container-xl">
            <div class="row g-2 align-items-center">
              <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">Payments</div>
                <h2 class="page-title"></h2>
              </div>
              <!-- Page title actions -->
              <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                  <span class="d-none d-sm-inline">
                    <!-- <a href="#" class="btn btn-1"> New  </a> -->
                  </span>
                    <!--

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

          <div class="row row-deck row-cards">
            <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Payments</h3>
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
                                  <th>Order ID</th>
                                  <th>User</th>
                                  <th>Phone</th>
                                  <th>Plan</th>
                                  <th>Amount</th>
                                  <th>Payment Method</th>
                                  <th>Status</th>
                                  <th>Paid At</th>
                                  <th>Action</th>
                              </tr>
                              </thead>

                              <tbody>




                              </tbody>
                          </table>
                      </div>

                  </div>

                </div>
              </div>
          </div>
          </div>
        </div>

        @include("payments._modal")

        @endsection

        @push("js")
        @include("payments._datatable")
        <script>
            $(document).on('click', '.view-payment', function () {
                const button = $(this);
                const spinner = button.find('.spinner-border');
                const paymentId = button.data('id');
                const modal = $('#paymentModal');

                spinner.show();
                button.prop('disabled', true);

                $.ajax({
                    url: `/payments/${paymentId}`,
                    type: 'GET',
                    success: function (response) {
                        if (response.success) {
                            const payment = response.data;

                            modal.find('#order_id').text(payment.order_id || '—');
                            modal.find('#status')
                                .text(payment.status || '—')
                                .removeClass()
                                .addClass('fw-bold ' + (payment.status === 'success'
                                    ? 'text-success'
                                    : payment.status === 'failed'
                                        ? 'text-danger'
                                        : 'text-warning'));
                            modal.find('#billing_name').text(payment.billing_name || '—');
                            modal.find('#billing_email').text(payment.billing_email || '—');
                            modal.find('#billing_phone').text(payment.billing_phone || '—');
                            modal.find('#billing_address').text(payment.billing_address || '—');
                            modal.find('#amount').text(payment.amount || '—');
                            modal.find('#currency').text(payment.currency || '—');
                            modal.find('#payment_method').text(payment.payment_method || '—');
                            modal.find('#transaction_id').text(payment.transaction_id || '—');
                            modal.find('#paid-at').text(payment.paid_at || '—');

                            modal.modal('show');
                        }
                    },
                    error: function () {
                        alert('Error loading payment details.');
                    },
                    complete: function () {
                        spinner.hide();
                        button.prop('disabled', false);
                    }
                });
            });

        </script>

        @endpush
