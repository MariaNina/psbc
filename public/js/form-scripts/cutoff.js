$(function(){

    let id; //define a global variable id for edit
    const page_route = 'cutoff_settings'; //define web route
    const opt = {
        errorElement: "div",
        rules: {
            start_date: "required",
            end_date: "required",
            pay_date: "required",
            edit_start_date: "required",
            edit_end_date: "required",
            edit_pay_date: "required",
        },
        messages: {
            start_date: {
                required: "Start Date is required",
            },
            end_date: {
                required: "End Date is required",
            },
            pay_date: {
                required: "Pay Date is required",
            },
            edit_start_date: {
                required: "Start Date is required",
            },
            edit_end_date: {
                required: "End Date is required",
            },
            edit_pay_date: {
                required: "Pay Date is required",
            },
        },
        highlight: function (element) {
            $(element).addClass("is-invalid");
        },
        unhighlight: function (element) {
            $(element).removeClass("is-invalid");
        },
    };

    $("#CutOffForm").validate(opt); // Validate
    $("#EditCutOffForm").validate(opt); // Validate

    $("#CutOffForm").submit(function(e){
        
        e.preventDefault();

        $("#HolidayForm").validate(opt);

        if (!$("#CutOffForm").valid()) {
            return false;
        }
        // Do something here if validation is passed.
        createData()
      });

      function createData() {
        // Do something here if validation is passed.
        let form_array = $("#CutOffForm").serialize(); 
        
        $.post("",form_array,function(resp){
            alertSuccess('Created') //calls function alertSuccess in public\js\main.js  
        })
          .done(function() {
                alertSuccess('Created') //calls function alertSuccess in public\js\main.js
                $("#CutOffForm")[0].reset();
                $('#addCutOffModal').modal('hide');
          })
          .fail(function() {
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
                // display data to updateschoolyearform
                console.log(result);
                $('#editCutOffModal').modal('show');
            
                    $('#edit_start_date').val(result[0].start_date);
                    $('#edit_end_date').val(result[0].end_date);
                    $('#edit_pay_date').val(result[0].pay_day);
            }
        });
    });

    // submit updates and save to database
    $('#EditCutOffForm').submit(function(e) {
        e.preventDefault();

        $("#EditCutOffForm").validate(opt);

        if (!$("#EditCutOffForm").valid()) {
            return false;
        }
        //if data is valid call function to run
        updateData()
    });

    function updateData() {
        // Do something here if validation is passed.
      let form_data = $("#EditCutOffForm").serialize(); 

      $.ajax({
          url: page_route+"/"+id,
          type: 'PUT',
          data: form_data
      })
      .done(function() {
          alertSuccess('Updated') //calls function alertSuccess in public\js\main.js
          $("#EditCutOffForm")[0].reset();
          $('#editCutOffModal').modal('hide');
      })
      .fail(function() {
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