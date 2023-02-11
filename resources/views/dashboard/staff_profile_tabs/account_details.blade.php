<form id="account_details_form" method="POST">

    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" name="email" id="email"
               placeholder="eg. joserizal13@gmail.com" value="{{ $user->email }}"/>
    </div>

    <div class="form-group">
        <label for="user_name">Username</label>
        <input type="text" class="form-control" name="user_name" id="user_name"
               placeholder="eg. joserizal" value="{{ $user->user_name }}"/>
        <a href="#!" data-toggle="modal" data-target="#changePasswordModal" class="text-info">
            <small>Click here to change your password</small>
        </a>
    </div>

    <hr/>
    <button class="btn btn-sm btn-secondary text-white px-3 py-1" type="submit">Save Changes</button>

</form>
