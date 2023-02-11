$(function () {
    var sectionTab = '';
    var tbl = $('.table');
    let id;
    let page_route ="/encode_grades";
    $(document).ready(function () {

        //edit Grade
        $('body').on('click', '.editGrade', function(e) {
            id = $(this).data("id");
            console.log(id);
            $.ajax({
                url: page_route+"/"+id+"/edit",
                type: "GET",
                success: function(result) {
                    
                    // display data to updateBranchForm
                    $('#updateGradeModal').modal('show');
                    // for (var i = 0; i < result.length; i++) {
                    //     $('#upd_college_code').val(result[i].college_code);
                    //     $('#upd_college_name').val(result[i].college_name);
                    //     $('#upd_college_desc').val(result[i].college_description);
                    // }
                    let x =0;
                    let subjectHTML ='';
                    let subjects = result.subjects;
                    let student_name = "Grades of "+result.student.last_name+", "+result.student.first_name;
                    $("#student_name").html(student_name);
                    subjects.forEach(sub => {
                        if(result.grades==null){
                            subjectHTML+='<div class="form-group"><label for="'+sub.id+'">'+sub.subject_name+'</label> <input type="number" value="60" class="form-control" name="grades[]" id="'+sub.id+'" /></div>';
                        }else{
                       subjectHTML+='<div class="form-group"><label for="'+sub.id+'">'+sub.subject_name+'</label> <input type="number" value="'+result.grades[x]+'" class="form-control" name="grades[]" id="'+sub.id+'" /></div>';
                       x++;
                    }
                    });
                    $("#grade-form").html(subjectHTML);
                }
            });
            $('#updateGradeForm').submit(function(e) {
                e.preventDefault();
                updateData();
            });
            function updateData() {
                // Do something here if validation is passed.
              let form_data = $("#updateGradeForm").serialize(); 
      
              $.ajax({
                  url: page_route+"/"+id,
                  type: 'PUT',
                  data: form_data,
                  async: true,
              })
              .done(function() {
                location.reload();
                  alertSuccess('Updated') //calls function alertSuccess in public\js\main.js
                  
              })
              .fail(function() {
                  alertFailed('Update')
              })
                  
          }
    
        });

       

       
    });

});