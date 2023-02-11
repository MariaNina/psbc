$(document).ready(function () {


    // Create our number formatter.
    var formatter = new Intl.NumberFormat('en-US', {
    style: 'currency',
    currency: 'PHP',
  
    // These options are needed to round to whole numbers if that's what you want.
    //minimumFractionDigits: 0, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
    //maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
  });
  
      // get data by id from schoolyear edit
      $('body').on('click', '.payFee', function(e) {
        // e.preventDefault();
        id = $(this).data('id');
        console.log(id)
        $.ajax({
            url: "payments/"+id+"/edit",
            type: "GET",
            success: function(result) {
                // display data to updateschoolyearform
                console.log(result);
                $('#addPaymentModal').modal('show');
                let total_fee =  result.assessments_details.fee_amount;
                let branchId = result.branch_id.id;
                let total_payment_received =  result.payments.total_payment;
                let available_balance = (total_fee - total_payment_received);
                $('#branch_id').val(branchId);
                $('#student_dept').val(result.assessments_details.student_department);                $('#payment_assessment_id').val(result.assessments_details.id);
                $('#payment_enrollment_id').val(result.assessments_details.enrollment_id);
                $('#payment_student_id').val(result.assessments_details.student_id);
                $('#payment_user_id').val(result.assessments_details.user_id);
                $('#payment_total_fees').val(total_fee);
                $('#payment_available_balance').val(available_balance);
                $('#payment_total_fees_display').val(formatter.format(total_fee));
                $('#payment_available_balance_display').val(formatter.format(available_balance));
            }
        });
    });
    $('#payment_amount').on('keyup', function(e){
        let balance =  $('#payment_available_balance').val();
        let payment = $(this).val();
        console.log(balance)
        if(parseFloat(payment) > parseFloat(balance)){
            $('#payment_amount').val(balance)
        }
    })

      // submit updates and save to database
      $('#paymentForm').submit(function(e) {
        e.preventDefault();

        // $("#updateProgramForm").validate(opt);

        // if (!$("#updateProgramForm").valid()) {
        //     return false;
        // }
        //if data is valid call function to run
        saveData()
    });

    function saveData() {
          // Do something here if validation is passed.
        let form_array = $("#paymentForm").serialize();

        $.ajax({
            url: "payments/savePayments",
            type: "POST",
            data: form_array
        })
        .done(function() {
            alertSuccess('Updated') //calls function alertSuccess in public\js\main.js
            $("#paymentForm")[0].reset();
            $('#addPaymentModal').modal('hide');
        })
        .fail(function(response) {
        })

    }

    $('body').on('click', '.deleteData', function(e) {
        Swal.fire({
            title: "Are you sure?",
            text: "Are you sure you want to delete this item?",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes",
        }).then((result) => {
            if (result.isConfirmed) {
                id = $(this).data('id');
                let _token  = $('meta[name="csrf-token"]').attr('content');
                // console.log(id)
                $.ajax({
                    url: "payments/"+id,
                    type: "DELETE",
                    data: {
                        _token: _token,
                    }
                })
                .done(function() {
                    alertSuccess('Deleted') //calls function alertSuccess in public\js\main.js
                })
                .fail(function() {
                    alertFailed('Deleted')
                })
            }
        });
    });



});
