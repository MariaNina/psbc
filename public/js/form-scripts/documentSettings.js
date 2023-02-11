$(function(){

    let id; //define a global variable id for edit
    const page_route = 'document_settings'; //define web route

    //define modals and forms for faster coding process
    const addModal = $('#addDocumentModal');
    const updateModal = $('#editDocumentModal');
    const addForm = $('#addDocumentForm');
    const updateForm = $('#editDocumentForm');

    const opt = {
        errorElement: "div",
        rules: {
            document_name: {
                required: true,
                minlength: 3,
                maxlength: 30
            },
            student_type: {
                required: true
            },
            student_dept: {
                required: true
            }
        },
        messages: {
            document_name: {
                required: "Document name is required"
            },
            student_type: {
                required: "Student Type is required"
            },
            student_dept: {
                required: "Student Department is required"
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
                alertSuccess('Created'); //calls function alertSuccess in public\js\main.js
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
                updateModal.modal('show');
                let studentTypehtml = '';
                let studentDepthtml = '';
                let requiredHtml = '';
                let student_type = result.getDataById[0].student_type;
                let student_dept = result.getDataById[0].student_dept;
                let is_required = result.getDataById[0].is_required;
                $('#document_name').val(result.getDataById[0].document_name);

                //create options
                studentTypehtml = '<option value="New"'+((student_type == "New") ? "selected" : "")+'>New</option>';
                studentTypehtml += '<option value="Old" '+((student_type == "Old") ? "selected" : "")+'>Old</option>';
                studentTypehtml += '<option value="Transferee" '+((student_type == "Transferee") ? "selected" : "")+'>Transferee</option>';
                studentTypehtml += '<option value="Cross Enrollee" '+((student_type == "Cross Enrollee") ? "selected" : "")+'>Cross Enrollee</option>';

                //render the options to the select box
                $('#student_type').html(studentTypehtml);

                //create options
                studentDepthtml = '<option value="Elementary"'+((student_dept == "Elementary") ? "selected" : "")+'>Elementary</option>';
                studentDepthtml += '<option value="JHS" '+((student_dept == "JHS") ? "selected" : "")+'>JHS</option>';
                studentDepthtml += '<option value="SHS" '+((student_dept == "SHS") ? "selected" : "")+'>SHS</option>';
                studentDepthtml += '<option value="College" '+((student_dept == "College") ? "selected" : "")+'>College</option>';
                studentDepthtml += '<option value="Graduate Studies" '+((student_dept == "Graduate Studies") ? "selected" : "")+'>Graduate Studies</option>';

                $('#student_dept').html(studentDepthtml);

                requiredHtml = '<option value="1" '+((is_required == "1") ? "selected" : "")+'>Yes</option>';
                requiredHtml += '<option value="0" '+((is_required == "0") ? "selected" : "")+'>No</option>';

                //render the options to the select box
                $('#is_required').html(requiredHtml);
                
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