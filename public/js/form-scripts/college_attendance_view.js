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
    viewTimeSheet();
    // get data by id from schoolyear edit
    $('#cutoff').on('change', function(e) {

        viewTimeSheet();
    });

    function viewTimeSheet() {
        // console.log(id)
        let cutoff = $('#cutoff').val();
        let _token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: "",
            type: "POST",
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

                if (salary_classification == 'daily') {
                    salary_amount = (salary_amount / 8);
                }
                if (salary_classification == 'hourly') {
                    salary_amount = salary_amount;
                }
                if (salary_classification == 'monthly') {
                    salary_amount = (salary_amount / 20) / 8;
                }
                $('#salary_amount').val(salary_amount);
                $('#cutoff_id').val(cutoff_id);

                let total_hours_rendered = 0;
                let total_rate = 0;
                var table_rows = '';
                if (!result.getDataById[0]) {

                    var dateArray = getDates(new Date(start_date), new Date(end_date));

                    for (i = 0; i < dateArray.length; i++) {
                        table_rows += '<tr>';
                        table_rows += '<td><input class="attendance_date" type="hidden" name="attendance_date[]" value="' + moment(dateArray[i]).format('YYYY-MM-DD') + '"/>' + moment(dateArray[i]).format('MM/DD/YYYY') + '</td>';
                        table_rows += '<td>' + moment(dateArray[i]).format('ddd') + '</td>';
                        table_rows += '<td></td>';
                        table_rows += '<td></td>';
                        table_rows += '</tr>';

                    }

                } else {

                    for (var i = 0; i < result.getDataById.length; i++) {
                        table_rows += '<tr>';
                        table_rows += '<td><input class="attendance_date" type="hidden" name="attendance_date[]" value="' + moment(result.getDataById[i].attendance_date).format('YYYY-MM-DD') + '"/>' + moment(result.getDataById[i].attendance_date).format('MM/DD/YYYY') + '</td>';
                        table_rows += '<td>' + moment(result.getDataById[i].attendance_date).format('ddd') + '</td>';
                        table_rows += '<td>' + ((!parseInt(result.getDataById[i].hours)) ? '' : parseInt(result.getDataById[i].hours)) + '</td>';
                        table_rows += '<td>' + ((!parseInt(result.getDataById[i].rate)) ? '' : parseInt(result.getDataById[i].rate)) + '</td>';
                        table_rows += '</tr>';
                        if (!parseInt(result.getDataById[i].hours)) {

                        } else {
                            total_hours_rendered += parseInt(result.getDataById[i].hours);
                        }
                        if (!parseInt(result.getDataById[i].rate)) {

                        } else {
                            total_rate += parseInt(result.getDataById[i].rate);
                        }
                    }
                    table_rows += '<tr><td></td><td></td><td>Total Hours: ' + total_hours_rendered + '</td><td>Total Rate: ' + total_rate + '</td></tr>';

                }
                $('.table_body').html(table_rows)

            }
        });
    }


})