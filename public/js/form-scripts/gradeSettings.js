$(function(){

    let id; //define a global variable id for edit
    const page_route = 'grade_settings'; //define web route
    const opt = {
        errorElement: "div",
        rules: {
            grade_range: "required",
            department: "required",
            status: "required",
        },
        messages: {
            grade_range: {
                required: "Grade Range is required",
            },
            department: {
                required: "Department is required",
            },
            status: {
                required: "Status is required",
            }
            
        },
        highlight: function (element) {
            $(element).addClass("is-invalid");
        },
        unhighlight: function (element) {
            $(element).removeClass("is-invalid");
        },
    };

    $("#point").hide();
    $("#letter").hide();
    $("#point_equivalent").val(0);
    $("#letter_equivalent").val("N/A");
    $("#department").change(function(){
        if($(this).val()=="College" || $(this).val()=="Graduate Studies"){
            $("#point").show();
            $("#letter").show();
        }else{
            $("#point").hide();
             $("#letter").hide();
             $("#point_equivalent").val(0);
             $("#letter_equivalent").val("N/A");
        }
      });

    $("#GradeSetForm").validate(opt); // Validate
    $("#GradeSetForm").submit(function(e){
        
        e.preventDefault();

        $("#GradeSetForm").validate(opt);

        if (!$("#GradeSetForm").valid()) {
            return false;
        }
        // Do something here if validation is passed.
        createData()
      });

      function createData() {
        // Do something here if validation is passed.
        let form_array = $("#GradeSetForm").serialize(); 
        
        $.post("",form_array,function(resp){
            alertSuccess('Created') //calls function alertSuccess in public\js\main.js  
        })
          .done(function() {
                alertSuccess('Created') //calls function alertSuccess in public\js\main.js
                $("#GradeSetForm")[0].reset();
                $('#addGradeSetModal').modal('hide');
          })
          .fail(function() {
                alertFailed('Create')
          })
    }

    //get data to edit
    $('body').on('click', '.editData', function(e) {
        // e.preventDefault();
        id = $(this).data('id');
        // console.log(id)
        $.ajax({
            url: page_route+"/"+id+"/edit",
            type: "GET",
            success: function(result) {
                // display data to updateschoolyearform
                console.log(result);
                let html ="";
                let html2 ="";
                let gr = result[0].grade_range;
                let department = result[0].level_department;
                let status = result[0].status;
                $("#grade_range1").val(gr);
                
                html += '<option value="Elementary"'+((department == "Elementary") ? "selected" : "")+'>Elementary</option>';
                html += '<option value="JHS" '+((department == "JHS") ? "selected" : "")+'>JHS</option>';
                html += '<option value="SHS" '+((department == "SHS") ? "selected" : "")+'>SHS</option>';
                html += '<option value="College" '+((department == "College") ? "selected" : "")+'>College</option>';
                html += '<option value="Graduate Studies" '+((department == "Graduate Studies") ? "selected" : "")+'>Graduate Studies</option>';

                html2 += '<option value="Passed"'+((status == "Passed") ? "selected" : "")+'>Passed</option>';
                html2 += '<option value="Failed" '+((status == "Failed") ? "selected" : "")+'>Failed</option>';
                html2 += '<option value="For Completion" '+((status == "For Completion") ? "selected" : "")+'>For Completion</option>';
                
                $('#department1').html(html);
                $('#status1').html(html2);

                    if($("#department1").val()=="College" || $("#department1").val()=="Graduate Studies"){
                        $("#point1").show();
                        $("#letter1").show();
                        $("#point_equivalent1").val(result[0].point_equivalent);
                         $("#letter_equivalent1").val(result[0].letter_equivalent);
                    }else{
                        $("#point1").hide();
                         $("#letter1").hide();
                         $("#point_equivalent1").val(0);
                         $("#letter_equivalent1").val("N/A");
                    }

                $('#editGradeSetModal').modal('show');
            }
        });
    });

    //submit updated value
    $('#editGradeSetForm').submit(function(e) {
        e.preventDefault();

        $("#editGradeSetForm").validate(opt);

        if (!$("#editGradeSetForm").valid()) {
            return false;
        }
        //if data is valid call function to run
        updateData()
    });

    function updateData() {
        // Do something here if validation is passed.
      let form_data = $("#editGradeSetForm").serialize(); 

      $.ajax({
          url: page_route+"/"+id,
          type: 'PUT',
          data: form_data
      })
      .done(function() {
          alertSuccess('Updated') //calls function alertSuccess in public\js\main.js
          $("#editGradeSetForm")[0].reset();
          $('#editGradeSetModal').modal('hide');
      })
      .fail(function() {
          alertFailed('Update')
      })
          
    }


});