$(function(){

    let id; //define a global variable id for edit
    const page_route = 'curriculums'; //define web route

    //define modals and forms for faster coding process
    const addModal = $('#collegeCurriculumModal');
    const updateModal = $('#editCollegeCurriculumModal');
    const addForm = $('#addCurriculumForm');
    const updateForm = $('#editCurriculumForm');

    const opt = {
        errorElement: "div",
        rules: {
            curriculumYear: {
                required: true,
                minlength: 9,
                maxlength: 9
            },
            curriculumDescription: {
                required: true,
                minlength: 5,
                maxlength: 100
            },
            programMajor: {
                required: true,
            },
            schoolYear: {
                required: true,
            },
            level: {
                required: true,
            }
        },
        messages: {
            curriculumYear: {
                required: "Curriculum Year is Required"
            },
            curriculumDescription: {
                required: "Description is Required"
            },
            programMajor: {
                required: "Program and Major is required",
            },
            schoolYear: {
                required: "School Year is Required"
            },
            level: {
                required: "Student Level is Required"
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
     $('body').on('click', '.editData_College', function(e) {
        // e.preventDefault();
        id = $(this).data('id');
        // console.log(id)
        $.ajax({
            url: page_route+"/"+id+"/edit",
            type: "GET",
            success: function(result) {
                // console.log(result)
                let pmHtml = ''; //programs majors html
                let syHtml = ''; //school year html
                let lhtml = ''; //levels html
                // display data to updateschoolyearform
                updateModal.modal('show');
                $('#upd_curriculumYear').val(result.getDataById[0].curriculum_year);
                $('#upd_curriculumDescription').val(result.getDataById[0].curriculum_description);
                let program_major_id = result.getDataById[0].program_major_id;
                let school_year_id = result.getDataById[0].school_year_id;
                let level_id = result.getDataById[0].level_id;

                result.programsMajorsCollege.forEach(pm => {
                    pmHtml += '<option value="'+pm.id+'" '+((program_major_id == pm.id) ? "selected" : "")+'>'+pm.program_code+'-'+pm.program_name+' ('+pm.major_name+')</option>';
                });
                result.school_years.forEach(sy => {
                    syHtml += '<option value="'+sy.id+'" '+((school_year_id == sy.id) ? "selected" : "")+'>'+sy.school_years+'</option>';
                });
                result.college_levels.forEach(l => {
                    lhtml += '<option value="'+l.id+'" '+((level_id == l.id) ? "selected" : "")+'>'+l.level_name+'</option>';
                });
                $('#upd_programMajor').html(pmHtml);
                $('#upd_schoolYear').html(syHtml);
                $('#upd_level').html(lhtml);
                // console.log(pmHtml)
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