$(function(){

    let id; //define a global variable id for edit
    const page_route = 'holiday_settings'; //define web route
    const opt = {
        errorElement: "div",
        rules: {
            holiday_name: "required",
            holiday_date: "required",
        },
        messages: {
            holiday_name: {
                required: "Holiday Name is required",
            },
            holiday_date: {
                required: "Holiday Date is required",
            },
        },
        highlight: function (element) {
            $(element).addClass("is-invalid");
        },
        unhighlight: function (element) {
            $(element).removeClass("is-invalid");
        },
    };

    $("#HolidayForm").validate(opt); // Validate
    $("#EditHolidayForm").validate(opt); // Validate

    $("#HolidayForm").submit(function(e){
        
        e.preventDefault();

        $("#HolidayForm").validate(opt);

        if (!$("#HolidayForm").valid()) {
            return false;
        }
        // Do something here if validation is passed.
        createData()
      });

      function createData() {
        // Do something here if validation is passed.
        let form_array = $("#HolidayForm").serialize(); 
        
        $.post("",form_array,function(resp){
            alertSuccess('Created') //calls function alertSuccess in public\js\main.js  
        })
          .done(function() {
                alertSuccess('Created') //calls function alertSuccess in public\js\main.js
                $("#HolidayForm")[0].reset();
                $('#addHolidayModal').modal('hide');
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
                $('#editHolidayModal').modal('show');
            
                    $('#edit_holiday_name').val(result[0].holiday_name);
                    $('#edit_holiday_date').val(result[0].holiday_date);
                    
            }
        });
    });

    // submit updates and save to database
    $('#EditHolidayForm').submit(function(e) {
        e.preventDefault();

        $("#EditHolidayForm").validate(opt);

        if (!$("#EditHolidayForm").valid()) {
            return false;
        }
        //if data is valid call function to run
        updateData()
    });

    function updateData() {
        // Do something here if validation is passed.
      let form_data = $("#EditHolidayForm").serialize(); 

      $.ajax({
          url: page_route+"/"+id,
          type: 'PUT',
          data: form_data
      })
      .done(function() {
          alertSuccess('Updated') //calls function alertSuccess in public\js\main.js
          $("#EditHolidayForm")[0].reset();
          $('#editHolidayModal').modal('hide');
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