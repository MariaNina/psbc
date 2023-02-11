$(document).ready(function () {
    let id; //define a global variable id for edit
    const page_route = "school_years";
    const opt = {
        errorElement: "div",
        rules: {
            sy: "required",
        },
        messages: {
            sy: {
                required: "School year must not be empty",
            },
        },
        highlight: function (element) {
            $(element).addClass("is-invalid");
        },
        unhighlight: function (element) {
            $(element).removeClass("is-invalid");
        },
    };

    $("#schoolYearForm").validate(opt); // Validate
    $("#updateSchoolYearForm").validate(opt); // Validate

   // Check validation if submit then add school year
    $("#schoolYearForm").submit(function(e){  //use .submit to read html validation
        e.preventDefault();
    
        $("#schoolYearForm").validate(opt);
            if (!$("#schoolYearForm").valid()) {
                return false;
            }
        //if data is valid call function to run
        storeData()
    });
    // end of adding school year

    // get data by id from schoolyear edit
    $('body').on('click', '.editData', function(e) {
        // e.preventDefault();
        id = $(this).data('id');
        // console.log(id)
        $.ajax({
            url:"school_years/"+id+"/edit",
            type: "GET",
            success: function(result) {
                // display data to updateschoolyearform
                $('#editYearModal').modal('show');
                for (var i = 0; i < result.length; i++) {
                    $('#updateSy').val(result[i].school_years);
                }
            }
        });
    });

    // submit updates and save to database
    $('#updateSchoolYearForm').submit(function(e) {
        e.preventDefault();

        $("#updateSchoolYearForm").validate(opt);

        if (!$("#updateSchoolYearForm").valid()) {
            return false;
        }
        //if data is valid call function to run
        updateData()
    });
      
    function storeData() {
        $("#btnCreate").attr('disabled',true);
        $("#btnCreate").html('Creating...')
        // Do something here if validation is passed.
        let form_array = $("#schoolYearForm").serialize(); 

        $.post("",form_array)
        .done(function(res) {
          
            if( res.status == 'success' ){
              $(".errorAlert").html('');
              $(".errorAlert").attr('hidden', true);
              $("#schoolYearForm")[0].reset();
              $('#addYearModal').modal('hide');
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

    function updateData() {

        $("#btnUpdate").attr('disabled',true);
        $("#btnUpdate").html('Updating')
          // Do something here if validation is passed.
        let form_data = $("#updateSchoolYearForm").serialize(); 

        $.ajax({
            url: page_route+"/"+id,
            type: 'PUT',
            data: form_data
        })
        .done(function(res) {
            
            if( res.status == 'success' ){
            $(".errorAlert").html('');
            $(".errorAlert").attr('hidden', true);
            $("#updateSchoolYearForm")[0].reset();
            $('#editYearModal').modal('hide');
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
