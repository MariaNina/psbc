$(document).ready(function () {

    const page_route = "assessments";
    // $(".js-example-basic-single").select2({
    //     placeholder:'No selected',
    //     theme: "bootstrap4",
    // });

    var i = 1; //count for adding tuition fee
    var other_fee_number = 1; //count for other fees
    var discount_number = 1; //count for discounts


    //function when button plus in tuition fee is clicked, it will append new row
    $('#add_fee').click(function() {

        let assessment_type = "Discountable Fee"; //to get fees for tution
        let student_department = $('#student_department').val(); //department
        let _token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: page_route+"/getFeesByDepartment",
            type: "POST",
            data: {
                assessment_type: assessment_type,
                student_department: student_department,
                _token: _token
            }
        })
        .done(function(result) {
            let html = '';

            //options for select box in tuition fee
            result.fees.forEach(feehtml => {
                html +="<option value='"+feehtml.fee_name+"'>"+feehtml.fee_name+"</option>";
            })
            $('#addField').append("<div class='col col-lg-5 col-md-12 col-sm-12 col-12 to_remove"+i+"'><div class='form-group '><select class='form-control fee_selectbox' data-id='"+i+"' name='fee_type[]' required><option disabled selected value=''>Select...</option>"+html+"</select></div></div><div class='col col-lg-4 col-md-12 col-sm-12 col-12 to_remove"+i+"'><div class='form-group '><input class='form-control fee_amount inputbox_"+i+"' name='fee_amount[]' type='number' required='' placeholder='Amount' readonly></div></div><div class='col col-sm-3 col-md-3 col-sm-3 col-3 to_remove"+i+"'><a id='"+i+"' class='btn btn-danger btn-sm btn_remove' style='color:white;'>-</a></div>");
            i++;
        })
        .fail(function() {
        })
    });


    //remove row in tuition fee
    $(document).on('click', '.btn_remove', function() {
        var row_id = $(this).attr('id');
        $('.to_remove'+row_id).remove();
        compute_total_amount();
    });

    //function when button plus in discounts is clicked, it will append new row
    $('#add_discount').click(function() {

        let student_department = $('#student_department').val();
        let _token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: page_route+"/getDiscountsByDepartment",
            type: "POST",
            data: {
                student_department: student_department,
                _token: _token
            }
        })
        .done(function(result) {
            let html = '';
            result.discs.forEach(discHtml => {
                html +="<option value='"+discHtml.discount_name+"'>"+discHtml.discount_name+"</option>";

            })
                $('#discount_area').append("<div class='col col-lg-5 col-md-12 col-sm-12 col-12 discount_"+ discount_number+"'><div class='form-group '><select class='form-control disc_selectbox' data-id='"+discount_number+"' name='discount_type[]' required><option disabled selected value=''>Select...</option>"+html+"</select></div></div><div class='col col-lg-4 col-md-12 col-sm-12 col-12 discount_"+discount_number+"'><div class='form-group '><input class='form-control fee_amount dis_inputbox_"+discount_number+"' name='discount_amount[]' type='text' required=''  placeholder='Amount'></div></div><div class='col col-sm-3 col-md-3 col-sm-3 col-3 discount_"+discount_number+"'><a id='"+discount_number+"' class='btn btn-danger btn-sm btn_remove_disc ' style='color:white;'>-</a></div>");
                discount_number++;
            })
            .fail(function() {
            })
    });

    //remove row in discount
    $(document).on('click', '.btn_remove_disc', function() {
        var row_id = $(this).attr('id');
        $('.discount_'+row_id).remove();
        compute_total_amount();
    });

    //function when button plus in other fee is clicked, it will append new row
    $('#add_other_fee').click(function() {

        let assessment_type = "Others"; //to get fees for others
        let student_department = $('#student_department').val(); //department
        let _token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: page_route+"/getFeesByDepartment",
            type: "POST",
            data: {
                assessment_type: assessment_type,
                student_department: student_department,
                _token: _token
            }
        })
        .done(function(result) {
            let html = '';

            //options for select box in tuition fee
            result.fees.forEach(feehtml => {
                html +="<option value='"+feehtml.fee_name+"'>"+feehtml.fee_name+"</option>";
            })
            $('#addOtherField').append("<div class='col col-lg-5 col-md-12 col-sm-12 col-12 other_to_remove"+other_fee_number+"'><div class='form-group '><select class='form-control other_fee_selectbox' data-id='"+other_fee_number+"' name='other_fee_type[]' required><option disabled selected value=''>Select...</option>"+html+"</select></div></div><div class='col col-lg-4 col-md-12 col-sm-12 col-12 other_to_remove"+other_fee_number+"'><div class='form-group '><input class='form-control other_fee_amount other_inputbox_"+other_fee_number+"' name='other_fee_amount[]' type='number' required='' placeholder='Amount'></div></div><div class='col col-sm-3 col-md-3 col-sm-3 col-3 other_to_remove"+other_fee_number+"'><a id='"+other_fee_number+"' class='btn btn-danger btn-sm btn_remove_other_fee ' style='color:white;'>-</a></div>");
            other_fee_number++;
        })
        .fail(function() {
        })
            });
            //remove row in other
        $(document).on('click', '.btn_remove_other_fee', function() {
            var row_id = $(this).attr('id');
            $('.other_to_remove'+row_id).remove();
            compute_total_amount();
        });


    function getFees() {

        let assessment_type = "Discountable Fee";
        let student_department = $('#student_department').val();
        let _token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: page_route+"/getFeesByDepartment",
            type: "POST",
            data: {
                assessment_type: assessment_type,
                student_department: student_department,
                _token: _token
            }
        })
        .done(function(result) {
            // console.log(result)
            let total_fees = 0;
            $('#addField').empty();
            result.fees.forEach(fee => {
                let html = '';
                result.fees.forEach(feehtml => {
                    html +="<option "+((fee.fee_name == feehtml.fee_name) ? "selected" : "")+" value='"+feehtml.fee_name+"'>"+feehtml.fee_name+"</option>";
                 })
                $('#addField').append("<div class='col col-lg-5 col-md-12 col-sm-12 col-12 to_remove"+i+"'><div class='form-group '><select class='form-control fee_selectbox' data-id='"+i+"' name='fee_type[]' required><option disabled selected value=''>Select...</option>"+html+"</select></div></div><div class='col col-lg-4 col-md-12 col-sm-12 col-12 to_remove"+i+"'><div class='form-group '><input class='form-control fee_amount inputbox_"+i+"' name='fee_amount[]' type='number' required='' value='"+fee.fee_amount+"' placeholder='Amount'></div></div><div class='col col-sm-3 col-md-3 col-sm-3 col-3 to_remove"+i+"'><a id='"+i+"' class='btn btn-danger btn-sm btn_remove ' style='margin-top:15pxpx;color:white;'>-</a></div>");
                i++;
                total_fees += parseInt(fee.fee_amount);
            });
            $('#total_fees').val(total_fees);
            compute_total_amount();
        })
        .fail(function() {
        })

    }


    //function when fee selection change
    $('body').on('change', '.fee_selectbox', function (e) {

        let id = $(this).data('id');
        console.log(id)
        let student_department = $('#student_department').val();
        let val = $(this).val();
        let _token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: page_route+"/getFeeAmount",
            type: "POST",
            data: {
                student_department: student_department,
                val: val,
                _token: _token
            },
            success: function (result) {
                let amount = result.fee_amount;
                $('.inputbox_'+id).val(amount);
                compute_total_amount();
            }
        });
    });

    //function when discount selection change
    $('body').on('change', '.disc_selectbox', function (e) {
        // e.preventDefault();

        let id = $(this).data('id');
        console.log(id)
        let student_department = $('#student_department').val();
        let val = $(this).val();
        let _token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: page_route+"/getDiscountAmount",
            type: "POST",
            data: {
                student_department: student_department,
                val: val,
                _token: _token
            },
            success: function (result) {
                let amount = result.amount;
                let disc_type = result.discount_type;
                if(disc_type == "Percentage" || disc_type == 'Constant'){
                    $('.dis_inputbox_'+id).attr('readonly', true);
                    console.log(disc_type);
                }else{
                    $('.dis_inputbox_'+id).attr('readonly', false);
                }

                $('.dis_inputbox_'+id).val(amount);
                compute_total_amount();
            }
        });
    });

     //function when fee selection change
     $('body').on('change', '.other_fee_selectbox', function (e) {

        let id = $(this).data('id');
        console.log(id)
        let student_department = $('#student_department').val();
        let val = $(this).val();
        let _token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: page_route+"/getFeeAmount",
            type: "POST",
            data: {
                student_department: student_department,
                val: val,
                _token: _token
            },
            success: function (result) {
                let amount = result.fee_amount;
                $('.other_inputbox_'+id).val(amount);
                compute_total_amount();
            }
        });
    });
    //compute total amount value changes
    $('body').on('click keyup', '.discount_amount', function (e) {
        // e.preventDefault();
        compute_total_amount();
    });

    //compute total amount value changes
    $('body').on('click keyup', '.fee_amount', function (e) {
        // e.preventDefault();
        compute_total_amount();
    });

        //compute total amount value changes
    $('body').on('click keyup', '.other_fee_amount', function (e) {
        // e.preventDefault();
        compute_total_amount();
    });

    //function to compute total amount to pay
    function compute_total_amount()
    {
        var all_fees = 0;
        var total_amount = 0;
        var total_discount = 0;
        var total_fees = 0;
        var total_other_fees = 0;

        //get tuition fees
        $("input[name='fee_amount[]']").each(function() {
            if (this.value != "")
            total_fees += parseFloat(this.value);
        });
        $('#total_fees').val("₱ "+total_fees);

        //get discounts
        $('input[name="discount_amount[]"]').each(function() {
            if (this.value != ''){
            let disc = this.value;
            let disc_first_char =disc.substring(0, 1);
            let disc_val = disc.replace('X','');
                if(disc_first_char == 'X'){
                    total_discount += (parseFloat(total_fees) * parseFloat(disc_val));
                }else{
                    total_discount += parseFloat(this.value);
                }

            }
        });


        $('#total_discount').val("₱ "+total_discount);

        //get other fees
        $("input[name='other_fee_amount[]']").each(function() {
            if (this.value != "")
            total_other_fees += parseFloat(this.value);
        });
        $('#total_other_fees').val("₱ "+total_other_fees);

        all_fees = parseFloat(total_fees) + parseFloat(total_other_fees)
        total_amount = parseFloat(all_fees) - parseFloat(total_discount);
        $('#total_amount').val("₱ "+total_amount);
    }

    $("#updateForm").submit(function(e){

        e.preventDefault();
        updateData()
    });

    function updateData() {
        // Do something here if validation is passed.
        let form_data = $("#updateForm").serialize();

        $.ajax({
            url: page_route+"/"+id,
            type: 'PUT',
            data: form_data
        })
          .done(function() {
                alertSuccess('Created') //calls function alertSuccess in public\js\main.js
                $('#updateModal').modal('hide');
                window.location.reload();
          })
          .fail(function() {
                alertFailed('Create')
          })
    }

    // get data by id from assessments edit
    $('body').on('click', '.editData', function (e) {
        // e.preventDefault();
        id = $(this).data('id');

        $('#discount_area').empty();
        $('#addOtherField').empty();
        $('#addField').empty();
        $('#collegeFees').empty();
        $('#total_fees').val(0);
        $('#total_other_fees').val(0);
        $('#total_discount').val(0);
        $('#total_amount').val(0);
        $.ajax({
            url: page_route + "/" + id + "/edit",
            type: "GET",
        })
        .done(function(result) {

    // if(result.student_details.student_department == "Graduate Studies" || result.student_details.student_department == "College" ){

    //         }

           
            $('#updateModal').modal('show');
            $('#application_no').val(result.student_details.application_no)
            $('#enrollment_id').val(result.student_details.enrollment_id)
            $('#student_department').val(result.student_details.student_department);
            $('#student_id').val(result.student_details.student_id);
            $('#student_name').val(result.student_details.studentName);
            $('#program_major').val(result.student_details.programMajor);
            let stud_dept = result.student_details.student_department;




            let assessment_fees = JSON.parse(result.student_details.fees);
            let assessment_other_fees = JSON.parse(result.student_details.other_fees);
            let assessment_discounts = JSON.parse(result.student_details.discounts);

            if(assessment_discounts != null){

                assessment_discounts.forEach(disc => {

                    $('#discount_area').append("<div class='col col-lg-5 col-md-12 col-sm-12 col-12 discount_"+ discount_number+"'><div class='form-group '><input class='form-control disc_selectbox' name='discount_type[]' type='text' required='' value='"+disc.discount_type+"' placeholder='discount name' readonly></div></div><div class='col col-lg-4 col-md-12 col-sm-12 col-12 discount_"+discount_number+"'><div class='form-group '><input class='form-control fee_amount dis_inputbox_"+discount_number+"' name='discount_amount[]' type='text' required=''  value='"+disc.discount_amount+"'placeholder='Amount' readonly></div></div><div class='col col-sm-3 col-md-3 col-sm-3 col-3 discount_"+discount_number+"'><a id='"+discount_number+"' class='btn btn-danger btn-sm btn_remove_disc ' style='color:white;'>-</a></div>");
                    discount_number++
                });

            }else{

            }
            if(assessment_other_fees != null){

                assessment_other_fees.forEach(fee => {

                    $('#addOtherField').append("<div class='col col-lg-5 col-md-12 col-sm-12 col-12 other_to_remove"+other_fee_number+"'><div class='form-group '><input class='form-control other_fee_selectbox' name='other_fee_type[]' type='text' required='' value='"+fee.other_fee_types+"' placeholder='fee name' readonly></div></div><div class='col col-lg-4 col-md-12 col-sm-12 col-12 other_to_remove"+other_fee_number+"'><div class='form-group '><input class='form-control other_fee_amount other_inputbox_"+other_fee_number+"' name='other_fee_amount[]' type='number' required='' value='"+fee.other_fee_amount+"' placeholder='Amount' readonly></div></div><div class='col col-sm-3 col-md-3 col-sm-3 col-3 other_to_remove"+other_fee_number+"'><a id='"+other_fee_number+"' class='btn btn-danger btn-sm btn_remove_other_fee ' style='color:white;'>-</a></div>");
                    other_fee_number++;
                });

            }else{


            }
            if(assessment_fees != null || assessment_fees > 0){

                assessment_fees.forEach(fee => {

                    $('#addField').append("<div class='col col-lg-5 col-md-12 col-sm-12 col-12 to_remove"+i+"'><div class='form-group '><input class='form-control fee_selectbox' name='fee_type[]' type='text' required='' value='"+fee.fee_type+"' placeholder='fee name' readonly></div></div><div class='col col-lg-4 col-md-12 col-sm-12 col-12 to_remove"+i+"'><div class='form-group '><input class='form-control fee_amount inputbox_"+i+"' name='fee_amount[]' type='number' required='' value='"+fee.fee_amount+"' placeholder='Amount' readonly></div></div><div class='col col-sm-3 col-md-3 col-sm-3 col-3 to_remove"+i+"'><a id='"+i+"' class='btn btn-danger btn-sm btn_remove ' style='margin-top:15pxpx;color:white;'>-</a></div>");
                    i++;
                    total_fees += parseInt(fee.fee_amount);
                });
            }else{
                let total_fees = 0;
                if(stud_dept == "College" || stud_dept == "Graduate Studies"){
                    let lect_units = 0;
                    let lab_units = 0;

                    let lec_amount = 0;
                    let lab_amount = 0;

                    lect_units = result.lect_units[0].total_lect_unit;
                    lab_units = result.lab_units[0].total_lab_unit;
                    lec_amount = result.lec_amount.fee_amount;
                    lab_amount = result.lab_amount.fee_amount;

                    lec_amount = (lect_units*lec_amount);
                    lab_amount = (lab_units*lab_amount);


                    let units = '';
                        units +="<div class='col col-lg-5 col-md-12 col-sm-12 col-12'>";
                        units += "<div class='form-group'>";
                        units += "<input id='lec_units' class='form-control fee_selectbox' name='fee_type[]' type='text' required='' value='"+lect_units + " Lec Units' placeholder='fee name' readonly> </div> </div>";
                        units += "<div class='col col-lg-4 col-md-12 col-sm-12 col-12'>";
                        units += "<div class='form-group '>";
                        units += "<input id='lec_unit_amount' class='form-control fee_amount' name='fee_amount[]' type='number' required='' value='"+lec_amount+"' placeholder='Amount' readonly></div></div>";

                        units += "<div class='col col-lg-5 col-md-12 col-sm-12 col-12'>";
                        units += "<div class='form-group '>";
                        units += "<input  id='lab_units' class='form-control fee_selectbox' name='fee_type[]' type='text' required='' value='"+lab_units + " Lab Units' placeholder='fee name' readonly></div> </div>";
                        units += "<div class='col col-lg-4 col-md-12 col-sm-12 col-12'>";
                        units += "<div class='form-group '>";
                        units += "<input id='lab_unit_amount' class='form-control fee_amount' name='fee_amount[]' type='number' required='' value='"+lab_amount+"' placeholder='Amount' readonly></div> </div>";

                        $('#collegeFees').html(units);

                    total_fees += parseInt(lec_amount);
                    total_fees += parseInt(lab_amount);
                }else{
                    $('#collegeFees').empty();
                }

                result.fees.forEach(fee => {
                    let html = '';
                    result.fees.forEach(feehtml => {
                        html +="<option "+((fee.fee_name == feehtml.fee_name) ? "selected" : "")+" value='"+feehtml.fee_name+"'>"+feehtml.fee_name+"</option>";
                    })
                    $('#addField').append("<div class='col col-lg-5 col-md-12 col-sm-12 col-12 to_remove"+i+"'><div class='form-group '><select class='form-control fee_selectbox' data-id='"+i+"' name='fee_type[]' required><option disabled selected value=''>Select...</option>"+html+"</select></div></div><div class='col col-lg-4 col-md-12 col-sm-12 col-12 to_remove"+i+"'><div class='form-group '><input class='form-control fee_amount inputbox_"+i+"' name='fee_amount[]' type='number' required='' value='"+fee.fee_amount+"' placeholder='Amount'></div></div><div class='col col-sm-3 col-md-3 col-sm-3 col-3 to_remove"+i+"'><a id='"+i+"' class='btn btn-danger btn-sm btn_remove ' style='margin-top:15pxpx;color:white;'>-</a></div>");
                    i++;
                    total_fees += parseInt(fee.fee_amount);
                });
            }
            $('#total_fees').val(total_fees);
            compute_total_amount();
        })
        .fail(function() {

        })

    });

});
