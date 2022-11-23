<?php
// error_reporting(E_ALL & ~E_NOTICE);
error_reporting('0');
include "config.php";

## Helper function section start
function dateFormatcorr($date)
{
	$temp_dt = explode("-", $date);
	$fix_dt = $temp_dt[0] . $temp_dt[1] . $temp_dt[2];
	return $fix_dt;
}
## Helper function section end
?>
<!DOCTYPE html>
<html>

<head>
	<title>Contact Report Information</title>
	<style>
		.customers {
			font-family: Arial, Helvetica, sans-serif;
			border-collapse: collapse;
			width: 100%;
		}

		.customers td,
		.customers th {
			border: 1px solid #000;
			padding: 8px;
		}

		.customers tr:nth-child(even) {
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

		th,
		td {
			text-align: left;
			padding: 8px;
		}

		tr:nth-child(even) {
			background-color: #f2f2f2;
		}
	</style>


</head>

<body>
	<div class="container">
	<h2 >Contract Report Information</h2>
		<a href="contract_excel.php"><button style="margin-bottom: 12px;">Save to excel</button></a>
		<div style="overflow-x:auto;">
			<table class="table customers" id="table_content">
				<thead>
					<tr>
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
					</tr>
				</thead>

				<tbody>

					<?php

					## For installment contract data


					$sql = "SELECT * FROM cib_installments_contracts WHERE report_branch_code = '1001' AND month_no = '2022-10'";
					$result = mysqli_query($conn, $sql);

					while ($r = mysqli_fetch_array($result)) {
					?>
						<tr>
							<td><?php echo $r['record_type'] ?> </td>
							<td><?php echo $r['fi_code'] ?> </td>
							<td><?php echo $r['branch_code'] ?> </td>
							<td><?php echo $r['fi_subject_code'] ?> </td>
							<td><?php echo $r['fi_contract_code'] ?> </td>
							<td><?php echo $r['contract_type'] ?> </td>
							<td><?php echo $r['contract_phase'] ?> </td>
							<td><?php echo $r['contract_status'] ?> </td>
							<td><?php echo $r['currency_code'] ?> </td>
							<td><?php echo dateFormatcorr($r['starting_date_of_the_contract']) ?> </td>
							<td><?php echo dateFormatcorr($r['request_date_of_the_contract']) ?> </td>
							<td><?php echo dateFormatcorr($r['planned_end_date_of_the_contract']) ?> </td>
							<td><?php echo dateFormatcorr($r['actual_end_date_of_the_contract']) ?> </td>
							<td><?php echo $r['default_status'] ?> </td>
							<td><?php echo dateFormatcorr($r['date_of_last_payment']) ?> </td>
							<td><?php echo $r['flag_subsidized_credit'] ?> </td>
							<td><?php echo $r['flag_pre_finance_of_loan'] ?> </td>
							<td><?php echo $r['code_reorganized_credit'] ?> </td>
							<td><?php echo $r['third_party_guarantee_type'] ?> </td>
							<td><?php echo $r['security_type'] ?> </td>
							<td><?php echo $r['amount_guaranteed_by_third_party_guarantor'] ?> </td>
							<td><?php echo $r['amount_guaranteed_by_security_type'] ?> </td>
							<td><?php echo $r['basis_for_classification_qualitative_judgment'] ?> </td>
							<td><?php echo $r['sanction_limit'] ?> </td>
							<td><?php echo $r['total_disbursed_amount'] ?> </td>
							<td><?php echo $r['total_outstanding_amount'] ?> </td>
							<td><?php echo $r['total_number_of_installments'] ?> </td>
							<td><?php echo $r['periodicity_of_payment'] ?> </td>
							<td><?php echo $r['method_of_payment'] ?> </td>
							<td><?php echo $r['installment_amount'] ?> </td>
							<td><?php echo dateFormatcorr($r['expiration_date_of_next_installment']) ?> </td>
							<td><?php echo $r['amount_of_next_expiring_installment'] ?> </td>
							<td><?php echo $r['number_of_remaining_installments'] ?> </td>
							<td><?php echo $r['remaining_amount'] ?> </td>
							<td><?php echo $r['number_of_overdue_installment'] ?> </td>
							<td><?php echo $r['overdue_amount'] ?> </td>
							<td><?php echo $r['number_of_days_of_payment_delay'] ?> </td>
							<td><?php echo $r['type_of_leased_good'] ?> </td>
							<td><?php echo $r['value_of_leased_good'] ?> </td>
							<td><?php echo $r['registration_number'] ?> </td>
							<td><?php echo dateFormatcorr($r['date_of_manufacturing']) ?> </td>
							<td><?php echo $r['due_for_recovery'] ?> </td>
							<td><?php echo $r['recovery_during_the_reporting_period'] ?> </td>
							<td><?php echo $r['cumulative_recovery'] ?> </td>
							<td><?php echo dateFormatcorr($r['date_of_law_suit']) ?> </td>
							<td><?php echo dateFormatcorr($r['date_of_classification']) ?> </td>
							<td><?php echo $r['no_of_time_rescheduling'] ?> </td>
							<td><?php echo dateFormatcorr($r['date_of_last_rescheduling']) ?> </td>
							<td><?php echo $r['economic_purpose_code'] ?> </td>
							<td><?php echo $r['sme'] ?> </td>
							<td><?php echo $r['enterprise_type'] ?> </td>
						</tr>

					<?php
					}

					## For non installment data

					$sql = "SELECT * FROM cib_noninstall_contracts WHERE report_branch_code = '1001' AND month_no = '2022-10'";
					$result = mysqli_query($conn, $sql);

					while ($r = mysqli_fetch_array($result)) {


						$starting_date_contract = dateFormatcorr($r['starting_date_of_the_contract']);
						$request_date_contract = dateFormatcorr($r['request_date_of_the_contract']);
						$planned_end_datecontract = dateFormatcorr($r['planned_end_date_of_the_contract']);
						$dt_classification = dateFormatcorr($r['date_of_classification']);
						$dt_rescheduling = dateFormatcorr($r['no_of_time_rescheduling']);

					?>

						<tr>
							<td><?php echo $r['record_type'] ?></td>
							<td><?php echo $r['fi_code'] ?></td>
							<td><?php echo $r['branch_code'] ?></td>
							<td><?php echo $r['fi_subject_code'] ?></td>
							<td><?php echo $r['fi_contract_code'] ?></td>
							<td><?php echo $r['contract_type'] ?></td>
							<td><?php echo $r['contract_phase'] ?></td>
							<td><?php echo $r['contract_status'] ?></td>
							<td><?php echo $r['currency_code'] ?></td>
							<td><?php echo $starting_date_contract ?></td>
							<td><?php echo $request_date_contract ?></td>
							<td><?php echo $planned_end_datecontract ?></td>
							<td><?php echo $r['actual_end_date_of_the_contract'] ?></td>
							<td><?php echo $r['default_status'] ?></td>
							<td><?php echo $r['date_of_last_payment'] ?></td>
							<td><?php echo $r['flag_subsidized_credit'] ?></td>
							<td><?php echo $r['flag_pre_finance_of_loan'] ?></td>
							<td><?php echo $r['code_reorganized_credit'] ?></td>
							<td><?php echo $r['third_party_guarantee_type'] ?></td>
							<td><?php echo $r['security_type'] ?></td>
							<td><?php echo $r['amount_guaranteed_by_third_party_guarantor'] ?></td>
							<td><?php echo $r['amount_guaranteed_by_security_type'] ?></td>
							<td><?php echo $r['basis_for_classification_qualitative_judgment'] ?></td>
							<td><?php echo $r['sanction_limit'] ?></td>
							<td><?php echo $r['total_outstanding_amount'] ?></td>
							<td><?php echo $r['nr_of_days_of_payment_delay'] ?></td>
							<td><?php echo $r['overdue_amount'] ?></td>
							<td><?php echo $r['recovery_during_the_reporting_period'] ?></td>
							<td><?php echo $r['cumulative_recovery'] ?></td>
							<td><?php echo dateFormatcorr($r['date_of_law_suit']) ?></td>
							<td><?php echo $dt_classification ?></td>
							<td><?php echo $dt_rescheduling ?></td>
							<td><?php echo $r['economic_purpose_code'] ?></td>
							<td><?php echo $r['sme'] ?></td>
							<td><?php echo $r['enterprise_type'] ?></td>
						</tr>
					<?php

					}
					?>

				</tbody>
			</table>

		</div>
	</div>
</body>

</html>