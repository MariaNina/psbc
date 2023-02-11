$(function () {

     $.ajaxSetup({
         headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
     });

    $('#showDepedGradeBtn').click(function() {

        $.ajax({
            url: '/grade_settings/toggle_showing_deped_grade',
            type: 'POST',
            data: {
             '_method': 'PUT'
            },
            success:function() {
                Swal.fire({
                  icon: 'success',
                  showCloseButton: true,
                  title: 'Updated',
                  text:  'Your changes has been saved',
                  showConfirmButton: true,
                  timer: 5000,
                  didClose: reloadPage
                })

            },
            error: function() {
               Swal.fire("Error" ,"Something went wrong, try again later", "error");
            }
        });

    });

    $('#showChedGradeBtn').click(function() {

        $.ajax({
            url: '/grade_settings/toggle_showing_ched_grade',
            type: 'POST',
            data: {
             '_method': 'PUT'
            },
            success:function() {
                Swal.fire({
                  icon: 'success',
                  showCloseButton: true,
                  title: 'Updated',
                  text:  'Your changes has been saved',
                  showConfirmButton: true,
                  timer: 5000,
                  didClose: reloadPage
                })

            },
            error: function() {
               Swal.fire("Error" ,"Something went wrong, try again later", "error");
            }
        });

    });

       function reloadPage(){
           window.location.reload();
       }

});
