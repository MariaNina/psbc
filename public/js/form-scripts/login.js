$(document).ready(function () {
    let id; //define a global variable id for edit

    const opt = {
        errorElement: "div",
        rules: {
            email: {
                required: true,
                email: false,
            },
            password: {
                required: true,
            },
        },
        messages: {
            email: {
                required: "Email Address is required",
            },
            password: {
                required: "Password is required",
            },
        },
        highlight: function (element) {
            $(element).addClass("is-invalid");
        },
        unhighlight: function (element) {
            $(element).removeClass("is-invalid");
        },
    };

    // Check validation if submit
    $("#loginForm").submit(function (e) {
        e.preventDefault();
        $("#loginForm").validate(opt);

        if (!$("#loginForm").valid()) {
            return false;
        }
        // Do something here if validation is passed.

        let email = $("#email").val();
        let password = $("#password").val();
        let _token = $('meta[name="csrf-token"]').attr("content");

        $.ajax({
            url: "/login",
            type: "POST",
            data: {
                email: email,
                password: password,
                _token: _token,
            },
            success: function (response) {
                if (response.status === 401) {
                    // Wrong Email Or Password

                    const Toast = Swal.mixin({
                        toast: true,
                        position: "top-right",
                        iconColor: "red",
                        showConfirmButton: false,
                        timer: 1100,
                        timerProgressBar: true,
                    });

                    const errMsg = "Invalid Email or Password";

                    Toast.fire({
                        icon: "error",
                        title: errMsg,
                    });
                } else {

                    // Redirect to correct route
                    if (response.role !== "Student") {
                        return window.location.href = "/dashboard";
                    } else {
                        // Student
                        return window.location.href = "/profile";
                    }

                }
            },
            error: function (response) {
                alertFailed("login"); //calls function alertFailed in public\js\main.js
            },
        });
        e.preventDefault();
    });
});
