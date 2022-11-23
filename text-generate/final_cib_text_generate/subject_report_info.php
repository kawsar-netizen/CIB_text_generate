<?php
    // error_reporting(E_ALL & ~E_NOTICE);
    include "config.php";
    error_reporting('0');
    ## Helper function section start
    function dateFormatcorr($date) {
        $temp_dt = explode("-", $date);
        $fix_dt = $temp_dt[0] . $temp_dt[1] . $temp_dt[2];
        return $fix_dt;
    }
    ## Helper function section end

    
?>

<!DOCTYPE html>
<html>
<head>
    <title>Subject Report In System</title>
    <style>
        .customers {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }
        .customers td, .customers th {
            border: 1px solid #000;
            padding: 8px;
        }
        .customers tr:nth-child(even){
            background-color: #f2f2f2;
        }
        .customers tr:hover {
            background-color: #ddd;
        }
        .customers th {
            /* padding-top: 12px;
            padding-bottom: 12px; */
            text-align: left;
            /* background-color: #04AA6D; */
            color: #000;
            border: 1px solid #000;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {background-color: #f2f2f2;}
    </style>
   
</head>

<body>
    <div class="container">
        <h2 >Subject Report Information</h2>

        <a href = "subject_excel.php"><button style="margin-bottom: 12px;" class="btn btn-primary">Save to excel</button></a>
  <br>
        <table class="table customers" id="table_content">
            <thead>
                <tr>
                    <!-- <th>Sl.</th> -->
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
                </tr>
            </thead>
            <tbody>
                <?php
                         ## For subject personal table data

                         $sql = "SELECT * FROM cib_subject_personal WHERE report_branch_code = '1001' AND month_no = '2022-10'";
                         $result = mysqli_query($conn, $sql);
                         $p_count = mysqli_num_rows($result);
                         $sl_count = 1;
                         while ($r = mysqli_fetch_array($result)) {

                             $dt_birth = dateFormatcorr($r['date_of_birth']);

                             # Check if your variable is an integer
                             $permanent_address_postal_code = '';
                             if (filter_var($r['permanent_address_postal_code'], FILTER_VALIDATE_INT) === false) {
                                 $permanent_address_postal_code = '    ';
                             } else {
                                 $permanent_address_postal_code = $r['permanent_address_postal_code'];
                             }

                             ?>
                             <tr>
                                 <!-- <td><?php echo $sl_count; ?></td> -->
                                 <td><?php echo $r['record_type'] ?></td>
                                 <td><?php echo $r['fi_code'] ?></td>
                                 <td><?php echo $r['branch_code'] ?></td>
                                 <td><?php echo $r['fi_subject_code'] ?></td>
                                 <td><?php echo $r['title'] ?></td>
                                 <td><?php echo $r['name'] ?></td>
                                 <td><?php echo $r['father_title'] ?></td>
                                 <td><?php echo $r['father_name'] ?></td>
                                 <td><?php echo $r['mother_title'] ?></td>
                                 <td><?php echo $r['mother_name'] ?></td>
                                 <td><?php echo $r['spouse_title'] ?></td>
                                 <td><?php echo $r['spouse_name'] ?></td>
                                 <td><?php echo $r['sector_type'] ?></td>
                                 <td><?php echo $r['sector_code'] ?></td>
                                 <td><?php echo $r['gender'] ?></td>
                                 <td><?php echo $dt_birth ?></td>
                                 <td><?php echo $r['place_of_birth_district'] ?></td>
                                 <td><?php echo $r['country_of_birth_code'] ?></td> 
                                 <td><?php echo $r['national_id_number'] ?></td> 
                                 <td><?php echo $r['national_id_number_available'] ?></td> 
                                 <td><?php echo $r['tin'] ?></td>
                                 <td><?php echo $r['permanent_address_street_nr'] ?></td>
                                 <td><?php echo $permanent_address_postal_code ?></td>
                                 <td><?php echo $r['permanent_address_district'] ?></td>
                                 <td><?php echo $r['permanent_address_country_code'] ?></td>
                                 <td><?php echo $r['present_address_street_nr'] ?></td>
                                 <td><?php echo $r['present_address_postal_code'] ?></td>
                                 <td><?php echo $r['present_address_district'] ?></td>
                                 <td><?php echo $r['present_address_country_code'] ?></td>
                                 <td><?php echo $r['business_address'] ?></td>
                                 <td><?php echo $r['business_address_postal_code'] ?></td>
                                 <td><?php echo $r['business_address_district'] ?></td>
                                 <td><?php echo $r['business_address_country_code'] ?></td> 
                                 <td><?php echo $r['id_type'] ?></td>
                                 <td><?php echo $r['id_nr'] ?></td>
                                 <td><?php echo dateFormatcorr($r['id_issue_date']) ?></td>
                                 <td><?php echo $r['id_issue_country_code'] ?></td>
                                 <td><?php echo $r['phone_nr'] ?></td>
                             </tr>
                         <?php 
                             // $sl_count ++ ;
                         } 








                    ## For subject individual proprietorship table data

                    $sql = "SELECT * FROM cib_subject_individual_proprietorship_info WHERE report_branch_code = '1001' AND month_no = '2022-10'";
                    $result = mysqli_query($conn, $sql);
                    $ind_count = mysqli_num_rows($result);
                    $sl_count = 1;
                    while ($r = mysqli_fetch_array($result)) {

                          $registration_date     = dateFormatcorr($r['registration_date']);

                            //Check if your variable is an integer
                            $business_address_postal_code = '';
                            if ( filter_var($r['business_address_postal_code'], FILTER_VALIDATE_INT) === false ) {
                            $business_address_postal_code = '    ';
                            }else{
                                $business_address_postal_code = $r['business_address_postal_code'];
                            }
                        ?>
                        <tr>
                            <!-- <td><?php echo $sl_count; ?></td> -->
                            <td><?php echo $r['record_type'] ?></td>
                            <td><?php echo $r['fi_code'] ?></td>
                            <td><?php echo $r['branch_code'] ?></td>
                            <td><?php echo $r['fi_subject_code'] ?></td>
                            <td><?php echo $r['title'] ?></td>
                            <td><?php echo $r['trade_name'] ?></td>
                            <td><?php echo $r['sector_type'] ?></td>
                            <td><?php echo $r['sector_code'] ?></td>
                            <td><?php echo $r['legal_form'] ?></td>
                            <td><?php echo $r['registration_number'] ?></td>
                            <td><?php echo $registration_date ?></td> 
                            <td><?php echo $r['tin'] ?></td>
                            <td><?php echo $r['business_address_street_nr'] ?></td>
                            <td><?php echo $business_address_postal_code ?></td>
                            <td><?php echo $r['business_address_district'] ?></td>
                            <td><?php echo $r['business_address_country_code'] ?></td>
                            <td><?php echo $r['factory_address_street_nr'] ?></td>
                            <td><?php echo $r['factory_address_postal_code'] ?></td>
                            <td><?php echo $r['factory_address_district'] ?></td>
                            <td><?php echo $r['factory_address_country_code'] ?></td>
                            <td><?php echo $r['crg_scoring'] ?></td>
                            <td><?php echo $r['credit_rating'] ?></td> 
                            <td><?php echo $r['phone_nr'] ?></td>
                        </tr>
                    <?php 
                        // $sl_count ++ ;
                    } 


                    ## For subject company table data

                    $sql = "SELECT * FROM cib_subject_company_info WHERE report_branch_code = '1001' AND month_no = '2022-10'";
                    $result     = mysqli_query($conn, $sql);
                    $c_count = mysqli_num_rows($result);
                    $sl_count = 1;
                    while ($r = mysqli_fetch_array($result)) {


                        # Check if your variable is an integer
                        $business_address_postal_code = '';
                        if (filter_var($r['business_address_postal_code'], FILTER_VALIDATE_INT) === false) {
                            $business_address_postal_code = '    ';
                        } else {
                            $business_address_postal_code = $r['business_address_postal_code'];
                        }

                        $registration_date = dateFormatcorr($r['registration_date']);


                        ?>
                        <tr>
                            <!-- <td><?php echo $sl_count; ?></td> -->
                            <td><?php echo $r['record_type'] ?></td>
                            <td><?php echo $r['fi_code'] ?></td>
                            <td><?php echo $r['branch_code'] ?></td>
                            <td><?php echo $r['fi_subject_code'] ?></td>
                            <td><?php echo $r['title'] ?></td>
                            <td><?php echo $r['trade_name'] ?></td>
                            <td><?php echo $r['sector_type'] ?></td>
                            <td><?php echo $r['sector_code'] ?></td>
                            <td><?php echo $r['legal_form'] ?></td>
                            <td><?php echo $r['registration_number'] ?></td>
                            <td><?php echo $registration_date ?></td> 
                            <td><?php echo $r['tin'] ?></td>
                            <td><?php echo $r['business_address_street_nr'] ?></td>
                            <td><?php echo $business_address_postal_code ?></td>
                            <td><?php echo $r['business_address_district'] ?></td>
                            <td><?php echo $r['business_address_country_code'] ?></td>
                            <td><?php echo $r['factory_address_street_nr'] ?></td>
                            <td><?php echo $r['factory_address_postal_code'] ?></td>
                            <td><?php echo $r['factory_address_district'] ?></td>
                            <td><?php echo $r['factory_address_country_code'] ?></td>
                            <td><?php echo $r['crg_scoring'] ?></td>
                            <td><?php echo $r['credit_rating'] ?></td> 
                            <td><?php echo $r['phone_nr'] ?></td>
                        </tr>
                    <?php 
                        // $sl_count ++ ;
                    }
                                    

                    ## For subject links shareholder propretiship table data

                    $sql = "SELECT * FROM cib_links_shareholder_propretiship WHERE report_branch_code = '1001' AND month_no = '2022-10'";
                    $result = mysqli_query($conn, $sql);
                    $s_count = mysqli_num_rows($result);
                    $sl_count = 1;
                    while ($r = mysqli_fetch_array($result)) {

                        ?>
                        <tr>
                            <!-- <td><?php echo $sl_count; ?></td> -->
                            <td><?php echo $r['record_type'] ?></td>
                            <td><?php echo $r['fi_code'] ?></td>
                            <td><?php echo $r['branch_code'] ?></td>
                            <td><?php echo $r['fi_subject_code'] ?></td>
                            <td><?php echo $r['role'] ?></td>
                            <td><?php echo $r['fi_subject_code_of_owner'] ?></td>
                        </tr>
                    <?php 
                        // $sl_count ++ ;
                    }
                    ?>
            </tbody>
        </table>
    </div>
</body>

</html>

