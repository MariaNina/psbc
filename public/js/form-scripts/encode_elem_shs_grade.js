$(document).ready(function () {
    let id; //define a global variable id for edit
    const page_route = "";

    // get data by id from role edit
    $('body').on('click', '.editGrades', function(e) {
        // e.preventDefault();
        id = $(this).data('id');
        console.log(id)
        $.ajax({
            url: id+"/edit",
            type: "GET",
            success: function(result) {
                // display data to update grades
                $('#editGradesModal').modal('show');
                console.log(result)
                let gradeHTML ="";
                result.getDataById.forEach(grade => {
                    gradeHTML+='<div class="form-group"><h5>'+grade.subject_name+'</h5><input value="'+grade.grade+'" type="number" step=0.01 name="grades[]" id="'+grade.subject_name+'" class="form-control mb-3"/><input type="hidden" name="gradeName[]" value="'+grade.id+'"</div>';
                });
                $("#gradeList").html(gradeHTML);
                $("#exampleModalLabel").html("Grades of "+result.student.last_name+", "+result.student.first_name);
            }
        });
    });

     // submit updates and save to database
     $('#editGrades').submit(function(e) {
        e.preventDefault();
        //if data is valid call function to run
        updateData()
    });

    function updateData() {
        // Do something here if validation is passed.
      let form_data = $("#editGrades").serialize(); 
      $.ajax({
          url: id,
          type: 'PUT',
          data: form_data
      })
      .done(function() {
          alertSuccess('Updated') //calls function alertSuccess in public\js\main.js
          $("#editGrades")[0].reset();
          $('#editGradesModal').modal('hide');
      })
      .fail(function() {
          alertFailed('Update')
      })
          
    }

});