$(function(){
    let cur_des = $('#cur_des').text();
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
                title: `PSBC List of ${cur_des}`,
            },
        ],
        "responsive": true,
        "pageLength": 10,
        "processing":true,
        "serverSide": true, 
        ajax: {
            url: window.location.href, // Route of Controller with DataTables Yajra
        },
        columns: [
            {
                data: 'DT_RowIndex', 
                name: 'DT_RowIndex', 
                orderable: false, 
                searchable: false
                },
            {
                data: "term_name",
                name: "terms_tbls.term_name", 
            },
            {
                data: "subjectName",
                name: "subject_tbls.subject_name",
            },
            {
                data: "preReqSubjectName",
                name: "subject_tbls.subject_name",
            },
            {
                data: "is_offered",
                name: "is_offered",
                render: (is_offered) => {
                    return `<span class="mode ${
                        is_offered === 1 ? "mode_on" : "mode_off"
                    }">${is_offered === 1 ? "Yes" : "No"
                    }</span>`;
                },
            },
            {
                data: "is_active",
                name: "is_active",
                render: (is_active) => {
                    return `<span class="mode ${
                        is_active === 1 ? "mode_on" : "mode_off"
                    }">${is_active === 1 ? "Open" : "Close"
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