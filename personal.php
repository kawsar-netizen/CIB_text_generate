<?php
include "config.php";
error_reporting(0);

function SpaceFiller($act_name, $name_filler)
{
    include "config.php";
    $sql2 = "SELECT $name_filler FROM personal_len ";
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
//echo SpaceFiller('Bekayet Hossain Sheikh Mujib', 'name');

$sql = "SELECT * FROM cib_subject_personal where branch_code='0008'";

$result = mysqli_query($conn, $sql);

function dateFormatcorr($date)
{
    $temp_dt = explode("-", $date);
    $fix_dt = $temp_dt[0] . $temp_dt[1] . $temp_dt[2];
    return $fix_dt;
}

//  echo dateFormatcorr('08-02-1986');

while ($r = mysqli_fetch_array($result)) {

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
        . SpaceFiller($r['permanent_address_postal_code'], "permanent_address_postal_code")
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
        . SpaceFiller(dateFormatcorr($r['id_issue_date']),"id_issue_date")
        . SpaceFiller($r['id_issue_country_code'], "id_issue_country_code")
        . SpaceFiller($r['phone_nr'], "phone_nr");

        $final_text_len = strlen($text_content) + 1;

        $re_fill='';
        for($re_filler = $final_text_len; $re_filler < 1100; $re_filler++) { 
            $re_fill = $re_fill.' '; 
        }
        $remaining_data_filler =  $re_fill;

    $file_text = file_put_contents('personal.txt', $text_content.$remaining_data_filler . PHP_EOL, FILE_APPEND);

    
}
