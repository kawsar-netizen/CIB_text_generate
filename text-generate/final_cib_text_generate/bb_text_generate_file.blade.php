@php
    
    $cib_db_conn = new mysqli('localhost', 'root', '', 'cbr_cib_db');
    
    //database connection for getting length value starts
    function db()
    {
        static $conn;
        if ($conn === null) {
            $conn = mysqli_connect('localhost', 'root', '', 'cib_13112022');
        }
        return $conn;
    }
    //database connection for getting length value ends
    
    error_reporting(0);
    
    // subject header filler function start
    function HFiller()
    {
        $start = 24;
        $end = 1100;
        $h_fill = '';
        for ($filler = $start; $filler <= $end; $filler++) {
            $h_fill = $h_fill . ' ';
        }
        return $h_fill;
    }
    // subject header filler function end
    
    $record_type = 'H';
    $fi_code = '045';
    $accounting_date = date('tmY', strtotime($year_month));
    $production_date = date('dmY'); //Current date
    $date = Date('Y_m');
    $line = 'public/cib/subjects/subject' . '_' . $date . '.txt';
    
    //my portion start
    $conn = new mysqli('localhost', 'root', '', 'cib_13112022');
    $insertSqlForId = 'INSERT INTO link_id (entry_date,entry_time) VALUES (CURDATE(),curtime())';
    $insertOperationForId = mysqli_query($conn, $insertSqlForId);
    
    $selectSqlForId = 'SELECT id FROM link_id ORDER BY id DESC LIMIT 1';
    $selectOperationForId = mysqli_query($conn, $selectSqlForId);
    $fetchedDataForId = mysqli_fetch_array($selectOperationForId);
    $l_id = $fetchedDataForId['id'];
    
    if (strlen($l_id) == 1) {
        $code_link = '00' . $l_id;
    } elseif (strlen($l_id) == 2) {
        $code_link = '0' . $l_id;
    } else {
        $code_link = $l_id;
    }
    //my portion end
    
    //subject header start
    $h_filler = HFiller();
    $final_header = $record_type . $fi_code . $accounting_date . $production_date . $code_link . $h_filler;
    $file_text = file_put_contents($line, $final_header . PHP_EOL, FILE_APPEND);
    //subject header end
    
    // subject individual proprietorship table data start
    function IndividualProprietorshipSpaceFiller($act_name, $name_filler)
    {
        $conn = db();
        $sql2 = "SELECT $name_filler FROM subject_individual_proprietorship_info_len";
        $result2 = mysqli_query($conn, $sql2);
        $row = mysqli_fetch_array($result2);
        $nm_fill = $row[$name_filler];
        $act_name_length = strlen($act_name);
    
        if ($act_name_length == $nm_fill || $act_name_length > $nm_fill) {
            $converted_value_in_string = strval($act_name);
            $trimmed_act_name = substr($converted_value_in_string, 0, $nm_fill);
            return $trimmed_act_name;
        } else {
            $fill = '';
            for ($filler = $act_name_length; $filler < $nm_fill; $filler++) {
                $fill = $fill . ' ';
            }
            return $act_name . $fill;
        }
    }
    
    // $sql = "SELECT * FROM cib_subject_individual_proprietorship_info WHERE month_no = '$year_month' $report_branch_code_query";
    
    $sql = "SELECT * FROM cib_subject_individual_proprietorship_info 
              WHERE 
                 record_type != '' and  
                 fi_code != '' and  
                 fi_subject_code != '' and  
                 trade_name != '' and  
                 sector_type != '' and  
                 business_address_street_nr != ''  and 
                 month_no = '$year_month' ";
    
    $result = mysqli_query($cib_db_conn, $sql);
    
    $ind_count = mysqli_num_rows($result);
    
    function dateFormatcorr($date)
    {
        $temp_dt = explode('-', $date);
        $fix_dt = $temp_dt[0] . $temp_dt[1] . $temp_dt[2];
        return $fix_dt;
    }
    
    while ($r = mysqli_fetch_array($result)) {
        //Check if your variable is an integer
        $business_address_postal_code = '';
        if (filter_var($r['business_address_postal_code'], FILTER_VALIDATE_INT) === false) {
            $business_address_postal_code = '    ';
        } else {
            $business_address_postal_code = $r['business_address_postal_code'];
        }
        $registration_date = dateFormatcorr($r['registration_date']);
    
        $text_content =
            IndividualProprietorshipSpaceFiller($r['record_type'], 'record_type') .
            IndividualProprietorshipSpaceFiller($r['fi_code'], 'fi_code') .
            IndividualProprietorshipSpaceFiller($r['branch_code'], 'branch_code') .
            IndividualProprietorshipSpaceFiller($r['fi_subject_code'], 'fi_subject_code') .
            IndividualProprietorshipSpaceFiller($r['title'], 'title') .
            IndividualProprietorshipSpaceFiller($r['trade_name'], 'trade_name') .
            IndividualProprietorshipSpaceFiller($r['sector_type'], 'sector_type') .
            IndividualProprietorshipSpaceFiller($r['sector_code'], 'sector_code') .
            IndividualProprietorshipSpaceFiller($r['legal_form'], 'legal_form') .
            IndividualProprietorshipSpaceFiller($r['registration_number'], 'registration_number') .
            IndividualProprietorshipSpaceFiller($registration_date, 'registration_date') .
            IndividualProprietorshipSpaceFiller($r['tin'], 'tin') .
            IndividualProprietorshipSpaceFiller($r['business_address_street_nr'], 'business_address_street_nr') .
            IndividualProprietorshipSpaceFiller($business_address_postal_code, 'business_address_postal_code') .
            IndividualProprietorshipSpaceFiller($r['business_address_district'], 'business_address_district') .
            IndividualProprietorshipSpaceFiller($r['business_address_country_code'], 'business_address_country_code') .
            IndividualProprietorshipSpaceFiller($r['factory_address_street_nr'], 'factory_address_street_nr') .
            IndividualProprietorshipSpaceFiller($r['factory_address_postal_code'], 'factory_address_postal_code') .
            IndividualProprietorshipSpaceFiller($r['factory_address_district'], 'factory_address_district') .
            IndividualProprietorshipSpaceFiller($r['factory_address_country_code'], 'factory_address_country_code') .
            IndividualProprietorshipSpaceFiller($r['crg_scoring'], 'crg_scoring') .
            IndividualProprietorshipSpaceFiller($r['credit_rating'], 'credit_rating') .
            IndividualProprietorshipSpaceFiller($r['phone_nr'], 'phone_nr');
    
        $final_text_len = strlen($text_content);
    
        $re_fill = '';
        for ($re_filler = $final_text_len; $re_filler < 1100; $re_filler++) {
            $re_fill = $re_fill . ' ';
        }
        $remaining_data_filler = $re_fill;
    
        $r_data_len = strlen($remaining_data_filler);
        $fixed_text_len = $final_text_len + $r_data_len;
    
        if ($fixed_text_len == 1100) {
            $file_text = file_put_contents($line, $text_content . $remaining_data_filler . PHP_EOL, FILE_APPEND);
            //echo 'This is not error '.'<br>';
        } else {
            echo 'This is error ' . $r['fi_subject_code'];
            exit();
        }
    }
    // subject individual proprietorship table data ends
    
    // subject personal table data start
    function SpaceFiller($act_name, $name_filler)
    {
        $conn = db();
        $sql2 = "SELECT $name_filler FROM personal_len";
        $result2 = mysqli_query($conn, $sql2);
        $row = mysqli_fetch_array($result2);
        $nm_fill = $row[$name_filler];
        $act_name_length = strlen($act_name);
    
        if ($act_name_length == $nm_fill || $act_name_length > $nm_fill) {
            $converted_value_in_string = strval($act_name);
            $trimmed_act_name = substr($converted_value_in_string, 0, $nm_fill);
            return $trimmed_act_name;
        } else {
            $fill = '';
            for ($filler = $act_name_length; $filler < $nm_fill; $filler++) {
                $fill = $fill . ' ';
            }
            return $act_name . $fill;
        }
    }
    
    // $sql = "SELECT * FROM cib_subject_personal WHERE month_no = '$year_month' $report_branch_code_query";
    
    $sql = "SELECT * FROM cib_subject_personal 
            WHERE 
                 record_type != '' and  
                 fi_code != '' and  
                 fi_subject_code != '' and  
                 name != '' and  
                 father_name != '' and  
                 mother_name != '' and  
                 sector_type != '' and  
                 gender != '' and                          
                 country_of_birth_code != '' and  
                 national_id_number_available != '' and                         
                 month_no = '$year_month'";
    
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
    
        $text_content =
            SpaceFiller($r['record_type'], 'record_type') .
            SpaceFiller($r['fi_code'], 'fi_code') .
            SpaceFiller($r['branch_code'], 'branch_code') .
            SpaceFiller($r['fi_subject_code'], 'fi_subject_code') .
            SpaceFiller($r['title'], 'title') .
            SpaceFiller($r['name'], 'name') .
            SpaceFiller($r['father_title'], 'father_title') .
            SpaceFiller($r['father_name'], 'father_name') .
            SpaceFiller($r['mother_title'], 'mother_title') .
            SpaceFiller($r['mother_name'], 'mother_name') .
            SpaceFiller($r['spouse_title'], 'spouse_title') .
            SpaceFiller($r['spouse_name'], 'spouse_name') .
            SpaceFiller($r['sector_type'], 'sector_type') .
            SpaceFiller($r['sector_code'], 'sector_code') .
            SpaceFiller($r['gender'], 'gender') .
            SpaceFiller($dt_birth, 'date_of_birth') .
            SpaceFiller($r['place_of_birth_district'], 'place_of_birth_district') .
            SpaceFiller($r['country_of_birth_code'], 'country_of_birth_code') .
            SpaceFiller($r['national_id_number'], 'national_id_number') .
            SpaceFiller($r['national_id_number_available'], 'national_id_number_available') .
            SpaceFiller($r['tin'], 'tin') .
            SpaceFiller($r['permanent_address_street_nr'], 'permanent_address_street_nr') .
            SpaceFiller($permanent_address_postal_code, 'permanent_address_postal_code') .
            SpaceFiller($r['permanent_address_district'], 'permanent_address_district') .
            SpaceFiller($r['permanent_address_country_code'], 'permanent_address_country_code') .
            SpaceFiller($r['present_address_street_nr'], 'present_address_street_nr') .
            SpaceFiller($r['present_address_postal_code'], 'present_address_postal_code') .
            SpaceFiller($r['present_address_district'], 'present_address_district') .
            SpaceFiller($r['present_address_country_code'], 'present_address_country_code') .
            SpaceFiller($r['business_address'], 'business_address') .
            SpaceFiller($r['business_address_postal_code'], 'business_address_postal_code') .
            SpaceFiller($r['business_address_district'], 'business_address_district') .
            SpaceFiller($r['business_address_country_code'], 'business_address_country_code') .
            SpaceFiller($r['id_type'], 'id_type') .
            SpaceFiller($r['id_nr'], 'id_nr') .
            SpaceFiller(dateFormatcorr($r['id_issue_date']), 'id_issue_date') .
            SpaceFiller($r['id_issue_country_code'], 'id_issue_country_code') .
            SpaceFiller($r['phone_nr'], 'phone_nr');
    
        $final_text_len = strlen($text_content);
    
        $re_fill = '';
        for ($re_filler = $final_text_len; $re_filler < 1100; $re_filler++) {
            $re_fill = $re_fill . ' ';
        }
        $remaining_data_filler = $re_fill;
    
        $r_data_len = strlen($remaining_data_filler);
        $fixed_text_len = $final_text_len + $r_data_len;
    
        if ($fixed_text_len == 1100) {
            $file_text = file_put_contents($line, $text_content . $remaining_data_filler . PHP_EOL, FILE_APPEND);
            //echo 'This is not error '.'<br>';
        } else {
            echo 'This is error ' . $r['fi_subject_code'];
            exit();
        }
    }
    // }
    // subject personal table data ends
    
    // subject company table data start
    
    function CompanySpaceFiller($act_name, $name_filler)
    {
        $conn = db();
        $sql2 = "SELECT $name_filler FROM subject_company_len";
        $result2 = mysqli_query($conn, $sql2);
        $row = mysqli_fetch_array($result2);
        $nm_fill = $row[$name_filler];
        $act_name_length = strlen($act_name);
    
        if ($act_name_length == $nm_fill || $act_name_length > $nm_fill) {
            $converted_value_in_string = strval($act_name);
            $trimmed_act_name = substr($converted_value_in_string, 0, $nm_fill);
            return $trimmed_act_name;
        } else {
            $fill = '';
            for ($filler = $act_name_length; $filler < $nm_fill; $filler++) {
                $fill = $fill . ' ';
            }
            return $act_name . $fill;
        }
    }
    
    // $sql = "SELECT * FROM cib_subject_company_info  WHERE month_no = '$year_month' $report_branch_code_query";
    
    $sql = "SELECT * FROM cib_subject_company_info 
            WHERE 
                 record_type != '' and  
                 fi_code != '' and  
                 fi_subject_code != '' and  
                 trade_name != '' and  
                 sector_type != '' and                         
                 business_address_street_nr != '' and                         
                 month_no = '$year_month'";
    
    $result = mysqli_query($cib_db_conn, $sql);
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
        $text_content =
            CompanySpaceFiller($r['record_type'], 'record_type') .
            CompanySpaceFiller($r['fi_code'], 'fi_code') .
            CompanySpaceFiller($r['branch_code'], 'branch_code') .
            CompanySpaceFiller($r['fi_subject_code'], 'fi_subject_code') .
            CompanySpaceFiller($r['title'], 'title') .
            CompanySpaceFiller($r['trade_name'], 'trade_name') .
            CompanySpaceFiller($r['sector_type'], 'sector_type') .
            CompanySpaceFiller($r['sector_code'], 'sector_code') .
            CompanySpaceFiller($r['legal_form'], 'legal_form') .
            CompanySpaceFiller($r['registration_number'], 'registration_number') .
            CompanySpaceFiller($registration_date, 'registration_date') .
            CompanySpaceFiller($r['tin'], 'tin') .
            CompanySpaceFiller($r['business_address_street_nr'], 'business_address_street_nr') .
            CompanySpaceFiller($business_address_postal_code, 'business_address_postal_code') .
            CompanySpaceFiller($r['business_address_district'], 'business_address_district') .
            CompanySpaceFiller($r['business_address_country_code'], 'business_address_country_code') .
            CompanySpaceFiller($r['factory_address_street_nr'], 'factory_address_street_nr') .
            CompanySpaceFiller($r['factory_address_postal_code'], 'factory_address_postal_code') .
            CompanySpaceFiller($r['factory_address_district'], 'factory_address_district') .
            CompanySpaceFiller($r['factory_address_country_code'], 'factory_address_country_code') .
            CompanySpaceFiller($r['crg_scoring'], 'crg_scoring') .
            CompanySpaceFiller($r['credit_rating'], 'credit_rating') .
            CompanySpaceFiller($r['phone_nr'], 'phone_nr');
    
        $final_text_len = strlen($text_content);
        $re_fill = '';
        for ($re_filler = $final_text_len; $re_filler < 1100; $re_filler++) {
            $re_fill = $re_fill . ' ';
        }
    
        $remaining_data_filler = $re_fill;
        $r_data_len = strlen($remaining_data_filler);
        $fixed_text_len = $final_text_len + $r_data_len;
    
        if ($fixed_text_len == 1100) {
            $file_text = file_put_contents($line, $text_content . $remaining_data_filler . PHP_EOL, FILE_APPEND);
            //echo 'This is not error '.'<br>';
        } else {
            echo 'This is error ' . $r['fi_subject_code'];
            exit();
        }
    }
    // subject company table data ends
    
    // subject link shareholder table data start
    
    function ShareholderPropretishipSpaceFiller($act_name, $name_filler)
    {
        $conn = db();
        $sql2 = "SELECT $name_filler FROM links_shareholder_propretiship_len";
        $result2 = mysqli_query($conn, $sql2);
        $row = mysqli_fetch_array($result2);
        $nm_fill = $row[$name_filler];
        $act_name_length = strlen($act_name);
    
        if ($act_name_length == $nm_fill || $act_name_length > $nm_fill) {
            $converted_value_in_string = strval($act_name);
            $trimmed_act_name = substr($converted_value_in_string, 0, $nm_fill);
            return $trimmed_act_name;
        } else {
            $fill = '';
            for ($filler = $act_name_length; $filler < $nm_fill; $filler++) {
                $fill = $fill . ' ';
            }
            return $act_name . $fill;
        }
    }
    
    // $sql = "SELECT * FROM cib_links_shareholder_propretiship where branch_code = '1001'";
    
    $sql = "SELECT * FROM cib_links_shareholder_propretiship
             WHERE
                 record_type != '' and
                 fi_code != '' and
                 fi_subject_code != '' and
                 role != '' and
                 fi_subject_code_of_owner != '' and
                 DATE_FORMAT(created_at,'%Y-%m') = '$year_month'";
    
    $result = mysqli_query($cib_db_conn, $sql);
    $s_count = mysqli_num_rows($result);
    
    while ($r = mysqli_fetch_array($result)) {
        $text_content = ShareholderPropretishipSpaceFiller($r['record_type'], 'record_type') . ShareholderPropretishipSpaceFiller($r['fi_code'], 'fi_code') . ShareholderPropretishipSpaceFiller($r['branch_code'], 'branch_code') . ShareholderPropretishipSpaceFiller($r['fi_subject_code'], 'fi_subject_code') . ShareholderPropretishipSpaceFiller($r['role'], 'role') . ShareholderPropretishipSpaceFiller($r['fi_subject_code_of_owner'], 'fi_subject_code_of_owner');
    
        $final_text_len = strlen($text_content);
    
        $re_fill = '';
        for ($re_filler = $final_text_len; $re_filler < 1100; $re_filler++) {
            $re_fill = $re_fill . ' ';
        }
        $remaining_data_filler = $re_fill;
    
        $r_data_len = strlen($remaining_data_filler);
        $fixed_text_len = $final_text_len + $r_data_len;
    
        if ($fixed_text_len == 1100) {
            $file_text = file_put_contents($line, $text_content . $remaining_data_filler . PHP_EOL, FILE_APPEND);
            //echo 'This is not error '.'<br>';
        } else {
            echo 'This is error ' . $r['fi_subject_code'];
            exit();
        }
    }
    
    // subject link shareholder table data ends
    
    //subject footer filler function starts
    
    function Ffooter()
    {
        $start = '28';
        $end = '1100';
        $f_fill = '';
        for ($filler = $start; $filler <= $end; $filler++) {
            $f_fill = $f_fill . ' ';
        }
        return $f_fill;
    }
    //subject footer filler function ends
    
    //subject footer part start
    $end1_line = '  ';
    $f_record_type = 'Q';
    $f_fi_code = '045';
    $f_accounting_date = date('tmY', strtotime($year_month)); //Last date of previos mont
    $f_production_date = date('dmY'); //Current date
    $f_total_record = $ind_count + $p_count + $c_count + $s_count;
    $f_filler = Ffooter();
    $final_footer = $f_record_type . $f_fi_code . $f_accounting_date . $f_production_date . $f_total_record . $f_filler;
    $file_text = file_put_contents($line, $final_footer.$end1_line, FILE_APPEND);
    
    $subjectFile = $line;
    //subject footer part end
    
    ///////------------------------CONTRACT PART----------------------------------///////////
    
    //contract header filler function starts
    function ContractHeaderFiller()
    {
        $start = 24;
        $end = 600;
        $h_fill = '';
        for ($filler = $start; $filler <= $end; $filler++) {
            $h_fill = $h_fill . ' ';
        }
        return $h_fill;
    }
    //contract header filler function ends
    
    $record_type = 'H';
    $fi_code = '045';
    $f_accounting_date = date('tmY', strtotime($year_month)); //Last date of current mont
    $production_date = date('dmY'); //Current date
    $date = Date('Y_m');
    $lineContract = 'public/cib/contracts/contract' . '_' . $date . '.txt';
    
    //my portion start
    $conn = new mysqli('localhost', 'root', '', 'cib_13112022');
    $selectSqlForId = 'SELECT id FROM link_id ORDER BY id DESC LIMIT 1';
    $selectOperationForId = mysqli_query($conn, $selectSqlForId);
    $fetchedDataForId = mysqli_fetch_array($selectOperationForId);
    $l_id = $fetchedDataForId['id'];
    
    if (strlen($l_id) == 1) {
        $code_link = '00' . $l_id;
    } elseif (strlen($l_id) == 2) {
        $code_link = '0' . $l_id;
    } else {
        $code_link = $l_id;
    }
    //my portion end
    
    //contract header start
    $h_filler = ContractHeaderFiller();
    $final_header = $record_type . $fi_code . $accounting_date . $production_date . $code_link . $h_filler;
    $fileContract_text = file_put_contents($lineContract, $final_header . PHP_EOL, FILE_APPEND);
    //contract header end
    
    // installment part start
    function InstallSpaceFiller($act_name, $name_filler)
    {
        $conn = db();
        $sql2 = "SELECT $name_filler FROM installments_len ";
        $result2 = mysqli_query($conn, $sql2);
        $row = mysqli_fetch_array($result2);
        $nm_fill = $row[$name_filler];
        $act_name_length = strlen($act_name);
    
        if ($act_name_length == $nm_fill || $act_name_length > $nm_fill) {
            $converted_value_in_string = strval($act_name);
            $trimmed_act_name = substr($converted_value_in_string, 0, $nm_fill);
            return $trimmed_act_name;
        } else {
            $fill = '';
            for ($filler = $act_name_length; $filler < $nm_fill; $filler++) {
                $fill = $fill . ' ';
            }
            return $act_name . $fill;
        }
    }
    
    function dateFormatcorrContract($date)
    {
        $temp_dt = explode('-', $date);
        $fix_dt = $temp_dt[0] . $temp_dt[1] . $temp_dt[2];
        return $fix_dt;
    }
    
    function restText()
    {
        $start = 124;
        $end = 250;
        // $need_to_fill = $end - $start;
    
        $fill = '';
        for ($filler = $start; $filler <= $end; $filler++) {
            $fill = $fill . ' ';
        }
        return $fill;
    }
    
    // $sql = "SELECT * FROM cib_installments_contracts report_branch_code = '$report_branch_code' AND month_no = '$year_month'";
    
    $sql = "SELECT * FROM cib_installments_contracts 
                 where 
                         record_type != '' and  
                         fi_code != '' and  
                         fi_subject_code != '' and  
                         fi_contract_code != '' and  
                         contract_type != '' and  
                         contract_phase != '' and  
                         contract_status != '' and  
                         currency_code != '' and                          
                         sanction_limit != '' and  
                         total_disbursed_amount != '' and  
                         total_outstanding_amount != '' and 
                         month_no = '$year_month'";
    
    $result = mysqli_query($cib_db_conn, $sql);
    $install_count = mysqli_num_rows($result);
    
    while ($r = mysqli_fetch_array($result)) {
        $starting_date_of_the_contract = dateFormatcorrContract($r['starting_date_of_the_contract']);
        $request_date_of_the_contract = dateFormatcorrContract($r['request_date_of_the_contract']);
        $planned_end_date_of_the_contract = dateFormatcorrContract($r['planned_end_date_of_the_contract']);
        $actual_end_date_of_the_contract = dateFormatcorrContract($r['actual_end_date_of_the_contract']);
        $date_of_last_payment = dateFormatcorrContract($r['date_of_last_payment']);
        $expiration_date_of_next_installment = dateFormatcorrContract($r['expiration_date_of_next_installment']);
        $date_of_manufacturing = dateFormatcorrContract($r['date_of_manufacturing']);
        $date_of_law_suit = dateFormatcorrContract($r['date_of_law_suit']);
        $date_of_classification = dateFormatcorrContract($r['date_of_classification']);
        $date_of_last_rescheduling = dateFormatcorrContract($r['date_of_last_rescheduling']);
    
        $text_content =
            InstallSpaceFiller($r['record_type'], 'record_type') .
            InstallSpaceFiller($r['fi_code'], 'fi_code') .
            InstallSpaceFiller($r['branch_code'], 'branch_code') .
            InstallSpaceFiller($r['fi_subject_code'], 'fi_subject_code') .
            InstallSpaceFiller($r['fi_contract_code'], 'fi_contract_code') .
            InstallSpaceFiller($r['contract_type'], 'contract_type') .
            InstallSpaceFiller($r['contract_phase'], 'contract_phase') .
            InstallSpaceFiller($r['contract_status'], 'contract_status') .
            InstallSpaceFiller($r['currency_code'], 'currency_code') .
            InstallSpaceFiller($starting_date_of_the_contract, 'starting_date_of_the_contract') .
            InstallSpaceFiller($request_date_of_the_contract, 'request_date_of_the_contract') .
            InstallSpaceFiller($planned_end_date_of_the_contract, 'planned_end_date_of_the_contract') .
            InstallSpaceFiller($actual_end_date_of_the_contract, 'actual_end_date_of_the_contract') .
            InstallSpaceFiller($r['default_status'], 'default_status') .
            InstallSpaceFiller($date_of_last_payment, 'date_of_last_payment') .
            InstallSpaceFiller($r['flag_subsidized_credit'], 'flag_subsidized_credit') .
            InstallSpaceFiller($r['flag_pre_finance_of_loan'], 'flag_pre_finance_of_loan') .
            InstallSpaceFiller($r['code_reorganized_credit'], 'code_reorganized_credit') .
            InstallSpaceFiller($r['third_party_guarantee_type'], 'third_party_guarantee_type') .
            InstallSpaceFiller($r['security_type'], 'security_type') .
            InstallSpaceFiller($r['amount_guaranteed_by_third_party_guarantor'], 'amount_guaranteed_by_third_party_guarantor') .
            InstallSpaceFiller($r['amount_guaranteed_by_security_type'], 'amount_guaranteed_by_security_type') .
            InstallSpaceFiller($r['basis_for_classification_qualitative_judgment'], 'basis_for_classification_qualitative_judgment') .
            restText() .
            InstallSpaceFiller($r['sanction_limit'], 'sanction_limit') .
            InstallSpaceFiller($r['total_disbursed_amount'], 'total_disbursed_amount') .
            InstallSpaceFiller($r['total_outstanding_amount'], 'total_outstanding_amount') .
            InstallSpaceFiller($r['total_number_of_installments'], 'total_number_of_installments') .
            InstallSpaceFiller($r['periodicity_of_payment'], 'periodicity_of_payment') .
            InstallSpaceFiller($r['method_of_payment'], 'method_of_payment') .
            InstallSpaceFiller($r['installment_amount'], 'installment_amount') .
            InstallSpaceFiller($expiration_date_of_next_installment, 'expiration_date_of_next_installment') .
            InstallSpaceFiller($r['amount_of_next_expiring_installment'], 'amount_of_next_expiring_installment') .
            InstallSpaceFiller($r['number_of_remaining_installments'], 'number_of_remaining_installments') .
            InstallSpaceFiller($r['remaining_amount'], 'remaining_amount') .
            InstallSpaceFiller($r['number_of_overdue_installment'], 'number_of_overdue_installment') .
            InstallSpaceFiller($r['overdue_amount'], 'overdue_amount') .
            InstallSpaceFiller($r['number_of_days_of_payment_delay'], 'number_of_days_of_payment_delay') .
            InstallSpaceFiller($r['type_of_leased_good'], 'type_of_leased_good') .
            InstallSpaceFiller($r['value_of_leased_good'], 'value_of_leased_good') .
            InstallSpaceFiller($r['registration_number'], 'registration_number') .
            InstallSpaceFiller($date_of_manufacturing, 'date_of_manufacturing') .
            InstallSpaceFiller($r['due_for_recovery'], 'due_for_recovery') .
            InstallSpaceFiller($r['recovery_during_the_reporting_period'], 'recovery_during_the_reporting_period') .
            InstallSpaceFiller($r['cumulative_recovery'], 'cumulative_recovery') .
            InstallSpaceFiller($date_of_law_suit, 'date_of_law_suit') .
            InstallSpaceFiller($date_of_classification, 'date_of_classification') .
            InstallSpaceFiller($r['no_of_time_rescheduling'], 'no_of_time_rescheduling') .
            InstallSpaceFiller($date_of_last_rescheduling, 'date_of_last_rescheduling') .
            InstallSpaceFiller($r['economic_purpose_code'], 'economic_purpose_code') .
            InstallSpaceFiller($r['sme'], 'sme') .
            InstallSpaceFiller($r['enterprise_type'], 'enterprise_type');
    
        $final_text_len = strlen($text_content);
        $re_fill = '';
        for ($re_filler = $final_text_len; $re_filler < 600; $re_filler++) {
            $re_fill = $re_fill . ' ';
        }
        $remaining_data_filler = $re_fill;
    
        $r_data_len = strlen($remaining_data_filler);
        $fixed_text_len = $final_text_len + $r_data_len;
    
        if ($fixed_text_len == 600) {
            $fileContract_text = file_put_contents($lineContract, $text_content . $remaining_data_filler . PHP_EOL, FILE_APPEND);
            //echo 'This is not error '.'<br>';
        } else {
            echo 'This is error for installment ' . $r['fi_subject_code'];
            exit();
        }
    }
    
    // installment part ends
    
    //guarantor coborrower part starts
    function ContractLinksSpaceFiller($act_name, $name_filler)
    {
        $conn = db();
        $sql2 = "SELECT $name_filler FROM  cib_links_guarantor_coborrower_len";
        $result2 = mysqli_query($conn, $sql2);
        $row = mysqli_fetch_array($result2);
        $nm_fill = $row[$name_filler];
        $act_name_length = strlen($act_name);
    
        if ($act_name_length == $nm_fill || $act_name_length > $nm_fill) {
            $converted_value_in_string = strval($act_name);
            $trimmed_act_name = substr($converted_value_in_string, 0, $nm_fill);
            return $trimmed_act_name;
        } else {
            $fill = '';
            for ($filler = $act_name_length; $filler < $nm_fill; $filler++) {
                $fill = $fill . ' ';
            }
            return $act_name . $fill;
        }
    }
    
    // $sql = 'SELECT * FROM cib_links_guarantor_coborrower';
    
    $sql = "SELECT * FROM cib_links_guarantor_coborrower
        WHERE
                    record_type != '' and
                    fi_code != '' and
                    type_of_link != '' and
                    fi_primary_code != '' and
                    fi_primary_code != '' and
                    fi_secondary_code != '' and
                    fi_contract_code != '' and
                    DATE_FORMAT(created_at,'%Y-%m') = '$year_month'";
    
    $result = mysqli_query($cib_db_conn, $sql);
    $s_count = mysqli_num_rows($result);
    
    while ($r = mysqli_fetch_array($result)) {
        $text_content = ContractLinksSpaceFiller($r['record_type'], 'record_type') . ContractLinksSpaceFiller($r['fi_code'], 'fi_code') . ContractLinksSpaceFiller($r['branch_code'], 'branch_code') . ContractLinksSpaceFiller($r['type_of_link'], 'type_of_link') . ContractLinksSpaceFiller($r['fi_primary_code'], 'fi_primary_code') . ContractLinksSpaceFiller($r['fi_secondary_code'], 'fi_secondary_code') . ContractLinksSpaceFiller($r['fi_contract_code'], 'fi_contract_code');
    
        $final_text_len = strlen($text_content);
    
        $re_fill = '';
        for ($re_filler = $final_text_len; $re_filler < 600; $re_filler++) {
            $re_fill = $re_fill . ' ';
        }
        $remaining_data_filler = $re_fill;
        $r_data_len = strlen($remaining_data_filler);
        $fixed_text_len = $final_text_len + $r_data_len;
        if ($fixed_text_len == 600) {
            $fileContract_text = file_put_contents($lineContract, $text_content . $remaining_data_filler . PHP_EOL, FILE_APPEND);
        } else {
            echo 'This is error ' . $r['fi_code'];
            exit();
        }
    }
    //guarantor coborrower part ends
    
    //non installment part starts
    
    function NonistallSpaceFiller($act_name, $name_filler)
    {
        $conn = db();
        $sql2 = "SELECT $name_filler FROM noninstall_len ";
        $result2 = mysqli_query($conn, $sql2);
        $row = mysqli_fetch_array($result2);
        $nm_fill = $row[$name_filler];
        $act_name_length = strlen($act_name);
    
        if ($act_name_length == $nm_fill || $act_name_length > $nm_fill) {
            $converted_value_in_string = strval($act_name);
            $trimmed_act_name = substr($converted_value_in_string, 0, $nm_fill);
            return $trimmed_act_name;
        } else {
            $fill = '';
            for ($filler = $act_name_length; $filler < $nm_fill; $filler++) {
                $fill = $fill . ' ';
            }
            return $act_name . $fill;
        }
    }
    
    // $sql = "SELECT * FROM cib_noninstall_contracts WHERE report_branch_code = '$report_branch_code' AND month_no = '$year_month'";
    
    $sql = "SELECT * FROM cib_noninstall_contracts 
                        where 
                         record_type != '' and  
                         fi_code != '' and  
                         fi_subject_code != '' and  
                         fi_contract_code != '' and  
                         contract_type != '' and  
                         contract_phase != '' and  
                         contract_status != '' and  
                         currency_code != '' and  
                         sanction_limit != '' and  
                         total_outstanding_amount != '' and 
                         month_no = '$year_month'";
    
    $result = mysqli_query($cib_db_conn, $sql);
    $noninstall_count = mysqli_num_rows($result);
    while ($r = mysqli_fetch_array($result)) {
        $starting_date_contract = dateFormatcorr($r['starting_date_of_the_contract']);
        $request_date_contract = dateFormatcorr($r['request_date_of_the_contract']);
        $planned_end_datecontract = dateFormatcorr($r['planned_end_date_of_the_contract']);
        $dt_classification = dateFormatcorr($r['date_of_classification']);
        $dt_rescheduling = dateFormatcorr($r['no_of_time_rescheduling']);
    
        $text_content =
            NonistallSpaceFiller($r['record_type'], 'record_type') .
            NonistallSpaceFiller($r['fi_code'], 'fi_code') .
            NonistallSpaceFiller($r['branch_code'], 'branch_code') .
            NonistallSpaceFiller($r['fi_subject_code'], 'fi_subject_code') .
            NonistallSpaceFiller($r['fi_contract_code'], 'fi_contract_code') .
            NonistallSpaceFiller($r['contract_type'], 'contract_type') .
            NonistallSpaceFiller($r['contract_phase'], 'contract_phase') .
            NonistallSpaceFiller($r['contract_status'], 'contract_status') .
            NonistallSpaceFiller($r['currency_code'], 'currency_code') .
            NonistallSpaceFiller($starting_date_contract, 'starting_date_of_the_contract') .
            NonistallSpaceFiller($request_date_contract, 'request_date_of_the_contract') .
            NonistallSpaceFiller($planned_end_datecontract, 'planned_end_date_of_the_contract') .
            NonistallSpaceFiller($r['actual_end_date_of_the_contract'], 'actual_end_date_of_the_contract') .
            NonistallSpaceFiller($r['default_status'], 'default_status') .
            NonistallSpaceFiller($r['date_of_last_payment'], 'date_of_last_payment') .
            NonistallSpaceFiller($r['flag_subsidized_credit'], 'flag_subsidized_credit') .
            NonistallSpaceFiller($r['flag_pre_finance_of_loan'], 'flag_pre_finance_of_loan') .
            NonistallSpaceFiller($r['code_reorganized_credit'], 'code_reorganized_credit') .
            NonistallSpaceFiller($r['third_party_guarantee_type'], 'third_party_guarantee_type') .
            NonistallSpaceFiller($r['security_type'], 'security_type') .
            NonistallSpaceFiller($r['amount_guaranteed_by_third_party_guarantor'], 'amount_guaranteed_by_third_party_guarantor') .
            NonistallSpaceFiller($r['amount_guaranteed_by_security_type'], 'amount_guaranteed_by_security_type') .
            NonistallSpaceFiller($r['basis_for_classification_qualitative_judgment'], 'basis_for_classification_qualitative_judgment') .
            NonistallSpaceFiller($r['sanction_limit'], 'sanction_limit') .
            NonistallSpaceFiller($r['total_outstanding_amount'], 'total_outstanding_amount') .
            NonistallSpaceFiller($r['nr_of_days_of_payment_delay'], 'nr_of_days_of_payment_delay') .
            NonistallSpaceFiller($r['overdue_amount'], 'overdue_amount') .
            NonistallSpaceFiller($r['recovery_during_the_reporting_period'], 'recovery_during_the_reporting_period') .
            NonistallSpaceFiller($r['cumulative_recovery'], 'cumulative_recovery') .
            NonistallSpaceFiller(dateFormatcorrContract($r['date_of_law_suit']), 'date_of_law_suit') .
            NonistallSpaceFiller($dt_classification, 'date_of_classification') .
            NonistallSpaceFiller($dt_rescheduling, 'no_of_time_rescheduling') .
            NonistallSpaceFiller($r['economic_purpose_code'], 'economic_purpose_code') .
            NonistallSpaceFiller($r['sme'], 'sme') .
            NonistallSpaceFiller($r['enterprise_type'], 'enterprise_type');
    
        $final_text_len = strlen($text_content);
    
        $re_fill = '';
        for ($re_filler = $final_text_len; $re_filler < 600; $re_filler++) {
            $re_fill = $re_fill . ' ';
        }
        $remaining_data_filler = $re_fill;
        $r_data_len = strlen($remaining_data_filler);
        $fixed_text_len = $final_text_len + $r_data_len;
    
        if ($fixed_text_len == 600) {
            $fileContract_text = file_put_contents($lineContract, $text_content . $remaining_data_filler . PHP_EOL, FILE_APPEND);
            //echo 'This is not error '.'<br>';
        } else {
            echo 'This is error for nonistallment ' . $r['fi_subject_code'];
            exit();
        }
    }
    
    // non installment part ends
    
    //contract footer function start
    function ContractFooterFiller()
    {
        $start = '28';
        $end = '600';
        $f_fill = '';
        for ($filler = $start; $filler <= $end; $filler++) {
            $f_fill = $f_fill . ' ';
        }
        return $f_fill;
    }
    //contract footer function end
    $end_line = '    ';
    $f_record_type = 'Q';
    $f_fi_code = '045';
    $f_accounting_date = date('tmY', strtotime($year_month)); //Last date of current mont
    $f_production_date = date('dmY'); //Current date
    $f_total_record = $install_count + $noninstall_count;
    $f_filler = ContractFooterFiller();
    $final_footer = $f_record_type . $f_fi_code . $f_accounting_date . $f_production_date . $f_total_record . $f_filler;

    $fileContract_text = file_put_contents($lineContract, $final_footer.$end_line, FILE_APPEND);
    
    $contractFile = $lineContract;
    //contract footer ends
    
    $zipname = 'cib_text_file.zip';
    $zip = new ZipArchive();
    $zip->open($zipname, ZipArchive::CREATE);
    $zip->addFile($subjectFile, pathinfo($subjectFile, PATHINFO_BASENAME));
    $zip->addFile($contractFile, pathinfo($contractFile, PATHINFO_BASENAME));
    $zip->close();
    unlink($line);
    unlink($lineContract);
    
    header('Content-Type: application/zip');
    header('Content-disposition: attachment; filename=' . $zipname);
    header('Content-Length: ' . filesize($zipname));
    readfile($zipname);
    
    // //subject text file download starts
    // header('Content-Description: File Transfer');
    // header('Content-Disposition: attachment; filename='.basename($file));
    // header('Expires: 0');
    // header('Cache-Control: must-revalidate');
    // header('Pragma: public');
    // header('Content-Length: ' . filesize($file));
    // header("Content-Type: text/plain");
    // readfile($file);
    // unlink($file);
    // //subject text file download ends
    
@endphp
