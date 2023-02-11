$(function(){

    let id; //define a global variable id for edit
    const page_route = '/branch_college_program_majors'; //define web route
    const opt = {
        errorElement: "div",
        rules: {
            levelCode: "required",
            levelName: "required",
            studentDept: "required",
        },
        messages: {
            levelCode: {
                required: "Level code is required",
            },
            levelName: {
                required: "Level name is required",
            },
            studentDept: {
                required: "Student Dept is required",
            },
        },
        highlight: function (element) {
            $(element).addClass("is-invalid");
        },
        unhighlight: function (element) {
            $(element).removeClass("is-invalid");
        },
    };

    $("#BranchCollgeForm").validate(opt); // Validate
    $("#updateLevelForm").validate(opt); // Validate
         // add grade level
      $("#BranchCollgeForm").submit(function(e){
        
        e.preventDefault();

        $("#BranchCollgeForm").validate(opt);

        if (!$("#BranchCollgeForm").valid()) {
            return false;
        }
        // Do something here if validation is passed.
        createData()
      });

      function createData() {
        // Do something here if validation is passed.
        let form_array = $("#BranchCollgeForm").serialize(); 
        
        $.post("",form_array,function(resp){
            alertSuccess('Created') //calls function alertSuccess in public\js\main.js  
        })
          .done(function() {
                alertSuccess('Created'); //calls function alertSuccess in public\js\main.js
                $("#BranchCollgeForm")[0].reset();
                $('#addBranchCollegeModal').modal('hide');
          })
          .fail(function() {
                alertFailed('Create')
          })
    }

     // get data by id from schoolyear edit
     $('body').on('click', '.editData', function(e) {
        // e.preventDefault();
        id = $(this).data('id');
        console.log(id)
        $.ajax({
            url: page_route+"/"+id+"/edit",
            type: "GET",
        })
        .done((result)=>{
            // console.log(result);
            let branchhtml = '';
            let collegehtml = '';
            let programMajorhtml = '';
            // display data to program major
            $('#editBranchCollegeModal').modal('show');
            console.log(result);
            let branch_id = result.getDataById[0].branch_id;
            let college_id = result.getDataById[0].college_id;
            let program_major_id = result.getDataById[0].program_major_id;
            result.branches.forEach(b => {
                branchhtml += '<option value="'+b.id+'" '+((branch_id == b.id) ? "selected" : "")+'>'+b.branch_name+'</option>';
            });

            result.colleges.forEach(c => {
                collegehtml += '<option value="'+c.id+'" '+((college_id == c.id) ? "selected" : "")+'>'+c.college_name+'</option>';
            });

            result.programMajors.forEach(pm => {
                programMajorhtml += '<option value="'+pm.id+'" '+((program_major_id == pm.id) ? "selected" : "")+'>'+pm.program_name+" "+pm.major_name+'</option>';
            });
            $('#upbranchName').html(branchhtml);
            $('#upcollegeName').html(collegehtml);
            $('#upprogramMajor').html(programMajorhtml);

        })
    });

    // submit updates and save to database
    $('#upBranchCollgeForm').submit(function(e) {
        e.preventDefault();

        $("#upBranchCollgeForm").validate(opt);

        if (!$("#upBranchCollgeForm").valid()) {
            return false;
        }
        //if data is valid call function to run
        updateData()
    });

    function updateData() {
        // Do something here if validation is passed.
      let form_data = $("#upBranchCollgeForm").serialize(); 

      $.ajax({
          url: page_route+"/"+id,
          type: 'PUT',
          data: form_data
      })
      .done(function() {
          alertSuccess('Updated') //calls function alertSuccess in public\js\main.js
        //   $("#upBranchCollgeForm")[0].reset();
          $("#branchName").vall();
          $("#collegeName").vall();
          $("#programMajor").vall();
          $('#editBranchCollegeModal').modal('hide');
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
                    },
                    
                    success: function(data){
                        alertSuccess('Deactivated') //calls function alertSuccess in public\js\main.js
                        // reloadDatatable() //reloads the school year datatable
                    },
                    error: function (xhr, status, errorThrown) {
                        alertFailed('Deactivate')  //calls function alertFailed in public\js\main.js
                    }
                });
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
                    },
                    success: function(data){
                        alertSuccess('Activated') //calls function alertSuccess in public\js\main.js
                        // reloadDatatable() //reloads the school year datatable
                    },
                    error: function (xhr, status, errorThrown) {
                        alertFailed('Activate')  //calls function alertFailed in public\js\main.js
                    }
                });
            }
        });
    });

  });