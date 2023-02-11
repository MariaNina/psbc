$(function () {

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    let id = null;
    //When click the Create button
    $("body").on("click", ".createUser", function (e) {
        id = $(this).data("id");

        // Update UI
        $.ajax({
            url: `/all_pages`,
            type: "GET",
            success: function (response) {
                // ========= DO SOMETING ========= //
                const pages = response;

                const allPages = getAllPages();

                let perm = {};

                pages.forEach((page) => {
                    let name = page.page_name;

                    perm[name] = name;
                });

                let output = "";

                allPages.forEach((page) => {
                    let name = page.page_name;

                    output += `
                	<div class="form-check">
                				<input class="form-check-input permission_checkbox" name="${page.page_name}" type="checkbox" value="${page.id}"
                				id="${page.id}" />

                				<label class="form-check-label" for="${page.id}">
                				${page.page_name}
                				</label>
                	 </div>
                	`;
                });

                $("#permission_container").html(output);

            },
            error: function (err) {
                Swal.fire({
                    icon: "error",
                    title: "Failed",
                    text: "Something went wrong! Please try again later",
                });
            },
        });
    });

    // When the user permission button has been clicked
    $("body").on("click", ".userPermission", function (e) {
        id = $(this).data("id");

        // Update UI
        $.ajax({
            url: `/users_pages/${id}`,
            type: "GET",
            success: function (response) {
                // ========= DO SOMETING ========= //
                const pages = response;

                const allPages = getAllPages();

                let perm = {};

                pages.forEach((page) => {
                    let name = page.page_name;

                    perm[name] = name;
                });

                let output = "";

                allPages.forEach((page) => {
                    let name = page.page_name;

                    output += `
                	<div class="form-check">
                				<input class="form-check-input permission_checkbox" name="${page.page_name}" type="checkbox" value="${page.id}"
                				id="${page.id}" ${perm[name] === name ? "checked" : ""} />

                				<label class="form-check-label" for="${page.id}">
                				${page.page_name}
                				</label>
                	 </div>
                	`;
                });

                $("#permission_wrapper").html(output);

            },
            error: function (err) {
                Swal.fire({
                    icon: "error",
                    title: "Failed",
                    text: "Something went wrong! Please try again later",
                });
            },
        });
    });

    // When the form or update button has been clicked/submitted
    $("#userPermissionForm").submit(function (e) {

        const checkboxes = $('.permission_checkbox:checkbox:checked'); // All checked checkboxes
        e.preventDefault();

        let pageId = [];

        checkboxes.each(function () {
            pageId = [...pageId, parseInt($(this).val())] // Store all id in array
        });

        const formData = {
            pageId
        };

        // Update the permission from the server
        $.ajax({
            url: `/update_user_permission/${id}`,
            type: "POST",
            data: formData,
            success: function (response) {
                Swal.fire("Updated!", response.msg, "success");
                $("#userPermissionModal").modal("hide"); // Hide the modal
            },
            error: function (err) {
                Swal.fire({
                    icon: "error",
                    title: "Failed",
                    text: "Something went wrong! Please try again later",
                });
            },
        });


    });

    // Get all the pages from the database
    function getAllPages() {
        let pages;

        $.ajax({
            async: false,
            url: `/all_pages`,
            type: "GET",
            success: function (response) {
                pages = response;
            },
            error: function (err) {
                Swal.fire({
                    icon: "error",
                    title: "Failed",
                    text: "Something went wrong! Please try again later",
                });
            },
        });

        return pages;
    }

});
