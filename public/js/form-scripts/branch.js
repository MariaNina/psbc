$(document).ready(function () {

    let id; //define a global variable id for edit

    const opt = {
        errorElement: "div",
        rules: {
            branch_name: {
                required: true,
                minlength: 3,
                maxlength: 10
            },
            branch_address: {
                required: true,
                minlength: 5,
                maxlength: 100
            },
            branch_desc: {
                required: true,
                maxlength: 100
            },
            branch_email: {
                required: true,
                email: true,
                maxlength: 30
            },
            branch_tel: { // Telephone
                required: true,
                maxlength: 30
            },
            branch_contact: { // Mobile
                required: true,
                number: true,
                minlength: 7,
                maxlength: 11
            },
        },
        messages: {
            branch_name: {
                required: "Branch name is required",
            },
            branch_address: {
                required: "Branch address is required",
            },
            branch_desc: {
                required: "Branch description code is required",
            },
            branch_email: {
                required: "Email address is required",
            },
            branch_tel: {
                required: "Telephone number is required",
            },
            branch_contact: {
                required: "Mobile number is required",
            },
        },
        highlight: function (element) {
            $(element).addClass("is-invalid");
        },
        unhighlight: function (element) {
            $(element).removeClass("is-invalid");
        },
    };

    $("#BranchForm").validate(opt); // Validate
    $("#updateBranchForm").validate(opt); // Validate

    // Check validation if submit
    $("#BranchForm").submit(function (e) {
        e.preventDefault();
        $("#BranchForm").validate(opt);

        if (!$("#BranchForm").valid()) {
            return false;
        }
        // Do something here if validation is passed.
        storeData();
    });

    function storeData() {

        $("#btnCreate").attr('disabled',true);
        $("#btnCreate").html('Creating...')
        // Do something here if validation is passed.
        let form_array = $("#BranchForm").serializeArray(); 

        $.post("",form_array)
          .done(function(res) {
          
              if( res.status == 'success' ){
                $(".errorAlert").html('');
                $(".errorAlert").attr('hidden', true);
                $("#BranchForm")[0].reset();
                $('#addBranchModal').modal('hide');
                alertSuccess('Created') //calls function alertSuccess in public\js\main.js

              }else{

                $(".errorAlert").html(res.message);
                $(".errorAlert").attr('hidden', false);
              }


                $("#btnCreate").attr('disabled',false);
                $("#btnCreate").html('Create')
               
          })
          .fail(function(response) {
            $("#btnCreate").attr('disabled',false);
            $("#btnCreate").html('Create')
            
            $(".errorAlert").attr('hidden', false);
            $('.errorAlert').html(""); //clear html elements
            //check the error tresponse
            let errorText = response.responseJSON.errors;
            for (var key in errorText) {
                console.log(errorText[key]+"<br />");
                    $('.errorAlert').append(errorText[key]+"<br />");
            }
                
                alertFailed('Create')
          })
    }

    // get data by id from schoolyear edit
    $('body').on('click', '.editData', function (e) {
        // e.preventDefault();
        id = $(this).data('id');
        // console.log(id)
        $.ajax({
            url: "branches/" + id + "/edit",
            type: "GET",
            success: function (result) {
                // display data to updateBranchForm
                $('#updateBranchModal').modal('show');
                for (var i = 0; i < result.length; i++) {
                    $('#upd_branch_name').val(result[i].branch_name);
                    $('#upd_branch_address').val(result[i].branch_address);
                    $('#upd_branch_desc').val(result[i].description);
                    $('#upd_branch_email').val(result[i].email);
                    $('#upd_branch_contact').val(result[i].mobile_no);
                    $('#upd_branch_tel').val(result[i].telephone_no);
                }
            }
        });
    });
    // submit updates and save to database
    $('#updateBranchForm').submit(function (e) {
        e.preventDefault();

        $("#updateBranchForm").validate(opt);

        if (!$("#updateBranchForm").valid()) {
            return false;
        }
        updateData();
    });

    function updateData() {

        $("#btnUpdate").attr('disabled',true);
        $("#btnUpdate").html('Updating')
        // Do something here if validation is passed.
        let form_data = $("#updateBranchForm").serialize(); 
    
        $.ajax({
            url: "branches/"+id,
            type: 'PUT',
            data: form_data
        })
        .done(function(res) {
            
            if( res.status == 'success' ){
            $(".errorAlert").html('');
            $(".errorAlert").attr('hidden', true);
            $("#updateBranchForm")[0].reset();
            $('#updateBranchModal').modal('hide');
            alertSuccess('Updated') //calls function alertSuccess in public\js\main.js

            }else{

            $(".errorAlert").html(res.message);
            $(".errorAlert").attr('hidden', false);
            }


            $("#btnUpdate").attr('disabled',false);
            $("#btnUpdate").html('Update')
            
        })
        .fail(function(response) {
            $("#btnUpdate").attr('disabled',false);
            $("#btnUpdate").html('Update');

            $(".errorAlert").attr('hidden', false);
            $('.errorAlert').html(""); //clear html elements
            //check the error tresponse
            let errorText = response.responseJSON.errors;
            for (var key in errorText) {
                console.log(errorText[key]+"<br />");
                    $('.errorAlert').append(errorText[key]+"<br />");
            }
            
            alertFailed('Update')
        })
          
    }

});
