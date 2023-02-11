$(function(){

    let id; //define a global variable id for edit
    const page_route = 'levels'; //define web route
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

    $("#addLevelForm").validate(opt); // Validate
    $("#updateLevelForm").validate(opt); // Validate
         // add grade level
      $("#addLevelForm").submit(function(e){
        
        e.preventDefault();

        $("#addLevelForm").validate(opt);

        if (!$("#addLevelForm").valid()) {
            return false;
        }
        // Do something here if validation is passed.
        createData()
      });

      function createData() {
        // Do something here if validation is passed.
        let form_array = $("#addLevelForm").serialize(); 
        
        $.post("",form_array,function(resp){
            alertSuccess('Created') //calls function alertSuccess in public\js\main.js  
        })
          .done(function() {
                alertSuccess('Created') //calls function alertSuccess in public\js\main.js
                $("#addLevelForm")[0].reset();
                $('#addLevelModal').modal('hide');
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
                let studentDept;
                // display data to updateschoolyearform
                $('#updateLevelModal').modal('show');
                for (var i = 0; i < result.length; i++) {
                    $('#upd_levelCode').val(result[i].level_code);
                    $('#upd_levelName').val(result[i].level_name);
                    studentDept = result[i].student_dept;
                    
                }
                html = '<option value="Elementary"'+((studentDept == "Elementary") ? "selected" : "")+'>Elementary</option>';
                html += '<option value="JHS" '+((studentDept == "JHS") ? "selected" : "")+'>JHS</option>';
                html += '<option value="SHS" '+((studentDept == "SHS") ? "selected" : "")+'>SHS</option>';
                html += '<option value="College" '+((studentDept == "College") ? "selected" : "")+'>College</option>';
                html += '<option value="Graduate Studies" '+((studentDept == "Graduate Studies") ? "selected" : "")+'>Graduate Studies</option>';

                $('#upd_studentDept').html(html);
            }
        });
    });

    // submit updates and save to database
    $('#updateLevelForm').submit(function(e) {
        e.preventDefault();

        $("#updateLevelForm").validate(opt);

        if (!$("#updateLevelForm").valid()) {
            return false;
        }
        //if data is valid call function to run
        updateData()
    });

    function updateData() {
        // Do something here if validation is passed.
      let form_data = $("#updateLevelForm").serialize(); 

      $.ajax({
          url: page_route+"/"+id,
          type: 'PUT',
          data: form_data
      })
      .done(function() {
          alertSuccess('Updated') //calls function alertSuccess in public\js\main.js
          $("#updateLevelForm")[0].reset();
          $('#updateLevelModal').modal('hide');
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