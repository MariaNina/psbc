$(document).ready(function () {

    //initiate of axios
    const page_url ='/view_college_payslip'
    // Default Header for Request
    axios.defaults.headers.common["X-CSRF-TOKEN"] = $(
        "meta[name='csrf-token']"
    ).attr("content");

    $('#card_payslip').hide(); // hide payslip card
    $('#intro').text("Select Salary date and or employee name to show payslip");
    //click filter button
    // const getPayslipDatas =(e)=>{
    //     let id = $('#employee_name').val();
    //     let sub_id =$('#salary_date').val();
    //     e.preventDefault();
    //     axios.get(page_url+"/"+id+"?date_id="+sub_id).then(resp => {
    //         $('#card_payslip').show();
    //         $('#intro').hide();
    //         console.log(resp.data);
    //         const data =resp.data;
    //         const today = new Date();
    //         $('#payslip_id').text(data.staff.bio_id);
    //         $('#staff_id').text(data.staff.id);
    //         $('#full_name').text(data.staff.last_name+", "+data.staff.first_name+" "+data.staff.middle_name);
    //         $('#dept_pos').text(data.staff.Department+'/'+data.staff.position);
    //         $('#dtr_coverage').text(data.cutoff.start_date+" - "+data.cutoff.end_date);
    //         $('#pay_date').text(data.cutoff.pay_day);
    //         $('#today').text(today.getFullYear()+"-"+today.getDate()+"-"+today.getMonth());
    //         //all Earnings
    //         $('#daily_rate').text(data.daily_rate.salary_amount);
    //         $('#no_days').text(data.count_cutoff_date.weekdays);
    //         let semi_monthly = data.count_cutoff_date.weekdays* data.daily_rate.salary_amount;
    //         $('#basicpay').text(semi_monthly);
    //         $('#pay').text(semi_monthly);
    //         let gross_pay = semi_monthly;
    //         $('#gross').text(gross_pay);
    //         //all deductions
    //         $('#absence').text(data.count_cutoff_date.weekdays - data.attendance -data.holidays);
    //         let deduction = ((data.count_cutoff_date.weekdays - data.attendance - data.holidays)*data.daily_rate.salary_amount);
    //         $('#deduction').text(deduction);

    //         //total netpay
    //         let totalnet = gross_pay - deduction;
    //         $('#total_net').text(totalnet);
    //     }).catch(e=>{console.log(e)})
    // }
//get all payslips
const getAllPayslipData=(e)=>{
    e.preventDefault();
    let sub_id =$('#salary_date').val();
    axios.get(page_url+'/all?date_id='+sub_id).then(resp =>{
        console.log(resp.data);
        let payslipHistories = resp.data.payslipHistory;
        let paysHtml ='';
        let today = new Date();
        let month =[1,2,3,4,5,6,7,8,9,10,11,12];
        let cutOff = resp.data.cutoff;
        // let salary = resp.data.salary;
        let required_day =resp.data.count_cutoff_date;
        let i =0;
        payslipHistories.forEach(payslipHistory => {
        let daily_pay = payslipHistory.daily_rate;
        let special_allowance = payslipHistory.special_allowance;
        let semi_monthly = payslipHistory.semi_monthly_pay;
        let gross_pay = semi_monthly+special_allowance;
        //deductions
        let absent_amount = payslipHistory.absence;
        let canteen = payslipHistory.canteen;
        let tuition_fee = payslipHistory.tuition_fee;
        let cash_advance = payslipHistory.cash_advance;
        let sss = payslipHistory.sss;
        let others = payslipHistory.others;
        let late_undertime = payslipHistory.late_undertime;
        let total_deduction = absent_amount+canteen+tuition_fee+sss+cash_advance+others+late_undertime;
        let net_pay = gross_pay - total_deduction;
        i++;
        paysHtml += '<div class="text-center">';    
        paysHtml+='<span class="font-weight-bold header-title" style="line-height: 1px;">';
        paysHtml+='<img src="/img/logo.png" class="mr-4" alt="psbc-logo" width="40" height="40" />';
        paysHtml+='PAETE SCIENCE AND BUSINESS COLLEGE, INC.';
        paysHtml+='<p class="location" style="line-height: 2px;">PAETE, LAGUNA</p></span></div>';
        paysHtml+='<div class="row ml-4">';
        paysHtml+='<div class="col-7">';
        paysHtml+='<span class="font-weight-bold">Employee Payslip:'+payslipHistory.bio_id+'</span><span id="payslip_id"></span><br>';
        paysHtml+='<span class="font-weight-bold">Pay Type:</span> Semi-Monthly<br>';
        paysHtml+='<span class="font-weight-bold">Name: '+payslipHistory.last_name+', '+payslipHistory.first_name+'</span><span id="full_name"></span><br><span class="font-weight-bold">Employee Id: '+payslipHistory.bio_id+'</span><span id="staff_id"></span><br>';
        paysHtml+='<span class="font-weight-bold">Department/Position: '+payslipHistory.Department+'/'+payslipHistory.position+'</span><span id="dept_pos"></span><br></div>';
        paysHtml+='<div class="col-5">';
        paysHtml+='<span class="font-weight-bold">DTR Coverage: '+cutOff.start_date+'-'+cutOff.end_date+'</span><span id="dtr_coverage"></span><br>';
        paysHtml+='<span class="font-weight-bold">Pay Date: '+$("#salary_date :selected").text()+'</span><span id="pay_date"></span><br>';
        paysHtml+='<span class="font-weight-bold">Print Date: '+today.getFullYear()+"-"+today.getDate()+"-"+month[today.getMonth()]+'</span><span id="today"></span><br></div></div>';
        paysHtml+='<table class="table table-borderless" style="border: 1px solid;"><thead style="border: 1px solid;"><tr>';
        paysHtml+='<th>EARNINGS</th><th>DEDUCTIONS</th><th>NET PAY</th></tr></thead>';
        paysHtml+='<tbody style="border: 0px; padding:0;"><tr style="line-height: 0px;">';
        paysHtml+='<td><div class="row"><div class="col-6">Basic Pay: </div><div class="col-6" id="basicpay">'+semi_monthly.toFixed(2)+'</div></div></td>';
        paysHtml+='<td><div class="row"><div class="col-3">Late/UTime</div><div class="col-3">'+late_undertime.toFixed(2)+'</div><div class="col-3">Others:</div><div class="col-3">'+others.toFixed(2)+'</div></div></td><td></td></tr>';
        paysHtml+='<tr style="line-height: 0px;"><td><div class="row"><div class="col-6">Hourly/Daily Rate</div><div class="col-6" id="daily_rate">'+daily_pay.toFixed(2)+'</div></div></td>';
        paysHtml+='<td><div class="row"><div class="col-3">Absence:</div><div class="col-3" id="absence">'+absent_amount.toFixed(2)+'</div><div class="col-3"></div><div class="col-3"></div></div></td>';
        paysHtml+='<td></td></tr><tr style="line-height: 0px;"><td><div class="row"><div class="col-6">No. of Hours:</div><div class="col-6" id="no_days">'+payslipHistory.required_days+'</div></div></td><td>';
        paysHtml+='<div class="row"><div class="col-3">Canteen: </div><div class="col-3">'+canteen.toFixed(2)+'</div><div class="col-3"></div><div class="col-3"></div></div></td>';
        paysHtml+='<td></td></tr><tr style="line-height: 0px;"><td><div class="row"><div class="col-6">Semi-Monthly Pay:</div><div class="col-6" id="pay">'+semi_monthly.toFixed(2)+'</div></div></td>';
        paysHtml+='<td><div class="row"><div class="col-3">Tuition Fee: </div><div class="col-3">'+tuition_fee.toFixed(2)+'</div><div class="col-3">CA: </div><div class="col-3">'+cash_advance.toFixed(2)+'</div></div></td><td></td></tr>';
        paysHtml+='<tr style="line-height: 0px;"><td><div class="row"><div class="col-6">Special Allow.:</div><div class="col-6">'+special_allowance.toFixed(2)+'</div></div></td><td><div class="row"><div class="col-3">SSS: </div><div class="col-3">'+sss.toFixed(2)+'</div><div class="col-3"></div>';
        paysHtml+='<div class="col-3"></div></div></td><td></td></tr>';
        paysHtml+='<tr style="line-height: 0px; border:1px solid;"><td><div class="row">';
        paysHtml+='<div class="col-6">Gross Pay:</div><div class="col-6" id="gross">'+gross_pay.toFixed(2)+'</div></div></td><td>';
        paysHtml+='<div class="row"><div class="col-3">Deduction</div><div class="col-3"></div><div class="col-3"></div><div class="col-3" id="deduction">'+total_deduction.toFixed(2)+'</div></div></td>';
        paysHtml+='<td>Total net Pay: <span id="total_net">'+net_pay.toFixed(2)+'</span></td></tr></tbody></table><hr style="background-color: black;">'; 
       
    });
    $('#payslips').html(paysHtml);
    }).catch(e=>{console.log(e)})
}

//add to buttons the functions
    $('#generate').click(getAllPayslipData);
    $('#payslipFilter').submit(getAllPayslipData); //adding function to filter button


});
