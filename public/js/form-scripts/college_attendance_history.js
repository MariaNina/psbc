$(function() {
    
    Date.prototype.addDays = function(days) {
        var dat = new Date(this.valueOf())
        dat.setDate(dat.getDate() + days);
        return dat;
    }
 
    function getDates(startDate, stopDate) {
       var dateArray = new Array();
       var currentDate = startDate;
       while (currentDate <= stopDate) {
         dateArray.push(currentDate)
         currentDate = currentDate.addDays(1);
       }
       return dateArray;
     }
     let id = '';
    // get data by id from schoolyear edit
    $('body').on('click', '.editData', function(e) {
        // e.preventDefault();
        id = $(this).data('id');
        // console.log(id)
        let cutoff = $('#cutoff').val();
        let _token  = $('meta[name="csrf-token"]').attr('content'); 
        $.ajax({
            url: "college_attendance_histories/" + id + "/edit",
            type: "GET",
            data: {
                cutoff: cutoff,
                _token: _token,
            },
            success: function(result) {
                // display data to updateBranchForm
                $('#collegeAttendanceModal').modal('show');
                
                let start_date = result.cutoffDetails.start_date;
                let end_date = result.cutoffDetails.end_date;
                let cutoff_id = result.cutoffDetails.id;
                let salary_amount = result.salaryDetails.salary_amount;
                let salary_classification = result.salaryDetails.salary_classification;

                if(salary_classification == 'daily'){
                    salary_amount = (salary_amount/8);
                }
                if(salary_classification == 'hourly'){
                    salary_amount = salary_amount;
                }
                if(salary_classification == 'monthly'){
                    salary_amount = (salary_amount/20)/8;
                }
                $('#salary_amount').val(salary_amount);
                $('#cutoff_id').val(cutoff_id);
                var table_rows = '';
                if (!result.getDataById[0]) {
                  
                    var dateArray = getDates(new Date(start_date), new Date(end_date));
                  
                    for (i = 0; i < dateArray.length; i ++ ) {
                        table_rows += '<tr>';
                        table_rows += '<td><input class="attendance_date" type="hidden" name="attendance_date[]" value="'+moment(dateArray[i]).format('YYYY-MM-DD')+'"/>'+moment(dateArray[i]).format('MM/DD/YYYY')+'</td>';
                        table_rows += '<td>'+moment(dateArray[i]).format('ddd')+'</td>';
                        table_rows += '<td><input class="work_hours" data-id="'+i+'" type="number" name="work_hours[]"/></td>';
                        table_rows += '<td><input class="rate_'+i+'" data-id="'+i+'" type="number" name="rate[]" readonly/></td>';
                        table_rows += '</tr>';
                     
                    }
                
                } else {
                
                    for (var i = 0; i < result.getDataById.length; i++) {
                        table_rows += '<tr>';
                        table_rows += '<td><input class="attendance_date" type="hidden" name="attendance_date[]" value="'+moment(result.getDataById[i].attendance_date).format('YYYY-MM-DD')+'"/>'+moment(result.getDataById[i].attendance_date).format('MM/DD/YYYY')+'</td>';
                        table_rows += '<td>'+moment(result.getDataById[i].attendance_date).format('ddd')+'</td>';
                        table_rows += '<td><input class="work_hours" data-id="'+i+'" type="number" name="work_hours[]" value="'+result.getDataById[i].hours+'"/></td>';
                        table_rows += '<td><input class="rate_'+i+'" data-id="'+i+'" type="number" name="rate[]" value="'+result.getDataById[i].rate+'" readonly/></td>';
                        table_rows += '</tr>';
                     
                    }
                    
                }
                $('.table_body').html(table_rows)

            }
        });
    });

    $('body').on('change keyup', '.work_hours', function(e) { 
        let rate_id = ".rate_"+$(this).data('id');
        let salary_amount = $('#salary_amount').val();
        let work_hours = $(this).val();
        let rate = salary_amount * work_hours;
    
        $(rate_id).val(rate)

    });

    
    // submit updates and save to database
    $('#updateCollegeAttendance').submit(function(e) {
    e.preventDefault();
        //if data is valid call function to run
        updateData()
    });

    function updateData() {
        // Do something here if validation is passed.
      let form_data = $('#updateCollegeAttendance').serialize(); 

      $.ajax({
          url: "college_attendance_histories/"+id,
          type: 'PUT',
          data: form_data
      })
      .done(function() {
          alertSuccess('Updated') //calls function alertSuccess in public\js\main.js
          $('#updateCollegeAttendance')[0].reset();
          $('#collegeAttendanceModal').modal('hide');
      })
      .fail(function() {
          alertFailed('Update')
      })
          
    }
})