<?php
include "config.php";

$sql2       = "SELECT * FROM personal_len";
$result2    = mysqli_query($conn, $sql2);
$row        = mysqli_fetch_array($result2);
$title_len  = $row['title'];
$name_len   = $row['name'];
$nid_len  = $row['national_id_number'];


$sql = "SELECT sbj_personal_data_key,record_type,fi_code,branch_code, fi_subject_code,title,name,national_id_number  FROM cib_subject_personal where branch_code='0008' limit 12";

$result     = mysqli_query($conn, $sql);


while ($r = mysqli_fetch_array($result)) {


    $title_length    = strlen($r['title']);
    $title_filler     = $title_len - $title_length;

    $name_length    = strlen($r['name']);
    $name_filler    = $name_len - $name_length;

    $nid_length    = strlen($r['national_id_number']);
    $nid_filler    = $nid_len - $nid_length;


    $fill_title = ' ';
    $fill_name  = ' ';
    $fill_nid   = ' ';

    for ($filler = 1; $filler < $title_filler; $filler++) {
        $fill_title = $fill_title . ' ';
    }
    for ($filler = 1; $filler < $name_filler; $filler++) {
        $fill_name = $fill_name . ' ';
    }
    for ($filler = 1; $filler < $nid_filler; $filler++) {
        $fill_nid = $fill_nid . ' ';
    }



        file_put_contents('people.txt', $r['sbj_personal_data_key'] . $r['record_type'] . $r['fi_code'] . $r['branch_code'] . $r['fi_subject_code'] . $r['title'] . $fill_title . $r['name'] . $fill_name . $r['national_id_number'] . $fill_nid . PHP_EOL, FILE_APPEND);
    }
}
