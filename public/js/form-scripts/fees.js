$(function(){

    let id; //define a global variable id for edit
    const page_route = 'fees'; //define web route
    const opt = {
        errorElement: "div",
        rules: {
            feeName: "required",
            feeDesc: "required",
            feeAmount: {
                required: true,
                number: true
            },
            feeType: "required",
            studentDept: "required"
        },
        messages: {
            feeName: {
                required: "Fee name is required",
            },
            feeDesc: {
                required: "Description is required",
            },
            feeAmount: {
                required: "Amount is required",
            },
            feeType: {
                required: "Fee Type is required",
            },
            studentDept: {
                required: "Student Department is required",
            }
            
        },
        highlight: function (element) {
            $(element).addClass("is-invalid");
        },
        unhighlight: function (element) {
            $(element).removeClass("is-invalid");
        },
    };

    $("#addFeeForm").validate(opt); // Validate
    $("#updateFeeForm").validate(opt); // Validate
         // add fee
      $("#addFeeForm").submit(function(e){
        
        e.preventDefault();

        $("#addFeeForm").validate(opt);

        if (!$("#addFeeForm").valid()) {
            return false;
        }
        // Do something here if validation is passed.
        createData()
      });

      function createData() {
        // Do something here if validation is passed.
        let form_array = $("#addFeeForm").serialize(); 
        
        $.post("",form_array,function(resp){
            alertSuccess('Created') //calls function alertSuccess in public\js\main.js  
        })
          .done(function() {
                alertSuccess('Created') //calls function alertSuccess in public\js\main.js
                $("#addFeeForm")[0].reset();
                $('#addFeeModal').modal('hide');
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
                let html = '';
                let feeTypeHtml = '';
                let studentDept;
                let feeType;
                // display data to updateschoolyearform
                $('#updateFeeModal').modal('show');
                $('#feeName').val(result[0].fee_name);
                $('#feeDesc').val(result[0].fee_description);
                $('#feeAmount').val(result[0].fee_amount);
                studentDept = result[0].student_department;
                feeType = result[0].fee_type;

                html = '<option value="Elementary"'+((studentDept == "Elementary") ? "selected" : "")+'>Elementary</option>';
                html += '<option value="JHS" '+((studentDept == "JHS") ? "selected" : "")+'>JHS</option>';
                html += '<option value="SHS" '+((studentDept == "SHS") ? "selected" : "")+'>SHS</option>';
                html += '<option value="College" '+((studentDept == "College") ? "selected" : "")+'>College</option>';
                html += '<option value="Graduate Studies" '+((studentDept == "Graduate Studies") ? "selected" : "")+'>Graduate Studies</option>';

                $('#studentDept').html(html);

                 //set options for disc type
                 feeTypeHtml = '<option value="Discountable Fee" '+((feeType == "Discountable Fee") ? "selected" : "")+'>Discountable Fee</option>';
                 feeTypeHtml += '<option value="Lec Unit" '+((feeType == "Lec Unit") ? "selected" : "")+'>Lec Unit</option>';
                 feeTypeHtml += '<option value="Lab Unit" '+((feeType == "Lab Unit") ? "selected" : "")+'>Lab Unit</option>';
                 feeTypeHtml += '<option value="Others" '+((feeType == "Others") ? "selected" : "")+'>Others</option>';
                 
                 //dsplay in modal
                 $('#feeType').html(feeTypeHtml);
            }
        });
    });

    // submit updates and save to database
    $('#updateFeeForm').submit(function(e) {
        e.preventDefault();

        $("#updateFeeForm").validate(opt);

        if (!$("#updateFeeForm").valid()) {
            return false;
        }
        //if data is valid call function to run
        updateData()
    });

    function updateData() {
        // Do something here if validation is passed.
      let form_data = $("#updateFeeForm").serialize(); 

      $.ajax({
          url: page_route+"/"+id,
          type: 'PUT',
          data: form_data
      })
      .done(function() {
          alertSuccess('Updated') //calls function alertSuccess in public\js\main.js
          $("#updateFeeForm")[0].reset();
          $('#updateFeeModal').modal('hide');
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