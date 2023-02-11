$(function() {
    // server side datatable
    $('#filtertable').DataTable({
        dom: 'Blfrtip',
        buttons: [{
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
        columns: [    {
            data: 'DT_RowIndex', 
            name: 'DT_RowIndex', 
            orderable: false, 
            searchable: false
            },

            {
                data: "user_name",
                name: "users_tbls.user_name"
            },
            {
                data: "student_type",
                name: "students_tbls.student_type",
            },
            {
                data: "lrn",
                name: "lrn",
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
                data: "is_active",
                name: "users_tbls.is_active",
                render: (is_active) => {
                    return `<span class="mode ${
                        is_active === 1 ? "mode_on" : "mode_done"
                    }">${is_active === 1 ? "active" : "inactive"
                    }</span>`;
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