@extends('ui.app')

@section('content')
<section>
    <div class="container">
        <div class="row justify-content-center min-vh-50 py-5  m align-content-center align-items-center">
            <div class="col-lg-6">
                <div>
                    <img src="{{ asset('img/maintenance.svg') }}" class="img-fluid" alt="under-maintenance">
                    <p class="lead text-center text-dark font-weight-bold">Under Maintenance</p>
                    <div class="d-flex justify-content-center">
                        <div class="w-75">
                            <p class="text-muted text-center">
                                The page you're looking for is currently
                                under maintenance and will be back soon.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
