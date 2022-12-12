@extends('cib.layouts.master')
@section('title', 'Text Generate In System')
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
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div id="loader" class="col-sm-12 page_loader">
                <img src="{{ asset('public/cib/asset/loading.gif') }}">
            </div>
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h4>CIB Text Generate In System For BB Format</h4>
                    </div>
                    <div class="ibox-content">
                        @include('sbs2.partials.messages')
                        <span class="form-message"></span>
                        <form class="form-horizontal" name="info" action="{{ route('cib.db.file.generate.store') }}"
                            method="POST">
                            @csrf
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <label class="col-md-12"><strong>Month Wise</strong></label>
                                                <div class="col-md-12">
                                                    <div class="form-group datepicker-QY">
                                                        <div class="input-group date">
                                                            <span class="input-group-addon"><i
                                                                    class="fa fa-calendar"></i></span>
                                                            <input type="text" class="form-control" name="cib_date"
                                                                value='{{ date('Y-m', strtotime('-1 month')) }}' />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tile-footer">
                                <div class="row">
                                    <div class="col-md-8 col-md-offset-3">
                                        <button class="btn btn-primary btn-sm" type="submit">Generate</button>
                                    </div>
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
