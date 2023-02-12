
<div class="container">

    <!-- Header -->
    <header class=" mb-5">
        <div class="text-center">
            <span class="font-weight-bold header-title">
                PAETE SCIENCE AND BUSINESS COLLEGE, INC.
                <span>
                    <p class="location">PAETE, LAGUNA</p>
        </div>
    </header>

    <!-- Info -->
    <div class="rule">
        <h5 class="title text-uppercase font-weight-bold underline">
            Rules Concerning Fees and Deposits:
        </h5>

        <ul class="list-style-none rules-list line-h">
            <li class="mb-3">
                <span>1.</span>
                Entrance fees are payable in cash and not refundable. Tuition fees are payable in cash. Fees are on a
                semestral or quarterly basis in the Collegiate and on a yearly basis in the High School and Elementary
                Deperments Payments by installment may be allowed for the convenience of a student. If a student stops,
                studying or transfers to another school, he/she shall be liable to pay the full unpaid balance for the
                entire semester/summer or year, as the case may be.
            </li>
            <li>
                <span>2.</span>
                When tuition and other fees are paid in full for a semester or a year or for a length of not longer than
                one month such fees may be refunded to a students who widthraws within the first 30 days from the date
                of his/her registration, under the following conditions:

                <ul class="list-style-none ml-3" id="sub-rules">
                    <li>
                        a.
                        5% discount on full cash payments at time registration
                    </li>
                    <li>
                        b.
                        80% of the amount paid for the tuition fee if he/she withdraws during the first week after
                        registration, whether, he/she attended classes or not
                    </li>
                    <li>
                        c.
                        50% within the second week, 30^ for the third week and 20% for the fourth week.
                    </li>
                    <li>
                        d.
                        No refund will be made 30days after registration
                    </li>
                    <li>
                        e.
                        A charge of 5% of the amount due shall be imposed for every month of delay
                    </li>
                    <li>
                        f.
                        Dropping of course 30 days after the date of enrollment<br><br>
                    </li>
                </ul>

            </li>
        </ul>

    </div>

</div>


<!-- Page Break -->
<div class="container-fluid">
    <div class="page-br"></div>
</div>

<div class="container my-3">
    <div class="form-wrapper mb-1">
        <div class="d-flex justify-content-between mb-3">
            <h5>Student's Name:
                <span class="underline"><?php echo e($assessment->student->last_name); ?>, <?php echo e($assessment->student->first_name); ?>

                    <?php echo e($assessment->student->middle_name); ?></span>
            </h5>
            <h5>School Year: <span class="underline"><?php echo e($assessment->enrollment->school_year->school_years); ?></span></h5>
        </div>

        <div class="d-flex justify-content-between">
            <h5>Civil Status: <span class="underline-bottom"><?php echo e($assessment->student->civil_status); ?>

                </span></h5>
            <h5>Nationality: <span class="underline-bottom"><?php echo e($assessment->student->citizenship); ?></span></h5>
        </div>

        <div class="d-flex justify-content-between">
            <h5>Contact Number: <span class="underline-bottom"><?php echo e($assessment->student->contact_number); ?></span></h5>
            <h5>Grade/Yr & Sec: <span class="underline-bottom"><?php echo e($assessment->enrollment->level->level_name); ?> <?php echo e($assessment->enrollment->section->section_name); ?></span>
            </h5>
        </div>

        <div class="d-flex justify-content-between">
            <h5>Provincial Address: <span class="underline-bottom"><?php echo e($assessment->student->address); ?></span></h5>
            <h5>Parents/Guardians: <span class="underline-bottom">Mr(s).
                    <?php echo e($assessment->student->guardian->first_name); ?> <?php echo e($assessment->student->guardian->last_name); ?></span>
            </h5>
        </div>
    </div>


    <!-- Table -->
    <table class="basic-table">
        <thead>
            <tr>
                <th class="text-uppercase min-w-100px">DATE</th>
                <th class="text-uppercase min-w-100px">RECEIPT NO.</th>
                <th class="text-uppercase min-w-100px">AMOUNT</th>
                <th class="text-uppercase min-w-100px">BALANCE</th>
            </tr>
        </thead>
        <tbody>
            <?php $fee_amount = $assessment->fee_amount; ?>
            <?php $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e(($row->updated_at) ? date_format($row->updated_at,"F d Y H:i:s") : ''); ?></td>
                <td><?php echo e($row->or_number); ?></td>
                <td><?php echo e(($row->payment_amount) ? "₱ ". $row->payment_amount: ''); ?></td>
                <td><?php echo e("₱ ".$fee_amount -= $row->payment_amount); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php for($i = 0; $i < 11 - count($payments); $i++): ?> 
            <tr>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
            </tr>
            <?php endfor; ?>

        </tbody>
    </table>
    <br><br><br><br>
</div>
<div class="container-fluid">
    <div class="page-br"></div>
</div>
<div class="container">

    <!-- Header -->
    <header class="mb-5">
        <div class="text-center">
            <span class="font-weight-bold header-title">
                PAETE SCIENCE AND BUSINESS COLLEGE, INC.
                <span>
                    <p class="location">PAETE, LAGUNA</p>
        </div>
    </header>

    <!-- Info -->
    <div class="rule">

        <ul class="list-style-none rules-list line-h">
            <li>
                &nbsp;&nbsp;&nbsp;In consideration for my admission to the PAETE SCIENCE AND BUSINESS COLLEGE and of the
                privileges of students in this institution.
                I hereby promise and pledge to abide by and comply with the rules and regulations laid downby competent
                authority thereof, to observe
                and support the system. Code of Manners and Discipline as enforce, in this college.
            </li>
            <li>
                &nbsp;&nbsp;&nbsp;I hereby acknowledge that I have read the rules of PAETE SCIENCE AND BUSINESS COLLEGE
                about fees and deposits.
                Being allowed solely for my convenience to pay my tuition fees by installment. I hereby promise to pay
                in full the unpaid balance for
                the entire semester, quarter or year, as the case may be; even if I should stop studying or transfer to
                another school.
            </li>
        </ul>

    </div>
    <div>
        <div class="row">
            <div class="col col-5">
                <div class="row">
                    <div class="col col-2">Name</div> 
                    <div class="col col-10" style="border-bottom: 1px solid black">
                        <?php echo e($assessment->student->last_name); ?>, <?php echo e($assessment->student->first_name); ?>

                    <?php echo e($assessment->student->middle_name); ?>

                    </div>
                </div>
            </div>
            <?php 
            
            $birthDate = explode("-", date("m-d-Y",strtotime($assessment->student->birth_day)));
            //get age from date or birthdate
            $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
                ? ((date("Y") - $birthDate[2]) - 1)
                : (date("Y") - $birthDate[2]));
                ?>
            <div class="col col-2">
                <div class="row">
                    <div class="col col-4">Age</div> 
                    <div class="col col-8" style="border-bottom: 1px solid black">
                        <?php echo e($age); ?>

                    </div>
                </div> 
            </div> 
            <div class="col col-2">
                <div class="row">
                    <div class="col col-4">Sex</div> 
                    <div class="col col-8" style="border-bottom: 1px solid black">
                        <?php echo e($assessment->student->gender); ?>

                    </div>
                </div> 
            </div>
            <div class="col col-3">
                <div class="row">
                    <div class="col col-4">Religion</div> 
                    <div class="col col-8" style="border-bottom: 1px solid black">
                        <?php echo e($assessment->student->religion); ?>

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col col-6">
                <div class="row">
                    <div class="col col-3">Date of Birth </div> 
                    <div class="col col-9" style="border-bottom: 1px solid black">
                        <?php echo e($assessment->student->birth_day); ?>

                    </div>
                </div>
            </div>
            <div class="col col-6">
                <div class="row">
                    <div class="col col-3">Place of Birth</div> 
                    <div class="col col-9" style="border-bottom: 1px solid black">
                        <?php echo e($assessment->student->birth_place); ?>

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col col-6">
                <div class="row">
                    <div class="col col-3">Email Address</div> 
                    <div class="col col-9" style="border-bottom: 1px solid black">
                        <?php echo e($assessment->student->email); ?>

                    </div>
                </div>
            </div>
            <div class="col col-6">
                <div class="row">
                    <div class="col col-4">Provincial Address</div> 
                    <div class="col col-8" style="border-bottom: 1px solid black">
                        <?php echo e($assessment->student->address); ?>

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col col-6">
                <div class="row">
                    <div class="col col-4">Parent/Guardian</div> 
                    <div class="col col-8" style="border-bottom: 1px solid black">
                        Mr(s).
                    <?php echo e($assessment->student->guardian->first_name); ?> <?php echo e($assessment->student->guardian->last_name); ?>

                    </div>
                </div>
            </div>
            <div class="col col-6">
                <div class="row">
                    <div class="col col-2">Address</div> 
                    <div class="col col-10" style="border-bottom: 1px solid black">
                        <?php echo e($assessment->student->guardian->address); ?>

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col col-12">
                <div class="row">
                    <div class="col col-2">Contact No.</div> 
                    <div class="col col-10" style="border-bottom: 1px solid black">
                        <?php echo e($assessment->student->contact_number); ?>

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col col-9">
                <div class="row">
                    <div class="col col-4">Intermediate Grade Completed at </div> 
                    <div class="col col-8" style="border-bottom: 1px solid black">
                    </div>
                </div>
            </div>
            <div class="col col-3">
                <div class="row">
                    <div class="col col-4">Year</div> 
                    <div class="col col-8" style="border-bottom: 1px solid black">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col col-12">
                <div class="row">
                    <div class="col col-4">Last School Attended, if any </div> 
                    <div class="col col-8" style="border-bottom: 1px solid black">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="signatures mt-4">

        <div class="d-flex justify-content-around">
            <p class="signature-line text-center">STUDENT'S SIGNATURE</p>
            <p class="signature-line text-center">ADDRESS</p>
        </div>
    </div>
</div><?php /**PATH C:\Users\user\Documents\psbc\resources\views/print/backpage.blade.php ENDPATH**/ ?>