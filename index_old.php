<?php
include "config.php";

$sql2 = "SELECT * FROM personal_len";
$result2 = mysqli_query($conn,$sql2);
$row =  mysqli_fetch_array($result2);
$name_len = $row['name'];


$sql = "SELECT sbj_personal_data_key,record_type,fi_code,branch_code, fi_subject_code, name, national_id_number  FROM cib_subject_personal where branch_code='0008'";

$result = mysqli_query($conn,$sql);



while($r = mysqli_fetch_array($result)){

    //echo $r['branch_code'].','.$r['fi_subject_code']."<br>";


    $name_length = strlen($r['name']);
    $name_filler = $name_len - $name_length-1;

    
    $fill=' ';
    for($filler=1;$filler<=$name_filler;$filler++){ $fill=$fill.' '; }

    $text_generate  = 'people.text';
    $text_content=$r['branch_code'].$r['fi_subject_code']. $r['name'].$fill.$r['national_id_number'];
    $file_text      = file_put_contents('people.txt',$text_content . PHP_EOL, FILE_APPEND);
    


    

}
