$(function(){
    let id; //define a global variable id for edit
    const page_route = 'salary_settings'; //define web route

    const opt = {
        errorElement: "div",
        rules: {
            amount_salary: "required",
            salary_class: "required",
            employment_status: "required",
        },
        messages: {
            amount_salary: {
                required: "Amount is required",
            },
            salary_class: {
                required: "Salary classification is required",
            },
            employment_status: {
                required: "Employment Status is required",
            },
        },
        highlight: function (element) {
            $(element).addClass("is-invalid");
        },
        unhighlight: function (element) {
            $(element).removeClass("is-invalid");
        },
    };

    $("#editSalaryForm").validate(opt); // Validate
 // get data by id from schoolyear edit
 $('body').on('click', '.editData', function(e) {
    // e.preventDefault();
    id = $(this).data('id');
    // console.log(id)
    $.ajax({
        url: page_route+"/"+id+"/edit",
        type: "GET",
        success: function(result) {
            let classificationHtml ="";
            let employment_statusHtml = "";
            // display data to updateschoolyearform
            $('#editSalaryModal').modal('show');
            $('#employee_name').val(result.employee.last_name+", "+result.employee.first_name) 
            $('#amount_salary').val(result.getDataById.salary_amount)
            $('#special_allowance').val(result.getDataById.special_allowance)
            let classification = result.getDataById.salary_classification;
            let employment_status = result.getDataById.employment_status;

            classificationHtml  = '<option value="" disabled selected>--Select--</option>';
            classificationHtml += '<option value="hourly" '+((classification == "hourly") ? "selected" : "")+'>Hourly</option>';
            classificationHtml += '<option value="daily" '+((classification == "daily") ? "selected" : "")+'>Daily</option>';
            classificationHtml += '<option value="monthly" '+((classification == "monthly") ? "selected" : "")+'>Monthly</option>';
  
            employment_statusHtml  = '<option value="" disabled selected>--Select--</option>';
            employment_statusHtml += '<option value="regular" '+((employment_status == "regular") ? "selected" : "")+'>Regular</option>';
            employment_statusHtml += '<option value="parttimer" '+((employment_status == "parttimer") ? "selected" : "")+'>Part-Timer</option>';

            $('#salary_class').html(classificationHtml);
            $('#employment_status').html(employment_statusHtml);

        }
    });
});

 // submit updates and save to database
 $('#editSalaryForm').submit(function(e) {
    e.preventDefault();

    $("#editSalaryForm").validate(opt);

    if (!$("#editSalaryForm").valid()) {
        return false;
    }
    //if data is valid call function to run
    updateData()
});

function updateData() {
    // Do something here if validation is passed.
  let form_data = $("#editSalaryForm").serialize(); 

  $.ajax({
      url: page_route+"/"+id,
      type: 'PUT',
      data: form_data
  })
  .done(function() {
      alertSuccess('Updated') //calls function alertSuccess in public\js\main.js
      $("#editSalaryForm")[0].reset();
      $('#editSalaryModal').modal('hide');
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