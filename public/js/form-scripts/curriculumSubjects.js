$(function(){
    $('.select2').select2()
    let id; //define a global variable id for edit
    const page_route = 'curriculum_subjects'; //define web route

    //define modals and forms for faster coding process
    const addModal = $('#addCurriculumSubjectsModal');
    const updateModal = $('#editCurriculumSubjectsModal');
    const addForm = $('#addCurriculumSubjectForm');
    const updateForm = $('#editCurriculumSubjectForm');

    const opt = {
        errorElement: "div",
        rules: {
            term: {
                required: true
            },
            subject: {
                required: true
            }
        },
        messages: {
            term: {
                required: "Term is required"
            },
            subject: {
                required: "Subject is required"
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
                location.reload();
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
                console.log(result)
                let termsHtml = ''; //terms html
                let subjectsHtml = ''; //subjects html
                let prerequisiteHtml = '<option value="">N/A</option>'; //prerequisite html
                
                updateModal.modal('show');
                // $('#upd_curriculumYear').val(result.getDataById[0].curriculum_year);
                // $('#upd_curriculumDescription').val(result.getDataById[0].curriculum_description);
                let subject_id = result.getDataById.subject_id;
                let term_id = result.getDataById.term_id;
                let prerequisite_id = result.getDataById.prerequisite_subject_id;
                let is_offered = result.getDataById.is_offered;
                result.terms.forEach(term => {
                    termsHtml += '<option value="'+term.id+'" '+((term_id == term.id) ? "selected" : "")+'>'+term.term_name+'</option>';
                });
                result.subjects.forEach(subject => {
                    subjectsHtml += '<option value="'+subject.id+'" '+((subject_id == subject.id) ? "selected" : "")+'>'+subject.subject_code+' - '+subject.subject_name+'</option>';
                });
                result.prerequisites.forEach(prerequisite => {
                    prerequisiteHtml += '<option value="'+prerequisite.subject_id+'" '+((prerequisite_id == prerequisite.subject_id) ? "selected" : "")+'>'+prerequisite.subjectName+'</option>';
                });
                is_offered_html = '<option value="1" '+((is_offered == "1") ? "selected" : "")+'>Yes</option>';
                is_offered_html += '<option value="0" '+((is_offered == "0") ? "selected" : "")+'>No</option>';
                $('#is_offered').html(is_offered_html);
                $('#term').html(termsHtml);
                $('#subject').html(subjectsHtml);
                $('#prerequisite').html(prerequisiteHtml);
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
          location.reload();
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