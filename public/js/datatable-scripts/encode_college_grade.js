$(function(){
    $(".js-example-basic-single").select2({
        placeholder:'No selected',
        theme: "bootstrap4",
    });
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
                title: 'PSBC List of Sections',
            },
        ],
        "responsive": true,
        "pageLength": 10,
        "prowNumcessing":true,
        "serverSide": true, 
        ajax: {
            url: window.location.href, // Route of Controller with DataTables Yajra
        },
        columns: [
            {
                data: 'DT_RowIndex', 
                name: 'DT_RowIndex', 
                orderable: false, 
                searchable: false,
                },
            {
                data: "student_name",
                name: "student_name",
                
            },
            {
                data: "grade",
                name: "grades.grade",
            },
            {
                data: "action",
                name: "action",
                orderable: false,
            },
        ],
       
      })

})