@extends('dashboard.layouts.main')

@section('title')
    {{ $title }}
@endsection

@section('extra-css')
<link
  href="https://cdn.jsdelivr.net/npm/smartwizard@5/dist/css/smart_wizard_all.min.css"
  rel="stylesheet"
  type="text/css"
/>
@endsection

@section('content')
<!-- Content Row -->

<div class="row">

  <div class="col-lg-12">
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <div class="d-lg-flex align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-dark">
            <a class="d-none d-sm-inline-block btn btn-sm btn-light shadow-sm"  href="{{redirect()->back()->getTargetUrl()}}">
              <i class="fas fa-arrow-left font-lg fa-lg text-dark-50"></i>
            </a>
            Scheduler
          </h6>
        </div>
      </div>
      <div class="card-body">
        <div class="mb-4">
          <h3>{{$branches->branch_name}} Rooms</h3>
          <ul class="nav nav-tabs">
            @foreach ($rooms as $room)
              <li class="nav-item">
                  <a class="nav-link" id="{{$room->room_no}}"  href="#room{{$room->room_no}}">{{$room->room_no}}</a>
              </li>
              @endforeach
          </ul>
        </div>
          <div class="tab-content">
            @foreach ($rooms as $room)
            <div id="room{{$room->room_no}}" class="tab-pane  fade">
              <h3>Room {{$room->room_no}}</h3>
                  @include('dashboard.schedule_tab.editor')
            </div>
            @endforeach
        </div>
      </div>
      </div>
    </div>
  </div>

   @include('dashboard.modals.schedule')

@endsection

@section('extra-js')

<script type="text/javascript" src="{{ asset('js/datatable-scripts/schedule.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/form-scripts/schedule.js') }}"></script>

@endsection
