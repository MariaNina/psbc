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
                title: 'PSBC List of Employees',
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
                searchable: false
                },
            {
                data: "images",
                name: "images",
            },
            {
                data: "user_fullname"
            },
            {
                data: "bio_id",
                name: "bio_id",
            },
            {
                data: "csc_id",
                name: "csc_id",
            },
            {
                data: "staff_type",
                name: "staff_type",
            },
            {
                data: "position",
                name: "position",
            },
            {
                data: "Department",
                name: "Department",
            },
            {
                data: "subject_name",
                name: "subject_tbls.subject_name",
            },
            {
                data: "is_masteral",
                name: "is_masteral",
            },
            {
                data: "licence_number",
                name: "licence_number",
            },
            {
                data: "birth_day",
                name: "birth_day",
            },
            {
                data: "birth_place",
                name: "birth_place",
            },
            {
                data: "gender",
                name: "gender",
            },
            {
                data: "civil_status",
                name: "civil_status",
            },
            {
                data: "height_m",
                name: "height_m",
            },
            {
                data: "weight_kg",
                name: "weight_kg",
            },
            {
                data: "blood_type",
                name: "blood_type",
            },
            {
                data: "gsis",
                name: "gsis",
            },
            {
                data: "sss",
                name: "sss",
            },
            {
                data: "phil_health",
                name: "phil_health",
            },
            {
                data: "pagibig",
                name: "pagibig",
            },
            {
                data: "tin",
                name: "tin",
            },
            {
                data: "agency_employee_no",
                name: "agency_employee_no",
            },
            {
                data: "citizenship",
                name: "citizenship",
            },
            {
                data: "address",
                name: "address",
            },
            {
                data: "zip_code",
                name: "zip_code",
            },
            {
                data: "telephone_number",
                name: "telephone_number",
            },
            {
                data: "mobile_number",
                name: "mobile_number",
            },
            {
                data: "action",
                name: "action",
                orderable: false,
            },
        ],
       
      })

})