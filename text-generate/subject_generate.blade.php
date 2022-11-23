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
error_reporting(0);
// $report_branch_code = $_GET['g_date'];
// $report_date = $_GET['g_date'];
// $year_month = date("Y-m", strtotime($report_date));


function HFiller()
{
    $start  = 24;
    $end    = 1100;
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

//my portion start

$conn = new mysqli("localhost", "root", "", "cib_13112022");

$insertSqlForId = "INSERT INTO link_id (entry_date,entry_time) VALUES (CURDATE(),curtime())";
$insertOperationForId = mysqli_query($conn, $insertSqlForId);

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


//header format start
$h_filler = HFiller();
$final_header = $record_type . $fi_code . $accounting_date . $production_date . $code_link . $h_filler;
$file_text = file_put_contents('subject.txt', $final_header . PHP_EOL, FILE_APPEND);
//header format end



function IndividualProprietorshipSpaceFiller($act_name, $name_filler)
{
    // include "config.php";

    $conn = new mysqli("localhost", "root", "", "cib_13112022");

    $sql2 = "SELECT $name_filler FROM subject_individual_proprietorship_info_len";
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



$cib_db_conn = new mysqli("localhost", "root", "", "cbr_cib_db");

$sql = "SELECT * FROM cib_subject_individual_proprietorship_info WHERE report_branch_code = '$report_branch_code' AND month_no = '$year_month'";

$result = mysqli_query($cib_db_conn, $sql);

$ind_count = mysqli_num_rows($result);

function dateFormatcorr($date)
{
    $temp_dt = explode("-", $date);
    $fix_dt = $temp_dt[0] . $temp_dt[1] . $temp_dt[2];
    return $fix_dt;
}

while ($r = mysqli_fetch_array($result)) {

    $registration_date     = dateFormatcorr($r['registration_date']);

    //Check if your variable is an integer
    $business_address_postal_code = '';
    if (filter_var($r['business_address_postal_code'], FILTER_VALIDATE_INT) === false) {
        $business_address_postal_code = '    ';
    } else {
        $business_address_postal_code = $r['business_address_postal_code'];
    }

    $text_content = IndividualProprietorshipSpaceFiller($r['record_type'], 'record_type')
        . IndividualProprietorshipSpaceFiller($r['fi_code'], 'fi_code')
        . IndividualProprietorshipSpaceFiller($r['branch_code'], 'branch_code')
        . IndividualProprietorshipSpaceFiller($r['fi_subject_code'], 'fi_subject_code')
        . IndividualProprietorshipSpaceFiller($r['title'], 'title')
        . IndividualProprietorshipSpaceFiller($r['trade_name'], 'trade_name')
        . IndividualProprietorshipSpaceFiller($r['sector_type'], 'sector_type')
        . IndividualProprietorshipSpaceFiller($r['sector_code'], 'sector_code')
        . IndividualProprietorshipSpaceFiller($r['legal_form'], 'legal_form')
        . IndividualProprietorshipSpaceFiller($r['registration_number'], 'registration_number')
        . IndividualProprietorshipSpaceFiller($registration_date, 'registration_date')
        . IndividualProprietorshipSpaceFiller($r['tin'], 'tin')
        . IndividualProprietorshipSpaceFiller($r['business_address_street_nr'], 'business_address_street_nr')
        . IndividualProprietorshipSpaceFiller($business_address_postal_code, 'business_address_postal_code')
        . IndividualProprietorshipSpaceFiller($r['business_address_district'], 'business_address_district')
        . IndividualProprietorshipSpaceFiller($r['business_address_country_code'], 'business_address_country_code')
        . IndividualProprietorshipSpaceFiller($r['factory_address_street_nr'], 'factory_address_street_nr')
        . IndividualProprietorshipSpaceFiller($r['factory_address_postal_code'], 'factory_address_postal_code')
        . IndividualProprietorshipSpaceFiller($r['factory_address_district'], 'factory_address_district')
        . IndividualProprietorshipSpaceFiller($r['factory_address_country_code'], 'factory_address_country_code')
        . IndividualProprietorshipSpaceFiller($r['crg_scoring'], 'crg_scoring')
        . IndividualProprietorshipSpaceFiller($r['credit_rating'], 'credit_rating')
        . IndividualProprietorshipSpaceFiller($r['phone_nr'], 'phone_nr');

    $final_text_len = strlen($text_content);

    $re_fill = '';
    for ($re_filler = $final_text_len; $re_filler < 1100; $re_filler++) {
        $re_fill = $re_fill . ' ';
    }
    $remaining_data_filler =  $re_fill;

    $r_data_len = strlen($remaining_data_filler);
    $fixed_text_len = $final_text_len + $r_data_len;

    if ($fixed_text_len == 1100) {
        $file_text = file_put_contents('subject.txt', $text_content . $remaining_data_filler . PHP_EOL, FILE_APPEND);
        //echo 'This is not error '.'<br>';
    } else {
        echo 'This is error ' . $r['fi_subject_code'];
        exit();
    }
}



function SpaceFiller($act_name, $name_filler)
{
    // include "config.php";
    $conn = new mysqli("localhost", "root", "", "cib_13112022");

    $sql2 = "SELECT $name_filler FROM personal_len";
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

$sql = "SELECT * FROM cib_subject_personal WHERE report_branch_code = '$report_branch_code' AND month_no = '$year_month'";

$result = mysqli_query($cib_db_conn, $sql);

$p_count = mysqli_num_rows($result);


while ($r = mysqli_fetch_array($result)) {

    # Check if your variable is an integer
    $permanent_address_postal_code = '';
    if (filter_var($r['permanent_address_postal_code'], FILTER_VALIDATE_INT) === false) {
        $permanent_address_postal_code = '    ';
    } else {
        $permanent_address_postal_code = $r['permanent_address_postal_code'];
    }

    $dt_birth = dateFormatcorr($r['date_of_birth']);

    $text_content = SpaceFiller($r['record_type'], "record_type")
        . SpaceFiller($r['fi_code'], "fi_code")
        . SpaceFiller($r['branch_code'], "branch_code")
        . SpaceFiller($r['fi_subject_code'], "fi_subject_code")
        . SpaceFiller($r['title'], "title")
        . SpaceFiller($r['name'], "name")
        . SpaceFiller($r['father_title'], "father_title")
        . SpaceFiller($r['father_name'], "father_name")
        . SpaceFiller($r['mother_title'], "mother_title")
        . SpaceFiller($r['mother_name'], "mother_name")
        . SpaceFiller($r['spouse_title'], "spouse_title")
        . SpaceFiller($r['spouse_name'], "spouse_name")
        . SpaceFiller($r['sector_type'], "sector_type")
        . SpaceFiller($r['sector_code'], "sector_code")
        . SpaceFiller($r['gender'], "gender")
        . SpaceFiller($dt_birth, "date_of_birth")
        . SpaceFiller($r['place_of_birth_district'], "place_of_birth_district")
        . SpaceFiller($r['country_of_birth_code'], "country_of_birth_code")
        . SpaceFiller($r['national_id_number'], "national_id_number")
        . SpaceFiller($r['national_id_number_available'], "national_id_number_available")
        . SpaceFiller($r['tin'], "tin")
        . SpaceFiller($r['permanent_address_street_nr'], "permanent_address_street_nr")
        . SpaceFiller($permanent_address_postal_code, "permanent_address_postal_code")
        . SpaceFiller($r['permanent_address_district'], "permanent_address_district")
        . SpaceFiller($r['permanent_address_country_code'], "permanent_address_country_code")
        . SpaceFiller($r['present_address_street_nr'], "present_address_street_nr")
        . SpaceFiller($r['present_address_postal_code'], "present_address_postal_code")
        . SpaceFiller($r['present_address_district'], "present_address_district")
        . SpaceFiller($r['present_address_country_code'], "present_address_country_code")
        . SpaceFiller($r['business_address'], "business_address")
        . SpaceFiller($r['business_address_postal_code'], "business_address_postal_code")
        . SpaceFiller($r['business_address_district'], "business_address_district")
        . SpaceFiller($r['business_address_country_code'], "business_address_country_code")
        . SpaceFiller($r['id_type'], "id_type")
        . SpaceFiller($r['id_nr'], "id_nr")
        . SpaceFiller(dateFormatcorr($r['id_issue_date']), "id_issue_date")
        . SpaceFiller($r['id_issue_country_code'], "id_issue_country_code")
        . SpaceFiller($r['phone_nr'], "phone_nr");

    $final_text_len = strlen($text_content);

    $re_fill = '';
    for ($re_filler = $final_text_len; $re_filler < 1100; $re_filler++) {
        $re_fill = $re_fill . ' ';
    }
    $remaining_data_filler =  $re_fill;

    $r_data_len = strlen($remaining_data_filler);
    $fixed_text_len = $final_text_len + $r_data_len;

    if ($fixed_text_len == 1100) {
        $file_text = file_put_contents('subject.txt', $text_content . $remaining_data_filler . PHP_EOL, FILE_APPEND);
        //echo 'This is not error '.'<br>';
    } else {
        echo 'This is error ' . $r['fi_subject_code'];
        exit();
    }
}





function CompanySpaceFiller($act_name, $name_filler)
{
    // include "config.php";
    $conn = new mysqli("localhost", "root", "", "cib_13112022");

    $sql2 = "SELECT $name_filler FROM subject_company_len";
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

$sql = "SELECT * FROM cib_subject_company_info WHERE report_branch_code = '$report_branch_code' AND month_no = '$year_month'";

$result     = mysqli_query($cib_db_conn, $sql);
$c_count = mysqli_num_rows($result);

while ($r = mysqli_fetch_array($result)) {
    # Check if your variable is an integer
    $business_address_postal_code = '';
    if (filter_var($r['business_address_postal_code'], FILTER_VALIDATE_INT) === false) {
        $business_address_postal_code = '    ';
    } else {
        $business_address_postal_code = $r['business_address_postal_code'];
    }

    $registration_date = dateFormatcorr($r['registration_date']);
    $text_content = CompanySpaceFiller($r['record_type'], "record_type")
        . CompanySpaceFiller($r['fi_code'], "fi_code")
        . CompanySpaceFiller($r['branch_code'], "branch_code")
        . CompanySpaceFiller($r['fi_subject_code'], "fi_subject_code")
        . CompanySpaceFiller($r['title'], "title")
        . CompanySpaceFiller($r['trade_name'], "trade_name")
        . CompanySpaceFiller($r['sector_type'], "sector_type")
        . CompanySpaceFiller($r['sector_code'], "sector_code")
        . CompanySpaceFiller($r['legal_form'], "legal_form")
        . CompanySpaceFiller($r['registration_number'], "registration_number")
        . CompanySpaceFiller($registration_date, "registration_date")
        . CompanySpaceFiller($r['tin'], "tin")
        . CompanySpaceFiller($r['business_address_street_nr'], "business_address_street_nr")
        . CompanySpaceFiller($business_address_postal_code, "business_address_postal_code")
        . CompanySpaceFiller($r['business_address_district'], "business_address_district")
        . CompanySpaceFiller($r['business_address_country_code'], "business_address_country_code")
        . CompanySpaceFiller($r['factory_address_street_nr'], "factory_address_street_nr")
        . CompanySpaceFiller($r['factory_address_postal_code'], "factory_address_postal_code")
        . CompanySpaceFiller($r['factory_address_district'], "factory_address_district")
        . CompanySpaceFiller($r['factory_address_country_code'], "factory_address_country_code")
        . CompanySpaceFiller($r['crg_scoring'], "crg_scoring")
        . CompanySpaceFiller($r['credit_rating'], "credit_rating")
        . CompanySpaceFiller($r['phone_nr'], "phone_nr");


    $final_text_len = strlen($text_content);
    $re_fill = '';
    for ($re_filler = $final_text_len; $re_filler < 1100; $re_filler++) {
        $re_fill = $re_fill . ' ';
    }

    $remaining_data_filler =  $re_fill;
    $r_data_len = strlen($remaining_data_filler);
    $fixed_text_len = $final_text_len + $r_data_len;

    if ($fixed_text_len == 1100) {
        $file_text = file_put_contents('subject.txt', $text_content . $remaining_data_filler . PHP_EOL, FILE_APPEND);
        //echo 'This is not error '.'<br>';
    } else {
        echo 'This is error ' . $r['fi_subject_code'];
        exit();
    }
}


function ShareholderPropretishipSpaceFiller($act_name, $name_filler)
{
    // include "config.php";
    $conn = new mysqli("localhost", "root", "", "cib_13112022");

    $sql2 = "SELECT $name_filler FROM links_shareholder_propretiship_len";
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

$sql = "SELECT * FROM cib_links_shareholder_propretiship WHERE report_branch_code = '$report_branch_code' AND month_no = '$year_month'";


$result = mysqli_query($cib_db_conn, $sql);
$s_count = mysqli_num_rows($result);

while ($r = mysqli_fetch_array($result)) {


    $text_content = ShareholderPropretishipSpaceFiller($r['record_type'], ' record_type ')
        . ShareholderPropretishipSpaceFiller($r['fi_code'], 'fi_code')
        . ShareholderPropretishipSpaceFiller($r['branch_code'], 'branch_code')
        . ShareholderPropretishipSpaceFiller($r['fi_subject_code'], 'fi_subject_code')
        . ShareholderPropretishipSpaceFiller($r['role'], 'role')
        . ShareholderPropretishipSpaceFiller($r['fi_subject_code_of_owner'], 'fi_subject_code_of_owner');

    $final_text_len = strlen($text_content);

    $re_fill = '';
    for ($re_filler = $final_text_len; $re_filler < 1100; $re_filler++) {
        $re_fill = $re_fill . ' ';
    }
    $remaining_data_filler =  $re_fill;

    $r_data_len = strlen($remaining_data_filler);
    $fixed_text_len = $final_text_len + $r_data_len;

    if ($fixed_text_len == 1100) {
        $file_text = file_put_contents('subject.txt', $text_content . $remaining_data_filler . PHP_EOL, FILE_APPEND);
        //echo 'This is not error '.'<br>';
    } else {
        echo 'This is error ' . $r['fi_subject_code'];
        exit();
    }

    // $file_text      = file_put_contents('subject.txt', $text_content . $remaining_data_filler . PHP_EOL, FILE_APPEND);
}


function Ffooter()
{
    $start = '28';
    $end   = '1100';
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
$f_total_record =  $ind_count + $p_count + $c_count + $s_count;
$f_filler = Ffooter();
$final_footer = $f_record_type . $f_fi_code . $f_accounting_date . $f_production_date . $f_total_record . $f_filler;

$file_text    = file_put_contents('subject.txt', $final_footer . PHP_EOL, FILE_APPEND);
// echo "Done";

@endphp

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2 class="text-uppercase">Subject Text</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="#">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="#">CIB</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Subject Text</strong>
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
                    <form autocomplete="off" action="{{route('subject_text')}}" method="post" class="pull-form">
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
                                    <button class="btn btn-primary btn-sm" type="submit">Sgen</button>
                                        <!-- <a href="http://localhost/final_cib_text_generate/subject.php"
                                            onclick="window.open('http://localhost/final_cib_text_generate/subject.php?g_date='+document.info.cib_date.value,'newwindow', 'width=700, height=450'); return false;"
                                            class="btn btn-primary"><i
                                                class="fa fa-fw fa-lg fa-check-circle"></i>Generate</a> -->
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