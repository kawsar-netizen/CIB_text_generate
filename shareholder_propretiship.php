<?php
include "config.php";
error_reporting(0);

function ShareholderPropretishipSpaceFiller($act_name, $name_filler)
{
    include "config.php";
    $sql2 = "SELECT $name_filler FROM links_shareholder_propretiship_len ";
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


$sql = "SELECT * FROM cib_links_shareholder_propretiship where branch_code='0010'";

$result = mysqli_query($conn, $sql);


while ($r = mysqli_fetch_array($result)) {


    $text_content = ShareholderPropretishipSpaceFiller($r['record_type'], ' record_type ')
        . ShareholderPropretishipSpaceFiller($r['fi_code'], 'fi_code')
        . ShareholderPropretishipSpaceFiller($r['branch_code'], 'branch_code')
        . ShareholderPropretishipSpaceFiller($r['fi_subject_code'], 'fi_subject_code')
        . ShareholderPropretishipSpaceFiller($r['role'], 'role')
        . ShareholderPropretishipSpaceFiller($r['fi_subject_code_of_owner'], 'fi_subject_code_of_owner');

    $final_text_len = strlen($text_content) + 1;

    $re_fill = '';
    for ($re_filler = $final_text_len; $re_filler < 1100; $re_filler++) {
        $re_fill = $re_fill . ' ';
    }
    $remaining_data_filler =  $re_fill;

    $file_text      = file_put_contents('ShareholderPropretiship.txt', $text_content . $remaining_data_filler . PHP_EOL, FILE_APPEND);
}
