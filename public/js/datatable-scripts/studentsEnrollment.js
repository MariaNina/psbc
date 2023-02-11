$(function () {
    // server side datatable
    $('#filtertable').DataTable({
        dom: 'Blfrtip',
        buttons: [
            {
                extend: 'print',

            },
            {
                extend: 'excelHtml5',
                autoFilter: true,
                sheetName: 'Exported data',
                title: 'PSBC List of Students',
            },
        ],
        "responsive": true,
        "pageLength": 10,
        "processing": true,
        "serverSide": true,
        ajax: {
            url: window.location.href, // Route of Controller with DataTables Yajra
        },
        columns: [
            {
                data: "No",
                name: "No",
            },
            {
                data: "application_no",
                name: "enrollment_tbls.application_no",
            },
            {
                data: "student_type",
                name: "students_tbls.student_type",
            },
            {
                data: "lrn",
                name: "students_tbls.lrn",
            },
            {
                data: "first_name",
                name: "students_tbls.first_name",
            },
            {
                data: "middle_name",
                name: "students_tbls.middle_name",
            },
            {
                data: "last_name",
                name: "students_tbls.last_name",
            },
            {
                data: "email",
                name: "students_tbls.email",
            },
            {
                data: "contact_number",
                name: "students_tbls.contact_number"
            },
            {
                data: "address",
                name: "students_tbls.address"
            },
            {
                data: "student_department",
                name: "enrollment_tbls.student_department"
            },
            {
                data: "program_name",
                name: "programs_tbls.program_name"
            },
            {
                data: "major_name",
                name: "majors_tbls.major_name"
            },
            {
                data: "level_name",
                name: "levels_tbls.level_name"
            },
            {
                data: "app_status",
                name: "application_status_view.STATUS",
                render: (app_status) => {
                    return `<span class="mode ${
                        app_status === "Enrolled" ? "mode_on" : app_status === "Rejected" ? "mode_off" : "mode_done"
                    }">${app_status.replace(/\s/g, '')}</span>`;
                },
            },
            {
                data: "action",
                name: "action",
                orderable: false,
            },
        ],

    })

})
