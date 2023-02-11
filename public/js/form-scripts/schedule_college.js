$(function () {
    // Form Scripts Folder

    $(".filter-select").select2({
        placeholder: 'Teachers',
        theme: "bootstrap4",
    });

    let subjectId;

    $(".nav-tabs a").click(function (e) {

        $(this).tab('show'); // Change Tab

        subjectId = e.target.id; // subject Id or tab

        schedDatatable(subjectId);

        $("#submitBtn_" + subjectId).hide();

    });

    let i = 0;
    let j = i;
    let tbl;

    //append
    let rowBody = '';
    let sectionList = '';
    let teacherList = '';
    let subjectList = '';
    let roomList = '';

    let myTbl;

    // Add Input Field
    $('body').on('click', '.addInput', function (e) {

        i++;
        j = i - 1;

        rowBody += '<tr class="rowInput" id="row' + i + '">';
        rowBody += '<td>Start<input class="form-control" type="time" name="startTime[]" required id="startTime' + i + '">End<input class="form-control" required type="time" name="endTime[]" id="endTime' + i + '"></td>';
        rowBody += '<td> <div class="form-check form-check-inline"><input name="M[]" class="form-check-input" id="M' + i + '" type="checkbox" value="M"><label class="form-check-label">M</label></div>'
        rowBody += '<div class="form-check form-check-inline">'
        rowBody += ' <input class="form-check-input" name="T[]" id="T' + i + '" type="checkbox" value="T">'
        rowBody += ' <label class="form-check-label">T</label>'
        rowBody += ' </div>'
        rowBody += ' <div class="form-check form-check-inline">'
        rowBody += ' <input class="form-check-input" name="W[]" id="W' + i + '" type="checkbox" value="W">'
        rowBody += '   <label class="form-check-label">W</label>'
        rowBody += '    </div><br/>'
        rowBody += '  <div class="form-check form-check-inline">'
        rowBody += ' <input class="form-check-input" name="TH[]" id="TH' + i + '" type="checkbox" value="TH">'
        rowBody += '<label class="form-check-label">TH</label>'
        rowBody += ' </div>'
        rowBody += ' <div class="form-check form-check-inline">'
        rowBody += '  <input class="form-check-input" name="F[]" id="F' + i + '" type="checkbox" value="F">'
        rowBody += ' <label class="form-check-label">F</label>'
        rowBody += '  </div>'
        rowBody += ' <div class="form-check form-check-inline">'
        rowBody += ' <input class="form-check-input" name="S[]" id="S' + i + '" type="checkbox" value="S">'
        rowBody += '   <label class="form-check-label">S</label>'
        rowBody += '   </div>'
        rowBody += '</td>'
        rowBody += '<td>'
        rowBody += '    <select required name="section[]" id="section' + i + '" class="form-control js-example-basic-single" title="No selected year">'
        rowBody += '       <option value=""></option>'
        rowBody += '  </select>'
        rowBody += ' </td>'
        rowBody += ' <td>'
        rowBody += '    <select required name="teacher[]" id="teacher' + i + '" class="form-control js-example-basic-single" title="No selected year">'
        rowBody += '        <option value=""></option>'
        rowBody += '  </select>'
        rowBody += '</td>'
        rowBody += ' <td>'
        rowBody += '    <select required name="roomNumber[]" id="roomNumber' + i + '" class="form-control js-example-basic-single" title="No selected room">'
        rowBody += '        <option value=""></option>'
        rowBody += '  </select>'
        rowBody += '</td>'
        rowBody += ' <td>'
        rowBody += '    <select required name="term[]" id="term' + i + '" class="form-control js-example-basic-single" title="No selected room">'
        rowBody += '        <option value="1">1st</option><option value="2">2nd</option><option value="4">Summer</option>'
        rowBody += '  </select>'
        rowBody += '</td>'
        rowBody += ' <td>'
        rowBody += ' <button class="btn btn-danger remove_btn" id="' + i + '" type="button"><i class="fas fa-minus"></i></button>'
        rowBody += ' </td>'
        rowBody += '</tr>';

        $("#submitBtn_" + subjectId).show();
        $("#inputBody_" + subjectId).append(rowBody); // Add/Show the form in table

        // After showing the form, populate with values from the database
        $.ajax({
            url: '/all_datas/college',
            async: false,
            type: "GET",
            success: (resp) => {

                const datas = resp;

                console.log(datas);

                datas.section.forEach(sectionName => {
                    sectionList += "<option value='" + sectionName.id + "'>" + sectionName.section_label + "</option>";
                });

                datas.subjects.forEach(subjectName => {
                    subjectList += "<option value='" + subjectName.id + "'>" + subjectName.subject_code + " : " + subjectName.subject_name + "</option>";
                });

                datas.teachers.forEach(teacherName => {
                    teacherList += "<option value='" + teacherName.id + "'>" + teacherName.last_name + ", " + teacherName.first_name + "</option>";
                });

                datas.rooms.forEach(room => {
                    roomList += "<option value='" + room.id + "'>" + room.room_no + "</option>";
                });

                $("#section" + i + "").append(sectionList);
                $("#subject" + i + "").append(subjectList);
                $("#teacher" + i + "").append(teacherList);
                $("#roomNumber" + i + "").append(roomList);

                // For Bootstrap Select2 Styling
                $(".js-example-basic-single").select2({
                    placeholder: 'No selected',
                    theme: "bootstrap4",
                });


            },
            error: () => {
                Swal.fire({
                    icon: "error",
                    title: "Failed",
                    text: "Something went wrong! Please try again later",
                });
            },

        });

        // Reset -- Avoid duplicate data when adding more fields
        sectionList = '';
        teacherList = '';
        subjectList = '';
        rowBody = '';
        roomList = '';


    });

    // Remove Input Field
    $('body').on('click', '.remove_btn', function (e) {
        let buttonId = $(this).attr("id");
        $("#row" + buttonId + "").remove();
    });

    // Submit Input Fields To Server side
    $('body').on('click', '.subm', function (e) {

        e.preventDefault();

        let form_array = $("#ScheduleForm_" + subjectId + "").serializeArray(); // Form Data

        $.ajax({
            url: '/college_schedule',
            type: "POST",
            data: form_array,
            success: () => {

                Swal.fire({
                    icon: "success",
                    title: "Successfully!!",
                    text: "The Schedule you added to this room has successfully added",
                });

                reloadDatatable(subjectId);
            },
            error: (err) => {
                console.log(err);
                let text = err.responseJSON.message;
                console.log(text);
                if (text.includes("Invalid datetime format")) {
                    Swal.fire({
                        icon: "error",
                        title: "Missing Information",
                        text: "Please check all required data, There's some input that you missed",
                    });
                } else if (text.includes("schedules_tbls_room_days_time_unique")) {
                    Swal.fire({
                        icon: "error",
                        title: "Conflict Information",
                        text: "Room not available on this day and time on one of your entry",
                    });
                } else if (text.includes("schedules_tbls_teacher_days_time_unique")) {
                    Swal.fire({
                        icon: "error",
                        title: "Conflict Information",
                        text: "Teacher not available on this day and time on one of your entry",
                    });
                } else if (text.includes("schedules_tbls_section_days_time_unique")) {
                    Swal.fire({
                        icon: "error",
                        title: "Conflict Information",
                        text: "The section you selected for one of your entry have already scheduled on the day and time you picked ",
                    });
                } else if (text.includes("schedules_tbls_section_subject_unique")) {
                    Swal.fire({
                        icon: "error",
                        title: "Conflict Information",
                        text: "Duplicate subject of same section for one of your entry",
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Server Error",
                        text: "Something went wrong",
                    });
                }

            }
        });

    });


    // For Deleting Data From Datatable
    $('body').on('click', '.delete_row', function (e) {

        e.preventDefault();
        let id = $(this).attr("id");

        Swal.fire({
            title: "Are you sure?",
            text: "Are you sure you want to delete this item?",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes",
        }).then((result) => {
            if (result.isConfirmed) {
                console.log(id);
                $.ajax({
                    url: "/college_schedule/" + id,
                    type: "DELETE",
                    success: function (res) {
                        alertSuccess(res.msg)
                        reloadDatatable(subjectId);
                    },
                    error: function (xhr, status, errorThrown) {
                        alertFailed('Deactivate')
                    }
                });
            }
        });


    });


    // Show Data in Datatable
    const schedDatatable = (id) => {
        const tableOpt = {
            responsive: true,
            pageLength: 10,
            processing: true,
            serverSide: true,
            fixedHeader: true,
            ajax: {
                url: "/college_schedule/datatable/" + id, // Route of Controller with DataTables Yajra
            },
            columns: [
                {
                    data: "time",
                    name: "time",
                },
                {
                    data: "days",
                    name: "days",
                },
                {
                    data: "section",
                    name: "section",
                },
                {
                    data: "instructor",
                    name: "instructor",
                },
                {
                    data: "room",
                    name: "room",
                },
                {
                    data: "term",
                    name: "term",
                },
                {
                    data: "action",
                    name: "action",
                    orderable: false,
                    ordering: false,
                },
            ],
        };
        let table = "#filtertable_" + id;

        $(table).DataTable().destroy();
        myTbl = $(table).DataTable(tableOpt);


        return myTbl;

    }

    // For Reloading Datatable
    const reloadDatatable = (id) => {
        let table = "#filtertable_" + id;
        $(table).DataTable().ajax.reload();
    }

    $('.filter-select').change(function () {
        myTbl.column($(this).data('column'))
            .search($(this).val())
            .draw();
    });
})
