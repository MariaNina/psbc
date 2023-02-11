$(function () {

    function GetFromDate() {
        let from_date = $('#salary_date').val();
        return from_date;
    }
    // server side datatable
    $('#filtertable').DataTable({
        dom: '<"toolbar">Blfrtip',
        buttons: [
            {
                extend: 'print',
                customize: function(win)
            {
 
                var last = null;
                var current = null;
                var bod = [];
 
                var css = '@page { size: landscape; }',
                    head = win.document.head || win.document.getElementsByTagName('head')[0],
                    style = win.document.createElement('style');
 
                style.type = 'text/css';
                style.media = 'print';
 
                if (style.styleSheet)
                {
                  style.styleSheet.cssText = css;
                }
                else
                {
                  style.appendChild(win.document.createTextNode(css));
                }
 
                head.appendChild(style);
         },
                title: '<center><img src="/img/logo.png" width="75" height="75"><h5>Paete Science Business College<br>Payslip Summary<br>Coverage:'+$("#salary_date").val().split(',',2)+' <br>Pay Date:'+$("#salary_date").val().split(',',1)+'</h5></center>',
                exportOptions: {
                    columns: [ 0, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18]              
                  }
                  

            },
            {
                extend: 'excelHtml5',
                autoFilter: true,
                sheetName: 'Exported data',               
                 exportOptions: {
                    columns: [ 0, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18]            
                    }

            },
            
        ],
        
        "responsive": true,
        "pageLength": 10,
        "processing": true,
        "serverSide": true,
        ajax: {
            url: window.location.href, // Route of Controller with DataTables Yajra
            data: function(d) {
            d.payday = GetFromDate();
            }
        },
        columns: [
            {
                data: "DT_RowIndex",
            },
            {
                data: "payday",
                name: "cut_offs.pay_day",
                //visible: false
            },
            {
                data: "employee_name",
                name: "staffs_tbls.last_name",
            },
            {
                data: "basic_pay",
                name: "basic_pay",
            },
            {
                data: "daily_rate",
                name: "daily_rate",
            },
            {
                data: "required_days",
                name: "required_days",
            },
            {
                data: "semi_monthly_pay",
                name: "semi_monthly_pay",
            },
            {
                data: "special_allowance",
                name: "special_allowance",
            },
            {
                data: "gross_pay",
                name: "gross_pay",
            },
            {
                data: "late_undertime",
                name: "late_undertime",
            },
            {
                data: "absence",
                name: "absence",
            },
            {
                data: "canteen",
                name: "canteen",
            },
            {
                data: "tuition_fee",
                name: "tuition_fee",
            },
            {
                data: "cash_advance",
                name: "cash_advance",
            },
            {
                data: "others",
                name: "others",
            },
            {
                data: "sss",
                name: "sss",
            },
            {
                data: "total_deduction",
                name: "total_deduction",
            },
            {
                data: "net_pay",
                name: "net_pay",
            },
            {
                data:"signature",
                name:"signature",
            }
           
     
        ],

    })
    $('#salary_date').change(function() {
        $('#filtertable').DataTable().ajax.reload();
    });

})
