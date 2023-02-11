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
                title: 'PSBC List of Assessments',
            },
        ],
        "responsive": true,
        "pageLength": 10,
        "processing": true,
        "serverSide": true,
        ajax: {
            url: window.location.href, // Route of Controller with DataTables Yajra
            data: function (d) {
                d.level = $('#levels').val();
                d.branch = $('#branches').val();
                d.program = $('#programs').val();
                d._token = $('meta[name="csrf-token"]').attr("content");
            }
        },
        columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {
                data: "branch_name",
                name: "branch_tbls.branch_name"
            },
            {
                data: "application_no",
                name: "enrollment_tbls.application_no",
            },
            {
                data: "student_fullname",
                name: "student_fullname",

            },
            {
                data: "total_units",
                name: "total_units",
            },
            {
                data: "fee_amount",
                name: "fee_amount",
                render: (fee_amount) => {
                    return formatter.format(fee_amount);
                },
            },
            {
                data: "balance",
                name: "balance",
                orderable: false,
                searchable: false,
            },

            {
                data: "student_department",
                name: "student_department",
            },
              {
                data: "description",
                name: "program_majors_tbls.description",
            },
            {
                data: "status",
                name: "assessments_tbls.status",
                render: (status) => {
                    return `<span class="mode ${
                        status === 'paid' ? "mode_on" : status === 'rejected' ? "mode_off" : "mode_done"
                    }">${status.charAt(0).toUpperCase()+status.slice(1)}</span>`;
                },
            },
            {
                data: "action",
                name: "action",
                orderable: false,
            },
        ],

    })

    // Create our number formatter.
    var formatter = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'PHP',

        // These options are needed to round to whole numbers if that's what you want.
        //minimumFractionDigits: 0, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
        //maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
    });
})
