$(document).ready(function () {
    const editTimeSettingsRules = {
        errorElement: "div",
        rules: {
            morning_in: "required",
            morning_out: "required",
            afternoon_in: "required",
            afternoon_out: "required",
            "days[]": {
                required: true,
            },
            required_time: "required",
        },
        messages: {
            morning_in: {
                required: "Morning In is required",
            },
            morning_out: {
                required: "Morning Out date is required",
            },
            afternoon_in: {
                required: "Afternoon In is required",
            },
            afternoon_out: {
                required: "Afternoon Out is required",
            },
            "days[]": {
                required: "Please select at least 1 day",
            },
            required_time: {
                required: "Cutoff Time is required",
            },
        },
        highlight: function (element) {
            $(element).addClass("is-invalid");
        },
        unhighlight: function (element) {
            $(element).removeClass("is-invalid");
        },
    };

    $("#editTimeSettingsForm").validate(editTimeSettingsRules); // Validate

    // If Submit Form is Clicked
    $("#editTimeSettingsForm").submit(function (e) {
        e.preventDefault();

        $("#editTimeSettingsForm").validate(editTimeSettingsRules);

        if (!$("#editTimeSettingsForm").valid()) {
            return false;
        }

        // Do something here if validation is passed.
        editTimeSettings();
    });

    let id;

    let daysInAWeek = [
        {
            fullName: "Monday",
            abbrev: "MON",
        },
        {
            fullName: "Tuesday",
            abbrev: "TUE",
        },
        {
            fullName: "Wednesday",
            abbrev: "WED",
        },
        {
            fullName: "Thursday",
            abbrev: "THU",
        },
        {
            fullName: "Friday",
            abbrev: "FRI",
        },
        {
            fullName: "Saturday",
            abbrev: "SAT",
        },
        {
            fullName: "Sunday",
            abbrev: "SUN",
        },
    ];

    // Get the data ang put on the modal
    $("body").on("click", ".editTimeSettingsModalBtn", function () {
        id = $(this).attr("data-id");

        $("#editTimeSettingsForm").trigger("reset"); // Reset

        let options = "";

        $("#days").html(options); // Reset

        $.ajax({
            url: `/time_settings/${id}/edit `,
            type: "GET",
            success: function (response) {
                let fullName =
                    response.staff.first_name + " " + response.staff.last_name;

                $("#editTimeSettingsModal #staff_name").val(fullName);
                $("#editTimeSettingsModal #morning_in").val(
                    response.morning_in
                );
                $("#editTimeSettingsModal #morning_out").val(
                    response.morning_out
                );
                $("#editTimeSettingsModal #afternoon_in").val(
                    response.afternoon_in
                );
                $("#editTimeSettingsModal #afternoon_out").val(
                    response.afternoon_out
                );
                $("#editTimeSettingsModal #required_time").val(
                    response.required_time
                );

                let options = "";

                daysInAWeek.forEach((day) => {
                    options += `<option value="${day.abbrev}" ''>${day.fullName}</option>`; // Reset
                });

                if (response.days != null) {
                    daysInAWeek.forEach((day) => {
                        options += `<option value="${day.abbrev}" ${
                            response.days.includes(day.abbrev) ? "selected" : ""
                        }>${day.fullName}</option>`;
                    });
                }

                $("#days").html(options); // Append
            },
            error: function (err) {
                Swal.fire({
                    icon: "error",
                    title: "Failed",
                    text: "Something went wrong! Please try again later",
                });

                $("#editTimeSettingsForm").trigger("reset"); // Clear the form
            },
        });
    });

    function editTimeSettings() {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        let form_data = $("#editTimeSettingsForm").serialize();

        $.ajax({
            url: `/time_settings/${id}`,
            type: "PUT",
            data: form_data,
            success: function (response) {
                console.log(response);
                Swal.fire("Updated!", response.msg, "success");

                $("#editTimeSettingsForm").trigger("reset"); // Clear the form
                $("#editTimeSettingsModal").modal("hide"); // Hide the modal
                $("#filtertable").DataTable().ajax.reload();
            },
            error: function (err) {
                // validation error
                if (err.status == 422) {
                    Swal.fire({
                        icon: "error",
                        title: "Failed",
                        text: "All Fields are Required",
                    });
                    $("#editTimeSettingsForm").trigger("reset"); // Clear the form
                } else {
                    // Show another error message
                    Swal.fire({
                        icon: "error",
                        title: "Failed",
                        text: "Something went wrong! Please try again later",
                    });
                }
            },
        });
    }
});
