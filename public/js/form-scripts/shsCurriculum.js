$(function(){
    let id; //define a global variable id for edit
    const page_route = 'curriculums'; //define web route

    //define modals and forms for faster coding process
    const addModal2 = $('#shsCurriculumModal');
    const updateModal2 = $('#editShsCurriculumModal');
    const addForm2 = $('#addShsForm');
    const updateForm2 = $('#editShsForm');

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
            level: {
                required: true,
            },
            schoolYear: {
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
            level: {
                required: "Student level is required",
            },
            schoolYear: {
                required: "School Year is Required"
            }
        },
        highlight: function (element) {
            $(element).addClass("is-invalid");
        },
        unhighlight: function (element) {
            $(element).removeClass("is-invalid");
        },
    };

    addForm2.validate(opt); // Validate
    updateForm2.validate(opt); // Validate
    
    // add curriculum
    addForm2.submit(function(e){
        
        e.preventDefault();

        addForm2.validate(opt);

        if (!addForm2.valid()) {
            return false;
        }
        // Do something here if validation is passed.
        createData2()
    });

    function createData2() {
        // Do something here if validation is passed.
        let form_array = addForm2.serialize(); 
        
        $.post("",form_array,function(resp){
            alertSuccess('Created') //calls function alertSuccess in public\js\main.js  
        })
          .done(function() {
                alertSuccess('Created') //calls function alertSuccess in public\js\main.js
                addForm2[0].reset();
                addModal2.modal('hide');
          })
          .fail(function() {
                alertFailed('Create')
          })
    }

     // get data by id from schoolyear edit
     $('body').on('click', '.editData_SHS', function(e) {
        // e.preventDefault();
        id = $(this).data('id');
        // console.log(id)
        $.ajax({
            url: page_route+"/"+id+"/edit",
            type: "GET",
            success: function(result) {
                // console.log(result)
                let pmHtml = ''; //programs majors html
                let lHtml = '';
                let syHtml = '';
                // display data to updateschoolyearform
                updateModal2.modal('show');
                $('#upd_shscurriculumYear').val(result.getDataById[0].curriculum_year);
                $('#upd_shscurriculumDescription').val(result.getDataById[0].curriculum_description);
                let program_major_id = result.getDataById[0].program_major_id;
                let level_id = result.getDataById[0].level_id;
                let school_year_id = result.getDataById[0].school_year_id;

                result.programsMajorsSHS.forEach(pm => {
                    pmHtml += '<option value="'+pm.id+'" '+((program_major_id == pm.id) ? "selected" : "")+'>'+pm.program_code+'-'+pm.program_name+' ('+pm.major_name+')</option>';
                });
                result.shs_levels.forEach(l => {
                    lHtml += '<option value="'+l.id+'" '+((level_id == l.id) ? "selected" : "")+'>'+l.level_name+'</option>';
                });
                result.school_years.forEach(sy => {
                    syHtml += '<option value="'+sy.id+'" '+((school_year_id == sy.id) ? "selected" : "")+'>'+sy.school_years+'</option>';
                });
                $('#upd_shsprogramMajor').html(pmHtml)
                $('#upd_shslevel').html(lHtml);
                $('#upd_shsschoolYear').html(syHtml);
                // console.log(pmHtml)
            }
        });
    });

    // submit updates and save to database
    updateForm2.submit(function(e) {
        e.preventDefault();

        updateForm2.validate(opt);

        if (!updateForm2.valid()) {
            return false;
        }
        //if data is valid call function to run
        updateData2()
    });

    function updateData2() {
        // Do something here if validation is passed.
      let form_data = updateForm2.serialize(); 

      $.ajax({
          url: page_route+"/"+id,
          type: 'PUT',
          data: form_data
      })
      .done(function() {
          alertSuccess('Updated') //calls function alertSuccess in public\js\main.js
          updateForm2[0].reset();
          updateModal2.modal('hide');
      })
      .fail(function() {
          alertFailed('Update')
      })
          
    }
  });