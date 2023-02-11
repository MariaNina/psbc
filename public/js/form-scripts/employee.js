$(document).ready(function () {
    let id = ""; //define a global variable id for edit
    const page_route = "employees";
    
    const opt = {
        errorElement: "div",
        rules: {
            birthday: "required",
            gender: "required",
            civilStatus: "required",
            height: "required",
            weight: "required",
            bloodType: "required",
            address: "required",
            zipCode: "required",
            bio_id: "required",
        },
        messages: {
            birthday: {
                required: "Birthday is required",
            },
            gender: {
                required: "Gender is required",
            },
            civilStatus: {
                required: "Civil Status is required",
            },
            height: {
                required: "Height is required",
            },
            weight: {
                required: "Weight is required",
            },
            bloodType: {
                required: "Bllod Type is required",
            },
            address: {
                required: "Address is required",
            },
            zipCode: {
                required: "Zip Code is required",
            },
            bio_id: {
                required: "Biometric Id is required",
            },
        },
        highlight: function (element) {
            $(element).addClass("is-invalid");
        },
        unhighlight: function (element) {
            $(element).removeClass("is-invalid");
        },
    };

    $("#editStaffForm").validate(opt); // Validate


    $("#staffError").hide();

     // get data by id from staff edit
     $('body').on('click', '.editData', function(e) {
        // e.preventDefault();
        id = $(this).data('id');
        console.log(id)
        $.ajax({
            url: page_route+"/"+id+"/edit",
            type: "GET",
        })
        .done((result)=>{
            // console.log(result);
            let imageHtml ="";
            let employeeTypeHtml = '';
            let majorshtml = '';
            let masteralHtml = '';
            let genderHtml = '';
            let civilStatusHtml = '';
            let bloodTypeHtml = '';

            // display data to staff
            if(result.getDataById[0].image==null){
                $('#profile_pic').attr("src","storage/avatars_img/def.jpg");
            }else
            {
                $('#profile_pic').attr("src","storage"+result.getDataById[0].image);
            }
            $('#editStaffModal').modal('show');
            $('#firstName').val(result.getDataById[0].first_name);
            $('#middleName').val(result.getDataById[0].middle_name);
            $('#lastName').val(result.getDataById[0].last_name);
            $('#extensionName').val(result.getDataById[0].extension_name);
            $('#cscNumber').val(result.getDataById[0].csc_id);
            $('#position').val(result.getDataById[0].position);
            $('#department').val(result.getDataById[0].Department);
            $('#licenseNumber').val(result.getDataById[0].licence_number);
            $('#birthday').val(result.getDataById[0].birth_day);
            $('#birthPlace').val(result.getDataById[0].birth_place);
            $('#height').val(result.getDataById[0].height_m);
            $('#weight').val(result.getDataById[0].weight_kg);
            $('#gsis').val(result.getDataById[0].gsis);
            $('#sss').val(result.getDataById[0].sss);
            $('#philHealth').val(result.getDataById[0].phil_health);
            $('#pagibig').val(result.getDataById[0].pagibig);
            $('#tin').val(result.getDataById[0].tin);
            $('#agencyNumber').val(result.getDataById[0].agency_employee_no);
            $('#citizenship').val(result.getDataById[0].citizenship);
            $('#zipCode').val(result.getDataById[0].zip_code);
            $('#address').val(result.getDataById[0].address);
            $('#telNumber').val(result.getDataById[0].telephone_number);
            $('#mobileNumber').val(result.getDataById[0].mobile_number);
            $('#bio_id').val(result.getDataById[0].bio_id);
            let imagepic = result.getDataById[0].image;
            let staffType = result.getDataById[0].staff_type;
            let major_id = result.getDataById[0].major_in;
            let isMasteral = result.getDataById[0].is_masteral;
            let gender = result.getDataById[0].gender;
            let civilStatus = result.getDataById[0].civil_status;
            let bloodType = result.getDataById[0].blood_type;

            //image
            imageHtml += '<img src=""'
            //employment Type
            employeeTypeHtml += '<option value="Admin" '+((staffType == "Admin") ? "selected" : "")+'>Admin</option>';
            employeeTypeHtml += '<option value="Academic" '+((staffType == "Academic") ? "selected" : "")+'>Academic</option>';
            employeeTypeHtml += '<option value="Janitor/Guard" '+((staffType == "Janitor/Guard") ? "selected" : "")+'>Janitor/Guard</option>';
            //Major In
            result.subjects.forEach(m => {
                majorshtml += '<option value="'+m.id+'" '+((major_id == m.id) ? "selected" : "")+'>'+m.subject_name+'</option>';
            });
            //is Masteral
            masteralHtml += '<option value="1" '+((isMasteral == 1) ? "selected" : "")+'>Yes</option>';
            masteralHtml += '<option value="0" '+((isMasteral == 0) ? "selected" : "")+'>No</option>';

            //Gender
            genderHtml += '<option value="Male" '+((gender == "") ? "selected" : "")+'>Not Set</option>';
            genderHtml += '<option value="Male" '+((gender == "Male") ? "selected" : "")+'>Male</option>';
            genderHtml += '<option value="Female" '+((gender == "Female") ? "selected" : "")+'>Female</option>';

            //Civil Status
            civilStatusHtml += '<option value="" '+((civilStatus == "") ? "selected" : "")+'>Not Set</option>';
            civilStatusHtml += '<option value="Single" '+((civilStatus == "Single") ? "selected" : "")+'>Single</option>';
            civilStatusHtml += '<option value="Married" '+((civilStatus == "Married") ? "selected" : "")+'>Married</option>';
            civilStatusHtml += '<option value="Separated" '+((civilStatus == "Separated") ? "selected" : "")+'>Separated</option>';
            civilStatusHtml += '<option value="Widowed" '+((civilStatus == "Widowed") ? "selected" : "")+'>Widowed</option>';
            
            //Blood Type
            bloodTypeHtml += '<option value="" '+((bloodType == "") ? "selected" : "")+'>Not Set</option>';
            bloodTypeHtml += '<option value="A" '+((bloodType == "A") ? "selected" : "")+'>A</option>';
            bloodTypeHtml += '<option value="B" '+((bloodType == "B") ? "selected" : "")+'>B</option>';
            bloodTypeHtml += '<option value="AB" '+((bloodType == "AB") ? "selected" : "")+'>AB</option>';
            bloodTypeHtml += '<option value="O" '+((bloodType == "O") ? "selected" : "")+'>O</option>';

            $('#employmentType').html(employeeTypeHtml);
            $('#majorIn').html(majorshtml);
            $('#isMasteral').html(masteralHtml);
            $('#gender').html(genderHtml);
            $('#civilStatus').html(civilStatusHtml);
            $('#bloodType').html(bloodTypeHtml);
        })
    });

    // submit updates and save to database
    $('#editStaffForm').submit(function(e) {
        e.preventDefault();

        $("#editStaffForm").validate(opt);
        if (!$("#editStaffForm").valid()) {
            return false;
        }
        updateData()
    });

    function updateData() {
        // Do something here if validation is passed.
      let myForm = document.getElementById('editStaffForm');
      let formData = new FormData(myForm); //use formData for forms with files
          formData.append('_method', 'PUT'); //need to spoof PUT method here because formData and PUT are having an error.. Use POST as method then add this line successfully update the data
      console.log(formData);
      $.ajax({
          url: page_route+"/"+id,
          type: 'POST',
          data: formData,
          cache:false,
          contentType: false,
          processData: false,
      })
      .done(function(result) {
        console.log(result.info);
          alertSuccess('Updated') //calls function alertSuccess in public\js\main.js
          $("#editStaffForm")[0].reset();
          $('#editStaffModal').modal('hide');
      })
      .fail(function(result) {
          console.log(result.info);
          alertFailed('Update')
      })
          
  }

   });
