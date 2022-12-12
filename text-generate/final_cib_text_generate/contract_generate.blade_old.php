@extends('cib.layouts.master')
@section('title', 'Text Generate In System')

@section('css')
<!-- start -:- Datepicker3 CSS -->
<link href="{{ asset('public/assets/css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
<!-- end -:- Datepicker3 CSS -->

<!-- start -:- Date Range Picker CSS -->
<link href="{{ asset('public/assets/css/plugins/daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet">
<!-- end -:- Date Range Picker CSS -->

<!-- start -:- Select2 CSS -->
<link href="{{ asset('public/assets/css/plugins/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('public/assets/css/plugins/select2/select2-bootstrap4.min.css') }}" rel="stylesheet">
<!-- end -:- Select2 CSS -->
@endsection

@section('content')

@php

// include "config.php";
// error_reporting(E_ALL & ~E_NOTICE);
error_reporting('0');


// $report_branch_code = $_GET['g_date'];
// $report_date = $_GET['g_date'];
// $year_month = date("Y-m", strtotime($report_date));




function HFiller()
{
    $start  = 24;
    $end    = 600;
    $h_fill = '';
    for ($filler = $start; $filler <= $end; $filler++) {
        $h_fill = $h_fill . ' ';
    }
    return $h_fill;
}

$record_type = 'H';
$fi_code = '045';
$accounting_date =  date('tmY'); //Last date of current mont
$production_date =  date('dmY');; //Current date
//$code_link = '@@@'; //It changed
$date = Date('Y_m');
$line = 'contract'.'_'. $date . '.txt';

//my portion start

$conn = new mysqli("localhost", "root", "", "cib_13112022");
// $cib_db_conn = new mysqli("localhost", "root", "", "cbr_cib_db");

// $insertSqlForId = "INSERT INTO link_id (entry_date,entry_time) VALUES (CURDATE(),curtime())";
// $insertOperationForId = mysqli_query($conn, $insertSqlForId);

$selectSqlForId = "SELECT id FROM link_id ORDER BY id DESC LIMIT 1";
$selectOperationForId = mysqli_query($conn, $selectSqlForId);

$fetchedDataForId =  mysqli_fetch_array($selectOperationForId);

$l_id = $fetchedDataForId['id'];

if (strlen($l_id) == 1) {

    $code_link = '00' . $l_id;
} elseif (strlen($l_id) == 2) {

    $code_link = '0' . $l_id;
} else {

    $code_link = $l_id;
}
//my portion end





$h_filler = HFiller();
$final_header = $record_type . $fi_code . $accounting_date . $production_date . $code_link . $h_filler;

$file_text = file_put_contents($line, $final_header . PHP_EOL, FILE_APPEND);


function SpaceFiller($act_name, $name_filler)
{
    // include "config.php";
    $conn = new mysqli("localhost", "root", "", "cib_13112022");
    $sql2 = "SELECT $name_filler FROM installments_len ";
    $result2 = mysqli_query($conn, $sql2);
    $row =  mysqli_fetch_array($result2);
    $nm_fill = $row[$name_filler];
    $act_name_length = strlen($act_name);
    $fill = '';
    for ($filler = $act_name_length; $filler < $nm_fill; $filler++) {
        $fill = $fill . ' ';
    }
    return $act_name . $fill;
}

function dateFormatcorr($date)
{
    $temp_dt = explode("-", $date);
    $fix_dt = $temp_dt[0] . $temp_dt[1] . $temp_dt[2];
    return $fix_dt;
}

function restText()
{
    $start  = 124;
    $end    = 250;
    // $need_to_fill = $end - $start;

    $fill = '';
    for ($filler = $start; $filler <= $end; $filler++) {
        $fill = $fill . ' ';
    }
    return $fill;
}

$cib_db_conn = new mysqli("localhost", "root", "", "cbr_cib_db");

$sql = "SELECT * FROM cib_installments_contracts WHERE report_branch_code = '$report_branch_code' AND month_no = '$year_month'";
$result = mysqli_query($cib_db_conn, $sql);
$install_count = mysqli_num_rows($result);

while ($r = mysqli_fetch_array($result)) {
    $starting_date_of_the_contract = dateFormatcorr($r['starting_date_of_the_contract']);
    $request_date_of_the_contract = dateFormatcorr($r['request_date_of_the_contract']);
    $planned_end_date_of_the_contract = dateFormatcorr($r['planned_end_date_of_the_contract']);
    $actual_end_date_of_the_contract = dateFormatcorr($r['actual_end_date_of_the_contract']);
    $date_of_last_payment = dateFormatcorr($r['date_of_last_payment']);
    $expiration_date_of_next_installment = dateFormatcorr($r['expiration_date_of_next_installment']);
    $date_of_manufacturing = dateFormatcorr($r['date_of_manufacturing']);
    $date_of_law_suit = dateFormatcorr($r['date_of_law_suit']);
    $date_of_classification = dateFormatcorr($r['date_of_classification']);
    $date_of_last_rescheduling = dateFormatcorr($r['date_of_last_rescheduling']);


    $text_content = SpaceFiller($r['record_type'], "record_type")
        . SpaceFiller($r['fi_code'], "fi_code")
        . SpaceFiller($r['branch_code'], "branch_code")
        . SpaceFiller($r['fi_subject_code'], "fi_subject_code")
        . SpaceFiller($r['fi_contract_code'], "fi_contract_code")
        . SpaceFiller($r['contract_type'], "contract_type")
        . SpaceFiller($r['contract_phase'], "contract_phase")
        . SpaceFiller($r['contract_status'], "contract_status")
        . SpaceFiller($r['currency_code'], "currency_code")
        . SpaceFiller($starting_date_of_the_contract, "starting_date_of_the_contract")
        . SpaceFiller($request_date_of_the_contract, "request_date_of_the_contract")
        . SpaceFiller($planned_end_date_of_the_contract, "planned_end_date_of_the_contract")
        . SpaceFiller($actual_end_date_of_the_contract, "actual_end_date_of_the_contract")
        . SpaceFiller($r['default_status'], "default_status")
        . SpaceFiller($date_of_last_payment, "date_of_last_payment")
        . SpaceFiller($r['flag_subsidized_credit'], "flag_subsidized_credit")
        . SpaceFiller($r['flag_pre_finance_of_loan'], "flag_pre_finance_of_loan")
        . SpaceFiller($r['code_reorganized_credit'], "code_reorganized_credit")
        . SpaceFiller($r['third_party_guarantee_type'], "third_party_guarantee_type")
        . SpaceFiller($r['security_type'], "security_type")
        . SpaceFiller($r['amount_guaranteed_by_third_party_guarantor'], "amount_guaranteed_by_third_party_guarantor")
        . SpaceFiller($r['amount_guaranteed_by_security_type'], "amount_guaranteed_by_security_type")
        . SpaceFiller($r['basis_for_classification_qualitative_judgment'], "basis_for_classification_qualitative_judgment")
        . restText()
        . SpaceFiller($r['sanction_limit'], "sanction_limit")
        . SpaceFiller($r['total_disbursed_amount'], "total_disbursed_amount")
        . SpaceFiller($r['total_outstanding_amount'], "total_outstanding_amount")
        . SpaceFiller($r['total_number_of_installments'], "total_number_of_installments")
        . SpaceFiller($r['periodicity_of_payment'], "periodicity_of_payment")
        . SpaceFiller($r['method_of_payment'], "method_of_payment")
        . SpaceFiller($r['installment_amount'], "installment_amount")
        . SpaceFiller($expiration_date_of_next_installment, "expiration_date_of_next_installment")
        . SpaceFiller($r['amount_of_next_expiring_installment'], "amount_of_next_expiring_installment")
        . SpaceFiller($r['number_of_remaining_installments'], "number_of_remaining_installments")
        . SpaceFiller($r['remaining_amount'], "remaining_amount")
        . SpaceFiller($r['number_of_overdue_installment'], "number_of_overdue_installment")
        . SpaceFiller($r['overdue_amount'], "overdue_amount")
        . SpaceFiller($r['number_of_days_of_payment_delay'], "number_of_days_of_payment_delay")
        . SpaceFiller($r['type_of_leased_good'], "type_of_leased_good")
        . SpaceFiller($r['value_of_leased_good'], "value_of_leased_good")
        . SpaceFiller($r['registration_number'], "registration_number")
        . SpaceFiller($date_of_manufacturing, "date_of_manufacturing")
        . SpaceFiller($r['due_for_recovery'], "due_for_recovery")
        . SpaceFiller($r['recovery_during_the_reporting_period'], "recovery_during_the_reporting_period")
        . SpaceFiller($r['cumulative_recovery'], "cumulative_recovery")
        . SpaceFiller($date_of_law_suit, "date_of_law_suit")
        . SpaceFiller($date_of_classification, "date_of_classification")
        . SpaceFiller($r['no_of_time_rescheduling'], "no_of_time_rescheduling")
        . SpaceFiller($date_of_last_rescheduling, "date_of_last_rescheduling")
        . SpaceFiller($r['economic_purpose_code'], "economic_purpose_code")
        . SpaceFiller($r['sme'], "sme")
        . SpaceFiller($r['enterprise_type'], "enterprise_type");

    $final_text_len = strlen($text_content);
    $re_fill = '';
    for ($re_filler = $final_text_len; $re_filler < 600; $re_filler++) {
        $re_fill = $re_fill . ' ';
    }
    $remaining_data_filler =  $re_fill;

    $r_data_len = strlen($remaining_data_filler);
    $fixed_text_len = $final_text_len + $r_data_len;

    if ($fixed_text_len == 600) {
        $file_text = file_put_contents($line, $text_content . $remaining_data_filler . PHP_EOL, FILE_APPEND);
        //echo 'This is not error '.'<br>';
    } else {
        echo 'This is error for installment ' . $r['fi_subject_code'];
        exit();
    }
}


function NonistallSpaceFiller($act_name, $name_filler)
{
    // include "config.php";
    $conn = new mysqli("localhost", "root", "", "cib_13112022");
   
    $sql2 = "SELECT $name_filler FROM noninstall_len ";
    $result2 = mysqli_query($conn, $sql2);
    $row =  mysqli_fetch_array($result2);
    $nm_fill = $row[$name_filler];

    $act_name_length    = strlen($act_name);

    $fill = '';
    for ($filler = $act_name_length; $filler < $nm_fill; $filler++) {
        $fill = $fill . ' ';
    }

    return $act_name . $fill;
}


$cib_db_conn = new mysqli("localhost", "root", "", "cbr_cib_db");

$sql = "SELECT * FROM cib_noninstall_contracts WHERE report_branch_code = '$report_branch_code' AND month_no = '$year_month'";

$result = mysqli_query($cib_db_conn, $sql);

$noninstall_count = mysqli_num_rows($result);

while ($r = mysqli_fetch_array($result)) {

    $starting_date_contract = dateFormatcorr($r['starting_date_of_the_contract']);
    $request_date_contract = dateFormatcorr($r['request_date_of_the_contract']);
    $planned_end_datecontract = dateFormatcorr($r['planned_end_date_of_the_contract']);
    $dt_classification = dateFormatcorr($r['date_of_classification']);
    $dt_rescheduling = dateFormatcorr($r['no_of_time_rescheduling']);

    $text_content = NonistallSpaceFiller($r['record_type'], 'record_type')
        . NonistallSpaceFiller($r['fi_code'], 'fi_code')
        . NonistallSpaceFiller($r['branch_code'], 'branch_code')
        . NonistallSpaceFiller($r['fi_subject_code'], 'fi_subject_code')
        . NonistallSpaceFiller($r['fi_contract_code'], 'fi_contract_code')
        . NonistallSpaceFiller($r['contract_type'], 'contract_type')
        . NonistallSpaceFiller($r['contract_phase'], 'contract_phase')
        . NonistallSpaceFiller($r['contract_status'], 'contract_status')
        . NonistallSpaceFiller($r['currency_code'], 'currency_code')
        . NonistallSpaceFiller($starting_date_contract, 'starting_date_of_the_contract')
        . NonistallSpaceFiller($request_date_contract, 'request_date_of_the_contract')
        . NonistallSpaceFiller($planned_end_datecontract, 'planned_end_date_of_the_contract')
        . NonistallSpaceFiller($r['actual_end_date_of_the_contract'], 'actual_end_date_of_the_contract')
        . NonistallSpaceFiller($r['default_status'], 'default_status')
        . NonistallSpaceFiller($r['date_of_last_payment'], 'date_of_last_payment')
        . NonistallSpaceFiller($r['flag_subsidized_credit'], 'flag_subsidized_credit')
        . NonistallSpaceFiller($r['flag_pre_finance_of_loan'], 'flag_pre_finance_of_loan')
        . NonistallSpaceFiller($r['code_reorganized_credit'], 'code_reorganized_credit')
        . NonistallSpaceFiller($r['third_party_guarantee_type'], 'third_party_guarantee_type')
        . NonistallSpaceFiller($r['security_type'], 'security_type')
        . NonistallSpaceFiller($r['amount_guaranteed_by_third_party_guarantor'], 'amount_guaranteed_by_third_party_guarantor')
        . NonistallSpaceFiller($r['amount_guaranteed_by_security_type'], 'amount_guaranteed_by_security_type')
        . NonistallSpaceFiller($r['basis_for_classification_qualitative_judgment'], 'basis_for_classification_qualitative_judgment')
        . NonistallSpaceFiller($r['sanction_limit'], 'sanction_limit')
        . NonistallSpaceFiller($r['total_outstanding_amount'], 'total_outstanding_amount')
        . NonistallSpaceFiller($r['nr_of_days_of_payment_delay'], 'nr_of_days_of_payment_delay')
        . NonistallSpaceFiller($r['overdue_amount'], 'overdue_amount')
        . NonistallSpaceFiller($r['recovery_during_the_reporting_period'], 'recovery_during_the_reporting_period')
        . NonistallSpaceFiller($r['cumulative_recovery'], 'cumulative_recovery')
        . NonistallSpaceFiller(dateFormatcorr($r['date_of_law_suit']), 'date_of_law_suit')
        . NonistallSpaceFiller($dt_classification, 'date_of_classification')
        . NonistallSpaceFiller($dt_rescheduling, 'no_of_time_rescheduling')
        . NonistallSpaceFiller($r['economic_purpose_code'], 'economic_purpose_code')
        . NonistallSpaceFiller($r['sme'], 'sme')
        . NonistallSpaceFiller($r['enterprise_type'], 'enterprise_type');

    $final_text_len = strlen($text_content);

    $re_fill = '';
    for ($re_filler = $final_text_len; $re_filler < 600; $re_filler++) {
        $re_fill = $re_fill . ' ';
    }
    $remaining_data_filler =  $re_fill;
    $r_data_len = strlen($remaining_data_filler);
    $fixed_text_len = $final_text_len + $r_data_len;

    if ($fixed_text_len == 600) {
        $file_text = file_put_contents($line, $text_content . $remaining_data_filler . PHP_EOL, FILE_APPEND);
        //echo 'This is not error '.'<br>';
    } else {
        echo 'This is error for nonistallment ' . $r['fi_subject_code'];
        exit();
    }

    //$file_text = file_put_contents('contact.txt', $text_content .$remaining_data_filler . PHP_EOL, FILE_APPEND);
}

function Ffooter()
{
    $start = '28';
    $end   = '600';
    $f_fill = '';
    for ($filler = $start; $filler <= $end; $filler++) {
        $f_fill = $f_fill . ' ';
    }
    return $f_fill;
}
$f_record_type = 'Q';
$f_fi_code     = '045';
$f_accounting_date = date('tmY'); //Last date of current mont
$f_production_date = date('dmY'); //Current date
$f_total_record =  $install_count + $noninstall_count;
$f_filler = Ffooter();
$final_footer = $f_record_type . $f_fi_code . $f_accounting_date . $f_production_date . $f_total_record . $f_filler;

$file_text = file_put_contents($line, $final_footer . PHP_EOL, FILE_APPEND);
// echo "Done";

@endphp


<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2 class="text-uppercase">Contract Text</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="#">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="#">CIB</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Contract Text</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div id="loader" class="col-sm-12" style="display: none;">
            <img src="{{ asset('public/asset/loading.gif') }}">
        </div>
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                </div>
                <div class="ibox-content">
                    <span class="form-message"></span>
                    <form autocomplete="off" action="{{route('contract_text')}}" method="post" class="pull-form">
                        @csrf
                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class="row">

                                <div class="col-md-6">
                                <label ><strong>Select Reporting Branch</strong></label>
                                    <select class="form-control select2 fm_branch_code" name="report_branch_code">
                                        <option value="">--SELECT BRANCH--</option>
                                        @foreach($reporting_branches as $report_branch)
                                        <option value="{{$report_branch->report_branch_code}}">{{$report_branch->branch_name}} ({{$report_branch->report_branch_code}})</option>
                                        @endforeach                                     
                                    </select>
                                </div>


                                    <div class="col-md-6">
                                        <div class="row">
                                            <label class="col-md-12"><strong>Reporting  Month</strong></label>
                                            <div class="col-md-12">
                                                <div class="form-group datepicker-QY">
                                                    <div class="input-group date">
                                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                        <input type="text" class="form-control" name="cib_date" value='{{ date("Y-m", strtotime("-1 month")) }}' />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="tile-footer">
                                <div class="row">
                                    <div class="col-md-8 col-md-offset-3">
                                    <button class="btn btn-primary btn-sm" type="submit">Generate</button>
                                        <!-- <a href="http://localhost/final_cib_text_generate/contract.php" onclick="window.open('http://localhost/final_cib_text_generate/contract.php?g_date='+document.info.cib_date.value,'newwindow', 'width=700, height=450'); return false;" class="btn btn-primary"><i class="fa fa-fw fa-lg fa-check-circle"></i>Generate</a> -->
                                        
                                    </div>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


@section('js')
<!-- start -:- Datepicker JS -->
<script src="{{ asset('public/assets/js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
<!-- end -:- Datepicker JS -->

<!-- Date Range Use moment.js Same As Full Calendar Plugin -->
<script src="{{ asset('public/assets/js/plugins/fullcalendar/moment.min.js') }}"></script>

<!-- start -:- Date Range Picker JS -->
<script src="{{ asset('public/assets/js/plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- end -:- Date Range Picker JS -->

<!-- start -:- Select2 JS -->
<script src="{{ asset('public/assets/js/plugins/select2/select2.full.min.js') }}"></script>
<!-- end -:- Select2 JS -->

<script type="text/javascript">
    $(document).ready(function() {
        // start -:- Monthly Datepicker
        $(".datepicker-QY .input-group.date").datepicker({
            format: "yyyy-mm",
            startView: "months",
            minViewMode: "months",
            autoclose: true,
        });
        // end -:- Monthly Datepicker
        
    }); // end -:- Document Ready Section.
</script>
@endsection