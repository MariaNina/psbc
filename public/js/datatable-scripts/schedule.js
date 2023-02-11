$(function () {

    //tabs
    var roomTab = '';
    let rowNum = '';
    var test = 0;
    var i = 0;
    var j = i;
    var tbl;
    $(document).ready(function () {
        // For Tabs
        $(".js-example-basic-single").select2({
            placeholder: 'No selected',
            theme: "bootstrap4",
        });

        $(".filter-select").select2({
            placeholder: 'Teachers',
            theme: "bootstrap4",
        });

        $(".nav-tabs a").click(function () {
            $(this).tab('show');
            $.ajax({
                url: '/all_datas',
                async: false,
                type: "GET",
            });
            roomTab = $(this).attr("id");
            $("#submitBtn" + roomTab + "").hide();

            $(".js-example-basic-single").select2({
                placeholder: 'No selected',
                theme: "bootstrap4",
            });
            console.log(roomTab);
            $('#filtertable' + roomTab).DataTable().destroy();
            tbl = $('#filtertable' + roomTab).DataTable({

                dom: 'Blfrtip',
                buttons: [
                    {
                        extend: 'print',

                    },
                    {
                        extend: 'excelHtml5',
                        autoFilter: true,
                        sheetName: 'Exported data',
                        title: 'Section Schedule',
                    },
                ],
                "responsive": true,
                "paging": false,
                "pageLength": 20,
                "processing": true,
                "serverSide": true,
                ajax: {
                    url: window.location.href, // Route of Controller with DataTables Yajra
                },
                columns: [
                    {
                        data: "time",
                        name: "schedules_tbls.start_time",
                    },
                    {
                        data: "days",
                        name: "schedules_tbls.days",
                    },
                    {
                        data: "section",
                        name: "sections_tbls.section_label"
                    },
                    {
                        data: "subject",
                        name: "subject_tbls.subject_name"
                    },
                    {
                        data: "teacher",
                        name: "staffs_tbls.last_name",
                    },
                    {
                        data: "room",
                        name: "room_tbls.room_no",
                        visible: false,
                    },
                    {
                        data: "action",
                        name: "action",
                        orderable: false,
                    }
                ],

            });
            tbl.columns([5, 6]).search(roomTab).draw();
        });

    });
//append
    let rowBody = '';
    let sectionList = '';
    let teacherList = '';
    let subjectList = '';
    $('body').on('click', '.addInput', function (e) {
        i++;
        console.log(i);
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
        rowBody += '    <select required name="subject[]" id="subject' + i + '" class="form-control js-example-basic-single" title="No selected year">'
        rowBody += '        <option value=""></option>'
        rowBody += '   </select>'
        rowBody += ' </td>'
        rowBody += ' <td>'
        rowBody += '    <select required name="teacher[]" id="teacher' + i + '" class="form-control js-example-basic-single" title="No selected year">'
        rowBody += '        <option value=""></option>'
        rowBody += '  </select>'
        rowBody += '</td>'
        rowBody += ' <td>'
        rowBody += ' <button class="btn btn-danger remove_btn" id="' + i + '" type="button"><i class="fas fa-minus"></i></button>'
        rowBody += ' </td>'
        rowBody += '</tr>';
        $("#submitBtn" + roomTab + "").show();
        let _token = $('meta[name="csrf-token"]').attr('content');
        $("#inputBody" + roomTab + "").append(rowBody);

        //get all teachers
        $.ajax({
            url: '/all_datas',
            async: false,
            type: "GET",
            success: (resp) => {
                const datas = resp;
                console.log(datas.teachers);
                datas.section.forEach(sectionName => {
                    sectionList += "<option value='" + sectionName.id + "'>" + sectionName.section_label + "</option>";
                });

                datas.subjects.forEach(subjectName => {
                    subjectList += "<option value='" + subjectName.id + "'>" + subjectName.subject_code + " : " + subjectName.subject_name + "</option>";
                });

                datas.teachers.forEach(teacherName => {
                    teacherList += "<option value='" + teacherName.id + "'>" + teacherName.last_name + ", " + teacherName.first_name + "</option>";
                });
                $("#section" + i + "").append(sectionList);
                $("#subject" + i + "").append(subjectList);
                $("#teacher" + i + "").append(teacherList);

            },
            error: (err) => {
                console.log("erroe");
                Swal.fire({
                    icon: "error",
                    title: "Failed",
                    text: "Something went wrong! Please try again later",
                });
            },
        });
        sectionList = '';
        teacherList = '';
        subjectList = '';
        rowBody = '';
        $(".js-example-basic-single").select2({
            placeholder: 'No selected',
            theme: "bootstrap4",
        });

    });


    $('body').on('click', '.subm', function (e) {
        // $("#ScheduleForm"+roomTab+"").submit(function (e) {
        e.preventDefault();
        let form_array = $("#ScheduleForm" + roomTab + "").serializeArray();
        // console.log(form_array)
        // console.log(roomTab)
        $.ajax({
            url: '/schedule',
            async: false,
            type: "POST",
            data: form_array,
            success: (resp) => {
                Swal.fire({
                    icon: "success",
                    title: "Successfully!!",
                    text: "The Schedule you added to this room has successfully added",
                }).then(() => {
                    tbl.ajax.reload();
                    $(this).hide();
                })
            },
            error: (err) => {
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
        // });
    });
    //remove fields
    $('body').on('click', '.remove_btn', function (e) {
        var buttonId = $(this).attr("id");
        $("#row" + buttonId + "").remove();
        // i--;
    });

    // server side datatable
    test = $(".room_no").val();
    console.log(test);
    $(".js-example-basic-single").select2({
        placeholder: 'No selected',
        theme: "bootstrap4",
    });

    $('body').on('click', '.delete_row', function (e) {
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
                var id = $(this).data('id');
                let _token = $('meta[name="csrf-token"]').attr('content');
                console.log(id);
                $.ajax({
                    url: "schedule/" + id,
                    type: "DELETE",
                    data: {
                        _token: _token,
                    },
                    success: function (data) {
                        alertSuccess('Deleted') //calls function alertSuccess in public\js\main.js
                        tbl.ajax.reload() //reloads the school year datatable
                    },
                    error: function (xhr, status, errorThrown) {
                        alertFailed('Deactivate')  //calls function alertFailed in public\js\main.js
                    }
                });
            }
        });
    });


    // Test
    $('.filter-input').keyup(function () {
        tbl.column($(this).data('column'))
            .search($(this).val())
            .draw();
    });


    $('.filter-select').change(function () {
        tbl.column($(this).data('column'))
            .search($(this).val())
            .draw();
    });


})
