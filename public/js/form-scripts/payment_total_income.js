$(document).ready(function () {

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    let level = '';

    $('html').on('change', '#levels', function () {
        level = $(this).val();
    });

    function getTotalIncome() {
        $.ajax({
            url: `/payments/total`,
            type: "POST",
            data: {
                date: $('#date').val(),
                level: level
            },
            success: function (response) {
                $('#total_income').html(`<span>₱ ${response.totalIncome}</span>`);
            },
            error: function (err) {
                console.error(err);
            },
        });
    }

    $('#filter_date').click(function () {
        let date = $('#date').val();

        if (date === '') {
            date = 'none'
        }

        console.log(date)
        console.log(level)

        // if (date.length !== 0) {

        $('#filtertable').DataTable().clear().destroy();

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
            ajax: {
                url: `/payments_filter/${date}/level/${level}`, // Route of Controller with DataTables Yajra
            },
            columns: [
                {
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

        getTotalIncome();


    });

    // Empty Fields
    $('#refresh').click(function () {
        $('#date').val("");
        level = ''

        $('#filtertable').DataTable().clear().destroy();

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
            ajax: {
                url: `/payments`, // Route of Controller with DataTables Yajra
            },
            columns: [
                {
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

        getTotalIncome();
    });
});
