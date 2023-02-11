$(document).ready(function () {
    let id; //define a global variable id for edit
    const page_route = "majors";
    const opt = {
        errorElement: "div",
        rules: {
            majorCode: {
                required: true,
                minlength: 3,
                maxlength: 10
            },
            majorName: {
                required: true,
                minlength: 5,
                maxlength: 100
            },
            majorDesc: {
                required: false,
                maxlength: 100
            }
        },
        messages: {
            majorCode: {
                required: "Major code is required",
            },
            majorName: {
                required: "Major name is required",
            },
        },
        highlight: function (element) {
            $(element).addClass("is-invalid");
        },
        unhighlight: function (element) {
            $(element).removeClass("is-invalid");
        },
    };

    $("#majorError").hide();
    $("#majorError2").hide();
    $("#MajorForm").validate(opt); // Validate
    $("#updateMajorForm").validate(opt); // Validate

    // Check validation if submit
    $("#MajorForm").submit(function (e) {
        e.preventDefault();

        $("#MajorForm").validate(opt);

        if (!$("#MajorForm").valid()) {
            return false;
        }
        // Do something here if validation is passed.
        createData();
    });

     // get data by id from majors edit
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
                $('#updateMajorModal').modal('show');
                for (var i = 0; i < result.length; i++) {
                    $('#updateMajorCode').val(result[i].major_code);
                    $('#updateMajorName').val(result[i].major_name);
                    $('#updateMajorDesc').val(result[i].major_description);
                }
            }
        });
    });

    // submit updates and save to database
    $('#updateMajorForm').submit(function(e) {
        e.preventDefault();

        $("#updateMajorForm").validate(opt);

        if (!$("#updateMajorForm").valid()) {
            return false;
        }
        //if data is valid call function to run
        updateData()
    });

    function createData() {
        // Do something here if validation is passed.
        let form_array = $("#MajorForm").serialize();

        $.post("",form_array,function(resp){
            //alertSuccess('Created') //calls function alertSuccess in public\js\main.js
        })
          .done(function() {
                alertSuccess('Created') //calls function alertSuccess in public\js\main.js
                $("#MajorForm")[0].reset();
                $('#addMajorModal').modal('hide');
                $("#majorError").hide();

          })
          .fail(function(response) {
                $("#majorError").show();
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
        let form_data = $("#updateMajorForm").serialize();

        $.ajax({
            url: page_route+"/"+id,
            type: 'PUT',
            data: form_data
        })
        .done(function() {
            alertSuccess('Updated') //calls function alertSuccess in public\js\main.js
            $("#updateMajorForm")[0].reset();
            $('#updateMajorModal').modal('hide');
            $("#majorError2").hide();
        })
        .fail(function(response) {
            $("#majorError2").show();
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
