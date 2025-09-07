@extends("layouts.app")

@section("content")


<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <!-- Page pre-title -->
        <div class="page-pretitle">plans</div>
        <h2 class="page-title"></h2>
      </div>
      <!-- Page title actions -->
      <div class="col-auto ms-auto d-print-none">
        <div class="btn-list">
          <span class="d-none d-sm-inline">
            <a href="{{route('plans.index')}}" class="btn btn-1"> Back </a>
          </span>
                    <a href="{{route('plans.create')}}" class="btn btn-primary btn-5 d-none d-sm-inline-block">
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
            Add plan
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

    <div class="row row-cards">

      @foreach ($plans as $plan )

      <div class="col-sm-6 col-lg-3">


        <div class="card card-md">
          @if($plan->is_popular)
          <div class="ribbon ribbon-top ribbon-bookmark bg-green">

            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-3">
              <path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z"></path>
            </svg>

          </div>
          @endif
          <div class="card-body text-center">
            <div class="text-uppercase text-secondary font-weight-medium">{{$plan->name["en"]}}</div>
            <div class="display-5 fw-bold my-3">{{$plan->price}}</div>
            <ul class="list-unstyled lh-lg">
              <li><strong>{{$plan->guest_passes_per_year}}</strong> Users</li>




              @foreach ($plan->features["en"] as $feature)
              <li>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                  fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                  stroke-linejoin="round" class="icon me-1 text-success icon-2">
                  <path d="M5 12l5 5l10 -10"></path>
                </svg>

                {{ $feature }}
              </li>
              @endforeach

            </ul>
<div class="text-center mt-4 d-flex gap-2 justify-content-center">
              <a href="{{route('plans.edit',$plan)}}" class="btn btn-green w-100">Edit plan</a>
                <form class="delete-form" action="{{ route('plans.destroy', $plan) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger delete-btn">Delete Plan</button>
    </form>
            </div>
          </div>
        </div>
      </div>
      @endforeach


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
