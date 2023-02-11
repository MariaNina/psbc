$(function(){

    // server side datatable
    var tbl = $('#filtertable').DataTable({
        dom: 'tlfripB',
        buttons: [
            {
                extend: 'print',
            
            },
            {
                extend: 'excelHtml5',
                autoFilter: true,
                sheetName: 'Exported data',
                title: 'PSBC List of Student Attendance',
            },
        ],
        "responsive": true,
        "pageLength": 5,
        "processing":true,
        "serverSide": true, 
        ajax: {
            url: window.location.href, // Route of Controller with DataTables Yajra
        },
        columns: [
            {
                data: "student_name",
                name: "student_attendance.student_name",
            },
            {
                data: "lrn", 
                name: "student_attendance.lrn",
            },
            {
                data: "department", 
                name: "student_attendance.department",
            },
            {
                data: "created_at",
                name: "student_attendance.created_at",
            },
            {
                data: "status",
                name: "student_attendance.status",
                render: (status) => {
                    return `<span class="mode ${
                        status === 1 ? "mode_on" : "mode_danger"
                    }">${status === 1 ? "Logged In" : "Logged Out"
                    }</span>`;
                },
            },
        ],
       
      })

});

