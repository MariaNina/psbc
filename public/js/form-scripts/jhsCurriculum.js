$(function(){
    let id; //define a global variable id for edit
    const page_route = 'curriculums'; //define web route

    //define modals and forms for faster coding process
    const addModal4 = $('#jhsCurriculumModal');
    const updateModal4 = $('#editjhsCurriculumModal');
    const addForm4 = $('#addjhsForm');
    const updateForm4 = $('#editjhsForm');

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

    addForm4.validate(opt); // Validate
    updateForm4.validate(opt); // Validate
    
    // add curriculum
    addForm4.submit(function(e){
        
        e.preventDefault();

        addForm4.validate(opt);

        if (!addForm4.valid()) {
            return false;
        }
        // Do something here if validation is passed.
        createData4()
    });

    function createData4() {
        // Do something here if validation is passed.
        let form_array = addForm4.serialize(); 
        
        $.post("",form_array,function(resp){
            alertSuccess('Created') //calls function alertSuccess in public\js\main.js  
        })
          .done(function() {
                alertSuccess('Created') //calls function alertSuccess in public\js\main.js
                addForm4[0].reset();
                addModal4.modal('hide');
          })
          .fail(function() {
                alertFailed('Create')
          })
    }

     // get data by id from schoolyear edit
     $('body').on('click', '.editData_JHS', function(e) {
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
                updateModal4.modal('show');
                $('#upd_jhscurriculumYear').val(result.getDataById[0].curriculum_year);
                $('#upd_jhscurriculumDescription').val(result.getDataById[0].curriculum_description);
                let program_major_id = result.getDataById[0].program_major_id;
                let level_id = result.getDataById[0].level_id;
                let school_year_id = result.getDataById[0].school_year_id;
    
                result.programsMajorsJHS.forEach(pm => {
                    pmHtml += '<option value="'+pm.id+'" '+((program_major_id == pm.id) ? "selected" : "")+'>'+pm.program_code+'-'+pm.program_name+'</option>';
                });
                result.jhs_levels.forEach(l => {
                    lHtml += '<option value="'+l.id+'" '+((level_id == l.id) ? "selected" : "")+'>'+l.level_name+'</option>';
                });
                result.school_years.forEach(sy => {
                    syHtml += '<option value="'+sy.id+'" '+((school_year_id == sy.id) ? "selected" : "")+'>'+sy.school_years+'</option>';
                });
                $('#upd_jhsprogramMajor').html(pmHtml)
                $('#upd_jhslevel').html(lHtml);
                $('#upd_jhsschoolYear').html(syHtml);
                // console.log(pmHtml)
            }
        });
    });

    // submit updates and save to database
    updateForm4.submit(function(e) {
        e.preventDefault();

        updateForm4.validate(opt);

        if (!updateForm4.valid()) {
            return false;
        }
        //if data is valid call function to run
        updateData4()
    });

    function updateData4() {
        // Do something here if validation is passed.
      let form_data = updateForm4.serialize(); 

      $.ajax({
          url: page_route+"/"+id,
          type: 'PUT',
          data: form_data
      })
      .done(function() {
          alertSuccess('Updated') //calls function alertSuccess in public\js\main.js
          updateForm4[0].reset();
          updateModal4.modal('hide');
      })
      .fail(function() {
          alertFailed('Update')
      })
          
    }
  });