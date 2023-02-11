<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayslipHistory extends Model
{
    use HasFactory;
    protected $table = "payslip_histories";
    protected $fillable =[
        "staff_cutoff",
        "staff_id","cutoff_id","basic_pay","daily_rate","required_days","semi_monthly_pay",
        "special_allowance","late_undertime","absence","canteen","tuition_fee",
        "sss","cash_advance","others",
    ];
}
