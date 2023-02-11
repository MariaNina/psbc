$(function(){

    let id; //define a global variable id for edit
    const page_route = 'discounts'; //define web route

    //define modals and forms for faster coding process
    const addModal = $('#addDiscountModal');
    const updateModal = $('#updateDiscountModal');
    const addForm = $('#addDiscountForm');
    const updateForm = $('#editDiscountForm');

    const opt = {
        errorElement: "div",
        rules: {
            discount_name: {
                required: true
            },
            description: {
                required: true
            },
            student_dept: {
                required: true
            },
            amount: {
                required: true,
                number: true
            },
            discount_type: {
                required: true
            }
        },
        messages: {
            discount_name: {
                required: "Discount Name is required"
            },
            description: {
                required: "Description is required"
            },
            student_dept: {
                required: "Student Department is required"
            },
            amount: {
                required: "Amount is required"
            },
            discount_type: {
                required: "Discount Type is required"
            }
        },
        highlight: function (element) {
            $(element).addClass("is-invalid");
        },
        unhighlight: function (element) {
            $(element).removeClass("is-invalid");
        },
    };

    addForm.validate(opt); // Validate
    updateForm.validate(opt); // Validate
    
    // add curriculum
    addForm.submit(function(e){
        
        e.preventDefault();

        addForm.validate(opt);

        if (!addForm.valid()) {
            return false;
        }
        // Do something here if validation is passed.
        createData()
    });

    function createData() {
        // Do something here if validation is passed.
        let form_array = addForm.serializeArray(); 
        console.log(form_array)
        $.post("",form_array,function(resp){
            alertSuccess('Created') //calls function alertSuccess in public\js\main.js  
        })
          .done(function() {
                alertSuccess('Created') //calls function alertSuccess in public\js\main.js
                addForm[0].reset();
                addModal.modal('hide');
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
                // console.log(result)
                let studentDeptHtml = ''; 
                let discTypeHtml = ''; 
                let disc_amount = 0;

                updateModal.modal('show');
                $('#discount_name').val(result.getDataById[0].discount_name);
                $('#description').val(result.getDataById[0].discount_description);
                disc_amount = result.getDataById[0].amount;
                disc_amount = disc_amount.replace('X','')
                $('#amount').val(disc_amount);

                let discount_type = result.getDataById[0].discount_type;
                let student_department = result.getDataById[0].student_department;

                //set options
                studentDeptHtml = '<option value="Elementary" '+((student_department == "Elementary") ? "selected" : "")+'>Elementary</option>';
                studentDeptHtml += '<option value="JHS" '+((student_department == "JHS") ? "selected" : "")+'>JHS</option>';
                studentDeptHtml += '<option value="SHS" '+((student_department == "SHS") ? "selected" : "")+'>SHS</option>';
                studentDeptHtml += '<option value="College" '+((student_department == "College") ? "selected" : "")+'>College</option>';
                studentDeptHtml += '<option value="Graduate Studies" '+((student_department == "Graduate Studies") ? "selected" : "")+'>Graduate Studies</option>';

                //display in modal
                $('#student_dept').html(studentDeptHtml);

                //set options for disc type
                discTypeHtml = '<option value="Percentage" '+((discount_type == "Percentage") ? "selected" : "")+'>Percentage</option>';
                discTypeHtml += '<option value="Constant" '+((discount_type == "Constant") ? "selected" : "")+'>Constant</option>';
                discTypeHtml += '<option value="Input Value" '+((discount_type == "Input Value") ? "selected" : "")+'>Input Value</option>';

                //dsplay in modal
                $('#discount_type').html(discTypeHtml);
            }
        });
    });

    // submit updates and save to database
    updateForm.submit(function(e) {
        e.preventDefault();

        updateForm.validate(opt);

        if (!updateForm.valid()) {
            return false;
        }
        //if data is valid call function to run
        updateData()
    });

    function updateData() {
        // Do something here if validation is passed.
      let form_data = updateForm.serialize(); 

      $.ajax({
          url: page_route+"/"+id,
          type: 'PUT',
          data: form_data
      })
      .done(function() {
          alertSuccess('Updated') //calls function alertSuccess in public\js\main.js
          updateForm[0].reset();
          updateModal.modal('hide');
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