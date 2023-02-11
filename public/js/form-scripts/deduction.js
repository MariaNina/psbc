$(function(){

    let id; //define a global variable id for edit
    const page_route = 'deduction_settings'; //define web route
    const opt = {
        errorElement: "div",
        rules: {
            deduction_name: "required",
            deduction_amount: "required",
            edit_deduction_name: "required",
            edit_amount: "required",
        },
        messages: {
            deduction_name: {
                required: "Deduction Name is required",
            },
            deduction_amount: {
                required: "Amount is required",
            },
            edit_deduction_name: {
                required: "Deduction Name is required",
            },
            edit_amount: {
                required: "Amount is required",
            },
        },
        highlight: function (element) {
            $(element).addClass("is-invalid");
        },
        unhighlight: function (element) {
            $(element).removeClass("is-invalid");
        },
    };

    $("#deductionForm").validate(opt); // Validate
    $("#editDeductionForm").validate(opt); // Validate

    $("#deductionForm").submit(function(e){
        
        e.preventDefault();

        $("#deductionForm").validate(opt);

        if (!$("#deductionForm").valid()) {
            return false;
        }
        // Do something here if validation is passed.
        createData()
      });

      function createData() {
        // Do something here if validation is passed.
        let form_array = $("#deductionForm").serialize(); 
        
        $.post("",form_array,function(resp){
            alertSuccess('Created') //calls function alertSuccess in public\js\main.js  
        })
          .done(function() {
                alertSuccess('Created') //calls function alertSuccess in public\js\main.js
                $("#deductionForm")[0].reset();
                $('#addDeductionModal').modal('hide');
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
            $('#editDeductionModal').modal('show');
        
                $('#edit_deduction_name').val(result[0].deduction_name);
                // $('#edit_amount').val(result[0].amount);   
        }
    });
});
// submit updates and save to database
$('#editDeductionForm').submit(function(e) {
    e.preventDefault();

    $("#editDeductionForm").validate(opt);

    if (!$("#editDeductionForm").valid()) {
        return false;
    }
    //if data is valid call function to run
    updateData()
});

function updateData() {
    // Do something here if validation is passed.
  let form_data = $("#editDeductionForm").serialize(); 

  $.ajax({
      url: page_route+"/"+id,
      type: 'PUT',
      data: form_data
  })
  .done(function() {
      alertSuccess('Updated') //calls function alertSuccess in public\js\main.js
      $("#editDeductionForm")[0].reset();
      $('#editDeductionModal').modal('hide');
  })
  .fail(function() {
      alertFailed('Update')
  })
      
}
//Deactivate
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
//Activate
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