@extends('people.main')

@section('content')

<form action="/ajaxPost" enctype="multipart/form-data" id="ajaxForm">

    @csrf

    <h1>Add person</h1>

    <div>
        <label for="image">Image</label>
        <input type="file" name="image" id="image" required/>
    </div>

    <br>


    <div>
        <label for="name">Name</label>
        <input type="text" name="name" id="name" required/>
    </div>

    <br>

    <div>
        <div>Description</div>
        <textarea name="description" id="description" cols="30" rows="10" required></textarea>
    </div>

    <br>

    <div>
        <label for="date">date</label>
        <input type="date" name="date" id="date" required/>
    </div>

    <br>

    <button id="btnsubmit" type="submit">Submit</button>


</form>

<br><br><br><br>

<a href="/people" class="cust-btn">Back</a>

@endsection


