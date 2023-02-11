$(document).ready(function () {
    let id; //define a global variable id for edit
    const page_route = "parents";
    const opt = {
        errorElement: "div",
        rules: {
            first_name: {
                required: true,
                minlength: 3,
                maxlength: 20
            },
            last_name: {
                required: true,
                minlength: 3,
                maxlength: 20
            },
            middle_name: {
                required: true,
                minlength: 3,
                maxlength: 20
            },
            address: {
                required: true,
                minlength: 3,
                maxlength: 50
            },
            contact_number: {
                required: true,
                number: true,
                minlength: 6,
                maxlength: 20
            },
        },
        messages: {
            first_name: {
                required: "First Name is Required"
            },
            last_name: {
                required: "Last Name is Required"
            },
            middle_name: {
                required: "Middle Name is Required"
            },
            address: {
                required: "Address is Required"
            },
            contact_number: {
                required: "Contact Number is Required"
            },
        },
        highlight: function (element) {
            $(element).addClass("is-invalid");
        },
        unhighlight: function (element) {
            $(element).removeClass("is-invalid");
        },
    };

    $("#updateForm").validate(opt); // Validate

     // get data by id from role edit
     $('body').on('click', '.editData', function(e) {
        // e.preventDefault();
        id = $(this).data('id');
        // console.log(id)
        $.ajax({
            url: page_route+"/"+id+"/edit",
            type: "GET",
            success: function(result) {
                $('#first_name').val(result.first_name);
                $('#last_name').val(result.last_name);
                $('#middle_name').val(result.middle_name);
                $('#address').val(result.address);
                $('#contact_number').val(result.contact_number);
                $('#editParentModal').modal('show');
              
            }
        });
    });

    // submit updates and save to database
    $('#updateForm').submit(function(e) {
        e.preventDefault();

        $("#updateForm").validate(opt);

        if (!$("#updateForm").valid()) {
            return false;
        }
        //if data is valid call function to run
        updateData()
    });

    function updateData() {
          // Do something here if validation is passed.
        let form_data = $("#updateForm").serialize();

        $.ajax({
            url: page_route+"/"+id,
            type: 'PUT',
            data: form_data
        })
        .done(function() {
            alertSuccess('Updated') //calls function alertSuccess in public\js\main.js
            $("#updateForm")[0].reset();
            $('#editParentModal').modal('hide');
        })
        .fail(function(response) {
          
        })

    }

});
