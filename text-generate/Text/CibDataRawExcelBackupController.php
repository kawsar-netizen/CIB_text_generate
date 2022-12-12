<?php

namespace App\Http\Controllers\Cib\Text;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Traits\cibTrait;

ini_set('max_execution_time', 0);
ini_set('memory_limit', '-1');
date_default_timezone_set('asia/dhaka');

class CibDataExcelController extends Controller
{
    use cibTrait;

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index_subject()
    {
        $reporting_branches = DB::connection('mysql')
            ->table('branches')
            ->select('*')
            ->get();
        return view('cib.pages.text-generate.index_subject', compact('reporting_branches'));
    }


    public function index_contract()
    {
        $reporting_branches = DB::connection('mysql')
        ->table('branches')
        ->select('*')
        ->get();
        return view('cib.pages.text-generate.index_contract',compact('reporting_branches'));
    }


    public function subjectExcelGenerate(Request $request)
    {
        $year_month = $request->fm_month_no;
        $report_br_code = $request->report_br_code;



        ## Helper function section start

        // function dateFormatcorr($date) {
        //     if($date == ''){
        //         return "not found";
        //     }else{

        //     $temp_dt = explode("-", $date);
        //     $fix_dt = $temp_dt[0] . $temp_dt[1] . $temp_dt[2];       
        //     return $fix_dt;
        //     }             

        // }

        ## Helper function section end

        $html = "<table><tr>
                <th>Record Type</th>
                <th>Branch Name</th>
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


        // $personal_info = DB::connection('cib')
        //     ->table('cib_subject_personal')
        //     ->select('*')
        //     ->where('report_branch_code',$report_br_code)
        //     ->where('month_no', $year_month)
        //     ->get();
        $personal_info = DB::connection('cib')
                          ->table('cib_subject_personal')
                          ->select('*')
                          ->where('record_type','!=','')
                          ->where('fi_code','!=','')
                          ->where('fi_subject_code','!=','')
                          ->where('name','!=','')
                          ->where('father_name','!=','')
                          ->where('mother_name','!=','')
                          ->where('sector_type','!=','')
                          ->where('gender','!=','')
                          ->where('country_of_birth_code','!=','')
                          ->where('national_id_number_available','!=','')
                          ->where('report_branch_code',$report_br_code)
                          ->where('month_no',$year_month)
                          ->get();

        foreach ($personal_info as $p_info) {

            # Check if your variable is an integer
            $permanent_address_postal_code = '';
            if (filter_var($p_info->permanent_address_postal_code, FILTER_VALIDATE_INT) === false) {
                $permanent_address_postal_code = '    ';
            } else {
                $permanent_address_postal_code = $p_info->permanent_address_postal_code;
            }

            $br_name = DB::connection('mysql')
            ->table('branches')
            ->where('branch_code','=',$p_info->branch_code)
            ->first();
            $branch_name = $br_name->branch_name;
 
            $html .= '<tr>
            <td>' . $p_info->record_type . '</td>
            <td>' . $branch_name . '</td>
            <td>' . $p_info->fi_code . '</td>
            <td>' . $p_info->branch_code . '</td>
            <td>' . $p_info->fi_subject_code . '</td>
            <td>' . $p_info->title . '</td>
            <td>' . $p_info->name . '</td>
            <td>' . $p_info->father_title . '</td>
            <td>' . $p_info->father_name . '</td>
            <td>' . $p_info->mother_title . '</td>
            <td>' . $p_info->mother_name . '</td>
            <td>' . $p_info->spouse_title . '</td>
            <td>' . $p_info->spouse_name . '</td>
            <td>' . $p_info->sector_type . '</td>
            <td>' . $p_info->sector_code . '</td>
            <td>' . $p_info->gender . '</td>
            <td>' . $p_info->date_of_birth . '</td>
            <td>' . $p_info->place_of_birth_district . '</td>
            <td>' . $p_info->country_of_birth_code . '</td> 
            <td>' . $p_info->national_id_number . '</td> 
            <td>' . $p_info->national_id_number_available . '</td> 
            <td>' . $p_info->tin . '</td>
            <td>' . $p_info->permanent_address_street_nr . '</td>
            <td>' . $permanent_address_postal_code . '</td>
            <td>' . $p_info->permanent_address_district . '</td>
            <td>' . $p_info->permanent_address_country_code . '</td>
            <td>' . $p_info->present_address_street_nr . '</td>
            <td>' . $p_info->present_address_postal_code . '</td>
            <td>' . $p_info->present_address_district . '</td>
            <td>' . $p_info->present_address_country_code . '</td>
            <td>' . $p_info->business_address . '</td>
            <td>' . $p_info->business_address_postal_code . '</td>
            <td>' . $p_info->business_address_district . '</td>
            <td>' . $p_info->business_address_country_code . '</td> 
            <td>' . $p_info->id_type . '</td>
            <td>' . $p_info->id_nr . '</td>
            <td>' . $p_info->id_issue_date . '</td>
            <td>' . $p_info->id_issue_country_code . '</td>
            <td>' . $p_info->phone_nr . '</td>
        </tr>';
        }

        //personal data end


        // individual data start
        // $individual_proprietorship_info = DB::connection('cib')
        //     ->table('cib_subject_individual_proprietorship_info')
        //     ->select('*')
        //     ->where('report_branch_code',$report_br_code)
        //     ->where('month_no', $year_month)
        //     ->get();

        $individual_proprietorship_info = DB::connection('cib')
        ->table('cib_subject_individual_proprietorship_info')
        ->select('*')
        ->where('record_type','!=','')
        ->where('fi_code','!=','')
        ->where('fi_subject_code','!=','')
        ->where('trade_name','!=','')
        ->where('sector_type','!=','')
        ->where('business_address_street_nr','!=','')
        ->where('report_branch_code',$report_br_code)
        ->where('month_no',$year_month)
        ->get();


        foreach ($individual_proprietorship_info as $individual_info) {

            //Check if your variable is an integer
            $business_address_postal_code = '';
            if (filter_var($individual_info->business_address_postal_code, FILTER_VALIDATE_INT) === false) {
                $business_address_postal_code = '    ';
            } else {
                $business_address_postal_code = $individual_info->business_address_postal_code;
            }

            $br_name = DB::connection('mysql')
            ->table('branches')
            ->where('branch_code','=',$individual_info->branch_code)
            ->first();
            $branch_name = $br_name->branch_name;

            $html .= '<tr>
            <td>' . $individual_info->record_type . '</td>
            <td>' . $branch_name . '</td>
            <td>' . $individual_info->fi_code . '</td>
            <td>' . $individual_info->branch_code . '</td>
            <td>' . $individual_info->fi_subject_code . '</td>
            <td>' . $individual_info->title . '</td>
            <td>' . $individual_info->trade_name . '</td>
            <td>' . $individual_info->sector_type . '</td>
            <td>' . $individual_info->sector_code . '</td>
            <td>' . $individual_info->legal_form . '</td>
            <td>' . $individual_info->registration_number . '</td>
            <td>' . $individual_info->registration_date . '</td> 
            <td>' . $individual_info->tin . '</td>
            <td>' . $individual_info->business_address_street_nr . '</td>
            <td>' . $business_address_postal_code . '</td>
            <td>' . $individual_info->business_address_district . '</td>
            <td>' . $individual_info->business_address_country_code . '</td>
            <td>' . $individual_info->factory_address_street_nr . '</td>
            <td>' . $individual_info->factory_address_postal_code . '</td>
            <td>' . $individual_info->factory_address_district . '</td>
            <td>' . $individual_info->factory_address_country_code . '</td>
            <td>' . $individual_info->crg_scoring . '</td>
            <td>' . $individual_info->credit_rating . '</td> 
            <td>' . $individual_info->phone_nr . '</td>
            </tr>';
        }

        //individual data end




        // company data start
        // $company_info = DB::connection('cib')
        //     ->table('cib_subject_company_info')
        //     ->select('*')
        //     ->where('report_branch_code',$report_br_code)
        //     ->where('month_no', $year_month)
        //     ->get();

        $company_info = DB::connection('cib')
        ->table('cib_subject_company_info')
        ->select('*')
        ->where('record_type','!=','')
        ->where('fi_code','!=','')
        ->where('fi_subject_code','!=','')
        ->where('trade_name','!=','')
        ->where('sector_type','!=','')
        ->where('business_address_street_nr','!=','')
        ->where('report_branch_code',$report_br_code)
        ->where('month_no',$year_month)
        ->get();


        foreach ($company_info as $c_info) {

            //Check if your variable is an integer
            $business_address_postal_code = '';
            if (filter_var($c_info->business_address_postal_code, FILTER_VALIDATE_INT) === false) {
                $business_address_postal_code = '    ';
            } else {
                $business_address_postal_code = $c_info->business_address_postal_code;
            }

            $br_name = DB::connection('mysql')
            ->table('branches')
            ->where('branch_code','=',$c_info->branch_code)
            ->first();
            $branch_name = $br_name->branch_name;

            $html .= '<tr>
            <td>' . $c_info->record_type . '</td>
            <td>' . $branch_name . '</td>
            <td>' . $c_info->fi_code . '</td>
            <td>' . $c_info->branch_code . '</td>
            <td>' . $c_info->fi_subject_code . '</td>
            <td>' . $c_info->title . '</td>
            <td>' . $c_info->trade_name . '</td>
            <td>' . $c_info->sector_type . '</td>
            <td>' . $c_info->sector_code . '</td>
            <td>' . $c_info->legal_form . '</td>
            <td>' . $c_info->registration_number . '</td>
            <td>' . $c_info->registration_date . '</td> 
            <td>' . $c_info->tin . '</td>
            <td>' . $c_info->business_address_street_nr . '</td>
            <td>' . $business_address_postal_code . '</td>
            <td>' . $c_info->business_address_district . '</td>
            <td>' . $c_info->business_address_country_code . '</td>
            <td>' . $c_info->factory_address_street_nr . '</td>
            <td>' . $c_info->factory_address_postal_code . '</td>
            <td>' . $c_info->factory_address_district . '</td>
            <td>' . $c_info->factory_address_country_code . '</td>
            <td>' . $c_info->crg_scoring . '</td>
            <td>' . $c_info->credit_rating . '</td> 
            <td>' . $c_info->phone_nr . '</td>
            </tr>';
        }

        //company data end


        // link data start
//         $year_month_separation = explode("-", $year_month);
//         $year = $year_month_separation[0];
//         $month = $year_month_separation[1];


//         $link_info = DB::connection('cib')
//             ->table('cib_links_shareholder_propretiship')
//             ->select('*')
//             ->where('report_branch_code',$report_br_code)
//             ->whereMonth('created_at', '=', $month)
//             ->whereYear('created_at', '=', $year)
//             ->get();



//         foreach ($link_info as $l_info) {

//             $html .= ' <tr>
//  <td>' . $l_info->record_type . '</td>
//  <td>' . $l_info->fi_code . '</td>
//  <td>' . $l_info->branch_code . '</td>
//  <td>' . $l_info->fi_subject_code . '</td>
//  <td>' . $l_info->role . '</td>
//  <td>' . $l_info->fi_subject_code_of_owner . '</td>
// </tr>';
//         }

        //link data end


        $html .= '</table>';



        // Headers for download 
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=subject report.xls");

        // Render excel data 
        echo $html;
    }





    public function contractExcelGenerate(Request $request)
    {

        $year_month = $request->fm_month_no;
        $report_br_code = $request->report_br_code;



        ## Helper function section start
        function dateFormatcorr($date)
        {
            if ($date == '') {
                return "not found";
            } else {

                $temp_dt = explode("-", $date);
                $fix_dt = $temp_dt[0] . $temp_dt[1] . $temp_dt[2];
                return $fix_dt;
            }
        }

        ## Helper function section end

        $html = "<table><tr>
            <th>Record Type</th>
            <th>Branch Name</th>
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

        // $installment_contract = DB::connection('cib')
        //     ->table('cib_installments_contracts')
        //     ->select('*')
        //     ->where('report_branch_code',$report_br_code)
        //     ->where('month_no', $year_month)
        //     ->get();

        $installment_contract = DB::connection('cib')
                          ->table('cib_installments_contracts')
                          ->select('*')
                          ->where('record_type','!=','')
                          ->where('fi_code','!=','')
                          ->where('fi_subject_code','!=','')
                          ->where('fi_contract_code','!=','')
                          ->where('contract_type','!=','')
                          ->where('contract_phase','!=','')
                          ->where('contract_status','!=','')
                          ->where('currency_code','!=','')
                          ->where('sanction_limit','!=','')
                          ->where('total_disbursed_amount','!=','')
                          ->where('total_outstanding_amount','!=','')
                          ->where('report_branch_code',$report_br_code)
                          ->where('month_no',$year_month)
                          ->get();

        foreach ($installment_contract as $ins_contract) {

            $br_name = DB::connection('mysql')
            ->table('branches')
            ->where('branch_code','=',$ins_contract->branch_code)
            ->first();
            $branch_name = $br_name->branch_name;

            $html .= '<tr>
            <td>' . $ins_contract->record_type . ' </td>
            <td>' . $branch_name. ' </td>
            <td>' . $ins_contract->fi_code . ' </td>
            <td>' . $ins_contract->branch_code . ' </td>
            <td>' . $ins_contract->fi_subject_code . ' </td>
            <td>' . $ins_contract->fi_contract_code . ' </td>
            <td>' . $ins_contract->contract_type . ' </td>
            <td>' . $ins_contract->contract_phase . ' </td>
            <td>' . $ins_contract->contract_status . ' </td>
            <td>' . $ins_contract->currency_code . ' </td>
            <td>' . $ins_contract->starting_date_of_the_contract . ' </td>
            <td>' . $ins_contract->request_date_of_the_contract . ' </td>
            <td>' . $ins_contract->planned_end_date_of_the_contract . ' </td>
            <td>' . $ins_contract->actual_end_date_of_the_contract . ' </td>
            <td>' . $ins_contract->default_status . ' </td>
            <td>' . $ins_contract->date_of_last_payment . ' </td>
            <td>' . $ins_contract->flag_subsidized_credit . ' </td>
            <td>' . $ins_contract->flag_pre_finance_of_loan . ' </td>
            <td>' . $ins_contract->code_reorganized_credit . ' </td>
            <td>' . $ins_contract->third_party_guarantee_type . ' </td>
            <td>' . $ins_contract->security_type . ' </td>
            <td>' . $ins_contract->amount_guaranteed_by_third_party_guarantor . ' </td>
            <td>' . $ins_contract->amount_guaranteed_by_security_type . ' </td>
            <td>' . $ins_contract->basis_for_classification_qualitative_judgment . ' </td>
            <td>' . $ins_contract->sanction_limit . ' </td>
            <td>' . $ins_contract->total_disbursed_amount . ' </td>
            <td>' . $ins_contract->total_outstanding_amount . ' </td>
            <td>' . $ins_contract->total_number_of_installments . ' </td>
            <td>' . $ins_contract->periodicity_of_payment . ' </td>
            <td>' . $ins_contract->method_of_payment . ' </td>
            <td>' . $ins_contract->installment_amount . ' </td>
            <td>' . $ins_contract->expiration_date_of_next_installment . ' </td>
            <td>' . $ins_contract->amount_of_next_expiring_installment . ' </td>
            <td>' . $ins_contract->number_of_remaining_installments . ' </td>
            <td>' . $ins_contract->remaining_amount . ' </td>
            <td>' . $ins_contract->number_of_overdue_installment . ' </td>
            <td>' . $ins_contract->overdue_amount . ' </td>
            <td>' . $ins_contract->number_of_days_of_payment_delay . ' </td>
            <td>' . $ins_contract->type_of_leased_good . ' </td>
            <td>' . $ins_contract->value_of_leased_good . ' </td>
            <td>' . $ins_contract->registration_number . ' </td>
            <td>' . $ins_contract->date_of_manufacturing . ' </td>
            <td>' . $ins_contract->due_for_recovery . ' </td>
            <td>' . $ins_contract->recovery_during_the_reporting_period . ' </td>
            <td>' . $ins_contract->cumulative_recovery . ' </td>
            <td>' . $ins_contract->date_of_law_suit . ' </td>
            <td>' . $ins_contract->date_of_classification . ' </td>
            <td>' . $ins_contract->no_of_time_rescheduling . ' </td>
            <td>' . $ins_contract->date_of_last_rescheduling . ' </td>
            <td>' . $ins_contract->economic_purpose_code . ' </td>
            <td>' . $ins_contract->sme . ' </td>
            <td>' . $ins_contract->enterprise_type . ' </td>
            </tr>';
        }

        // installment contract end




        // non installment start

        // $non_installment_contract = DB::connection('cib')
        //     ->table('cib_noninstall_contracts')
        //     ->select('*')
        //     ->where('report_branch_code',$report_br_code)
        //     ->where('month_no', $year_month)
        //     ->get();

        $non_installment_contract = DB::connection('cib')
                ->table('cib_noninstall_contracts')
                ->select('*')
                ->where('record_type','!=','')
                ->where('fi_code','!=','')
                ->where('fi_subject_code','!=','')
                ->where('fi_contract_code','!=','')
                ->where('contract_type','!=','')
                ->where('contract_phase','!=','')
                ->where('contract_status','!=','')
                ->where('currency_code','!=','')
                ->where('sanction_limit','!=','')
                ->where('total_outstanding_amount','!=','')
                ->where('report_branch_code',$report_br_code)
                ->where('month_no',$year_month)
                ->get();



        foreach ($non_installment_contract as $non_ins_contract) {
            $br_name = DB::connection('mysql')
            ->table('branches')
            ->where('branch_code','=',$non_ins_contract->branch_code)
            ->first();
            $branch_name = $br_name->branch_name;

            $html .= '<tr>
                        <td>' . $non_ins_contract->record_type . ' </td>
                        <td>' . $branch_name. ' </td>
                        <td>' . $non_ins_contract->fi_code . ' </td>
                        <td>' . $non_ins_contract->branch_code . ' </td>
                        <td>' . $non_ins_contract->fi_subject_code . ' </td>
                        <td>' . $non_ins_contract->fi_contract_code . ' </td>
                        <td>' . $non_ins_contract->contract_type . ' </td>
                        <td>' . $non_ins_contract->contract_phase . ' </td>
                        <td>' . $non_ins_contract->contract_status . ' </td>
                        <td>' . $non_ins_contract->currency_code . ' </td>
                        <td>' . $non_ins_contract->starting_date_of_the_contract . ' </td>
                        <td>' . $non_ins_contract->request_date_of_the_contract . ' </td>
                        <td>' . $non_ins_contract->planned_end_date_of_the_contract . ' </td>
                        <td>' . $non_ins_contract->actual_end_date_of_the_contract . ' </td>
                        <td>' . $non_ins_contract->default_status . ' </td>
                        <td>' . $non_ins_contract->date_of_last_payment . ' </td>
                        <td>' . $non_ins_contract->flag_subsidized_credit . ' </td>
                        <td>' . $non_ins_contract->flag_pre_finance_of_loan . ' </td>
                        <td>' . $non_ins_contract->code_reorganized_credit . ' </td>
                        <td>' . $non_ins_contract->third_party_guarantee_type . ' </td>
                        <td>' . $non_ins_contract->security_type . ' </td>
                        <td>' . $non_ins_contract->amount_guaranteed_by_third_party_guarantor . ' </td>
                        <td>' . $non_ins_contract->amount_guaranteed_by_security_type . ' </td>
                        <td>' . $non_ins_contract->basis_for_classification_qualitative_judgment . ' </td>
                        <td>' . $non_ins_contract->sanction_limit . ' </td>
                        <td>' . $non_ins_contract->total_outstanding_amount . ' </td>
                        <td>' . $non_ins_contract->nr_of_days_of_payment_delay . ' </td>
                        <td>' . $non_ins_contract->overdue_amount . ' </td>
                        <td>' . $non_ins_contract->recovery_during_the_reporting_period . ' </td>
                        <td>' . $non_ins_contract->cumulative_recovery . ' </td>
                        <td>' . $non_ins_contract->date_of_law_suit . ' </td>
                        <td>' . $non_ins_contract->date_of_classification . ' </td>
                        <td>' . $non_ins_contract->no_of_time_rescheduling . ' </td>
                        <td>' . $non_ins_contract->economic_purpose_code . ' </td>
                        <td>' . $non_ins_contract->sme . ' </td>
                        <td>' . $non_ins_contract->enterprise_type . ' </td>
                    </tr>';
        }


        //non installment end


        $html .= '</table>';

        // Headers for download 
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=contract report.xls");

        // Render excel data 
        echo $html;
    }

    public function create()
    {
        //echo $this->GetContractNumber('I63991', '0008', 1);die;
        return view('cib.pages.text-generate.create');
    } // end -:- create()


}// end -:- CibDataPushController
