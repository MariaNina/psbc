$(function(){

    let id; //define a global variable id for edit
    const page_route = 'terms'; //define web route

    const opt = {
        errorElement: "div",
        rules: {
            termName: {
                required: false,
                minlength: 3,
                maxlength: 30
            }
        },
        messages: {
            termName: {
                required: "Term name must not be empty",
            },
        },
        highlight: function (element) {
            $(element).addClass("is-invalid");
        },
        unhighlight: function (element) {
            $(element).removeClass("is-invalid");
        },
    };

    $('#addTermModal').click(function(){
        $("#termError").hide();
    $("#termError2").hide();
    });
    $("#termError").hide();
    $("#termError2").hide();
    $("#TermForm").validate(opt); // Validate
    $("#updateTermForm").validate(opt); // Validate

    // Check validation if submit then add school year
    $("#TermForm").submit(function(e){

        $("#TermForm").validate(opt);

        if (!$("#TermForm").valid()) {
            return false;
        }
        let termName = $.trim($("#termName").val());
        let _token  = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
          type: "POST",
          data:{
            termName:termName,
            _token: _token
          },
            success: function(data){
                $("#termError").hide();
                $("#addTermModal").modal('hide');
                alertSuccess('Created') //calls function alertSuccess in public\js\main.js
                $("#termName").val(""); //clear input
            },
            error: function (response) {
                $("#termError").show();
                console.log(response)
                    $('#termMessage').html(""); //clear html elements
                    //check the error tresponse
                    let errorText = response.responseJSON.errors;
                    console.log(errorText.term_name);
                    for (var key in errorText) {
                            $('#termMessage').append(errorText[key]+"<br />");
                    }
                alertFailed('Create')  //calls function alertFailed in public\js\main.js
            }
        });
        e.preventDefault();
    });

      // get data by id from schoolyear edit
      $('body').on('click', '.editData', function(e) {
        // e.preventDefault();
        id = $(this).data('id');
        console.log(id)
        $.ajax({
            url: page_route+"/"+id+"/edit",
            type: "GET",
            success: function(result) {
                // display data to updateschoolyearform
                $('#updateTermModal').modal('show');
                for (var i = 0; i < result.length; i++) {
                    $('#updateTermName').val(result[i].term_name);
                }
            }
        });
    });

    // submit updates and save to database
    $('#updateTermForm').submit(function(e) {
        e.preventDefault();

        $("#updateTermForm").validate(opt);

        if (!$("#updateTermForm").valid()) {
            return false;
        }

        //id data is valid
        let termName = $.trim($("#updateTermName").val());
        let _token  = $('meta[name="csrf-token"]').attr('content');


        $.ajax({
            url: page_route+"/"+id,
            type: 'PUT',
            data: {
                termName: termName,
                _token: _token,
            },
            success: function(data){
                $("#termError2").hide();
                $('#updateTermModal').modal('hide');
                alertSuccess('Updated') //calls function alertSuccess in public\js\main.js
                // reloadDatatable() //reloads the school year datatable
            },
            error: function (response) {
                $("#termError2").show();
                console.log(response)
                    $('#termMessage2').html(""); //clear html elements
                    //check the error tresponse
                    let errorText = response.responseJSON.errors;
                    console.log(errorText);
                    for (var key in errorText) {
                            $('#termMessage2').append(errorText[key]+"<br />");
                    }
                alertFailed('Update')  //calls function alertFailed in public\js\main.js
            }
        });
    });

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

});
