<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateApplicationStatusViewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE OR REPLACE VIEW application_status_view as
        SELECT DISTINCT(a.id), a.student_id, a.application_no, a.subject_ids, a.student_department, b.fees, c.id as paymentId, d.user_id, d.first_name, d.last_name, CASE WHEN a.is_approved = 0 THEN 'For Approval' WHEN a.is_approved = 1 THEN CASE WHEN b.fees is null THEN 'For Assessment' ELSE CASE WHEN c.id is null THEN 'For Payment' ELSE 'Enrolled' END END ELSE 'Rejected' END AS STATUS FROM `enrollment_tbls` a LEFT JOIN assessments_tbls b ON (a.id = b.enrollment_id) LEFT JOIN payment_history_tbls c ON (b.id = c.assessments_id)
        LEFT JOIN students_tbls d ON (a.student_id = d.id)");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW application_status_view");
    }
}
