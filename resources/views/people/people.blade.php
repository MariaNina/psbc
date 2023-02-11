@extends('people.main')

@section('content')
{{--Show People--}}
<br /><br /><br />

<a href="/people/create" class="cust-btn">ADD PERSON</a>

<br /><br /><br />

<table id="customers">
    <thead>
    <tr>
        <th>Name</th>
        <th>Description</th>
        <th>Status</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($people as $person)
        <tr>
            <td>{{$person->name}}</td>
            <td>{{$person->description}}</td>
            <td>{{$person->status}}</td>
        </tr>
    @endforeach
    </tbody>

</table>
@endsection

@section('extra-js')
    {{-- AJAX Request --}}
    <script src="{{ asset('js/ajax.js') }}"></script>
@endsection


