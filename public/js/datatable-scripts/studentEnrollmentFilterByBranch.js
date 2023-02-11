$(document).ready(function () {
    $('#strand-wrapper').hide();
    let department = 'All';
    let strand = 'All';
    let branch = 'All';

    $('html').on('change', '#strand', function () {
        strand = $(this).val();

        console.log(strand);

        initDatatable(branch, department, strand);

    });

    $('html').on('change', '#branches', function () {
        branch = $(this).val();

        department = $('#department').val();

        console.log('Department: ' + department, '|Branch: ' + branch, strand);

        initDatatable(branch, department, strand);

    });

    $('html').on('change', '#department', function () {
        department = $(this).val();

        branch = $('#branches').val();

        if (department === 'All' || department === 'Elementary' || department === 'JHS') {
            strand = 'All';
            $('#strand-wrapper').hide();
        }

        getStrand(department);

        console.log('Branch: ' + branch, '|Department: ' + department);

        initDatatable(branch, department, strand);

    });

    function getStrand(department) {
        if (department !== 'All' && department !== 'JHS' && department !== 'Elementary') {
            $.ajax({
                type: 'GET',
                url: '/students_enrollment/get_strand',
                data: {department: department},
                success: function (response) {

                    console.log(response);

                    if (response.length > 0) {
                        $('#strand').select2();

                        let strand = '<option selected value="All">All</option>';
                        response.forEach(curriculum => {
                            strand += `<option value="${curriculum.description}">${curriculum.description}</option>`;
                        });

                        $('#strand').html(strand);

                        $('#strand-wrapper').show();
                    }
                },
                error: function (err) {
                    console.error(err);
                }
            });
        }
    }

    function initDatatable(branch, department, strand) {
        $('#filtertable').DataTable().clear().destroy(); // Clear and Destroy Datatable

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
                    title: 'PSBC List of Students',
                },
            ],
            "responsive": true,
            "pageLength": 10,
            "processing": true,
            "serverSide": true,
            ajax: {
                url: `students_enrollment/${branch}/${department}/${strand}#step-1`, // Route of Controller with DataTables Yajra
            },
            columns: [
                {
                    data: "No",
                    name: "No",
                },
                {
                    data: "application_no",
                    name: "enrollment_tbls.application_no",
                },
                {
                    data: "student_type",
                    name: "students_tbls.student_type",
                },
                {
                    data: "lrn",
                    name: "students_tbls.lrn",
                },
                {
                    data: "first_name",
                    name: "students_tbls.first_name",
                },
                {
                    data: "middle_name",
                    name: "students_tbls.middle_name",
                },
                {
                    data: "last_name",
                    name: "students_tbls.last_name",
                },
                {
                    data: "email",
                    name: "students_tbls.email",
                },
                {
                    data: "contact_number",
                    name: "students_tbls.contact_number"
                },
                {
                    data: "address",
                    name: "students_tbls.address"
                },
                {
                    data: "student_department",
                    name: "enrollment_tbls.student_department"
                },
                {
                    data: "program_name",
                    name: "programs_tbls.program_name"
                },
                {
                    data: "major_name",
                    name: "majors_tbls.major_name"
                },
                {
                    data: "level_name",
                    name: "levels_tbls.level_name"
                },
                {
                    data: "app_status",
                    name: "application_status_view.STATUS",
                    render: (app_status) => {
                        return `<span class="mode ${
                            app_status === "Enrolled" ? "mode_on" : app_status === "Rejected" ? "mode_off" : "mode_done"
                        }">${app_status.replace(/\s/g, '')}</span>`;
                    },
                },
                {
                    data: "action",
                    name: "action",
                    orderable: false,
                },
            ],

        }) // Initialize again
    }
});
