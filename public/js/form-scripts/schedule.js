$(document).ready(function () {
    let id; //define a global variable id for edit
    const page_route = "schedule";
    console.log("detected");
   // Check validation if submit then add schedule
    $("#ScheduleForm").submit(function(e){  //use .submit to read html validation
        e.preventDefault();
        //if data is valid call function to run
        createData()
    });
    // end of adding school year

    
      
    function createData() {
        // Do something here if validation is passed.
        let form_array = $("#ScheduleForm").serialize(); 

        $.post("",form_array,function(resp){
            alertSuccess('Created') //calls function alertSuccess in public\js\main.js  
        })
            .done(function() {
                $('.btn').hide();
                alertSuccess('Created') //calls function alertSuccess in public\js\main.js
                $("#ScheduleForm")[0].reset();
            })
            .fail(function(xhr, status, error) {
                Swal.fire({
                    title: status,
                    text: "One of the Room is not available for the selected time or Teacher is not available on that time please choose another room or change the time selected",
                    icon: "warning",
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "OK",
                })
            })
        }

    // get data by id from user edit
     $('body').on('click', '.editData', function(e) {
        // e.preventDefault();
        id = $(this).data('id');
        let roomHtml = '';
        let teacherHtml = '';
        console.log(id);
        $.ajax({
            url: page_route+"/"+id+"/edit",
            type: "GET",
        })
        .done((result)=>{
            //display modal
            console.log(result.getDatabyId.room_id)
            let room_id = result.getDatabyId.room_id;
            let teacher_id = result.getDatabyId.staff_id;
            $('#editScheduleModal').modal('show');
            $('#subject').val(result.subject.subject_name);
            $('#startTime').val(result.getDatabyId.start_time);
            $('#endTime').val(result.getDatabyId.end_time);
            result.rooms.forEach(r => {
                roomHtml += '<option value="'+r.id+'" '+((room_id == r.id) ? "selected" : "")+'>'+r.room_no+'</option>';
            });

            result.teachers.forEach(t => {
                teacherHtml += '<option value="'+t.id+'" '+((teacher_id == t.id) ? "selected" : "")+'>'+t.last_name+' '+t.first_name+'</option>';
            });
            $('#room').html(roomHtml);
            $('#teacher').html(teacherHtml);
                let days = result.getDatabyId.days;
                if(days.indexOf('m')>-1){
                    $('#day1').prop('checked', true);
                }
                else{
                    $('#day1').prop('checked', false);
                }
                if(days.indexOf('t')>-1){
                    $('#day2').prop('checked', true);
                }
                else{
                    $('#day2').prop('checked', false);
                }
                if(days.indexOf('w')>-1){
                   
                    $('#day3').prop('checked', true);
                }
                else{
                    $('#day3').prop('checked', false);
                }
                if(days.indexOf('th')>-1){
                    $('#day4').prop('checked', true);
                }
                else{
                    $('#day4').prop('checked', false);
                }
                if(days.indexOf('f')>-1){
                    $('#day5').prop('checked', true);
                }
                else{
                    $('#day5').prop('checked', false);
                }
                if(days.indexOf('s')>-1){
                    $('#day6').prop('checked', true);
                }
                else{
                    $('#day6').prop('checked', false);
                }
        })

    });

    // submit updates and save to database
    $('#editScheduleForm').submit(function(e) {
        e.preventDefault();
        //if data is valid call function to run
        updateData()
    });

    function updateData() {
        // Do something here if validation is passed.
      let form_data = $("#editScheduleForm").serialize();

      $.ajax({
          url: page_route+"/"+id,
          type: 'PUT',
          data: form_data
      })
      .done(function() {
          alertSuccess('Updated') //calls function alertSuccess in public\js\main.js
          $("#editScheduleForm")[0].reset();
          $('#editScheduleModal').modal('hide');
          alertSuccess('Update');
      })
      .fail(function(response) {
          alertFailed('Update')
      })

  }
});
