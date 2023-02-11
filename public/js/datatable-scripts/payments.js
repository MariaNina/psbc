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
                title: 'PSBC List of Payments',
            },
        ],
        "responsive": true,
        "pageLength": 10,
        "processing": true,
        "serverSide": true,
        // "order": [[8, 'desc']],
        ajax: {
            url: window.location.href, // Route of Controller with DataTables Yajra
        },
        columns: [
            {
                data: 'DT_RowIndex', //DT_RowIndex
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {
                data: "branch_name",
                name: "branch_tbls.branch_name"
            },
            {
                data: "department",
                name: "assessments_tbls.student_department"
            },
            {
                data: "full_name",
                name: "users_tbls.full_name"
            },
            {
                data: "payment_method",
                name: "payment_method",
            },
            {
                data: "payment_type",
                name: "payment_type",
            },
            {
                data: "payment_amount",
                name: "payment_amount",
            },
            {
                data: "or_number",
                name: "or_number",
            },
            {
                data: "created_at",
                name: "created_at",
            },
            {
                data: "encoded_by",
                name: "encoded_by",
            },
            {
                data: "is_approved",
                name: "is_approved",
                render: (is_approved) => {
                    return `<span class="mode ${
                        is_approved === 1 ? "mode_on" : "mode_off"
                    }">${is_approved === 1 ? "Approved" : "For Approval"
                    }</span>`;
                },
            },
            {
                data: "action",
                name: "action",
                orderable: false,
                searchable: false
            },
        ],

    })

})
