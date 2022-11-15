<?php
include "config.php";
error_reporting(0);

function IndividualProprietorshipSpaceFiller($act_name,$name_filler){
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
    

    $text_content = IndividualProprietorshipSpaceFiller($r['record_type'],' record_type ')
    .IndividualProprietorshipSpaceFiller($r['fi_code'],'fi_code')
    .IndividualProprietorshipSpaceFiller($r['branch_code'],'branch_code')
    .IndividualProprietorshipSpaceFiller($r['fi_subject_code'],'fi_subject_code')
    .IndividualProprietorshipSpaceFiller($r['title'],'title')
    .IndividualProprietorshipSpaceFiller($r['trade_name'],'trade_name')
    .IndividualProprietorshipSpaceFiller($r['sector_type'],'sector_type')
    .IndividualProprietorshipSpaceFiller($r['sector_code'],'sector_code')
    .IndividualProprietorshipSpaceFiller($r['legal_form'],'legal_form')
    .IndividualProprietorshipSpaceFiller($r['registration_number'],'registration_number')
    .IndividualProprietorshipSpaceFiller($r['registration_date'],'registration_date')
    .IndividualProprietorshipSpaceFiller($r['tin'],'tin')
    .IndividualProprietorshipSpaceFiller($r['business_address_street_nr'],'business_address_street_nr')
    .IndividualProprietorshipSpaceFiller($r['business_address_postal_code'],'business_address_postal_code')
    .IndividualProprietorshipSpaceFiller($r['business_address_district'],'business_address_district')
    .IndividualProprietorshipSpaceFiller($r['business_address_country_code'],'business_address_country_code')
    .IndividualProprietorshipSpaceFiller($r['factory_address_street_nr'],'factory_address_street_nr')
    .IndividualProprietorshipSpaceFiller($r['factory_address_postal_code'],'factory_address_postal_code')
    .IndividualProprietorshipSpaceFiller($r['factory_address_district'],'factory_address_district')
    .IndividualProprietorshipSpaceFiller($r['factory_address_country_code'],'factory_address_country_code')
    .IndividualProprietorshipSpaceFiller($r['crg_scoring'],'crg_scoring')
    .IndividualProprietorshipSpaceFiller($r['credit_rating'],'credit_rating')
    .IndividualProprietorshipSpaceFiller($r['phone_nr'],'phone_nr');

    $final_text_len = strlen($text_content) + 1;

    $re_fill = '';
    for ($re_filler = $final_text_len; $re_filler < 1100; $re_filler++) {
        $re_fill = $re_fill . ' ';
    }
    $remaining_data_filler =  $re_fill;

    $file_text      = file_put_contents('IndividualProprietorship.txt', $text_content.$remaining_data_filler. PHP_EOL, FILE_APPEND);
}

