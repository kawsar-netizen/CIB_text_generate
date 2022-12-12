@extends('cib.layouts.master')
@section('title')
    CIB Data Push In System
@endsection
@section('css')
    <!-- start -:- Datepicker3 CSS -->
    <link href="{{ asset('public/assets/css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
    <!-- end -:- Datepicker3 CSS -->

    <!-- start -:- Date Range Picker CSS -->
    <link href="{{ asset('public/assets/css/plugins/daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet">
    <!-- end -:- Date Range Picker CSS -->

    <!-- start -:- Select2 CSS -->
    <link href="{{ asset('public/assets/css/plugins/select2/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/assets/css/plugins/select2/select2-bootstrap4.min.css') }}" rel="stylesheet">
    <!-- end -:- Select2 CSS -->
@endsection

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2 class="text-uppercase">Contract excel</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="#">CIB</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>Contract Excel</strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div id="loader" class="col-sm-12" style="display: none;">
                <img src="{{ asset('public/asset/loading.gif') }}">
            </div>
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                    </div>
                    <div class="ibox-content">
                        <span class="form-message"></span>
                        <form autocomplete="off" action="{{ route('contract_excel') }}" method="post" class="pull-form">
                            @csrf
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label><strong> Branches </strong></label>
                                            <select class="form-control select2 fm_branch_code" name="report_br_code">
                                                <option value="">-- select branch --</option>
                                                <option value="all">ALL</option>
                                                @foreach ($reporting_branches as $report_branch)
                                                    <option value="{{ $report_branch->report_branch_code }}">
                                                        {{ $report_branch->branch_name }}
                                                        ({{ $report_branch->report_branch_code }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <label class="col-md-12"><strong>Month Wise</strong></label>
                                                <div class="col-md-12">
                                                    <div class="form-group datepicker-QY">
                                                        <div class="input-group date">
                                                            <span class="input-group-addon"><i
                                                                    class="fa fa-calendar"></i></span>
                                                            <input type="text" class="form-control" name="fm_month_no"
                                                                value='{{ date('Y-m', strtotime('-1 month')) }}' />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group row">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <button class="btn btn-white btn-sm mr-2" type="reset">Cancel</button>
                                    <button class="btn btn-primary btn-sm" type="submit">Generate</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <!-- start -:- Datepicker JS -->
    <script src="{{ asset('public/assets/js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
    <!-- end -:- Datepicker JS -->

    <!-- Date Range Use moment.js Same As Full Calendar Plugin -->
    <script src="{{ asset('public/assets/js/plugins/fullcalendar/moment.min.js') }}"></script>

    <!-- start -:- Date Range Picker JS -->
    <script src="{{ asset('public/assets/js/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- end -:- Date Range Picker JS -->

    <!-- start -:- Select2 JS -->
    <script src="{{ asset('public/assets/js/plugins/select2/select2.full.min.js') }}"></script>
    <!-- end -:- Select2 JS -->

    <script type="text/javascript">
        $(document).ready(function() {
            // start -:- Monthly Datepicker
            $(".datepicker-QY .input-group.date").datepicker({
                format: "yyyy-mm",
                startView: "months",
                minViewMode: "months",
                autoclose: true,
            });
            // end -:- Monthly Datepicker

        }); // end -:- Document Ready Section.
    </script>
@endsection
