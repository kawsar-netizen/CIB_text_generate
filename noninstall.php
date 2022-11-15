<?php
include "config.php";
error_reporting(0);

function NonistallSpaceFiller($act_name, $name_filler)
{
    include "config.php";
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


$sql = "SELECT * FROM cib_noninstall_contracts where branch_code='0033'";

$result = mysqli_query($conn, $sql);

function dateFormatcorr($date)
{
    $temp_dt = explode("-", $date);
    $fix_dt = $temp_dt[0] . $temp_dt[1] . $temp_dt[2];
    return $fix_dt;
}

while ($r = mysqli_fetch_array($result)) {


    $starting_date_contract     = dateFormatcorr($r['starting_date_of_the_contract']);

    $request_date_contract     = dateFormatcorr($r['request_date_of_the_contract']);

    $planned_end_datecontract     = dateFormatcorr($r['planned_end_date_of_the_contract']);

    $dt_classification          = dateFormatcorr($r['date_of_classification']);

    $dt_rescheduling            = dateFormatcorr($r['no_of_time_rescheduling']);

    $text_content = NonistallSpaceFiller($r['record_type'], ' record_type ')
        . NonistallSpaceFiller($r['fi_code'], 'fi_code')
        . NonistallSpaceFiller($r['branch_code'], 'branch_code')
        . NonistallSpaceFiller($r['fi_subject_code'], 'fi_subject_code')
        . NonistallSpaceFiller($r['fi_contract_code'], 'fi_contract_code')
        . NonistallSpaceFiller($r['contract_type'], 'contract_type')
        . NonistallSpaceFiller($r['contract_phase'], 'contract_phase')
        . NonistallSpaceFiller($r['contract_status'], 'contract_status')
        . NonistallSpaceFiller($r['currency_code'], 'currency_code')
        . NonistallSpaceFiller($starting_date_contract,'starting_date_of_the_contract')
        . NonistallSpaceFiller($request_date_contract , 'request_date_of_the_contract')
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

    $final_text_len = strlen($text_content) + 1;

    $re_fill = '';
    for ($re_filler = $final_text_len; $re_filler < 1100; $re_filler++) {
        $re_fill = $re_fill . ' ';
    }
    $remaining_data_filler =  $re_fill;

    $file_text      = file_put_contents('nonistall.txt', $text_content .$remaining_data_filler . PHP_EOL, FILE_APPEND);
}
