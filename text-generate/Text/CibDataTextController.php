<?php

namespace App\Http\Controllers\Cib\Text;

use Illuminate\Http\Request;;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Html\Editor\Fields\Select;

ini_set('max_execution_time', 0);
ini_set('memory_limit', '-1');
date_default_timezone_set('asia/dhaka');

class CibDataTextController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $reporting_branches = DB::connection('mysql')
        ->table('branches')
        ->select('*')
        ->get();
        return view('cib.pages.text-generate.subject-text',compact('reporting_branches'));
    }

    
    public function subjectTextGenerate(Request $request){
        $year_month = $request->cib_date;
        $report_branch_code = $request->report_branch_code;

        // $report_branch_code='';
        // if($report_br_code == 'all'){
        //     $report_branch_code_query = '';
        // }else{
        //     $report_branch_code = $report_br_code;
        //     $report_branch_code_query = "AND report_branch_code = '$report_branch_code'" ;
        // }
        
        $reporting_branches = DB::connection('mysql')
        ->table('branches')
        ->select('*')
        ->get();
    return view('cib.pages.text-generate.subject_generate',compact('report_branch_code','year_month','reporting_branches'));
    }


    public function indexContract() {

        $reporting_branches = DB::connection('mysql')
        ->table('branches')
        ->select('*')
        ->get();
        return view('cib.pages.text-generate.contract-text',compact('reporting_branches'));
    }

    public function contractTextGenerate(Request $request){
        $year_month = $request->cib_date;
        // $report_br_code = $request->report_branch_code;
        $report_branch_code = $request->report_branch_code;
        
        // $report_branch_code='';
        // if($report_br_code == 'all'){
        //     $report_branch_code_query = '';
        // }else{
        //     $report_branch_code = $report_br_code;
        //     $report_branch_code_query = "AND report_branch_code = '$report_branch_code'" ;
        // }
        $reporting_branches = DB::connection('mysql')
        ->table('branches')
        ->select('*')
        ->get();
    return view('cib.pages.text-generate.contract_generate',compact('report_branch_code','year_month','reporting_branches'));
    }

    ## For download dummy excel file
    public function downloadSubjectExcel() {
        $filePath = public_path(). "/excel-download/subject-report.xls";
        $headers = ['Content-Type: xls'];
        $fileName = 'subject-report.xls';
        return response()->download($filePath, $fileName, $headers);
    }

    public function downloadContractExcel() {
        $filePath = public_path(). "/excel-download/contract-report.xls";
        $headers = ['Content-Type: xls'];
        $fileName = 'contract-report.xls';
        return response()->download($filePath, $fileName, $headers);
    }


    // public function downloadText(Request $request) {
    //     dd('Hello');
    //     ## helper function section start
    //     // function IndividualProprietorshipSpaceFiller($act_name, $name_filler) {
    //     //     //include "config.php";
    //     //     $sql2 = "SELECT $name_filler FROM cib_13112022.subject_individual_proprietorship_info_len";
    //     //     // $result2 = mysqli_query($conn, $sql2);
    //     //     // $row =  mysqli_fetch_array($result2);
    //     //     $results_ind = DB::select($sql2);
    //     //     $nm_fill = $results_ind[$name_filler];

    //     //     $act_name_length = strlen($act_name);

    //     //     $fill = '';
    //     //     for ($filler = $act_name_length; $filler < $nm_fill; $filler++) {
    //     //         $fill = $fill . ' ';
    //     //     }

    //     //     return $act_name . $fill;
    //     // }
    //     // dd($this.IndividualProprietorshipSpaceFiller('Dew','trade_name'));

    //     // function dateFormatcorr($date) {
    //     //     $temp_dt = explode("-", $date);
    //     //     $fix_dt = $temp_dt[0] . $temp_dt[1] . $temp_dt[2];
    //     //     return $fix_dt;
    //     // }
    //     ## helper function section end

    //     $input_date = $request->cib_date;
    //     // $year_month = date("Y-m", strtotime($input_date));
    //     // $sql_query_ind = "SELECT * FROM cbr_cib_db.cib_subject_individual_proprietorship_info WHERE month_no = '$year_month'";
    //     // $results_ind = DB::select($sql_query_ind);
    //     // foreach ($results_ind as $row) {
    //     //     $record_type = $row->record_type;
    //     //     if($record_type !='') {
    //     //         if(strlen($record_type) == 1) {
    //     //             $record_type;
    //     //         } else {
    //     //             $record_type =  $record_type.str_repeat(" ", 1 - strlen($record_type));
    //     //         }
    //     //     } else {
    //     //         $record_type = str_repeat(" ", 1);
    //     //     }

    //     //     $fi_code = $row->fi_code;
    //     //     if($fi_code !='') {
    //     //         if(strlen($fi_code) == 3) {
    //     //             $fi_code;
    //     //         } else {
    //     //             $fi_code =  $fi_code.str_repeat(" ", 3 - strlen($fi_code));
    //     //         }
    //     //     } else {
    //     //         $fi_code = str_repeat(" ", 3);
    //     //     }

    //     //     $branch_code = $row->branch_code;
    //     //     if($branch_code !='') {
    //     //         if(strlen($branch_code) == 4) {
    //     //             $branch_code;
    //     //         } else {
    //     //             $branch_code =  $branch_code.str_repeat(" ", 4 - strlen($branch_code));
    //     //         }
    //     //     } else {
    //     //         $branch_code = str_repeat(" ", 4);
    //     //     }

    //     //     $fi_subject_code = $row->fi_subject_code;
    //     //     if($fi_subject_code !='') {
    //     //         if(strlen($fi_subject_code) == 16) {
    //     //             $fi_subject_code;
    //     //         } else {
    //     //             $fi_subject_code =  $fi_subject_code.str_repeat(" ", 16 - strlen($fi_subject_code));
    //     //         }
    //     //     } else {
    //     //         $fi_subject_code = str_repeat(" ", 16);
    //     //     }

    //     //     $title = $row->title;
    //     //     if($title !='') {
    //     //         if(strlen($title) == 20) {
    //     //             $title;
    //     //         } else {
    //     //             $title =  $title.str_repeat(" ", 20 - strlen($title));
    //     //         }
    //     //     } else {
    //     //         $title = str_repeat(" ", 20);
    //     //     }

    //     //     $trade_name = $row->trade_name;

    //     //     if($trade_name !='')
    //     //     {
    //     //         if(strlen($trade_name) == 70)
    //     //         {
    //     //             $trade_name;
    //     //         }else{
    //     //             $trade_name =  $trade_name.str_repeat(" ", 70 - strlen($trade_name));
    //     //         }

    //     //     }else{
    //     //         $trade_name = str_repeat(" ", 70);
    //     //     }

    //     //     $sector_type = $row->sector_type;
            
    //     //     if($sector_type !='')
    //     //     {
    //     //         if(strlen($sector_type) == 1)
    //     //         {
    //     //             $sector_type;
    //     //         }else{
    //     //             $sector_type =  $sector_type.str_repeat(" ", 1 - strlen($sector_type));
    //     //         }

    //     //     }else{
    //     //         $sector_type = str_repeat(" ", 1);
    //     //     }

    //     //     $sector_code = $row->sector_code;
    //     //     if($sector_code !='')
    //     //     {
    //     //         if(strlen($sector_code) == 6)
    //     //         {
    //     //             $sector_code;
    //     //         }else{
    //     //             $sector_code =  $sector_code.str_repeat(" ", 6 - strlen($sector_code));
    //     //         }

    //     //     }else{
    //     //         $sector_code = str_repeat(" ", 6);
    //     //     }

    //     //     $legal_form = $row->legal_form;
    //     //     if($legal_form !='')
    //     //     {
    //     //         if(strlen($legal_form) == 2)
    //     //         {
    //     //             $legal_form;
    //     //         }else{
    //     //             $legal_form =  $legal_form.str_repeat(" ", 2 - strlen($legal_form));
    //     //         }

    //     //     }else{
    //     //         $legal_form = str_repeat(" ", 2);
    //     //     }

    //     //     $registration_number = $row->registration_number;
    //     //     if($registration_number !='')
    //     //     {
    //     //         if(strlen($registration_number) == 15)
    //     //         {
    //     //             $registration_number;
    //     //         }else{
    //     //             $registration_number =  $registration_number.str_repeat(" ", 15 - strlen($registration_number));
    //     //         }

    //     //     }else{
    //     //         $registration_number = str_repeat(" ", 15);
    //     //     }


    //     //     $registration_date = $row->registration_date;
    //     //     if($registration_date !='')
    //     //     {
    //     //         if(strlen($registration_date) == 8)
    //     //         {
    //     //             $registration_date;
    //     //         }else{
    //     //             $registration_date =  $registration_date.str_repeat(" ", 8 - strlen($registration_date));
    //     //         }

    //     //     }else{
    //     //         $registration_date = str_repeat(" ", 8);
    //     //     }

    //     //     $tin = $row->tin;
    //     //     dd($tin);
    //     //     if($tin !='')
    //     //     {
    //     //         if(strlen($tin) == 12)
    //     //         {
    //     //             $tin;
    //     //         }else{
    //     //             $tin =  $tin.str_repeat(" ", 12 - (strlen($tin) + 1));
    //     //         }

    //     //     }else{
    //     //         $tin = str_repeat(" ", 12);
    //     //     }

    //     //     $business_address_street_nr = $row->business_address_street_nr;
    //     //     if($business_address_street_nr !='')
    //     //     {
    //     //         if(strlen($business_address_street_nr) == 100)
    //     //         {
    //     //             $business_address_street_nr;
    //     //         }else{
    //     //             $business_address_street_nr =  $business_address_street_nr.str_repeat(" ", 100 - strlen($business_address_street_nr));
    //     //         }

    //     //     }else{
    //     //         $business_address_street_nr = str_repeat(" ", 100);
    //     //     }

    //     //     $business_address_postal_code = $row->business_address_postal_code;

    //     //     if($business_address_postal_code !='')
    //     //     {
    //     //         if(strlen($business_address_postal_code) == 4)
    //     //         {
    //     //             $business_address_postal_code;
    //     //         }else{
    //     //             $business_address_postal_code =  $business_address_postal_code.str_repeat(" ", 4 - strlen($business_address_postal_code));
    //     //         }

    //     //     }else{
    //     //         $business_address_postal_code = str_repeat(" ", 4);
    //     //     }
    //     //     $business_address_district = $row->business_address_district;

    //     //     if($business_address_district !='')
    //     //     {
    //     //         if(strlen($business_address_district) == 20)
    //     //         {
    //     //             $business_address_district;
    //     //         }else{
    //     //             $business_address_district =  $business_address_district.str_repeat(" ", 20 - strlen($business_address_district));
    //     //         }

    //     //     }else{
    //     //         $business_address_district = str_repeat(" ", 20);
    //     //     }

    //     //     $business_address_country_code = $row->business_address_country_code;
    //     //     if($business_address_country_code !='')
    //     //     {
    //     //         if(strlen($business_address_country_code) == 2)
    //     //         {
    //     //             $business_address_country_code;
    //     //         }else{
    //     //             $business_address_country_code =  $business_address_country_code.str_repeat(" ", 2 - strlen($business_address_country_code));
    //     //         }

    //     //     }else{
    //     //         $business_address_country_code = str_repeat(" ", 2);
    //     //     }

    //     //     $factory_address_street_nr = $row->factory_address_street_nr;

    //     //     if($factory_address_street_nr !='')
    //     //     {
    //     //         if(strlen($factory_address_street_nr) == 100)
    //     //         {
    //     //             $factory_address_street_nr;
    //     //         }else{
    //     //             $factory_address_street_nr =  $factory_address_street_nr.str_repeat(" ", 100 - strlen($factory_address_street_nr));
    //     //         }

    //     //     }else{
    //     //         $factory_address_street_nr = str_repeat(" ", 100);
    //     //     }

    //     //     $factory_address_postal_code = $row->factory_address_postal_code;
    //     //     if($factory_address_postal_code !='')
    //     //     {
    //     //         if(strlen($factory_address_postal_code) == 4)
    //     //         {
    //     //             $factory_address_postal_code;
    //     //         }else{
    //     //             $factory_address_postal_code =  $factory_address_postal_code.str_repeat(" ", 4 - strlen($factory_address_postal_code));
    //     //         }

    //     //     }else{
    //     //         $factory_address_postal_code = str_repeat(" ", 4);
    //     //     }

    //     //     $factory_address_district = $row->factory_address_district;

    //     //     if($factory_address_district !='')
    //     //     {
    //     //         if(strlen($factory_address_district) == 20)
    //     //         {
    //     //             $factory_address_district;
    //     //         }else{
    //     //             $factory_address_district =  $factory_address_district.str_repeat(" ", 20 - strlen($factory_address_district));
    //     //         }

    //     //     }else{
    //     //         $factory_address_district = str_repeat(" ", 20);
    //     //     }
    //     //     $factory_address_country_code = $row->factory_address_country_code;
            
    //     //     if($factory_address_country_code !='')
    //     //     {
    //     //         if(strlen($factory_address_country_code) == 2)
    //     //         {
    //     //             $factory_address_country_code;
    //     //         }else{
    //     //             $factory_address_country_code =  $factory_address_country_code.str_repeat(" ", 2 - strlen($factory_address_country_code));
    //     //         }

    //     //     }else{
    //     //         $factory_address_country_code = str_repeat(" ", 2);
    //     //     }
    //     //     $crg_scoring = $row->crg_scoring;
    //     //     if($crg_scoring !='')
    //     //     {
    //     //         if(strlen($crg_scoring) == 3)
    //     //         {
    //     //             $crg_scoring;
    //     //         }else{
    //     //             $crg_scoring =  $crg_scoring.str_repeat(" ", 3 - strlen($crg_scoring));
    //     //         }

    //     //     }else{
    //     //         $crg_scoring = str_repeat(" ", 3);
    //     //     }

    //     //     $credit_rating = $row->credit_rating;
    //     //     if($credit_rating !='')
    //     //     {
    //     //         if(strlen($credit_rating) == 3)
    //     //         {
    //     //             $credit_rating;
    //     //         }else{
    //     //             $credit_rating =  $credit_rating.str_repeat(" ", 3 - strlen($credit_rating));
    //     //         }

    //     //     }else{
    //     //         $credit_rating = str_repeat(" ", 3);
    //     //     }
    //     //     $phone_nr = $row->phone_nr;
    //     //     if($phone_nr !='')
    //     //     {
    //     //         if(strlen($phone_nr) == 40)
    //     //         {
    //     //             $phone_nr;
    //     //         }else{
    //     //             $phone_nr =  $phone_nr.str_repeat(" ", 40 - strlen($phone_nr));
    //     //         }

    //     //     }else{
    //     //         $phone_nr = str_repeat(" ", 40);
    //     //     }

    //     //     $text_content =  $record_type.$fi_code.$branch_code.$fi_subject_code.$title.$trade_name.$sector_type.$sector_code.$legal_form.$registration_number.$registration_date.$tin.$business_address_street_nr.$business_address_postal_code.$business_address_district.$business_address_country_code.$factory_address_street_nr.$factory_address_postal_code.$factory_address_district.$factory_address_country_code.$crg_scoring.$credit_rating.$phone_nr;

    //     //     file_put_contents('subject.txt', $text_content . PHP_EOL, FILE_APPEND);
            
    //     //     // print $row->individual_company_key;
    //     //     $registration_date     = dateFormatcorr($row->registration_date);
    //     //     //Check if your variable is an integer
    //     //     $business_address_postal_code = '';
    //     //     if ( filter_var($row->business_address_postal_code, FILTER_VALIDATE_INT) === false ) {
    //     //     $business_address_postal_code = '    ';
    //     //     } else {
    //     //         $business_address_postal_code = $row->business_address_postal_code;
    //     //     }

    //     //     $text_content = IndividualProprietorshipSpaceFiller($row->record_type, 'record_type')
    //     //     . IndividualProprietorshipSpaceFiller($row->fi_code, 'fi_code')
    //     //     . IndividualProprietorshipSpaceFiller($row->branch_code, 'branch_code')
    //     //     . IndividualProprietorshipSpaceFiller($row->fi_subject_code, 'fi_subject_code')
    //     //     . IndividualProprietorshipSpaceFiller($row->title, 'title')
    //     //     . IndividualProprietorshipSpaceFiller($row->trade_name, 'trade_name')
    //     //     . IndividualProprietorshipSpaceFiller($row->sector_type, 'sector_type')
    //     //     . IndividualProprietorshipSpaceFiller($row->sector_code, 'sector_code')
    //     //     . IndividualProprietorshipSpaceFiller($row->legal_form, 'legal_form')
    //     //     . IndividualProprietorshipSpaceFiller($row->registration_number, 'registration_number')
    //     //     . IndividualProprietorshipSpaceFiller($registration_date, 'registration_date')
    //     //     . IndividualProprietorshipSpaceFiller($row->tin, 'tin')
    //     //     . IndividualProprietorshipSpaceFiller($row->, 'business_address_street_nr')
    //     //     . IndividualProprietorshipSpaceFiller($business_address_postal_code, '')
    //     //     . IndividualProprietorshipSpaceFiller($row->business_address_district, '')
    //     //     . IndividualProprietorshipSpaceFiller($row->, 'business_address_country_code')
    //     //     . IndividualProprietorshipSpaceFiller($row->factory_address_street_nr, '')
    //     //     . IndividualProprietorshipSpaceFiller($row->, 'factory_address_postal_code')
    //     //     . IndividualProprietorshipSpaceFiller($row->, 'factory_address_district')
    //     //     . IndividualProprietorshipSpaceFiller($row->, 'factory_address_country_code')
    //     //     . IndividualProprietorshipSpaceFiller($row->, 'crg_scoring')
    //     //     . IndividualProprietorshipSpaceFiller($row->, 'credit_rating')
    //     //     . IndividualProprietorshipSpaceFiller($row->, 'phone_nr');

    //     //     $final_text_len = strlen($text_content);

    //     //     $re_fill = '';
    //     //     for ($re_filler = $final_text_len; $re_filler < 1100; $re_filler++) {
    //     //         $re_fill = $re_fill . ' ';
    //     //     }
    //     //     $remaining_data_filler =  $re_fill;

    //     //     $r_data_len = strlen($remaining_data_filler);
    //     //     $fixed_text_len = $final_text_len + $r_data_len;

    //     //     if ($fixed_text_len == 1100) {
    //     //         $file_text = file_put_contents('subject.txt', $text_content . $remaining_data_filler . PHP_EOL, FILE_APPEND);
    //     //         //echo 'This is not error '.'<br>';
    //     //     } else {
    //     //         echo 'This is error ' . $row->fi_subject_code;
    //     //         exit();
    //     //     }
    //     }
    // }
}
