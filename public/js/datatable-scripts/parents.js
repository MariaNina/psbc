$(function(){

    // server side datatable
    let table = $('#filtertable').DataTable({
        dom: 'Blfrtip',
        buttons: [
            {
                extend: 'print',
            
            },
            {
                extend: 'excelHtml5',
                autoFilter: true,
                sheetName: 'Exported data',
                title: 'PSBC List of Guardians',
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
                data: "first_name",
                name: "first_name",
            },
            {
                data: "last_name",
                name: "last_name",
            },
            {
                data: "middle_name",
                name: "middle_name",
            },
            {
                data: "address",
                name: "address",
            },
            {
                data: "contact_number",
                name: "contact_number",
            },
            {
                data: "action",
                name: "action",
                orderable: false,
            },
        ],
       
      });
      table.on('order.dt search.dt', function() {
        table.column(0, { search: 'applied', order: 'applied' }).nodes().each(function(cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();

})