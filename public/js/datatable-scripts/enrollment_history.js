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
                title: 'PSBC List of Payments',
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
                data: "application_no",
                name: "application_no",
            },
            {
                data: "student_department",
                name: "student_department",
            },
            {
                data: "STATUS",
                name: "STATUS",
                render: (status) => {
                    return `<span class="mode ${
                        status === 'Enrolled' ? "mode_on" : "mode_off"
                    }">${status}</span>`;
                },
            },
            {
                data: "action",
                name: "action",
                orderable: false,
                ordering: false,
            }
        ],

    })

})