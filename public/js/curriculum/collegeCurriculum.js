$(document).ready(function () {
    var tbl = $('#filtertable').DataTable({
      dom: 'Blfrtip',
			buttons: [
				{
					extend: 'print',
					// exportOptions: {
					// 	columns: ':visible'
					// },
				},
				{
					extend: 'excelHtml5',
					autoFilter: true,
					sheetName: 'Exported data',
					exportOptions: {
						columns: ':visible'
					},	title: 'PSBC Curriculum List',
				},
				// 'colvis'
			],
      pageLength: 10,
      responsive: true,
      processing: true,  
      serverSide: true, 
        ajax: {
            url: window.location.href, // Route of Controller with DataTables Yajra
        },
        columns: [
            {
                data: "id",
                name: "id",
            },
            {
                data: "cy",
                name: "cy", 
            },
            {
                data: "pname",
                name: "pname",
            },
            {
                data: "mname",
                name: "mname",
            },
            {
                data: "des",
                name: "des",
            },
            {
                data: "std_dept",
                name: "std_dept",
            },
            {
                data: "sy",
                name: "sy",
            },
            {
                data: "action",
                name: "action",
                orderable: false,
            },
        ],
       
    })

    $("#addCurriculumForm").submit(function(e){
        
        let curriculumYear = $("#curriculumYear").val();
        let curriculumDescription = $("#curriculumDescription").val();
        let programMajor = $("#programMajor").val();
        let schoolYear = $("#schoolYear").val();
        let studentDept = "College";
        let _token  = $('meta[name="csrf-token"]').attr('content');
        
        $('#collegeCurriculumModal').modal('hide');

        $.ajax({
          type: "POST",
          data:{
            curriculumYear:curriculumYear,
            curriculumDescription:curriculumDescription,
            programMajor:programMajor,
            schoolYear:schoolYear,
            studentDept:studentDept,
            _token: _token
          },
          success: function(data){
            alertSuccess('Created') //calls function alertSuccess in public\js\main.js
            tbl.ajax.reload() //reloads the school year datatable
          },
          error: function (xhr, status, errorThrown) {
              alertFailed('Create')  //calls function alertFailed in public\js\main.js
          }
        });
        e.preventDefault();
      });
  });