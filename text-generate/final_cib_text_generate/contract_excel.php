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
            <th>F.I. Contract Code</th>
            <th>Contract Type</th>
            <th>Contract Phase</th>
            <th>Contract Status</th>
            <th>Currency Code (in file)</th>
            <th>Starting date of the contract</th>
            <th>Request date of the contract</th>
            <th>Planned End Date of the contract</th>
            <th>Actual End Date of the contract</th>
            <th>Default status</th>
            <th>Date of Last Payment</th>
            <th>Flag Subsidized Credit</th>
            <th>Flag pre-finance of Loan</th>
            <th>Code Reorganized Credit</th>
            <th>Third Party Guarantee Type</th>
            <th>Security Type</th>
            <th>Amount guaranteed by Third Party Guarantor</th>
            <th>Amount guaranteed by Security type</th>
            <th>Basis for Classification: Qualitative judgment</th>
            <th>Sanction Limit</th>
            <th>Total Disbursed Amount</th>
            <th>Total Outstanding Amount</th>
            <th>Total Number of Installments</th>
            <th>Periodicity of Payment</th>
            <th>Method of Payment</th>
            <th>Installment Amount</th>
            <th>Expiration Date of Next Installment</th>
            <th>Amount of Next Expiring Installment</th>
            <th>Number of remaining Installments</th>
            <th>Remaining Amount</th>
            <th>Number of Overdue Installment</th>
            <th>Overdue Amount</th>
            <th>Number of days of payment delay</th>
            <th>Type of leased good</th>
            <th>Value of leased good</th>
            <th>Registration number</th>
            <th>Date of manufacturing</th>
            <th>Due for recovery</th>
            <th>Recovery during the reporting period</th>
            <th>Cumulative recovery</th>
            <th>Date of law suit</th>
            <th>Date of classification</th>
            <th>No. of time(s) rescheduling</th>
            <th>Date of Last Rescheduling</th>
            <th>Economic purpose code</th>
            <th>SME</th>
            <th>Enterprise Type</th>
            </tr>";



// installment contract start

        $sql = "SELECT * FROM cib_installments_contracts WHERE report_branch_code = '1001' AND month_no = '2022-10'";
        $result = mysqli_query($conn, $sql);
	
        while($r = mysqli_fetch_array($result)){
        

         $html .= '<tr>
         <td>'. $r['record_type'].' </td>
         <td>'. $r['fi_code'].' </td>
         <td>'. $r['branch_code'].' </td>
         <td>'. $r['fi_subject_code'].' </td>
         <td>'. $r['fi_contract_code'].' </td>
         <td>'. $r['contract_type'].' </td>
         <td>'. $r['contract_phase'].' </td>
         <td>'. $r['contract_status'].' </td>
         <td>'. $r['currency_code'].' </td>
         <td>'. dateFormatcorr($r['starting_date_of_the_contract']) .' </td>
         <td>'. dateFormatcorr($r['request_date_of_the_contract']) .' </td>
         <td>'. dateFormatcorr($r['planned_end_date_of_the_contract']) .' </td>
         <td>'. dateFormatcorr($r['actual_end_date_of_the_contract']) .' </td>
         <td>'. $r['default_status'].' </td>
         <td>'. dateFormatcorr($r['date_of_last_payment']) .' </td>
         <td>'. $r['flag_subsidized_credit'].' </td>
         <td>'. $r['flag_pre_finance_of_loan'].' </td>
         <td>'. $r['code_reorganized_credit'].' </td>
         <td>'. $r['third_party_guarantee_type'].' </td>
         <td>'. $r['security_type'].' </td>
         <td>'. $r['amount_guaranteed_by_third_party_guarantor'].' </td>
         <td>'. $r['amount_guaranteed_by_security_type'].' </td>
         <td>'. $r['basis_for_classification_qualitative_judgment'].' </td>
         <td>'. $r['sanction_limit'].' </td>
         <td>'. $r['total_disbursed_amount'].' </td>
         <td>'. $r['total_outstanding_amount'].' </td>
         <td>'. $r['total_number_of_installments'].' </td>
         <td>'. $r['periodicity_of_payment'].' </td>
         <td>'. $r['method_of_payment'].' </td>
         <td>'. $r['installment_amount'].' </td>
         <td>'. dateFormatcorr($r['expiration_date_of_next_installment']).' </td>
         <td>'. $r['amount_of_next_expiring_installment'].' </td>
         <td>'. $r['number_of_remaining_installments'].' </td>
         <td>'. $r['remaining_amount'].' </td>
         <td>'. $r['number_of_overdue_installment'].' </td>
         <td>'. $r['overdue_amount'].' </td>
         <td>'. $r['number_of_days_of_payment_delay'].' </td>
         <td>'. $r['type_of_leased_good'].' </td>
         <td>'. $r['value_of_leased_good'].' </td>
         <td>'. $r['registration_number'].' </td>
         <td>'. dateFormatcorr($r['date_of_manufacturing']).' </td>
         <td>'. $r['due_for_recovery'].' </td>
         <td>'. $r['recovery_during_the_reporting_period'].' </td>
         <td>'. $r['cumulative_recovery'].' </td>
         <td>'. dateFormatcorr($r['date_of_law_suit']).' </td>
         <td>'. dateFormatcorr($r['date_of_classification']).' </td>
         <td>'. $r['no_of_time_rescheduling'].' </td>
         <td>'. dateFormatcorr($r['date_of_last_rescheduling']).' </td>
         <td>'. $r['economic_purpose_code'].' </td>
         <td>'. $r['sme'].' </td>
         <td>'. $r['enterprise_type'].' </td>
         </tr>';
         
    }

// installment contract end




// non installment start
    
    $sql = "SELECT * FROM cib_noninstall_contracts WHERE report_branch_code = '1001' AND month_no = '2022-10'";
    $result = mysqli_query($conn, $sql);

while($r = mysqli_fetch_array($result)){
    
     
	$starting_date_contract = dateFormatcorr($r['starting_date_of_the_contract']);
    $request_date_contract = dateFormatcorr($r['request_date_of_the_contract']);
    $planned_end_datecontract = dateFormatcorr($r['planned_end_date_of_the_contract']);
    $dt_classification = dateFormatcorr($r['date_of_classification']);
    $dt_rescheduling = dateFormatcorr($r['no_of_time_rescheduling']);


                            $html .= '<tr>
                            <td>'. $r['record_type'].' </td>
                            <td>'. $r['fi_code'].' </td>
                            <td>'. $r['branch_code'].' </td>
                            <td>'. $r['fi_subject_code'].' </td>
                            <td>'. $r['fi_contract_code'].' </td>
                            <td>'. $r['contract_type'].' </td>
                            <td>'. $r['contract_phase'].' </td>
                            <td>'. $r['contract_status'].' </td>
                            <td>'. $r['currency_code'].' </td>
                            <td>'. $starting_date_contract .' </td>
                            <td>'. $request_date_contract .' </td>
                            <td>'. $planned_end_datecontract .' </td>
                            <td>'. $r['actual_end_date_of_the_contract'].' </td>
                            <td>'. $r['default_status'].' </td>
                            <td>'. $r['date_of_last_payment'].' </td>
                            <td>'. $r['flag_subsidized_credit'].' </td>
                            <td>'. $r['flag_pre_finance_of_loan'].' </td>
                            <td>'. $r['code_reorganized_credit'].' </td>
                            <td>'. $r['third_party_guarantee_type'].' </td>
                            <td>'. $r['security_type'].' </td>
                            <td>'. $r['amount_guaranteed_by_third_party_guarantor'].' </td>
                            <td>'. $r['amount_guaranteed_by_security_type'].' </td>
                            <td>'. $r['basis_for_classification_qualitative_judgment'].' </td>
                            <td>'. $r['sanction_limit'].' </td>
                            <td>'. $r['total_outstanding_amount'].' </td>
                            <td>'. $r['nr_of_days_of_payment_delay'].' </td>
                            <td>'. $r['overdue_amount'].' </td>
                            <td>'. $r['recovery_during_the_reporting_period'].' </td>
                            <td>'. $r['cumulative_recovery'].' </td>
                            <td>'. dateFormatcorr($r['date_of_law_suit']).' </td>
                            <td>'. $dt_classification.' </td>
                            <td>'. $dt_rescheduling.' </td>
                            <td>'. $r['economic_purpose_code'].' </td>
                            <td>'. $r['sme'].' </td>
                            <td>'. $r['enterprise_type'].' </td>
                        </tr>';
     
}

//non installment end





$html .= '</table>';



// Headers for download 
header("Content-Type: application/vnd.ms-excel"); 
header("Content-Disposition: attachment; filename=contract report.xls"); 
 
// Render excel data 
echo $html; 
 

?>