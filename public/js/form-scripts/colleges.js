$(function(){

    let id; //define a global variable id for edit
    const page_route = 'colleges'; //define web route
    const opt = {
        errorElement: "div",
        rules: {
            college_code: {
                required: true,
                minlength: 3,
                maxlength: 10
            },
            college_name: {
                required: true,
                minlength: 10,
                maxlength: 100
            },
            college_desc: {
                required: false,
                maxlength: 100
            }
        },
        messages: {
            college_code: {
                required: "College code is required",
            },
            college_name: {
                required: "College name is required",
            },
        },
        highlight: function (element) {
            $(element).addClass("is-invalid");
        },
        unhighlight: function (element) {
            $(element).removeClass("is-invalid");
        },
    };

    $("#collegeError").hide();
    $("#addCollegesForm").validate(opt); // Validate
    $("#updateCollegesForm").validate(opt); // Validate

        // add curriculum
        $("#addCollegesForm").submit(function(e){  //use .submit to read html validation
            e.preventDefault();
            $("#addCollegesForm").validate(opt);

            if (!$("#addCollegesForm").valid()) {
                return false;
            }
            storeData();
        });

        function storeData() {

            $(".errorAlert").html('');
            $(".errorAlert").attr('hidden', true);
            $("#btnCreate").attr('disabled',true);
            $("#btnCreate").html('Creating...')
            // Do something here if validation is passed.
            let form_array = $("#addCollegesForm").serializeArray(); 

            $.post("",form_array)
              .done(function(res) {
              
                  if( res.status == 'success' ){
                    $(".errorAlert").html('');
                    $(".errorAlert").attr('hidden', true);
                    $("#addCollegesForm")[0].reset();
                    $('#addCollegeModal').modal('hide');
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
     $('body').on('click', '.editData', function(e) {
        // e.preventDefault();
        id = $(this).data('id');
        // console.log(id)
        $.ajax({
            url: page_route+"/"+id+"/edit",
            type: "GET",
            success: function(result) {
                // display data to updateBranchForm
                $('#updateCollegeModal').modal('show');
                for (var i = 0; i < result.length; i++) {
                    $('#upd_college_code').val(result[i].college_code);
                    $('#upd_college_name').val(result[i].college_name);
                    $('#upd_college_desc').val(result[i].college_description);
                }
            }
        });
    });
    // submit updates and save to database
    $('#updateCollegesForm').submit(function(e) {
        e.preventDefault();

        $("#collegeError2").hide();
        $("#updateCollegesForm").validate(opt);

        if (!$("#updateCollegesForm").valid()) {
            return false;
        }
        updateData();

    });
    function updateData() {

        $(".errorAlert").html('');
        $(".errorAlert").attr('hidden', true);
        $("#btnUpdate").attr('disabled',true);
        $("#btnUpdate").html('Updating')
        // Do something here if validation is passed.
        let form_data = $("#updateCollegesForm").serializeArray(); 
        $.ajax({
            url: page_route+"/"+id,
            type: 'PUT',
            data: form_data
        })
        .done(function(res) {
            
            if( res.status == 'success' ){
                $(".errorAlert").html('');
                $(".errorAlert").attr('hidden', true);
                $("#updateCollegesForm")[0].reset();
                $('#updateCollegeModal').modal('hide');
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
                    },
                    success: function(data){
                        alertSuccess('Deactivated') //calls function alertSuccess in public\js\main.js
                        // reloadDatatable() //reloads the school year datatable
                    },
                    error: function (xhr, status, errorThrown) {
                        alertFailed('Deactivate')  //calls function alertFailed in public\js\main.js
                    }
                });
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
                    },
                    success: function(data){
                        alertSuccess('Activated') //calls function alertSuccess in public\js\main.js
                        // reloadDatatable() //reloads the school year datatable
                    },
                    error: function (xhr, status, errorThrown) {
                        alertFailed('Activate')  //calls function alertFailed in public\js\main.js
                    }
                });
            }
        });
    });
})
