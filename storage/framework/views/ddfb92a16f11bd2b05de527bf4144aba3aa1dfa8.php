<?php $__env->startSection('title'); ?>
    <?php echo e(env('APP_NAME')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <span class="badge badge-success py-2"><?php echo e(session('user')->branch); ?> Branch</span>
    </div>

    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Users
                            </div>
                            <div class="small text-xs text-muted mb-0 font-weight-bold">
                                Number of registered users
                            </div>
                        </div>
                        <div class="col-auto">
                            <span class="text-lg text-primary font-weight-bold"><?php echo e($userCount); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Students
                            </div>
                            <div class="small text-xs text-muted mb-0 font-weight-bold">
                                No. of registered students
                            </div>
                        </div>
                        <div class="col-auto">
                            <span id="registered_students"
                                  class="text-lg text-success font-weight-bold"><?php echo e($newStudentsCount + $oldStudentsCount + $transfereeStudentsCount); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Subjects
                            </div>
                            <div class="small text-xs text-muted mb-0 font-weight-bold">
                                Number of subjects registered
                            </div>
                        </div>
                        <div class="col-auto">
                            <span class="text-lg text-info font-weight-bold"><?php echo e($subjectCount); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Total Courses
                            </div>
                            <div class="small text-xs text-muted mb-0 font-weight-bold">
                                Number of course registered
                            </div>
                        </div>
                        <div class="col-auto">
                            <span class="text-lg text-warning font-weight-bold"><?php echo e($programCount); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Content Row -->

    <div class="row">

        <div class="col-lg-12">
            <div class="row">
                <div class="col-md-7">
                    
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="d-sm-flex align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-warning">Most Recent Announcement</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php if($announcement->count() > 0): ?>
                                <div class="px-3">
                                    <h5 class="p-0 m-0" style="font-size: 16px !important;">
                                        <?php echo e($announcement->announcement_title); ?>

                                    </h5>
                                    <small style="font-size: 0.7rem !important;">
                                        <i>Posted <?php echo e(\Carbon\Carbon::parse($announcement->created_at)->diffForHumans()); ?></i>
                                    </small>
                                    <div class="dashboard-text">
                                        <?php echo $announcement->announcement_body; ?>

                                    </div>
                                    <a class="m-0 p-0" href="<?php echo e(route('announcements.show', $announcement->id)); ?>"
                                       style="font-size: 0.8rem !important;">Read
                                        More...</a>
                                </div>
                            <?php else: ?>
                                <small>There are no announcements to show</small>
                                <i class="fas fa-clipboard"></i>
                            <?php endif; ?>
                        </div>

                    </div>


                    
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <figure class="highcharts-figure">
                                <div id="highcharts_enrollees_department"></div>
                            </figure>
                        </div>
                    </div>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="d-sm-flex align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-warning">Recent Enrolled Students</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table cust-datatable" id="student_table" width="100%" cellspacing="0">
                                    <thead>
                                    <tr>
                                        <th>LRN</th>
                                        <th>Name</th>
                                        <th>Course</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td><?php echo e($user->student->lrn); ?></td>
                                            <td><?php echo e($user->student->first_name .' ' .$user->student->last_name); ?></td>
                                            <td><?php echo e($user->student->enrollment->program_majors->program_code); ?></td>
                                            <td><?php echo e($user->joined_at); ?></td>
                                            <td>
                                                    <span
                                                        class="mode <?php echo e($user->is_active == 1 ? 'mode_on'  : 'mode_off'); ?>">
                                                        <?php echo e($user->is_active == 1 ? 'Active'  : 'Inactive'); ?>

                                                    </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                    
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="d-sm-flex align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-warning">Recent Employees</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table cust-datatable" id="employee_table" width="100%"
                                       cellspacing="0">
                                    <thead>
                                    <tr>
                                        <th>Account ID</th>
                                        <th>Name</th>
                                        <th>Position</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td><?php echo e($employee->id); ?></td>
                                            <td><?php echo e($employee->staff->first_name .' '. $employee->staff->last_name); ?></td>
                                            <td><?php echo e($employee->role->role_name); ?></td>
                                            <td>
                                                    <span
                                                        class="mode <?php echo e($employee->is_active == 1 ? 'mode_on'  : 'mode_off'); ?>">
                                                        <?php echo e($employee->is_active == 1 ? 'Active'  : 'Inactive'); ?>

                                                    </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <?php endif; ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">

                    
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <?php if($newStudentsCount != 0 || $oldStudentsCount != 0 || $transfereeStudentsCount != 0): ?>
                                <div class="text-center text-dark" style="font-size: 18px;">
                                    Registered Students
                                </div>
                                <div class="text-center text-dark mb-3" style="font-size: 12px !important;">
                                    (Except summer, Terms is only applied in SHS & above)
                                </div>

                                <div>
                                    <canvas id="studentsChart"></canvas>
                                </div>
                            <?php else: ?>
                                <div>
                                    <small>No data available in chart</small>
                                    <i class="fas fa-chart-pie"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <figure class="highcharts-figure">
                                <div id="highcharts_enrollees_per_sy"></div>
                                <p class="highcharts_description">
                                <div class="d-flex justify-content-between">

                                </div>
                                </p>
                            </figure>
                        </div>
                    </div>

                    
                    <div class="card shadow mb-4">

                        <div class="card-header py-3">
                            <div class="d-sm-flex align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-warning">Latest Events</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php $__empty_1 = true; $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <div class="px-3">
                                    <h5 class="p-0 m-0" style="font-size: 16px !important;">
                                        <?php echo e($event->title); ?>

                                    </h5>
                                    <small style="font-size: 0.7rem !important;">
                                        <i>Posted <?php echo e(\Carbon\Carbon::parse($event->created_at)->diffForHumans()); ?></i>
                                    </small>
                                    <div class="dashboard-text">
                                        <?php echo $event->body; ?>

                                    </div>
                                    <a class="m-0 p-0" href="<?php echo e(route('events.show', $event->id)); ?>"
                                       style="font-size: 0.8rem !important;">Read
                                        More...</a>
                                </div>

                                <?php echo (($events->count() - 1) != $key) ? '<hr/>' : null; ?>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <small>There are no events to show</small>
                                <i class="fas fa-clipboard"></i>
                            <?php endif; ?>
                        </div>
                    </div>


                </div>
            </div>


        </div>

    </div>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('extra-js'); ?>

    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/series-label.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

    <script>
        $(document).ready(function () {

            let dataSetPerDepartment = JSON.parse(atob('<?php echo e($enrolleesPerDepartment); ?>'));

            let seriesDataPerSchoolYear = [];

            let seriesDataPerDepartment = [];

            // Format the data
            dataSetPerDepartment.forEach((enrollee, index) => {

                seriesDataPerDepartment.push({
                    name: `Sy: ${enrollee.school_years}`,
                    data: [enrollee.elementary_count, enrollee.jhs_count, enrollee.shs_count, enrollee.college_count, enrollee.graduate_studies_count]
                })

                seriesDataPerSchoolYear.push({
                    name: enrollee.school_years,
                    data: [enrollee.elementary_count + enrollee.jhs_count + enrollee.shs_count + enrollee.college_count + enrollee.graduate_studies_count]
                })

            });

            // Highcharts 1
            Highcharts.chart('highcharts_enrollees_per_sy', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Enrollees per school year by term'
                },
                subtitle: {
                    text: '(Except summer, Terms is only applied in SHS & above)'
                },
                xAxis: {
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Count of Enrollees'
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px"></span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>{point.y}</b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                series: seriesDataPerSchoolYear
            });
            // End of Highcharts 1

            // Highcharts 2
            Highcharts.chart('highcharts_enrollees_department', {
                chart: {
                    type: 'bar'
                },
                title: {
                    text: 'Student Enrolled by Department/Term'
                },
                subtitle: {
                    text: '(Except summer, Terms is only applied in SHS & above)'
                },
                xAxis: {
                    categories: ['Elementary', 'JHS', 'SHS', 'College', 'Graduate S.'],
                    title: {
                        text: null
                    }
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Data (enrolled)',
                        align: 'high'
                    },
                    labels: {
                        overflow: 'justify'
                    }
                },
                plotOptions: {
                    bar: {
                        dataLabels: {
                            enabled: true
                        }
                    }
                },
                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'top',
                    x: -40,
                    y: 25,
                    floating: true,
                    borderWidth: 1,
                    backgroundColor:
                        Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF',
                    shadow: true
                },
                credits: {
                    enabled: false
                },
                series: seriesDataPerDepartment
            });
            // End Of highcharts 2

            let data = {
                labels: [
                    'New',
                    'Old',
                    'Transferee'
                ],
                datasets: [{
                    label: 'Students',
                    data: [<?php echo e($newStudentsCount); ?>, <?php echo e($oldStudentsCount); ?>, <?php echo e($transfereeStudentsCount); ?>],
                    backgroundColor: [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)'
                    ],
                    hoverOffset: 4
                }]
            };

            let config = {
                type: 'pie',
                data: data,
            };

            let myChart = new Chart(
                document.getElementById('studentsChart'),
                config
            );

            // ================ End of Charts ========================


            // =============== Table ================
            $("#student_table").DataTable({
                responsive: true
            });
            $("#employee_table").DataTable({
                responsive: true
            });
            // ===========  End of Table =======================

            // Select School Year and Term
            $('#school_year_select').on('change', function () {
                $("#school_year_form").submit();
            })

            $('#term_select').on('change', function () {
                $("#school_year_form").submit();
            })


        })
        ;

    </script>

    
    

<?php $__env->stopSection(); ?>

<?php echo $__env->make('dashboard.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\user\Documents\psbc\resources\views/dashboard/dashboard.blade.php ENDPATH**/ ?>