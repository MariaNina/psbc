$(document).ready(function () {
    let level = 'All';

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    function getProgramsByLevel(level){

        $.ajax({
            type: "GET",
            url: "/assessments/get_programs",
            data: {
                level: level
            },
            success: function (response) {
                let html = '<option selected value="All">All</option>';
                response.programs.forEach(p => {
                    html += `<option value="${p.id}">${p.description}</option>`;
                });

                $("#programs").html(html);
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!',
                })
            }
        })
    }
    // $('html').on('change', '#programs', function () {
    //     program = $(this).val();
    //     let level = $("#levels").val();
    //     let branch = $("#branches").val();

    //     $.ajax({
    //         type: "GET",
    //         url: "/assessments/total_balances",
    //         data: {
    //             level: level,
    //             branch: branch,
    //             program: program
    //         },
    //         success: function (response) {
    //             $('#total_balance').html(`<span>₱ ${response.balance}</span>`);
    //         },
    //         error: function () {
    //             Swal.fire({
    //                 icon: 'error',
    //                 title: 'Oops...',
    //                 text: 'Something went wrong!',
    //             })
    //         }
    //     })
    //     $('#filtertable').DataTable().ajax.reload();
    //     // initDataTable(level,branch)
    // });
  $('html').on('change', '#levels', function () {

        level = $(this).val();

        getProgramsByLevel(level);

        // let branch = $("#branches").val();
        // let program = $("#programs").val();
        // $.ajax({
        //     type: "GET",
        //     url: "/assessments/total_balances",
        //     data: {
        //         level: level,
        //         branch: branch,
        //         program: program
        //     },
        //     success: function (response) {
        //         $('#total_balance').html(`<span>₱ ${response.balance}</span>`);
        //     },
        //     error: function () {
        //         Swal.fire({
        //             icon: 'error',
        //             title: 'Oops...',
        //             text: 'Something went wrong!',
        //         })
        //     }
        // })

        // $('#filtertable').DataTable().ajax.reload();
        // initDataTable(level,branch)
    });
    $("#filter-search").click(function(e){

            let branch = $("#branches").val();
            let level = $("#levels").val();
        let program = $("#programs").val();
        $.ajax({
            type: "GET",
            url: "/assessments/total_balances",
            data: {
                level: level,
                branch: branch,
                program: program
            },
            success: function (response) {
                $('#total_balance').html(`<span>₱ ${response.balance}</span>`);
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!',
                })
            }
        });
        $('#filtertable').DataTable().ajax.reload();
    })
//     $('html').on('change', '#branches', function () {
//         branch = $(this).val();
//         let level = $("#levels").val();
//         let program = $("#programs").val();

//         $.ajax({
//             type: "GET",
//             url: "/assessments/total_balances",
//             data: {
//                 level: level,
//                 branch: branch,
//                 program: program
//             },
//             success: function (response) {
//                 $('#total_balance').html(`<span>₱ ${response.balance}</span>`);
//             },
//             error: function () {
//                 Swal.fire({
//                     icon: 'error',
//                     title: 'Oops...',
//                     text: 'Something went wrong!',
//                 })
//             }
//         })
// $('#filtertable').DataTable().ajax.reload();
//         // initDataTable(level,branch)
//     });

    const initDataTable = (level,branch,program) => {
        $('#filtertable').DataTable().clear().destroy(); // Clear and Destroy Datatable

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
                    title: 'PSBC List of Assessments',
                },
            ],
            "responsive": true,
            "pageLength": 10,
            "processing": true,
            "serverSide": true,
            ajax: {
                url: `/assessments/${level}/${branch}/${program}`, // Route of Controller with DataTables Yajra
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
                // {
                //     data: "payment_type",
                //     name: "payment_type",
                // },
                {
                    data: "student_department",
                    name: "student_department",
                },
                      {
                    data: "description",
                    name: "description",
                },
                {
                    data: "status",
                    name: "assessments_tbls.status",
                    render: (status) => {
                        return `<span class="mode ${
                            status === 'paid' ? "mode_on" : status === 'rejected' ? "mode_off" : "mode_done"
                        }">${status.charAt(0).toUpperCase() + status.slice(1)}</span>`;
                    },
                },
                {
                    data: "action",
                    name: "action",
                    orderable: false,
                },
            ],

        }) // Initialize again

        // Create our number formatter.
        var formatter = new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'PHP',

            // These options are needed to round to whole numbers if that's what you want.
            //minimumFractionDigits: 0, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
            //maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
        });
    }
});
