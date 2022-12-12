<?php

namespace App\Http\Controllers\Cib\Text;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;


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


    public function index_subject(){

        $reporting_branches = DB::connection('mysql')
                            ->table('branches')
                            ->select('*')
                            ->get();
        
        
        
        return view('cib.pages.text-generate.index_subject',compact('reporting_branches'));
    }


    public function index_contract(){

        $reporting_branches = DB::connection('mysql')
        ->table('branches')
        ->select('*')
        ->get();
        
        return view('cib.pages.text-generate.index_contract',compact('reporting_branches'));
    }








    public function subjectExcelGenerate(Request $request){
   
       //get value from ui/ux (start)
        $year_month = $request->fm_month_no;
        $report_br_code = $request->report_br_code;
       //get value from ui/ux (end)

       //personal sheet
       $spreadsheet = new Spreadsheet();
       $spreadsheet->createSheet();
       $spreadsheet->setActiveSheetIndex(0);
       $spreadsheet->getActiveSheet()->setTitle("Personal");

        //subject personal header start     
            $spreadsheet->getActiveSheet(0)->SetCellValue("A1", strtoupper('Customer Type'));
            $spreadsheet->getActiveSheet(0)->SetCellValue("B1", strtoupper('Name of The Branch'));
            $spreadsheet->getActiveSheet(0)->SetCellValue("C1", strtoupper('Branch Code'));
            $spreadsheet->getActiveSheet(0)->SetCellValue("D1", strtoupper('Account Basic Number'));
            $spreadsheet->getActiveSheet(0)->SetCellValue("E1", strtoupper('Title'));
            $spreadsheet->getActiveSheet(0)->SetCellValue("F1", strtoupper('Name of The Borrower'));
            $spreadsheet->getActiveSheet(0)->SetCellValue("G1", strtoupper('Fathers Title'));
            $spreadsheet->getActiveSheet(0)->SetCellValue("H1", strtoupper('Fathers Name'));
            $spreadsheet->getActiveSheet(0)->SetCellValue("I1", strtoupper('Mothers Title'));
            $spreadsheet->getActiveSheet(0)->SetCellValue("J1", strtoupper('Mothers Name'));
            $spreadsheet->getActiveSheet(0)->SetCellValue("K1", strtoupper('Spouses Title'));
            $spreadsheet->getActiveSheet(0)->SetCellValue("L1", strtoupper('Spouses Name'));
            $spreadsheet->getActiveSheet(0)->SetCellValue("M1", strtoupper('Sector Type'));
            $spreadsheet->getActiveSheet(0)->SetCellValue("N1", strtoupper('Sector Code'));
            $spreadsheet->getActiveSheet(0)->SetCellValue("O1", strtoupper('Gender'));
            $spreadsheet->getActiveSheet(0)->SetCellValue("P1", strtoupper('Date of Birth'));
            $spreadsheet->getActiveSheet(0)->SetCellValue("Q1", strtoupper('Place of Birth District'));
            $spreadsheet->getActiveSheet(0)->SetCellValue("R1", strtoupper('Place of Birth Country Code'));
            $spreadsheet->getActiveSheet(0)->SetCellValue("S1", strtoupper('National ID Number'));
            $spreadsheet->getActiveSheet(0)->SetCellValue("T1", strtoupper('Other ID Type'));
            $spreadsheet->getActiveSheet(0)->SetCellValue("U1", strtoupper('Other ID Number'));
            $spreadsheet->getActiveSheet(0)->SetCellValue("V1", strtoupper('Other ID Issue Date'));
            $spreadsheet->getActiveSheet(0)->SetCellValue("W1", strtoupper('Other ID Issue Country'));
            $spreadsheet->getActiveSheet(0)->SetCellValue("X1", strtoupper('ETIN'));
            $spreadsheet->getActiveSheet(0)->SetCellValue("Y1", strtoupper('Permanent Address: street + nr'));
            $spreadsheet->getActiveSheet(0)->SetCellValue("Z1", strtoupper('Permanent Address: Postal Code'));
            $spreadsheet->getActiveSheet(0)->SetCellValue("AA1", strtoupper('Permanent Address: District'));
            $spreadsheet->getActiveSheet(0)->SetCellValue("AB1", strtoupper('Permanent Address: Country(Code)'));         
            $spreadsheet->getActiveSheet(0)->SetCellValue("AC1", strtoupper('Present Address: street + nr'));
            $spreadsheet->getActiveSheet(0)->SetCellValue("AD1", strtoupper('Present Address: Postal code'));
            $spreadsheet->getActiveSheet(0)->SetCellValue("AE1", strtoupper('Present Address: District'));
            $spreadsheet->getActiveSheet(0)->SetCellValue("AF1", strtoupper('Present Address: Country(Code)'));
            $spreadsheet->getActiveSheet(0)->SetCellValue("AG1", strtoupper('Business address'));
            $spreadsheet->getActiveSheet(0)->SetCellValue("AH1", strtoupper('Business address: Postal code'));
            $spreadsheet->getActiveSheet(0)->SetCellValue("AI1", strtoupper('Business Address: District'));
            $spreadsheet->getActiveSheet(0)->SetCellValue("AJ1", strtoupper('Business Address: Country (code)'));
            $spreadsheet->getActiveSheet(0)->SetCellValue("AK1", strtoupper('Phone Number'));
            $spreadsheet->getActiveSheet(0)->GetStyle("A1:AK1")->getFont()->setBold(true);
//subject personal header ends

       
//subject personal body (start)
        if($report_br_code == 'all'){

            $personal_info = DB::connection('cib')
            ->table('cib_subject_personal')
            ->leftJoin('cbr_db.branches as cbr_db_branch_tbl', 'cib_subject_personal.report_branch_code', '=', 'cbr_db_branch_tbl.branch_code')
            ->select('cib_subject_personal.*','cbr_db_branch_tbl.branch_name as br_name')
            ->where('month_no',$year_month)
            ->get();

    
            $count = 2;
            foreach($personal_info as $p_info){               
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('A' . $count, 'Personal', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('B' . $count, $p_info->br_name, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('C' . $count, $p_info->report_branch_code, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('D' . $count, $p_info->account_basic, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('E' . $count, $p_info->title, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('F' . $count, $p_info->name, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('G' . $count, $p_info->father_title, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('H' . $count, $p_info->father_name, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('I' . $count, $p_info->mother_title, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('J' . $count, $p_info->mother_name, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('K' . $count, $p_info->spouse_title, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('L' . $count, $p_info->spouse_name, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('M' . $count, $p_info->sector_type, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('N' . $count, $p_info->sector_code, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('O' . $count, $p_info->gender, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('P' . $count, $p_info->date_of_birth, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('Q' . $count, $p_info->place_of_birth_district, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('R' . $count, $p_info->country_of_birth_code, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('S' . $count, $p_info->national_id_number, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('T' . $count, $p_info->id_type, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('U' . $count, $p_info->id_nr, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('V' . $count, $p_info->id_issue_date, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('W' . $count, $p_info->id_issue_country_code, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('X' . $count, $p_info->tin, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);

                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('Y' . $count, $p_info->permanent_address_street_nr, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('Z' . $count, $p_info->permanent_address_postal_code, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AA' . $count, $p_info->permanent_address_district, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AB' . $count, $p_info->permanent_address_country_code, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);

                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AC' . $count, $p_info->present_address_street_nr, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AD' . $count, $p_info->present_address_postal_code, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AE' . $count, $p_info->present_address_district, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AF' . $count, $p_info->present_address_country_code, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);

                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AG' . $count, $p_info->business_address, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AH' . $count, $p_info->business_address_postal_code, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AI' . $count, $p_info->business_address_district, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AJ' . $count, $p_info->business_address_country_code, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);

                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AK' . $count, $p_info->phone_nr, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $count++;
            
                                
            } 
            $spreadsheet->getActiveSheet(0)->GetColumnDimension("A")->SetAutoSize(true);
            $spreadsheet->getActiveSheet(0)->GetColumnDimension("B")->SetAutoSize(true);
            $spreadsheet->getActiveSheet(0)->GetColumnDimension("C")->SetAutoSize(true);
            $spreadsheet->getActiveSheet(0)->GetColumnDimension("D")->SetAutoSize(true);
            $spreadsheet->getActiveSheet(0)->GetColumnDimension("E")->SetAutoSize(true);
            $spreadsheet->getActiveSheet(0)->GetColumnDimension("F")->SetAutoSize(true);
            $spreadsheet->getActiveSheet(0)->GetColumnDimension("G")->SetAutoSize(true);
            $spreadsheet->getActiveSheet(0)->GetColumnDimension("H")->SetAutoSize(true);
            $spreadsheet->getActiveSheet(0)->GetColumnDimension("I")->SetAutoSize(true);
            $spreadsheet->getActiveSheet(0)->GetColumnDimension("J")->SetAutoSize(true);
            $spreadsheet->getActiveSheet(0)->GetColumnDimension("K")->SetAutoSize(true);
            $spreadsheet->getActiveSheet(0)->GetColumnDimension("L")->SetAutoSize(true);
            $spreadsheet->getActiveSheet(0)->GetColumnDimension("M")->SetAutoSize(true);
            $spreadsheet->getActiveSheet(0)->GetColumnDimension("N")->SetAutoSize(true);
            $spreadsheet->getActiveSheet(0)->GetColumnDimension("O")->SetAutoSize(true);
            $spreadsheet->getActiveSheet(0)->GetColumnDimension("P")->SetAutoSize(true);
            $spreadsheet->getActiveSheet(0)->GetColumnDimension("Q")->SetAutoSize(true);
            $spreadsheet->getActiveSheet(0)->GetColumnDimension("R")->SetAutoSize(true);
            $spreadsheet->getActiveSheet(0)->GetColumnDimension("S")->SetAutoSize(true);
            $spreadsheet->getActiveSheet(0)->GetColumnDimension("T")->SetAutoSize(true);
            $spreadsheet->getActiveSheet(0)->GetColumnDimension("U")->SetAutoSize(true);
            $spreadsheet->getActiveSheet(0)->GetColumnDimension("V")->SetAutoSize(true);
            $spreadsheet->getActiveSheet(0)->GetColumnDimension("W")->SetAutoSize(true);
            $spreadsheet->getActiveSheet(0)->GetColumnDimension("X")->SetAutoSize(true);
            $spreadsheet->getActiveSheet(0)->GetColumnDimension("Y")->SetAutoSize(true);
            $spreadsheet->getActiveSheet(0)->GetColumnDimension("Z")->SetAutoSize(true);

            $spreadsheet->getActiveSheet(0)->GetColumnDimension("AA")->SetAutoSize(true);
            $spreadsheet->getActiveSheet(0)->GetColumnDimension("AB")->SetAutoSize(true);
            $spreadsheet->getActiveSheet(0)->GetColumnDimension("AC")->SetAutoSize(true);
            $spreadsheet->getActiveSheet(0)->GetColumnDimension("AD")->SetAutoSize(true);
            $spreadsheet->getActiveSheet(0)->GetColumnDimension("AE")->SetAutoSize(true);
            $spreadsheet->getActiveSheet(0)->GetColumnDimension("AF")->SetAutoSize(true);
            $spreadsheet->getActiveSheet(0)->GetColumnDimension("AG")->SetAutoSize(true);
            $spreadsheet->getActiveSheet(0)->GetColumnDimension("AH")->SetAutoSize(true);
            $spreadsheet->getActiveSheet(0)->GetColumnDimension("AI")->SetAutoSize(true);
            $spreadsheet->getActiveSheet(0)->GetColumnDimension("AJ")->SetAutoSize(true);
            $spreadsheet->getActiveSheet(0)->GetColumnDimension("AK")->SetAutoSize(true);
          

        }else{

            $personal_info = DB::connection('cib')
            ->table('cib_subject_personal')
            ->select('*')
            ->where('report_branch_code',$report_br_code)
            ->where('month_no',$year_month)
            ->get();


            $count = 2;
            foreach($personal_info as $p_info){
      
                $br_name = DB::connection('mysql')
                ->table('branches')
                ->where('branch_code','=',$p_info->report_branch_code)
                ->first();      
                $branch_name = $br_name->branch_name;

                
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('A' . $count, 'Personal', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('B' . $count, $branch_name, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('C' . $count, $p_info->report_branch_code, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('D' . $count, $p_info->account_basic, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('E' . $count, $p_info->title, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('F' . $count, $p_info->name, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('G' . $count, $p_info->father_title, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('H' . $count, $p_info->father_name, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('I' . $count, $p_info->mother_title, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('J' . $count, $p_info->mother_name, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);

                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('K' . $count, $p_info->spouse_title, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('L' . $count, $p_info->spouse_name, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);

                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('M' . $count, $p_info->sector_type, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('N' . $count, $p_info->sector_code, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('O' . $count, $p_info->gender, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('P' . $count, $p_info->date_of_birth, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('Q' . $count, $p_info->place_of_birth_district, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('R' . $count, $p_info->country_of_birth_code, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('S' . $count, $p_info->national_id_number, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);

                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('T' . $count, $p_info->id_type, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('U' . $count, $p_info->id_nr, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('V' . $count, $p_info->id_issue_date, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('W' . $count, $p_info->id_issue_country_code, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);

                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('X' . $count, $p_info->tin, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);

                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('Y' . $count, $p_info->permanent_address_street_nr, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('Z' . $count, $p_info->permanent_address_postal_code, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AA' . $count, $p_info->permanent_address_district, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AB' . $count, $p_info->permanent_address_country_code, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);

                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AC' . $count, $p_info->present_address_street_nr, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AD' . $count, $p_info->present_address_postal_code, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AE' . $count, $p_info->present_address_district, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AF' . $count, $p_info->present_address_country_code, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);

                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AG' . $count, $p_info->business_address, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AH' . $count, $p_info->business_address_postal_code, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AI' . $count, $p_info->business_address_district, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AJ' . $count, $p_info->business_address_country_code, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);

                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AK' . $count, $p_info->phone_nr, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $count++;
      
            }  
             $spreadsheet->getActiveSheet(0)->GetColumnDimension("A")->SetAutoSize(true);
            $spreadsheet->getActiveSheet(0)->GetColumnDimension("B")->SetAutoSize(true);
            $spreadsheet->getActiveSheet(0)->GetColumnDimension("C")->SetAutoSize(true);
            $spreadsheet->getActiveSheet(0)->GetColumnDimension("D")->SetAutoSize(true);
            $spreadsheet->getActiveSheet(0)->GetColumnDimension("E")->SetAutoSize(true);
            $spreadsheet->getActiveSheet(0)->GetColumnDimension("F")->SetAutoSize(true);
            $spreadsheet->getActiveSheet(0)->GetColumnDimension("G")->SetAutoSize(true);
            $spreadsheet->getActiveSheet(0)->GetColumnDimension("H")->SetAutoSize(true);
            $spreadsheet->getActiveSheet(0)->GetColumnDimension("I")->SetAutoSize(true);
            $spreadsheet->getActiveSheet(0)->GetColumnDimension("J")->SetAutoSize(true);
            $spreadsheet->getActiveSheet(0)->GetColumnDimension("K")->SetAutoSize(true);
            $spreadsheet->getActiveSheet(0)->GetColumnDimension("L")->SetAutoSize(true);
            $spreadsheet->getActiveSheet(0)->GetColumnDimension("M")->SetAutoSize(true);
            $spreadsheet->getActiveSheet(0)->GetColumnDimension("N")->SetAutoSize(true);
            $spreadsheet->getActiveSheet(0)->GetColumnDimension("O")->SetAutoSize(true);
            $spreadsheet->getActiveSheet(0)->GetColumnDimension("P")->SetAutoSize(true);
            $spreadsheet->getActiveSheet(0)->GetColumnDimension("Q")->SetAutoSize(true);
            $spreadsheet->getActiveSheet(0)->GetColumnDimension("R")->SetAutoSize(true);
            $spreadsheet->getActiveSheet(0)->GetColumnDimension("S")->SetAutoSize(true);
            $spreadsheet->getActiveSheet(0)->GetColumnDimension("T")->SetAutoSize(true);
            $spreadsheet->getActiveSheet(0)->GetColumnDimension("U")->SetAutoSize(true);
            $spreadsheet->getActiveSheet(0)->GetColumnDimension("V")->SetAutoSize(true);
            $spreadsheet->getActiveSheet(0)->GetColumnDimension("W")->SetAutoSize(true);
            $spreadsheet->getActiveSheet(0)->GetColumnDimension("X")->SetAutoSize(true);
            $spreadsheet->getActiveSheet(0)->GetColumnDimension("Y")->SetAutoSize(true);
            $spreadsheet->getActiveSheet(0)->GetColumnDimension("Z")->SetAutoSize(true);

            $spreadsheet->getActiveSheet(0)->GetColumnDimension("AA")->SetAutoSize(true);
            $spreadsheet->getActiveSheet(0)->GetColumnDimension("AB")->SetAutoSize(true);
            $spreadsheet->getActiveSheet(0)->GetColumnDimension("AC")->SetAutoSize(true);
            $spreadsheet->getActiveSheet(0)->GetColumnDimension("AD")->SetAutoSize(true);
            $spreadsheet->getActiveSheet(0)->GetColumnDimension("AE")->SetAutoSize(true);
            $spreadsheet->getActiveSheet(0)->GetColumnDimension("AF")->SetAutoSize(true);
            $spreadsheet->getActiveSheet(0)->GetColumnDimension("AG")->SetAutoSize(true);
            $spreadsheet->getActiveSheet(0)->GetColumnDimension("AH")->SetAutoSize(true);
            $spreadsheet->getActiveSheet(0)->GetColumnDimension("AI")->SetAutoSize(true);
            $spreadsheet->getActiveSheet(0)->GetColumnDimension("AJ")->SetAutoSize(true);
            $spreadsheet->getActiveSheet(0)->GetColumnDimension("AK")->SetAutoSize(true);

        }

//subject personal body (end)




        //company sheet
        $spreadsheet->createSheet();
        $spreadsheet->setActiveSheetIndex(1);
        $spreadsheet->getActiveSheet()->setTitle('Company');


        //company header start                  
        $spreadsheet->getActiveSheet(0)->SetCellValue("A1", strtoupper('Customer Type'));
        $spreadsheet->getActiveSheet(0)->SetCellValue("B1", strtoupper('Name of The Branch'));
        $spreadsheet->getActiveSheet(0)->SetCellValue("C1", strtoupper('Branch Code'));
        $spreadsheet->getActiveSheet(0)->SetCellValue("D1", strtoupper('Account Basic Number'));
        $spreadsheet->getActiveSheet(0)->SetCellValue("E1", strtoupper('Title'));
        $spreadsheet->getActiveSheet(0)->SetCellValue("F1", strtoupper('Trade Name'));
        $spreadsheet->getActiveSheet(0)->SetCellValue("G1", strtoupper('Sector Type'));
        $spreadsheet->getActiveSheet(0)->SetCellValue("H1", strtoupper('Sector Code'));
        $spreadsheet->getActiveSheet(0)->SetCellValue("I1", strtoupper('Legal Form'));
        $spreadsheet->getActiveSheet(0)->SetCellValue("J1", strtoupper('Registration Number'));
        $spreadsheet->getActiveSheet(0)->SetCellValue("K1", strtoupper('Registration Date'));
        $spreadsheet->getActiveSheet(0)->SetCellValue("L1", strtoupper('ETIN'));
        $spreadsheet->getActiveSheet(0)->SetCellValue("M1", strtoupper('Business address'));
        $spreadsheet->getActiveSheet(0)->SetCellValue("N1", strtoupper('Business address: Postal code'));
        $spreadsheet->getActiveSheet(0)->SetCellValue("O1", strtoupper('Business Address: District'));
        $spreadsheet->getActiveSheet(0)->SetCellValue("P1", strtoupper('Business Address: Country (code)'));  
        $spreadsheet->getActiveSheet(0)->SetCellValue("Q1", strtoupper('Factory address'));
        $spreadsheet->getActiveSheet(0)->SetCellValue("R1", strtoupper('Factory address: Postal code'));
        $spreadsheet->getActiveSheet(0)->SetCellValue("S1", strtoupper('Factory Address: District'));
        $spreadsheet->getActiveSheet(0)->SetCellValue("T1", strtoupper('Factory Address: Country (code)'));
        $spreadsheet->getActiveSheet(0)->SetCellValue("U1", strtoupper('CRG Scroring'));
        $spreadsheet->getActiveSheet(0)->SetCellValue("V1", strtoupper('Credit Rating'));
        $spreadsheet->getActiveSheet(0)->SetCellValue("W1", strtoupper('Phone Number'));
        $spreadsheet->getActiveSheet(0)->GetStyle("A1:W1")->getFont()->setBold(true);
        //company header ends


        // company body data start

if($report_br_code == 'all'){


    $company_info = DB::connection('cib')
    ->table('cib_subject_company_info')
    ->leftJoin('cbr_db.branches as cbr_db_branch_tbl', 'cib_subject_company_info.report_branch_code', '=', 'cbr_db_branch_tbl.branch_code')
    ->select('cib_subject_company_info.*','cbr_db_branch_tbl.branch_name as br_name')
    ->where('month_no',$year_month)
    ->get();

    
    $count = 2;
    foreach($company_info as $c_info){


                
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('A' . $count, 'Company', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('B' . $count, $c_info->br_name, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('C' . $count, $c_info->report_branch_code, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('D' . $count, $c_info->account_basic, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('E' . $count, $c_info->title, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('F' . $count, $c_info->trade_name, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('G' . $count, $c_info->sector_type, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('H' . $count, $c_info->sector_code, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('I' . $count, $c_info->legal_form, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('J' . $count, $c_info->registration_number, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('K' . $count, $c_info->registration_date, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('L' . $count, $c_info->tin, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('M' . $count, $c_info->business_address_street_nr, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('N' . $count, $c_info->business_address_postal_code, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('O' . $count, $c_info->business_address_district, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('P' . $count, $c_info->business_address_country_code, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('Q' . $count, $c_info->factory_address_street_nr, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('R' . $count, $c_info->factory_address_postal_code, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('S' . $count, $c_info->factory_address_district, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('T' . $count, $c_info->factory_address_country_code, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('U' . $count, $c_info->crg_scoring, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('V' . $count, $c_info->credit_rating, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('W' . $count, $c_info->phone_nr, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $count++;

    }
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("A")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("B")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("C")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("D")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("E")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("F")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("G")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("H")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("I")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("J")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("K")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("L")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("M")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("N")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("O")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("P")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("Q")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("R")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("S")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("T")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("U")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("V")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("W")->SetAutoSize(true);
    

    }else{

        $company_info = DB::connection('cib')
            ->table('cib_subject_company_info')
            ->select('*')
            ->where('report_branch_code',$report_br_code)
            ->where('month_no',$year_month)
            ->get(); 

    $count = 2;
    foreach($company_info as $c_info){


        $br_name = DB::connection('mysql')
                ->table('branches')
                ->where('branch_code','=',$c_info->report_branch_code)
                ->first();      
                $branch_name = $br_name->branch_name;

                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('A' . $count, 'Company', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('B' . $count, $branch_name, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('C' . $count, $c_info->report_branch_code, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('D' . $count, $c_info->account_basic, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('E' . $count, $c_info->title, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('F' . $count, $c_info->trade_name, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('G' . $count, $c_info->sector_type, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('H' . $count, $c_info->sector_code, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('I' . $count, $c_info->legal_form, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('J' . $count, $c_info->registration_number, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('K' . $count, $c_info->registration_date, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('L' . $count, $c_info->tin, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('M' . $count, $c_info->business_address_street_nr, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('N' . $count, $c_info->business_address_postal_code, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('O' . $count, $c_info->business_address_district, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('P' . $count, $c_info->business_address_country_code, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('Q' . $count, $c_info->factory_address_street_nr, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('R' . $count, $c_info->factory_address_postal_code, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('S' . $count, $c_info->factory_address_district, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('T' . $count, $c_info->factory_address_country_code, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('U' . $count, $c_info->crg_scoring, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('V' . $count, $c_info->credit_rating, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $spreadsheet->getActiveSheet(0)->setCellValueExplicit('W' . $count, $c_info->phone_nr, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $count++;

    }

                $spreadsheet->getActiveSheet(0)->GetColumnDimension("A")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("B")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("C")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("D")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("E")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("F")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("G")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("H")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("I")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("J")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("K")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("L")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("M")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("N")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("O")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("P")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("Q")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("R")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("S")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("T")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("U")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("V")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("W")->SetAutoSize(true);
    }

//company body data end





  //company link sheet
  $spreadsheet->createSheet();
  $spreadsheet->setActiveSheetIndex(2);
  $spreadsheet->getActiveSheet()->setTitle('Company Link');


  //company link header start                  
  $spreadsheet->getActiveSheet(0)->SetCellValue("A1", strtoupper('Record_type'));
  $spreadsheet->getActiveSheet(0)->SetCellValue("B1", strtoupper('FI_Code'));
  $spreadsheet->getActiveSheet(0)->SetCellValue("C1", strtoupper('Branch_code'));
  $spreadsheet->getActiveSheet(0)->SetCellValue("D1", strtoupper('FI_subject_code'));
  $spreadsheet->getActiveSheet(0)->SetCellValue("E1", strtoupper('Role'));
  $spreadsheet->getActiveSheet(0)->SetCellValue("F1", strtoupper('Subject_code_of_company_owner'));
  $spreadsheet->getActiveSheet(0)->SetCellValue("G1", strtoupper('acc_month'));
  $spreadsheet->getActiveSheet(0)->SetCellValue("H1", strtoupper('data_purity'));
  $spreadsheet->getActiveSheet(0)->GetStyle("A1:H1")->getFont()->setBold(true);
  //company link header ends


  // company link body data start
          $spreadsheet->getActiveSheet(0)->setCellValueExplicit('A2', 'L', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
          $spreadsheet->getActiveSheet(0)->setCellValueExplicit('B2',  '045', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
          $spreadsheet->getActiveSheet(0)->setCellValueExplicit('C2' , '13', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
          $spreadsheet->getActiveSheet(0)->setCellValueExplicit('D2' , '452893624', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
          $spreadsheet->getActiveSheet(0)->setCellValueExplicit('E2' , '2', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
          $spreadsheet->getActiveSheet(0)->setCellValueExplicit('F2' , '452893624101', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
          $spreadsheet->getActiveSheet(0)->setCellValueExplicit('G2' , '06-22', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
          $spreadsheet->getActiveSheet(0)->setCellValueExplicit('H2' , '0', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);

          $spreadsheet->getActiveSheet(0)->GetColumnDimension("A")->SetAutoSize(true);
          $spreadsheet->getActiveSheet(0)->GetColumnDimension("B")->SetAutoSize(true);
          $spreadsheet->getActiveSheet(0)->GetColumnDimension("C")->SetAutoSize(true);
          $spreadsheet->getActiveSheet(0)->GetColumnDimension("D")->SetAutoSize(true);
          $spreadsheet->getActiveSheet(0)->GetColumnDimension("E")->SetAutoSize(true);
          $spreadsheet->getActiveSheet(0)->GetColumnDimension("F")->SetAutoSize(true);
          $spreadsheet->getActiveSheet(0)->GetColumnDimension("G")->SetAutoSize(true);
          $spreadsheet->getActiveSheet(0)->GetColumnDimension("H")->SetAutoSize(true);
//company link body data end





//Proprietroship sheet
$spreadsheet->createSheet();
$spreadsheet->setActiveSheetIndex(3);
$spreadsheet->getActiveSheet()->setTitle('Proprietroship');



 //Proprietroship header start                  
 $spreadsheet->getActiveSheet(0)->SetCellValue("A1", strtoupper('Customer Type'));
 $spreadsheet->getActiveSheet(0)->SetCellValue("B1", strtoupper('Name of The Branch'));
 $spreadsheet->getActiveSheet(0)->SetCellValue("C1", strtoupper('Branch Code'));
 $spreadsheet->getActiveSheet(0)->SetCellValue("D1", strtoupper('Account Basic Number'));
 $spreadsheet->getActiveSheet(0)->SetCellValue("E1", strtoupper('Title'));
 $spreadsheet->getActiveSheet(0)->SetCellValue("F1", strtoupper('Trade Name'));
 $spreadsheet->getActiveSheet(0)->SetCellValue("G1", strtoupper('Sector Type'));
 $spreadsheet->getActiveSheet(0)->SetCellValue("H1", strtoupper('Sector Code'));
 $spreadsheet->getActiveSheet(0)->SetCellValue("I1", strtoupper('Legal Form'));
 $spreadsheet->getActiveSheet(0)->SetCellValue("J1", strtoupper('Registration Number'));
 $spreadsheet->getActiveSheet(0)->SetCellValue("K1", strtoupper('Registration Date'));
 $spreadsheet->getActiveSheet(0)->SetCellValue("L1", strtoupper('ETIN'));
 $spreadsheet->getActiveSheet(0)->SetCellValue("M1", strtoupper('Business address'));
 $spreadsheet->getActiveSheet(0)->SetCellValue("N1", strtoupper('Business address: Postal code'));
 $spreadsheet->getActiveSheet(0)->SetCellValue("O1", strtoupper('Business Address: District'));
 $spreadsheet->getActiveSheet(0)->SetCellValue("P1", strtoupper('Business Address: Country (code)'));  
 $spreadsheet->getActiveSheet(0)->SetCellValue("Q1", strtoupper('Factory address'));
 $spreadsheet->getActiveSheet(0)->SetCellValue("R1", strtoupper('Factory address: Postal code'));
 $spreadsheet->getActiveSheet(0)->SetCellValue("S1", strtoupper('Factory Address: District'));
 $spreadsheet->getActiveSheet(0)->SetCellValue("T1", strtoupper('Factory Address: Country (code)'));
 $spreadsheet->getActiveSheet(0)->SetCellValue("U1", strtoupper('CRG Scroring'));
 $spreadsheet->getActiveSheet(0)->SetCellValue("V1", strtoupper('Credit Rating'));
 $spreadsheet->getActiveSheet(0)->SetCellValue("W1", strtoupper('Phone Number'));
 $spreadsheet->getActiveSheet(0)->GetStyle("A1:W1")->getFont()->setBold(true);
 //Proprietroship header ends


 // Proprietroship body data start

if($report_br_code == 'all'){


    $individual_proprietorship_info = DB::connection('cib')
    ->table('cib_subject_individual_proprietorship_info')
    ->leftJoin('cbr_db.branches as cbr_db_branch_tbl', 'cib_subject_individual_proprietorship_info.report_branch_code', '=', 'cbr_db_branch_tbl.branch_code')
    ->select('cib_subject_individual_proprietorship_info.*','cbr_db_branch_tbl.branch_name as br_name')
    ->where('month_no',$year_month)
    ->get();

  
    $count = 2;
    foreach($individual_proprietorship_info as $i_info){

            
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('A' . $count, 'Proprietorship', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('B' . $count, $i_info->br_name, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('C' . $count, $i_info->report_branch_code, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('D' . $count, $i_info->account_basic, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('E' . $count, $i_info->title, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('F' . $count, $i_info->trade_name, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('G' . $count, $i_info->sector_type, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('H' . $count, $i_info->sector_code, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('I' . $count, $i_info->legal_form, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('J' . $count, $i_info->registration_number, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('K' . $count, $i_info->registration_date, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('L' . $count, $i_info->tin, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('M' . $count, $i_info->business_address_street_nr, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('N' . $count, $i_info->business_address_postal_code, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('O' . $count, $i_info->business_address_district, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('P' . $count, $i_info->business_address_country_code, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('Q' . $count, $i_info->factory_address_street_nr, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('R' . $count, $i_info->factory_address_postal_code, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('S' . $count, $i_info->factory_address_district, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('T' . $count, $i_info->factory_address_country_code, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('U' . $count, $i_info->crg_scoring, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('V' . $count, $i_info->credit_rating, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('W' . $count, $i_info->phone_nr, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $count++;

    }
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("A")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("B")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("C")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("D")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("E")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("F")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("G")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("H")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("I")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("J")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("K")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("L")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("M")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("N")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("O")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("P")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("Q")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("R")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("S")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("T")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("U")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("V")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("W")->SetAutoSize(true);
    

    }else{

        $individual_proprietorship_info = DB::connection('cib')
            ->table('cib_subject_individual_proprietorship_info')
            ->select('*')
            ->where('report_branch_code',$report_br_code)
            ->where('month_no',$year_month)
            ->get(); 


        

    $count = 2;
    foreach($individual_proprietorship_info as $i_info){


        $br_name = DB::connection('mysql')
                ->table('branches')
                ->where('branch_code','=',$i_info->report_branch_code)
                ->first();      
                $branch_name = $br_name->branch_name;

                     
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('A' . $count, 'Proprietorship', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('B' . $count, $branch_name, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('C' . $count, $i_info->report_branch_code, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('D' . $count, $i_info->account_basic, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('E' . $count, $i_info->title, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('F' . $count, $i_info->trade_name, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('G' . $count, $i_info->sector_type, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('H' . $count, $i_info->sector_code, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('I' . $count, $i_info->legal_form, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('J' . $count, $i_info->registration_number, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('K' . $count, $i_info->registration_date, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('L' . $count, $i_info->tin, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('M' . $count, $i_info->business_address_street_nr, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('N' . $count, $i_info->business_address_postal_code, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('O' . $count, $i_info->business_address_district, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('P' . $count, $i_info->business_address_country_code, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('Q' . $count, $i_info->factory_address_street_nr, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('R' . $count, $i_info->factory_address_postal_code, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('S' . $count, $i_info->factory_address_district, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('T' . $count, $i_info->factory_address_country_code, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('U' . $count, $i_info->crg_scoring, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('V' . $count, $i_info->credit_rating, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('W' . $count, $i_info->phone_nr, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $count++;

    }

                $spreadsheet->getActiveSheet(0)->GetColumnDimension("A")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("B")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("C")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("D")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("E")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("F")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("G")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("H")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("I")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("J")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("K")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("L")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("M")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("N")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("O")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("P")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("Q")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("R")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("S")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("T")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("U")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("V")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("W")->SetAutoSize(true);
    }

//Proprietroship body data end




//Proprietroship link sheet
$spreadsheet->createSheet();
$spreadsheet->setActiveSheetIndex(4);
$spreadsheet->getActiveSheet()->setTitle('Proprietroship Link');


//Proprietroship link header start                  
$spreadsheet->getActiveSheet(0)->SetCellValue("A1", strtoupper('Record_type'));
$spreadsheet->getActiveSheet(0)->SetCellValue("B1", strtoupper('FI_Code'));
$spreadsheet->getActiveSheet(0)->SetCellValue("C1", strtoupper('Branch_code'));
$spreadsheet->getActiveSheet(0)->SetCellValue("D1", strtoupper('FI_subject_code'));
$spreadsheet->getActiveSheet(0)->SetCellValue("E1", strtoupper('Role'));
$spreadsheet->getActiveSheet(0)->SetCellValue("F1", strtoupper('Subject_code_of_company_owner'));
$spreadsheet->getActiveSheet(0)->SetCellValue("G1", strtoupper('acc_month'));
$spreadsheet->getActiveSheet(0)->SetCellValue("H1", strtoupper('data_purity'));
$spreadsheet->getActiveSheet(0)->GetStyle("A1:H1")->getFont()->setBold(true);
//Proprietroship link header ends


// Proprietroship link body data start
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('A2', 'L', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('B2', '045', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('C2', '672', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('D2', '452893277', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('E2', '10', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('F2', '452893277101', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('G2', '06-22', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('H2', '0', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);

        $spreadsheet->getActiveSheet(0)->GetColumnDimension("A")->SetAutoSize(true);
        $spreadsheet->getActiveSheet(0)->GetColumnDimension("B")->SetAutoSize(true);
        $spreadsheet->getActiveSheet(0)->GetColumnDimension("C")->SetAutoSize(true);
        $spreadsheet->getActiveSheet(0)->GetColumnDimension("D")->SetAutoSize(true);
        $spreadsheet->getActiveSheet(0)->GetColumnDimension("E")->SetAutoSize(true);
        $spreadsheet->getActiveSheet(0)->GetColumnDimension("F")->SetAutoSize(true);
        $spreadsheet->getActiveSheet(0)->GetColumnDimension("G")->SetAutoSize(true);
        $spreadsheet->getActiveSheet(0)->GetColumnDimension("H")->SetAutoSize(true);
//Proprietroship link body data end



        
// Headers for download 
// header("Content-Type: application/vnd.ms-excel"); 
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=subject report.xls"); 
header('Cache-Control: max-age=0');
header('Cache-Control: max-age=1');
$write = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
$write->save('php://output');


    }


   
   




   
    public function contractExcelGenerate(Request $request){

        //get value from ui/ux (start)      
        $year_month = $request->fm_month_no;
        $report_br_code = $request->report_br_code;
        //get value from ui/ux (end)


        //installment contract sheet
       $spreadsheet = new Spreadsheet();
       $spreadsheet->createSheet();
       $spreadsheet->setActiveSheetIndex(0);
       $spreadsheet->getActiveSheet()->setTitle("Installment Contract");
       
     
             //installment contract header start     
             $spreadsheet->getActiveSheet(0)->SetCellValue("A1", strtoupper('SL no'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("B1", strtoupper('Borrower CIB Code'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("C1", strtoupper('Contract Code'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("D1", strtoupper('Name of Borrower'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("E1", strtoupper('A/C No'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("F1", strtoupper('Customer ID'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("G1", strtoupper('Loan Account No'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("H1", strtoupper('Branch code'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("I1", strtoupper('Branch Mnemonic'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("J1", strtoupper('Deal Type'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("K1", strtoupper('Deal Reference'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("L1", strtoupper('Nature of Advance'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("M1", strtoupper('Type of Contract'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("N1", strtoupper('CIB Nature Code'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("O1", strtoupper('PPG Code'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("P1", strtoupper('Type of Concern'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("Q1", strtoupper('Sanction Amount/Limit'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("R1", strtoupper('Number of Installment'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("S1", strtoupper('Amount of Monthly Installment'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("T1", strtoupper('Periodicity of Payment'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("U1", strtoupper('Type of Installment'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("V1", strtoupper('Number of Remaining Installment'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("W1", strtoupper('Amount of Remaining Installment'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("X1", strtoupper('Number of Overdue Installment'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("Y1", strtoupper('Overdue Amount'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("Z1", strtoupper('Disbursement During Month'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AA1", strtoupper('Cumulative Disbursement'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AB1", strtoupper('Outstanding'));         
             $spreadsheet->getActiveSheet(0)->SetCellValue("AC1", strtoupper('Recov During Month'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AD1", strtoupper('Cumulative Recovery'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AE1", strtoupper('OVERDUE'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AF1", strtoupper('Economic Purpose Code'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AG1", strtoupper('Security Code'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AH1", strtoupper('CL Status(NF/SD/SM/SS/DF/BL/WO)'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AI1", strtoupper('Basis for Classification'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AJ1", strtoupper('Loan Type(Regular/Rescheduled/Re-structured)'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AK1", strtoupper('Date of Lasr Rescheduling/Re-structuring(dd/mm/yyyy)'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AL1", strtoupper('ESDD Risk(Low/Medium/High)'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AM1", strtoupper('ICRR Score'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AN1", strtoupper('Date of Sanction/Renewal(dd/mm/yy)'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AO1", strtoupper('Date of maturity/expiry(dd/mm/yy)'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AP1", strtoupper('Date of Classificationl(dd/mm/yy)'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AQ1", strtoupper('Date of Law Suit'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AR1", strtoupper('Total Guaranteed'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AS1", strtoupper('Risk Grade'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AT1", strtoupper('Y Score'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AU1", strtoupper('Z Score'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AV1", strtoupper('REMARKS'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AW1", strtoupper('Borrower Address'));

            //  $spreadsheet->getActiveSheet(0)->GetStyle("A1:AW1")->getFont()->setBold(true);

             $spreadsheet->getActiveSheet(0)->SetCellValue("A2", strtoupper('1'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("B2", strtoupper('2'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("C2", strtoupper('3'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("D2", strtoupper('4'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("E2", strtoupper('5'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("F2", strtoupper('6'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("G2", strtoupper('7'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("H2", strtoupper('8'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("I2", strtoupper('9'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("J2", strtoupper('10'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("K2", strtoupper('11'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("L2", strtoupper('12'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("M2", strtoupper('13'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("N2", strtoupper('14'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("O2", strtoupper('15'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("P2", strtoupper('16'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("Q2", strtoupper('17'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("R2", strtoupper('18'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("S2", strtoupper('19'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("T2", strtoupper('20'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("U2", strtoupper('21'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("V2", strtoupper('22'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("W2", strtoupper('23'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("X2", strtoupper('24'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("Y2", strtoupper('25'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("Z2", strtoupper('26'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AA2", strtoupper('27'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AB2", strtoupper('28'));         
             $spreadsheet->getActiveSheet(0)->SetCellValue("AC2", strtoupper('29'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AD2", strtoupper('30'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AE2", strtoupper('31'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AF2", strtoupper('32'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AG2", strtoupper('33'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AH2", strtoupper('34'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AI2", strtoupper('35'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AJ2", strtoupper('36'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AK2", strtoupper('37'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AL2", strtoupper('38'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AM2", strtoupper('39'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AN2", strtoupper('40'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AO2", strtoupper('41'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AP2", strtoupper('42'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AQ2", strtoupper('43'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AR2", strtoupper('44'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AS2", strtoupper('45'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AT2", strtoupper('46'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AU2", strtoupper('47'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AV2", strtoupper('48'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AW2", strtoupper('49'));

            //  $spreadsheet->getActiveSheet(0)->GetStyle("A2:AW2")->getFont()->setBold(true);

             $spreadsheet->getActiveSheet(0)->SetCellValue("A3", strtoupper('SRL'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("B3", strtoupper('BCODE'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("C3", strtoupper('Cont_Code'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("D3", strtoupper('BNAME'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("E3", strtoupper('ACNO'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("F3", strtoupper('C_ID'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("G3", strtoupper('Loan_A/C_No.'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("H3", strtoupper('Br_Code'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("I3", strtoupper('Br_Mnem'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("J3", strtoupper('Deal_Type'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("K3", strtoupper('Deal_Ref'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("L3", strtoupper('NAT'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("M3", strtoupper('TYP_CON'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("N3", strtoupper('NATADV1'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("O3", strtoupper('PPG'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("P3", strtoupper('CONCERN'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("Q3", strtoupper('LIMIT1'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("R3", strtoupper('NO_INSTL'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("S3", strtoupper('AMT_INSTL'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("T3", strtoupper('PERIOD_PAY'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("U3", strtoupper('TYP_INSTL'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("V3", strtoupper('REMN_INSTL'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("W3", strtoupper('REN_AMNT'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("X3", strtoupper('OVER_INST'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("Y3", strtoupper('OVER_AMNT'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("Z3", strtoupper('DISBURS1'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AA3", strtoupper('CUMDISBR'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AB3", strtoupper('OUTSTND1'));         
             $spreadsheet->getActiveSheet(0)->SetCellValue("AC3", strtoupper('RECOVRY1'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AD3", strtoupper('CUMRECOV'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AE3", strtoupper('OVERDUE1'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AF3", strtoupper('ECOPUR1'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AG3", strtoupper('SECURTY1'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AH3", strtoupper('CLASSIFY1'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AI3", strtoupper('Q_Judgement'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AJ3", strtoupper('RSLDNO1'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AK3", strtoupper('LRDATE'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AL3", strtoupper('ESDD Risk'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AM3", strtoupper('ICRR Score'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AN3", strtoupper('SANCDAT1'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AO3", strtoupper('EXPDAT1'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AP3", strtoupper('CLASSDAT1'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AQ3", strtoupper('LAWDAT1'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AR3", strtoupper('GUARANT1'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AS3", strtoupper('GRADE'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AT3", strtoupper('YSCORE'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AU3", strtoupper('ZSCORE'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AV3", strtoupper('REMARKS'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AW3", strtoupper('BADDR'));

            //  $spreadsheet->getActiveSheet(0)->GetStyle("A3:AW3")->getFont()->setBold(true);

 //installment contract header ends



  // installment body data start

if($report_br_code == 'all'){


    $installment_contract = DB::connection('cib')
    ->table('cib_installments_contracts')
    ->leftJoin('cbr_db.branches as cbr_db_branch_tbl', 'cib_installments_contracts.report_branch_code', '=', 'cbr_db_branch_tbl.branch_code')
    ->select('cib_installments_contracts.*','cbr_db_branch_tbl.branch_name as br_name')
    ->where('month_no',$year_month)
    ->get();


    $count = 4;
    $sn = 1;
    foreach($installment_contract as $ins_contract){

            
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('A' . $count, $sn++, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('B' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('C' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('D' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('E' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('F' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('G' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('H' . $count, $ins_contract->report_branch_code, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('I' . $count, $ins_contract->branch_mnemonic, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('J' . $count, $ins_contract->deal_type, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('K' . $count, $ins_contract->deal_reference, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('L' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('M' . $count, $ins_contract->contract_type, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('N' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('O' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('P' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('Q' . $count, $ins_contract->sanction_limit, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('R' . $count, $ins_contract->total_number_of_installments, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('S' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('T' . $count, $ins_contract->periodicity_of_payment, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('U' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('V' . $count, $ins_contract->number_of_remaining_installments, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('W' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('X' . $count, $ins_contract->number_of_overdue_installment, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('Y' . $count, $ins_contract->overdue_amount, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('Z' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AA' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AB' . $count, $ins_contract->total_outstanding_amount, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AC' . $count, $ins_contract->recovery_during_the_reporting_period, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AD' . $count, $ins_contract->cumulative_recovery, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AE' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AF' . $count, $ins_contract->economic_purpose_code, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AG' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AH' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AI' . $count, $ins_contract->basis_for_classification_qualitative_judgment, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AJ' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AK' . $count, $ins_contract->date_of_last_rescheduling, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AL' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AM' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AN' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AO' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AP' . $count, $ins_contract->date_of_classification, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AQ' . $count, $ins_contract->date_of_law_suit, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AR' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AS' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AT' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AU' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AV' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AW' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);       
        $count++;

    }
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("A")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("B")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("C")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("D")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("E")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("F")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("G")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("H")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("I")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("J")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("K")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("L")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("M")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("N")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("O")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("P")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("Q")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("R")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("S")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("T")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("U")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("V")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("W")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("X")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("Y")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("Z")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("AA")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("AB")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("AC")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("AD")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("AE")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("AF")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("AG")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("AH")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("AI")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("AJ")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("AK")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("AL")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("AM")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("AN")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("AO")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("AP")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("AQ")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("AR")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("AS")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("AT")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("AU")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("AV")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("AW")->SetAutoSize(true);
    

    }else{

           $installment_contract = DB::connection('cib')
            ->table('cib_installments_contracts')
            ->select('*')
            ->where('report_branch_code',$report_br_code)
            ->where('month_no',$year_month)
            ->get(); 

        
    $sn = 1;
    $count = 4;
    foreach($installment_contract as $ins_contract){

                   
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('A' . $count, $sn++, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('B' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('C' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('D' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('E' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('F' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('G' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('H' . $count, $ins_contract->report_branch_code, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('I' . $count, $ins_contract->branch_mnemonic, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('J' . $count, $ins_contract->deal_type, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('K' . $count, $ins_contract->deal_reference, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('L' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('M' . $count, $ins_contract->contract_type, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('N' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('O' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('P' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('Q' . $count, $ins_contract->sanction_limit, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('R' . $count, $ins_contract->total_number_of_installments, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('S' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('T' . $count, $ins_contract->periodicity_of_payment, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('U' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('V' . $count, $ins_contract->number_of_remaining_installments, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('W' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('X' . $count, $ins_contract->number_of_overdue_installment, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('Y' . $count, $ins_contract->overdue_amount, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('Z' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AA' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AB' . $count, $ins_contract->total_outstanding_amount, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AC' . $count, $ins_contract->recovery_during_the_reporting_period, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AD' . $count, $ins_contract->cumulative_recovery, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AE' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AF' . $count, $ins_contract->economic_purpose_code, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AG' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AH' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AI' . $count, $ins_contract->basis_for_classification_qualitative_judgment, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AJ' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AK' . $count, $ins_contract->date_of_last_rescheduling, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AL' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AM' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AN' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AO' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AP' . $count, $ins_contract->date_of_classification, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AQ' . $count, $ins_contract->date_of_law_suit, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AR' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AS' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AT' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AU' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AV' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AW' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);       
        $count++;

    }


    $spreadsheet->getActiveSheet(0)->GetColumnDimension("A")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("B")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("C")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("D")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("E")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("F")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("G")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("H")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("I")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("J")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("K")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("L")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("M")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("N")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("O")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("P")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("Q")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("R")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("S")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("T")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("U")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("V")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("W")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("X")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("Y")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("Z")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("AA")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("AB")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("AC")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("AD")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("AE")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("AF")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("AG")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("AH")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("AI")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("AJ")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("AK")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("AL")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("AM")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("AN")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("AO")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("AP")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("AQ")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("AR")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("AS")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("AT")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("AU")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("AV")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("AW")->SetAutoSize(true);
    }

//installment body data end




       //non installment contract sheet
       $spreadsheet->createSheet();
       $spreadsheet->setActiveSheetIndex(1);
       $spreadsheet->getActiveSheet()->setTitle('Non Installment Contract');
       
          
             //non installment contract header start     
             $spreadsheet->getActiveSheet(0)->SetCellValue("A1", strtoupper('SL no'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("B1", strtoupper('Borrower CIB Code'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("C1", strtoupper('Contract Code'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("D1", strtoupper('Name of Borrower'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("E1", strtoupper('A/C No'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("F1", strtoupper('Customer ID'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("G1", strtoupper('Loan Account No'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("H1", strtoupper('Branch code'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("I1", strtoupper('Branch Mnemonic'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("J1", strtoupper('Deal Type'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("K1", strtoupper('Deal Reference'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("L1", strtoupper('Nature of Advance'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("M1", strtoupper('Type of Contract'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("N1", strtoupper('CIB Nature Code'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("O1", strtoupper('PPG Code'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("P1", strtoupper('Type of Concern'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("Q1", strtoupper('Sanction Amount/Limit'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("R1", strtoupper('Number of Installment'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("S1", strtoupper('Amount of Monthly Installment'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("T1", strtoupper('Periodicity of Payment'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("U1", strtoupper('Type of Installment'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("V1", strtoupper('Number of Remaining Installment'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("W1", strtoupper('Amount of Remaining Installment'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("X1", strtoupper('Number of Overdue Installment'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("Y1", strtoupper('Overdue Amount'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("Z1", strtoupper('Disbursement During Month'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AA1", strtoupper('Cumulative Disbursement'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AB1", strtoupper('Outstanding'));         
             $spreadsheet->getActiveSheet(0)->SetCellValue("AC1", strtoupper('Recov During Month'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AD1", strtoupper('Cumulative Recovery'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AE1", strtoupper('OVERDUE'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AF1", strtoupper('Economic Purpose Code'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AG1", strtoupper('Security Code'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AH1", strtoupper('CL Status(NF/SD/SM/SS/DF/BL/WO)'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AI1", strtoupper('Basis for Classification'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AJ1", strtoupper('Loan Type(Regular/Rescheduled/Re-structured)'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AK1", strtoupper('Date of Lasr Rescheduling/Re-structuring(dd/mm/yyyy)'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AL1", strtoupper('ESDD Risk(Low/Medium/High)'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AM1", strtoupper('ICRR Score'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AN1", strtoupper('Date of Sanction/Renewal(dd/mm/yy)'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AO1", strtoupper('Date of maturity/expiry(dd/mm/yy)'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AP1", strtoupper('Date of Classificationl(dd/mm/yy)'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AQ1", strtoupper('Date of Law Suit'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AR1", strtoupper('Total Guaranteed'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AS1", strtoupper('Risk Grade'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AT1", strtoupper('Y Score'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AU1", strtoupper('Z Score'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AV1", strtoupper('REMARKS'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AW1", strtoupper('Borrower Address'));

            //  $spreadsheet->getActiveSheet(0)->GetStyle("A1:AW1")->getFont()->setBold(true);

             $spreadsheet->getActiveSheet(0)->SetCellValue("A2", strtoupper('1'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("B2", strtoupper('2'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("C2", strtoupper('3'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("D2", strtoupper('4'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("E2", strtoupper('5'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("F2", strtoupper('6'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("G2", strtoupper('7'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("H2", strtoupper('8'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("I2", strtoupper('9'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("J2", strtoupper('10'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("K2", strtoupper('11'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("L2", strtoupper('12'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("M2", strtoupper('13'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("N2", strtoupper('14'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("O2", strtoupper('15'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("P2", strtoupper('16'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("Q2", strtoupper('17'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("R2", strtoupper('18'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("S2", strtoupper('19'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("T2", strtoupper('20'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("U2", strtoupper('21'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("V2", strtoupper('22'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("W2", strtoupper('23'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("X2", strtoupper('24'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("Y2", strtoupper('25'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("Z2", strtoupper('26'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AA2", strtoupper('27'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AB2", strtoupper('28'));         
             $spreadsheet->getActiveSheet(0)->SetCellValue("AC2", strtoupper('29'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AD2", strtoupper('30'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AE2", strtoupper('31'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AF2", strtoupper('32'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AG2", strtoupper('33'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AH2", strtoupper('34'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AI2", strtoupper('35'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AJ2", strtoupper('36'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AK2", strtoupper('37'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AL2", strtoupper('38'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AM2", strtoupper('39'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AN2", strtoupper('40'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AO2", strtoupper('41'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AP2", strtoupper('42'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AQ2", strtoupper('43'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AR2", strtoupper('44'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AS2", strtoupper('45'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AT2", strtoupper('46'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AU2", strtoupper('47'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AV2", strtoupper('48'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AW2", strtoupper('49'));

            //  $spreadsheet->getActiveSheet(0)->GetStyle("A2:AW2")->getFont()->setBold(true);

             $spreadsheet->getActiveSheet(0)->SetCellValue("A3", strtoupper('SRL'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("B3", strtoupper('BCODE'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("C3", strtoupper('Cont_Code'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("D3", strtoupper('BNAME'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("E3", strtoupper('ACNO'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("F3", strtoupper('C_ID'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("G3", strtoupper('Loan_A/C_No.'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("H3", strtoupper('Br_Code'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("I3", strtoupper('Br_Mnem'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("J3", strtoupper('Deal_Type'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("K3", strtoupper('Deal_Ref'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("L3", strtoupper('NAT'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("M3", strtoupper('TYP_CON'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("N3", strtoupper('NATADV1'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("O3", strtoupper('PPG'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("P3", strtoupper('CONCERN'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("Q3", strtoupper('LIMIT1'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("R3", strtoupper('NO_INSTL'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("S3", strtoupper('AMT_INSTL'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("T3", strtoupper('PERIOD_PAY'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("U3", strtoupper('TYP_INSTL'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("V3", strtoupper('REMN_INSTL'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("W3", strtoupper('REN_AMNT'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("X3", strtoupper('OVER_INST'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("Y3", strtoupper('OVER_AMNT'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("Z3", strtoupper('DISBURS1'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AA3", strtoupper('CUMDISBR'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AB3", strtoupper('OUTSTND1'));         
             $spreadsheet->getActiveSheet(0)->SetCellValue("AC3", strtoupper('RECOVRY1'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AD3", strtoupper('CUMRECOV'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AE3", strtoupper('OVERDUE1'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AF3", strtoupper('ECOPUR1'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AG3", strtoupper('SECURTY1'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AH3", strtoupper('CLASSIFY1'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AI3", strtoupper('Q_Judgement'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AJ3", strtoupper('RSLDNO1'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AK3", strtoupper('LRDATE'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AL3", strtoupper('ESDD Risk'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AM3", strtoupper('ICRR Score'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AN3", strtoupper('SANCDAT1'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AO3", strtoupper('EXPDAT1'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AP3", strtoupper('CLASSDAT1'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AQ3", strtoupper('LAWDAT1'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AR3", strtoupper('GUARANT1'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AS3", strtoupper('GRADE'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AT3", strtoupper('YSCORE'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AU3", strtoupper('ZSCORE'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AV3", strtoupper('REMARKS'));
             $spreadsheet->getActiveSheet(0)->SetCellValue("AW3", strtoupper('BADDR'));

            //  $spreadsheet->getActiveSheet(0)->GetStyle("A3:AW3")->getFont()->setBold(true);
            
 //non installment contract header ends












  //non installment body data start

  if($report_br_code == 'all'){


    $non_installment_contract = DB::connection('cib')
    ->table('cib_noninstall_contracts')
    ->leftJoin('cbr_db.branches as cbr_db_branch_tbl', 'cib_noninstall_contracts.report_branch_code', '=', 'cbr_db_branch_tbl.branch_code')
    ->select('cib_noninstall_contracts.*','cbr_db_branch_tbl.branch_name as br_name')
    ->where('month_no',$year_month)
    ->get();


    $count = 4;
    $sn = 1;
    foreach($non_installment_contract as $non_ins_contract){

            
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('A' . $count, $sn++, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('B' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('C' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('D' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('E' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('F' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('G' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('H' . $count, $non_ins_contract->report_branch_code, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('I' . $count, $non_ins_contract->branch_mnemonic, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('J' . $count, $non_ins_contract->deal_type, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('K' . $count, $non_ins_contract->deal_reference, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('L' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('M' . $count, $non_ins_contract->contract_type, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('N' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('O' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('P' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('Q' . $count, $non_ins_contract->sanction_limit, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('R' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('S' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('T' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('U' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('V' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('W' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('X' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('Y' . $count, $non_ins_contract->overdue_amount, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('Z' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AA' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AB' . $count, $non_ins_contract->total_outstanding_amount, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AC' . $count, $non_ins_contract->recovery_during_the_reporting_period, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AD' . $count, $non_ins_contract->cumulative_recovery, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AE' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AF' . $count, $non_ins_contract->economic_purpose_code, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AG' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AH' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AI' . $count, $non_ins_contract->basis_for_classification_qualitative_judgment, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AJ' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AK' . $count, $non_ins_contract->date_of_last_rescheduling, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AL' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AM' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AN' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AO' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AP' . $count, $non_ins_contract->date_of_classification, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AQ' . $count, $non_ins_contract->date_of_law_suit, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AR' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AS' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AT' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AU' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AV' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AW' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);       
        $count++;

    }
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("A")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("B")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("C")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("D")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("E")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("F")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("G")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("H")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("I")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("J")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("K")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("L")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("M")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("N")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("O")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("P")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("Q")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("R")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("S")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("T")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("U")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("V")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("W")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("X")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("Y")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("Z")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("AA")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("AB")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("AC")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("AD")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("AE")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("AF")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("AG")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("AH")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("AI")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("AJ")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("AK")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("AL")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("AM")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("AN")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("AO")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("AP")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("AQ")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("AR")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("AS")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("AT")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("AU")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("AV")->SetAutoSize(true);
                $spreadsheet->getActiveSheet(0)->GetColumnDimension("AW")->SetAutoSize(true);
    

    }else{

           $non_installment_contract = DB::connection('cib')
            ->table('cib_noninstall_contracts')
            ->select('*')
            ->where('report_branch_code',$report_br_code)
            ->where('month_no',$year_month)
            ->get(); 

      
    $sn = 1;
    $count = 4;
    foreach($non_installment_contract as $non_ins_contract){

                   
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('A' . $count, $sn++, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('B' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('C' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('D' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('E' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('F' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('G' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('H' . $count, $non_ins_contract->report_branch_code, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('I' . $count, $non_ins_contract->branch_mnemonic, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('J' . $count, $non_ins_contract->deal_type, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('K' . $count, $non_ins_contract->deal_reference, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('L' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('M' . $count, $non_ins_contract->contract_type, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('N' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('O' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('P' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('Q' . $count, $non_ins_contract->sanction_limit, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('R' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('S' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('T' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('U' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('V' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('W' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('X' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('Y' . $count, $non_ins_contract->overdue_amount, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('Z' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AA' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AB' . $count, $non_ins_contract->total_outstanding_amount, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AC' . $count, $non_ins_contract->recovery_during_the_reporting_period, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AD' . $count, $non_ins_contract->cumulative_recovery, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AE' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AF' . $count, $non_ins_contract->economic_purpose_code, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AG' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AH' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AI' . $count, $non_ins_contract->basis_for_classification_qualitative_judgment, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AJ' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AK' . $count, $non_ins_contract->date_of_last_rescheduling, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AL' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AM' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AN' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AO' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AP' . $count, $non_ins_contract->date_of_classification, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AQ' . $count, $non_ins_contract->date_of_law_suit, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AR' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AS' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AT' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AU' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AV' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $spreadsheet->getActiveSheet(0)->setCellValueExplicit('AW' . $count, ' ', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);       
        $count++;
    }

    $spreadsheet->getActiveSheet(0)->GetColumnDimension("A")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("B")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("C")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("D")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("E")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("F")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("G")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("H")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("I")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("J")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("K")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("L")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("M")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("N")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("O")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("P")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("Q")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("R")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("S")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("T")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("U")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("V")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("W")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("X")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("Y")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("Z")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("AA")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("AB")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("AC")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("AD")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("AE")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("AF")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("AG")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("AH")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("AI")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("AJ")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("AK")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("AL")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("AM")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("AN")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("AO")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("AP")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("AQ")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("AR")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("AS")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("AT")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("AU")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("AV")->SetAutoSize(true);
    $spreadsheet->getActiveSheet(0)->GetColumnDimension("AW")->SetAutoSize(true);
    }

//non installment body data end




// Headers for download 

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=contract report.xls"); 
header('Cache-Control: max-age=0');
header('Cache-Control: max-age=1');
$write = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
$write->save('php://output');
 

    }
   
   
   
   
   
   
   
   
   
   
    public function create()
    {
       //echo $this->GetContractNumber('I63991', '0008', 1);die;
        return view('cib.pages.text-generate.create');
    } // end -:- create()

  
}// end -:- CibDataPushController
