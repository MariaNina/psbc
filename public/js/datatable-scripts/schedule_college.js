$(document).ready(function () {

    let table;

    /*
    // For Changing Tabs
    $(".nav-tabs a").click(function (e) {
        $(this).tab('show');

        let subjectId = e.target.id; // subject Id

        console.log("datatable- tab id is: " + subjectId);

        $.ajax({
            url: '/college_schedule/datatable',
            async: false,
            type: "GET",
        });

        $('#filtertable_' + subjectId).DataTable().destroy();

        table = $('#filtertable_' + subjectId).DataTable({

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
                url: '/', // Route of Controller with DataTables Yajra
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
        tbl.columns([5, 6]).search(subjectId).draw();

    });
    */

});
