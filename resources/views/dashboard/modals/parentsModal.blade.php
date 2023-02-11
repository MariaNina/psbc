<!-- Update Modal-->
<div
    class="modal fade"
    id="editParentModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Update Parent
                </h5>
                <button
                    class="close"
                    type="button"
                    data-dismiss="modal"
                    aria-label="Close"
                >
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="updateForm" role="form"  data-toggle="validator">
                    @csrf
                    <div class="form-group">
                      <label for="first_name">First Name</label>
                      <input type="text" required name="first_name" id="first_name" class="form-control"  placeholder="eg. super admin,admin,teacher">
                    </div>
                    <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" required name="last_name" id="last_name" class="form-control"  placeholder="eg. super admin,admin,teacher">
                      </div>
                      <div class="form-group">
                        <label for="middle_name">Middle Name</label>
                        <input type="text" required name="middle_name" id="middle_name" class="form-control"  placeholder="eg. super admin,admin,teacher">
                      </div>
                      <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" required name="address" id="address" class="form-control"  placeholder="eg. super admin,admin,teacher">
                      </div>
                      <div class="form-group">
                        <label for="contact_number">Contact Number</label>
                        <input type="number" required name="contact_number" id="contact_number" class="form-control"  placeholder="enter contact number" onkeypress="return isNumber(event)">
                      </div>
                
                    <button id="btn" type="submit" class="btn btn-success float-right">Update</button>
                </form>
            
            </div>
        </div>
    </div>
</div>
