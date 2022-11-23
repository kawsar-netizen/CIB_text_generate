<?php 
// Load the database configuration file 
include_once 'config.php'; 

// error_reporting(E_ALL & ~E_NOTICE);
error_reporting('0');
 


## Helper function section start
function dateFormatcorr($date) {
    $temp_dt = explode("-", $date);
    $fix_dt = $temp_dt[0] . $temp_dt[1] . $temp_dt[2];
    return $fix_dt;
}
## Helper function section end


            $html = "<table><tr>
                <th>Record Type</th>
                <th>F.I. Code</th>
                <th>Branch Code</th>
                <th>F.I. Subject Code</th>
                <th>Title</th>
                <th>Name</th>
                <th>Father's Title</th>
                <th>Father's Name</th>
                <th>Mother's Title</th>
                <th> Mother's Name</th>
                <th>Spouse's Title</th>
                <th>Spouse's Name</th>
                <th>Sector Type</th>
                <th>Sector Code</th>
                <th>Gender</th>
                <th>Date of Birth</th>
                <th>Place of Birth (District)</th>
                <th> Country of Birth (Code)</th>
                <th> National ID Number</th>
                <th>National ID Number available/not available</th>
                <th>T.I.N.</th>
                <th>Permanent Address: street + nr</th>
                <th>Permanent Address: Postal Code</th>
                <th>Permanent Address: District</th>
                <th>Permanent Address: Country(Code)</th>
                <th>Present Address: street + nr</th>
                <th>Present Address: Postal code</th>
                <th>Present Address: District</th>
                <th>Present Address: Country(Code)</th>
                <th>Business address</th>
                <th>Business address: Postal code</th>
                <th>Business Address: District</th>
                <th>Business Address: Country (code)</th>
                <th>ID Type</th>
                <th>ID Nr.</th>
                <th>ID Issue Date</th>
                <th>ID Issue Country (Code)</th>
                <th>Phone Nr</th>
                </tr>";



// personal data start

        $sql = "SELECT * FROM cib_subject_personal WHERE report_branch_code = '1001' AND month_no = '2022-10'";
        $result = mysqli_query($conn, $sql);
	
        while($r = mysqli_fetch_array($result)){
        
            $dt_birth = dateFormatcorr($r['date_of_birth']);

            # Check if your variable is an integer
            $permanent_address_postal_code = '';
            if (filter_var($r['permanent_address_postal_code'], FILTER_VALIDATE_INT) === false) {
                $permanent_address_postal_code = '    ';
            } else {
                $permanent_address_postal_code = $r['permanent_address_postal_code'];
            }


         $html .= '<tr>
         <td>'. $r['record_type'] .'</td>
         <td>'. $r['fi_code'] .'</td>
         <td>'. $r['branch_code'] .'</td>
         <td>'. $r['fi_subject_code'] .'</td>
         <td>'. $r['title'] .'</td>
         <td>'. $r['name'] .'</td>
         <td>'. $r['father_title'] .'</td>
         <td>'. $r['father_name'] .'</td>
         <td>'. $r['mother_title'] .'</td>
         <td>'. $r['mother_name'] .'</td>
         <td>'. $r['spouse_title'] .'</td>
         <td>'. $r['spouse_name'] .'</td>
         <td>'. $r['sector_type'] .'</td>
         <td>'. $r['sector_code'] .'</td>
         <td>'. $r['gender'] .'</td>
         <td>'. $dt_birth .'</td>
         <td>'. $r['place_of_birth_district'] .'</td>
         <td>'. $r['country_of_birth_code'] .'</td> 
         <td>'. $r['national_id_number'] .'</td> 
         <td>'. $r['national_id_number_available'] .'</td> 
         <td>'. $r['tin'] .'</td>
         <td>'. $r['permanent_address_street_nr'] .'</td>
         <td>'. $permanent_address_postal_code .'</td>
         <td>'. $r['permanent_address_district'] .'</td>
         <td>'. $r['permanent_address_country_code'] .'</td>
         <td>'. $r['present_address_street_nr'] .'</td>
         <td>'. $r['present_address_postal_code'] .'</td>
         <td>'. $r['present_address_district'] .'</td>
         <td>'. $r['present_address_country_code'] .'</td>
         <td>'. $r['business_address'] .'</td>
         <td>'. $r['business_address_postal_code'] .'</td>
         <td>'. $r['business_address_district'] .'</td>
         <td>'. $r['business_address_country_code'] .'</td> 
         <td>'. $r['id_type'] .'</td>
         <td>'. $r['id_nr'] .'</td>
         <td>'. dateFormatcorr($r['id_issue_date']) .'</td>
         <td>'. $r['id_issue_country_code'] .'</td>
         <td>'. $r['phone_nr'] .'</td>
     </tr>';
         
    }

//personal data end




// individual data start
    
    $sql = "SELECT * FROM cib_subject_individual_proprietorship_info WHERE report_branch_code = '1001' AND month_no = '2022-10'";
    $result = mysqli_query($conn, $sql);

while($r = mysqli_fetch_array($result)){


    $registration_date = dateFormatcorr($r['registration_date']);
    
     //Check if your variable is an integer
     $business_address_postal_code = '';
     if ( filter_var($r['business_address_postal_code'], FILTER_VALIDATE_INT) === false ) {
     $business_address_postal_code = '    ';
     }else{
         $business_address_postal_code = $r['business_address_postal_code'];
     }


     $html .= '<tr>
     <td>'.$r['record_type'].'</td>
     <td>'. $r['fi_code'] .'</td>
     <td>'. $r['branch_code'] .'</td>
     <td>'. $r['fi_subject_code'] .'</td>
     <td>'. $r['title'] .'</td>
     <td>'. $r['trade_name'] .'</td>
     <td>'. $r['sector_type'] .'</td>
     <td>'. $r['sector_code'] .'</td>
     <td>'. $r['legal_form'] .'</td>
     <td>'. $r['registration_number'] .'</td>
     <td>'. $registration_date .'</td> 
     <td>'. $r['tin'] .'</td>
     <td>'. $r['business_address_street_nr'] .'</td>
     <td>'. $business_address_postal_code .'</td>
     <td>'. $r['business_address_district'] .'</td>
     <td>'. $r['business_address_country_code'] .'</td>
     <td>'. $r['factory_address_street_nr'] .'</td>
     <td>'. $r['factory_address_postal_code'] .'</td>
     <td>'. $r['factory_address_district'] .'</td>
     <td>'. $r['factory_address_country_code'] .'</td>
     <td>'. $r['crg_scoring'] .'</td>
     <td>'. $r['credit_rating'] .'</td> 
     <td>'. $r['phone_nr'] .'</td>
 </tr>';
     
}

//individual data end



// company data start
    
$sql = "SELECT * FROM cib_subject_company_info WHERE report_branch_code = '1001' AND month_no = '2022-10'";
$result = mysqli_query($conn, $sql);

while($r = mysqli_fetch_array($result)){


$registration_date = dateFormatcorr($r['registration_date']);

 # Check if your variable is an integer
 $business_address_postal_code = '';
 if (filter_var($r['business_address_postal_code'], FILTER_VALIDATE_INT) === false) {
     $business_address_postal_code = '    ';
 } else {
     $business_address_postal_code = $r['business_address_postal_code'];
 }


 $html .= '<tr>
 <td>'. $r['record_type'] .'</td>
 <td>'. $r['fi_code'] .'</td>
 <td>'. $r['branch_code'] .'</td>
 <td>'. $r['fi_subject_code'] .'</td>
 <td>'. $r['title'] .'</td>
 <td>'. $r['trade_name'] .'</td>
 <td>'. $r['sector_type'] .'</td>
 <td>'. $r['sector_code'] .'</td>
 <td>'. $r['legal_form'] .'</td>
 <td>'. $r['registration_number'] .'</td>
 <td>'. $registration_date .'</td> 
 <td>'. $r['tin'] .'</td>
 <td>'. $r['business_address_street_nr'] .'</td>
 <td>'. $business_address_postal_code .'</td>
 <td>'. $r['business_address_district'] .'</td>
 <td>'. $r['business_address_country_code'] .'</td>
 <td>'. $r['factory_address_street_nr'] .'</td>
 <td>'. $r['factory_address_postal_code'] .'</td>
 <td>'. $r['factory_address_district'] .'</td>
 <td>'. $r['factory_address_country_code'] .'</td>
 <td>'. $r['crg_scoring'] .'</td>
 <td>'. $r['credit_rating'] .'</td> 
 <td>'. $r['phone_nr'] .'</td>
</tr>';
 
}
//company data end




// link data start
    
$sql = "SELECT * FROM cib_links_shareholder_propretiship WHERE report_branch_code = '1001' AND month_no = '2022-10'";
$result = mysqli_query($conn, $sql);

while($r = mysqli_fetch_array($result)){




 $html .= ' <tr>
 <td>'. $r['record_type'] .'</td>
 <td>'. $r['fi_code'] .'</td>
 <td>'. $r['branch_code'] .'</td>
 <td>'. $r['fi_subject_code'] .'</td>
 <td>'. $r['role'] .'</td>
 <td>'. $r['fi_subject_code_of_owner'] .'</td>
</tr>';
 
}
//link data end


$html .= '</table>';



// Headers for download 
header("Content-Type: application/vnd.ms-excel"); 
header("Content-Disposition: attachment; filename=subject report.xls"); 
 
// Render excel data 
echo $html; 
 

?>