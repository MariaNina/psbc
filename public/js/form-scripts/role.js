$(document).ready(function () {
    let id; //define a global variable id for edit
    const page_route = "roles";
    const opt = {
        errorElement: "div",
        rules: {
            roleName: {
                required: true,
                minlength: 3,
                maxlength: 20
            },
        },
        messages: {
            roleName: {
                required: "Role name is required",
            },
        },
        highlight: function (element) {
            $(element).addClass("is-invalid");
        },
        unhighlight: function (element) {
            $(element).removeClass("is-invalid");
        },
    };

    $("#roleError").hide();
    $("#roleError2").hide();
    $("#addRoleForm").validate(opt); // Validate
    $("#editRoleForm").validate(opt); // Validate

    // Check validation if submit
    $("#addRoleForm").submit(function (e) {
        e.preventDefault();

        $("#addRoleForm").validate(opt);

        if (!$("#addRoleForm").valid()) {
            return false;
        }
        // Do something here if validation is passed.
        createData();
    });

     // get data by id from role edit
     $('body').on('click', '.editData', function(e) {
        // e.preventDefault();
        id = $(this).data('id');
        // console.log(id)
        $.ajax({
            url: page_route+"/"+id+"/edit",
            type: "GET",
            success: function(result) {
                console.log(result);
                // display data to updateschoolyearform
                $('#editRoleModal').modal('show');
                for (var i = 0; i < result.length; i++) {
                    $('#editRole').val(result[i].role_name);
                }
            }
        });
    });

    // submit updates and save to database
    $('#editRoleForm').submit(function(e) {
        e.preventDefault();

        $("#editRoleForm").validate(opt);

        if (!$("#editRoleForm").valid()) {
            return false;
        }
        //if data is valid call function to run
        updateData()
    });

    function createData() {
        // Do something here if validation is passed.
        let form_array = $("#addRoleForm").serialize();

        $.post("",form_array,function(resp){
            //alertSuccess('Created') //calls function alertSuccess in public\js\main.js
        })
          .done(function() {
                alertSuccess('Created') //calls function alertSuccess in public\js\main.js
                $("#addRoleForm")[0].reset();
                $('#addRoleModal').modal('hide');
                $("#roleError").hide();

          })
          .fail(function(response) {
                $("#roleError").show();
                $('#errorMessage').html(""); //clear html elements
                //check the error tresponse
                let errorText = response.responseJSON.errors;
                for (var key in errorText) {
                        $('#errorMessage').append(errorText[key]+"<br />");
                }
                alertFailed('Create')
          })
    }

    function updateData() {
          // Do something here if validation is passed.
        let form_data = $("#editRoleForm").serialize();

        $.ajax({
            url: page_route+"/"+id,
            type: 'PUT',
            data: form_data
        })
        .done(function() {
            alertSuccess('Updated') //calls function alertSuccess in public\js\main.js
            $("#editRoleForm")[0].reset();
            $('#editRoleModal').modal('hide');
            $("#roleError2").hide();
        })
        .fail(function(response) {
            $("#roleError2").show();
                $('#errorMessage2').html(""); //clear html elements
                //check the error tresponse
                let errorText = response.responseJSON.errors;
                for (var key in errorText) {
                        $('#errorMessage2').append(errorText[key]+"<br />");
                }
            alertFailed('Update')
        })

    }

    $('body').on('click', '.deactivate', function(e) {
        Swal.fire({
            title: "Are you sure?",
            text: "Are you sure you want to deactivate this item?",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes",
        }).then((result) => {
            if (result.isConfirmed) {
                id = $(this).data('id');
                let _token  = $('meta[name="csrf-token"]').attr('content');
                // console.log(id)
                $.ajax({
                    url: page_route+"/"+id,
                    type: "DELETE",
                    data: {
                        is_active: 0,
                        _token: _token,
                    }
                })
                .done(function() {
                    alertSuccess('Deactivated') //calls function alertSuccess in public\js\main.js
                })
                .fail(function() {
                    alertFailed('Deactivate')
                })
            }
        });
    });

    $('body').on('click', '.activate', function(e) {
        Swal.fire({
            title: "Are you sure?",
            text: "Are you sure you want to activate this item?",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes",
        }).then((result) => {
            if (result.isConfirmed) {
                id = $(this).data('id');
                let _token  = $('meta[name="csrf-token"]').attr('content');
                // console.log(id)
                $.ajax({
                    url: page_route+"/"+id,
                    type: "DELETE",
                    data: {
                        is_active: 1,
                        _token: _token,
                    }
                })
                .done(function() {
                    alertSuccess('Activated') //calls function alertSuccess in public\js\main.js
                })
                .fail(function() {
                    alertFailed('Activate')
                })
            }
        });
    });

});
