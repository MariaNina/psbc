$(document).ready(function () {
    let id; //define a global variable id for edit
    const page_route = "programs";
    const opt = {
        errorElement: "div",
        rules: {
            program_name: {
                required: true,
                minlength: 10,
                maxlength: 100
            },
            program_code: {
                required: true,
                minlength: 3,
                maxlength: 10
            },
            program_desc: {
                required: false,
                maxlength: 100
            }
        },
        messages: {
            program_name: {
                required: "Program name is required",
            },
            program_code: {
                required: "Program code is required",
            },
        },
        highlight: function (element) {
            $(element).addClass("is-invalid");
        },
        unhighlight: function (element) {
            $(element).removeClass("is-invalid");
        },
    };


    $("#programError").hide();
    $("#programError2").hide();
    $("#ProgramForm").validate(opt); // Validate
    $("#updateProgramForm").validate(opt); // Validate

    // Check validation if submit
    $("#ProgramForm").submit(function (e) {
        e.preventDefault();

        $("#ProgramForm").validate(opt);

        if (!$("#ProgramForm").valid()) {
            return false;
        }
        // Do something here if validation is passed.
        createData()
    });

     // get data by id from schoolyear edit
     $('body').on('click', '.editData', function(e) {
        // e.preventDefault();
        id = $(this).data('id');
        // console.log(id)
        $.ajax({
            url: page_route+"/"+id+"/edit",
            type: "GET",
            success: function(result) {
                // display data to updateschoolyearform
                $('#updateProgramsModal').modal('show');
                for (var i = 0; i < result.length; i++) {
                    $('#upd_program_code').val(result[i].program_code);
                    $('#upd_program_name').val(result[i].program_name);
                    $('#upd_program_desc').val(result[i].program_description);
                }
            }
        });
    });

    // submit updates and save to database
    $('#updateProgramForm').submit(function(e) {
        e.preventDefault();

        $("#updateProgramForm").validate(opt);

        if (!$("#updateProgramForm").valid()) {
            return false;
        }
        //if data is valid call function to run
        updateData()
    });

    function createData() {
        // Do something here if validation is passed.
        let form_array = $("#ProgramForm").serialize();

        $.post("",form_array,function(resp){
            alertSuccess('Created') //calls function alertSuccess in public\js\main.js
        })
          .done(function() {
                alertSuccess('Created') //calls function alertSuccess in public\js\main.js
                $("#ProgramForm")[0].reset();
                $("#programError").hide();
                $('#addProgramsModal').modal('hide');
          })
          .fail(function(response) {
            $("#programError").show();
            $('#errorMessage').html(""); //clear html elements
            //check the error tresponse
            let errorText = response.responseJSON.errors;
            for (var key in errorText) {
                    $('#errorMessage').append(errorText[key]+"<br />");
            }
            console.log(response);
                alertFailed('Create')
          })
    }

    function updateData() {
          // Do something here if validation is passed.
        let form_data = $("#updateProgramForm").serialize();

        $.ajax({
            url: page_route+"/"+id,
            type: 'PUT',
            data: form_data
        })
        .done(function() {
            alertSuccess('Updated') //calls function alertSuccess in public\js\main.js
            $("#updateProgramForm")[0].reset();
            $('#updateProgramsModal').modal('hide');
            $("#programError2").hide();
        })
        .fail(function(response) {
            $("#programError2").show();
            $('#errorMessage2').html(""); //clear html elements
            //check the error tresponse
            let errorText = response.responseJSON.errors;
            for (var key in errorText) {
                    $('#errorMessage2').append(errorText[key]+"<br />");
            }
            $('#errorMessage2').append("Wrong Entry");
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
