<?php

namespace App\Http\Controllers\Cib\Text;

use Illuminate\Http\Request;;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Html\Editor\Fields\Select;

ini_set('max_execution_time', 0);
ini_set('memory_limit', '-1');
date_default_timezone_set('asia/dhaka');

class CibBBTextController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function db_textfile_index()
    {
        $reporting_branches = DB::connection('mysql')
        ->table('branches')
        ->select('*')
        ->get();
        return view('cib.pages.text-generate.bb_text_generate_index',compact('reporting_branches'));
    }

    public function db_textfile_store(Request $request)
    {
        $year_month = $request->cib_date;

        return view('cib.pages.text-generate.bb_text_generate_file',compact('year_month'));
    //    return redirect()->route('cib.db.file.generate.index',compact('year_month'))->with('message','Successfully text generated !!');
    }

}
