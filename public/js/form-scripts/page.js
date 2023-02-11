$(document).ready(function () {
    let id; //define a global variable id for edit
    const page_route = "pages";
    const opt = {
        errorElement: "div",
        rules: {
            pageName: {
                required: true,
                minlength: 3,
                maxlength: 20
            },
        },
        messages: {
            pageName: {
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

    $("#pageError").hide();
    $("#pageError2").hide();
    $("#addPageForm").validate(opt); // Validate
    $("#editPageForm").validate(opt); // Validate

    // Check validation if submit
    $("#addPageForm").submit(function (e) {
        e.preventDefault();

        $("#addPageForm").validate(opt);

        if (!$("#addPageForm").valid()) {
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
                $('#editPageModal').modal('show');
                for (var i = 0; i < result.length; i++) {
                    $('#editPageName').val(result[i].page_name);
                }
            }
        });
    });

    // submit updates and save to database
    $('#editPageForm').submit(function(e) {
        e.preventDefault();

        $("#editPageForm").validate(opt);

        if (!$("#editPageForm").valid()) {
            return false;
        }
        //if data is valid call function to run
        updateData()
    });

    function createData() {
        // Do something here if validation is passed.
        let form_array = $("#addPageForm").serialize();

        $.post("",form_array,function(resp){
            //alertSuccess('Created') //calls function alertSuccess in public\js\main.js
        })
          .done(function() {
                alertSuccess('Created') //calls function alertSuccess in public\js\main.js
                $("#addPageForm")[0].reset();
                $('#addPageModal').modal('hide');
                $("#pageError").hide();

          })
          .fail(function(response) {
                $("#pageError").show();
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
        let form_data = $("#editPageForm").serialize();

        $.ajax({
            url: page_route+"/"+id,
            type: 'PUT',
            data: form_data
        })
        .done(function() {
            alertSuccess('Updated') //calls function alertSuccess in public\js\main.js
            $("#editPageForm")[0].reset();
            $('#editPageModal').modal('hide');
            $("#pageError2").hide();
        })
        .fail(function(response) {
            $("#pageError2").show();
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
