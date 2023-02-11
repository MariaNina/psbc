$(document).ready(function () {
    //initiate of axios
    const APi_URL = '/getSinglePayslip'
    // Default Header for Request
    axios.defaults.headers.common["X-CSRF-TOKEN"] = $(
        "meta[name='csrf-token']"
    ).attr("content");
    
    console.log('this is from console');


    // When Button Click
    $('#viewBtn').click(async (e) => {
        e.preventDefault();
        
        let cutOffDate = $('#salary_date').val();
        
        console.log(cutOffDate)
        
        if (cutOffDate != '') {

            try {

                const payslipResponse = await axios.post('/getSinglePayslip', {
                    cutOffDate: cutOffDate
                });

                const {user, payslip, now} = payslipResponse.data;
                
                // console.log(user)
                // console.log(payslip)
                // console.log(now)
                

                let paysHtml = '';

                /*
                let daily_pay = salary[i].salary_amount;
                let special_allowance = salary[i].special_allowance;
                let semi_monthly = required_day.weekdays * daily_pay;
                let gross_pay = semi_monthly + special_allowance;
                //deductions
                let absent = required_day.weekdays - resp.data.attendance[i] - resp.data.holidays;
                let absent_amount = absent * daily_pay;
                let canteen = resp.data.deductions[i].canteen;
                let tuition_fee = resp.data.deductions[i].tuition_fee;
                let cash_advance = resp.data.deductions[i].cash_advance;
                let sss = resp.data.deductions[i].sss;
                let others = resp.data.deductions[i].others;
                let total_deduction = absent_amount + canteen + tuition_fee + sss + cash_advance + others;
                let net_pay = gross_pay - total_deduction;*/

                if (payslip && user) {
                    let gross_pay = Number(payslip.semi_monthly_pay) + Number(payslip.special_allowance);
                    let total_deduction = payslip.absence + payslip.canteen + payslip.tuition_fee + payslip.sss + payslip.cash_advance + payslip.others;
                    let net_pay = gross_pay - total_deduction;

                    paysHtml += '<div class="text-center">';
                    paysHtml += '<span class="font-weight-bold header-title" style="line-height: 1px;">';
                    paysHtml += '<img src="img/logo.png" class="mr-4" alt="psbc-logo" width="40" height="40" />';
                    paysHtml += 'PAETE SCIENCE AND BUSINESS COLLEGE, INC.';
                    paysHtml += '<p class="location" style="line-height: 2px;">PAETE, LAGUNA</p></span></div>';
                    paysHtml += '<div class="row ml-4">';
                    paysHtml += '<div class="col-7">';
                    paysHtml += '<span class="font-weight-bold">Employee Payslip:' + user.bio_id + '</span><span id="payslip_id"></span><br>';
                    paysHtml += '<span class="font-weight-bold">Pay Type:</span> Semi-Monthly<br>';
                    paysHtml += '<span class="font-weight-bold">Name: ' + user.last_name + ', ' + user.first_name + '</span><span id="full_name"></span><br><span class="font-weight-bold">Employee Id: ' + user.bio_id + '</span><span id="staff_id"></span><br>';
                    paysHtml += '<span class="font-weight-bold">Department/Position: ' + user.Department + '/' + user.position + '</span><span id="dept_pos"></span><br></div>';
                    paysHtml += '<div class="col-5">';
                    paysHtml += '<span class="font-weight-bold">DTR Coverage: ' + payslip.start_date + '-' + payslip.end_date + '</span><span id="dtr_coverage"></span><br>';
                    paysHtml += '<span class="font-weight-bold">Pay Date: ' + payslip.pay_day + '</span><span id="pay_date"></span><br>';
                    paysHtml += '<span class="font-weight-bold">Print Date: ' + now + '</span><span id="today"></span><br></div></div>';
                    paysHtml += '<table class="table table-borderless" style="border: 1px solid;"><thead style="border: 1px solid;"><tr>';
                    paysHtml += '<th>EARNINGS</th><th>DEDUCTIONS</th><th>NET PAY</th></tr></thead>';
                    paysHtml += '<tbody style="border: 0px; padding:0;"><tr style="line-height: 0px;">';
                    paysHtml += '<td><div class="row"><div class="col-6">Basic Pay: </div><div class="col-6" id="basicpay">' + payslip.basic_pay.toFixed(2) + '</div></div></td>';
                    paysHtml += '<td><div class="row"><div class="col-3">Late/UTime</div><div class="col-3">' + payslip.late_undertime + '</div><div class="col-3">Others:</div><div class="col-3">' + payslip.others + '</div></div></td><td></td></tr>';
                    paysHtml += '<tr style="line-height: 0px;"><td><div class="row"><div class="col-6">Daily Rate</div><div class="col-6" id="daily_rate">' + payslip.daily_rate.toFixed(2) + '</div></div></td>';
                    paysHtml += '<td><div class="row"><div class="col-3">Absence:</div><div class="col-3" id="absence">' + payslip.absence.toFixed(2) + '</div><div class="col-3"></div><div class="col-3"></div></div></td>';
                    paysHtml += '<td></td></tr><tr style="line-height: 0px;"><td><div class="row"><div class="col-6">No. of Days:</div><div class="col-6" id="no_days">' + payslip.required_days + '</div></div></td><td>';
                    paysHtml += '<div class="row"><div class="col-3">Canteen: </div><div class="col-3">' + payslip.canteen + '</div><div class="col-3"></div><div class="col-3"></div></div></td>';
                    paysHtml += '<td></td></tr><tr style="line-height: 0px;"><td><div class="row"><div class="col-6">Semi-Monthly Pay:</div><div class="col-6" id="pay">' + payslip.semi_monthly_pay.toFixed(2) + '</div></div></td>';
                    paysHtml += '<td><div class="row"><div class="col-3">Tuition Fee: </div><div class="col-3">' + payslip.tuition_fee.toFixed(2) + '</div><div class="col-3">CA: </div><div class="col-3">' + payslip.cash_advance.toFixed(2) + '</div></div></td><td></td></tr>';
                    paysHtml += '<tr style="line-height: 0px;"><td><div class="row"><div class="col-6">Special Allow.:</div><div class="col-6">' + payslip.special_allowance.toFixed(2) + '</div></div></td><td><div class="row"><div class="col-3">SSS: </div><div class="col-3">' + payslip.sss.toFixed(2) + '</div><div class="col-3"></div>';
                    paysHtml += '<div class="col-3"></div></div></td><td></td></tr>';
                    paysHtml += '<tr style="line-height: 0px; border:1px solid;"><td><div class="row">';
                    paysHtml += '<div class="col-6">Gross Pay:</div><div class="col-6" id="gross">' + gross_pay.toFixed(2) + '</div></div></td><td>';
                    paysHtml += '<div class="row"><div class="col-3">Deduction</div><div class="col-3"></div><div class="col-3"></div><div class="col-3" id="deduction">' + total_deduction.toFixed(2) + '</div></div></td>';
                    paysHtml += '<td>Total net Pay: <span id="total_net">' + net_pay.toFixed(2) + '</span></td></tr></tbody></table>';
                } else {
                    paysHtml += `
                    <div>
                        <h5 class="text-center">No Payslip</h5>
                    </div>
                    `;
                    
                    //console.log(payslipResponse)
                }


                $('#payslip').html(paysHtml);
            } catch (e) {
                console.error(e.message);
            }


        }

    });

})
