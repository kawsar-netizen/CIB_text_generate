<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*----------------------------------- Upload cib file -----------------------------------------------*/
Route::group(['prefix'=>'file/system/', 'namespace'=> 'Cib\FileSystem', 'as'=>'file.system.'], function(){

    Route::get('card/index', 'SystemController@index')->name('card.index');
    Route::post('card/index', 'SystemController@check_card_imported_data')->name('card.check_card_imported_data');
    Route::post('card/save_contract', 'SystemController@save_contract')->name('card.save_contract');

    /* --------------------------close card upload web -----------------------------------*/
    Route::get('card/close/index', 'SystemCloseCardController@index')->name('card.close.index');
    Route::post('card/close/index', 'SystemCloseCardController@save_card_close')->name('card.close.save_card_close');
});


/*----------------------------------- Upload cib file -----------------------------------------------*/

/*----------------------------------- Process cib -----------------------------------------------*/
Route::group(['prefix'=>'process/', 'namespace'=> 'Cib\Process', 'as'=>'process.'], function(){

    Route::get('card/index', 'CardProcessController@index')->name('card.index');
    Route::post('card/index', 'CardProcessController@cib_data_check')->name('card.cib_data_check');
    Route::post('card/generate_cib_data', 'CardProcessController@generate_cib_data')->name('card.generate_cib_data');

     /* --------------------------close card process web -----------------------------------*/
     Route::get('card/close', 'Card\CloseCardController@index')->name('card.close');
     Route::post('card/close', 'Card\CloseCardController@process_close_card')->name('card.close.process_close_card');
});

/* ---------------------------downlod web route------------------------------------------ */
Route::group(['prefix'=>'process/download', 'namespace'=> 'Cib\Process', 'as'=>'process.'], function(){
    Route::get('card/index', 'CardCibDownloadController@index')->name('card.cib.download');     
});

Route::get("download_card_cib/{date}", 'Cib\Process\CardCibDownloadController@download_cib_data');
Route::get("download_cib_data_with_error/{date}", 'Cib\Process\cardCibDownloadControllerWithError@download_cib_data');

Route::get("card/cib/download/{subject}/{contract}/{date}", 'Cib\Process\CardCibDownloadController@ZipfileDownload')->name('card.download');
/* ---------------------------downlod web route------------------------------------------ */


/* ---------------------------downlod web route------------------------------------------ */
Route::group(['prefix'=>'process/download', 'namespace'=> 'Cib\Process', 'as'=>'process.'], function(){
    Route::get('index', 'CibDownloadController@index')->name('cib.download');     
});

Route::get("download_cib/{date}", 'Cib\Process\CibDownloadController@download_cib_data');
Route::get("download_cib_with_error/{date}/{flag}", 'Cib\Process\CibDownloadControllerWithError@download_cib_data');

Route::get("cib/download/{subject}/{contract}/{date}", 'Cib\Process\CibDownloadControllerWithError@ZipfileDownload')->name('cib.download');
/* ---------------------------downlod web route------------------------------------------ */

// Coding by Sizar start

 //last working route start

Route::get('cib/db/text/file/download/index', 'Cib\Text\CibBBTextController@db_textfile_index')->name('cib.db.file.generate.index');
Route::post('cib/db/text/file/download/store','Cib\Text\CibBBTextController@db_textfile_store')->name('cib.db.file.generate.store');

 //last working route start

// Start -:- CibDataTextController
Route::get('cib/text/data/download/index', 'Cib\Text\CibDataTextController@index')->name('cib.text.data.download.index');
Route::post('cib/text/data/generate/subject/index/text_generate','Cib\Text\CibDataTextController@subjectTextGenerate')->name('subject_text');

Route::get('cib/text/data/download/contract', 'Cib\Text\CibDataTextController@indexContract')->name('cib.text.data.download.contract');
Route::post('cib/text/data/generate/contract/index/text_generate','Cib\Text\CibDataTextController@contractTextGenerate')->name('contract_text');

// subject
Route::get('cib/text/data/generate/subject/index_subject','Cib\Text\CibDataExcelController@index_subject')->name('cib.text.data.generate.index_subject');
Route::post('cib/text/data/generate/subject/index/excel','Cib\Text\CibDataExcelController@subjectExcelGenerate')->name('subject_excel');

// contract
Route::get('cib/text/data/generate/contract/index_contract','Cib\Text\CibDataExcelController@index_contract')->name('cib.text.data.generate.index_contract');
Route::post('cib/text/data/generate/contract/index/excel','Cib\Text\CibDataExcelController@contractExcelGenerate')->name('contract_excel');

// Coding by Sizar end

## Generate dummy excel download
Route::get('/report/generate-subject-excel-report', 'Cib\Text\CibDataTextController@downloadSubjectExcel')->name('cbi.text.download.subject.excel');
Route::get('/report/generate-contract-excel-report', 'Cib\Text\CibDataTextController@downloadContractExcel')->name('cbi.text.download.contractt.excel');

/*----------------------------------- Process cib -----------------------------------------------*/

/*----------------------------------- error cib for card -----------------------------------------------*/
Route::group(['prefix'=>'error/', 'namespace'=> 'Cib\Error\Card', 'as'=>'error.'], function(){

    Route::get('card/index', 'SubjectErrorController@index')->name('card.index');
    Route::get('card/{id}', 'SubjectErrorController@errorDetails')->name('card.errorDetails');
    Route::post('subject_edit_save', 'SubjectErrorController@subject_edit_save')->name('card.subject_edit_save');
    Route::post('stop_reporting', 'SubjectErrorController@stop_reporting')->name('card.stop_reporting');
   
});


/*------------------------------------------------------------------- Subject personal error -----------------------------------*/
Route::group(['prefix'=>'error/personal/', 'namespace'=> 'Cib\Error', 'as'=>'error.personal.'], function(){

    Route::get('index', 'SubjectPersonalErrorController@index')->name('index');
    Route::get('{id}', 'SubjectPersonalErrorController@errorDetails')->name('errorDetails');
    Route::post('subject_edit_save', 'SubjectPersonalErrorController@subject_edit_save')->name('subject_edit_save');
    Route::post('stop_reporting', 'SubjectPersonalErrorController@stop_reporting')->name('stop_reporting');
   
});
/*------------------------------------------------------------------- Subject personal error -----------------------------------*/


/*------------------------------------------------------------------- Subject Company error -----------------------------------*/
Route::group(['prefix'=>'error/company/', 'namespace'=> 'Cib\Error', 'as'=>'error.company.'], function(){

    Route::get('index', 'SubjectCompanyErrorController@index')->name('index');
    Route::get('{id}', 'SubjectCompanyErrorController@errorDetails')->name('errorDetails');
    Route::post('subject_edit_save', 'SubjectCompanyErrorController@subject_edit_save')->name('subject_edit_save');
    Route::post('stop_reporting', 'SubjectCompanyErrorController@stop_reporting')->name('stop_reporting');
   
});
/*------------------------------------------------------------------- Subject Company error -----------------------------------*/

/*------------------------------------------------------------------- Subject Company error -----------------------------------*/
Route::group(['prefix'=>'error/individual/', 'namespace'=> 'Cib\Error', 'as'=>'error.individual.'], function(){

    Route::get('index', 'SubjectIndividualErrorController@index')->name('index');
    Route::get('{id}', 'SubjectIndividualErrorController@errorDetails')->name('errorDetails');
    Route::post('subject_edit_save', 'SubjectIndividualErrorController@subject_edit_save')->name('subject_edit_save');
    Route::post('stop_reporting', 'SubjectIndividualErrorController@stop_reporting')->name('stop_reporting');
   
});
/*------------------------------------------------------------------- Subject Company error -----------------------------------*/



Route::group(['prefix'=>'error/', 'namespace'=> 'Cib\Error\Card', 'as'=>'error.card.'], function(){

    Route::get('card/contract/index', 'ContractErrorController@index')->name('contract.index');
    Route::get('card/contract/{id}', 'ContractErrorController@errorDetails')->name('contract.errorDetails');
    Route::post('contract/contract_edit_save', 'ContractErrorController@contracts_edit_save')->name('contract.contract_edit_save');
    Route::post('contract/stop_reporting', 'ContractErrorController@stop_reporting')->name('contract.stop_reporting');
   
});

/*----------------------------------- error cib for card -----------------------------------------------*/


/*--------------------------------------------------- error for noinstallment  -------------------------*/
Route::group(['prefix'=>'error/', 'namespace'=> 'Cib\Error', 'as'=>'error.contact.noninstallment.'], function(){
    Route::get('noninstallment', 'NoninstallmentContacttController@index')->name('index');
    Route::get('noninstallment/{id}', 'NoninstallmentContacttController@errorDetails')->name('errorDetails');
    Route::post('noninstallment', 'NoninstallmentContacttController@contracts_edit_save')->name('contract_edit_save');
    Route::post('noninstallment/stop_reporting', 'NoninstallmentContacttController@stop_reporting')->name('stop_reporting');
    
});
/*--------------------------------------------------- error for noinstallment  -------------------------*/

/*--------------------------------------------------- error for installment  -------------------------*/
Route::group(['prefix'=>'error/', 'namespace'=> 'Cib\Error', 'as'=>'error.contact.installment.'], function(){
    Route::get('installment', 'InstallmentContactController@index')->name('index');
    Route::get('installment/{id}', 'InstallmentContactController@errorDetails')->name('errorDetails');
    Route::post('installment', 'InstallmentContactController@contracts_edit_save')->name('contract_edit_save');
    Route::post('installment/stop_reporting', 'InstallmentContactController@stop_reporting')->name('stop_reporting');
    
});
/*--------------------------------------------------- error for installment  -------------------------*/

/*----------------------------------- cib archive route  -----------------------------------------------*/
Route::group(['prefix'=>'archive/card/', 'namespace'=>'Cib\Archive\Card', 'as'=> 'archive.card.'], function(){
    Route::get('subject-info', 'SubjectArchiveController@index')->name('subject');
    Route::post('subject-info', 'SubjectArchiveController@fetch_subject_data')->name('fetch_subject_data');
    Route::post('check_archive_subject_data', 'SubjectArchiveController@check_archive_subject_data')->name('check_archive_subject_data');
    Route::post('archive_subject_data', 'SubjectArchiveController@archive_subject_data')->name('archive_subject_data');
});

Route::group(['prefix'=>'archive/card/', 'namespace'=>'Cib\Archive\Card', 'as'=> 'archive.card.'], function(){
    Route::get('contract-info', 'ContractArchiveController@index')->name('contract');
    Route::post('contract-info', 'ContractArchiveController@fetch_contracts_data')->name('fetch_contracts_data');
    Route::post('check_archive_contract_data', 'ContractArchiveController@check_archive_contract_data')->name('check_archive_contract_data');
    Route::post('archive_contract_data', 'ContractArchiveController@archive_contract_data')->name('archive_contract_data');
});




/* -----------------------------subject company ------------------------------------------------*/
Route::group(['prefix'=>'archive/comapny', 'namespace'=>'Cib\Archive', 'as'=> 'archive.subject.'], function(){
    Route::get('subject', 'SubjectArchiveController@index')->name('company');
    Route::post('subject-info', 'SubjectArchiveController@fetch_subject_data')->name('fetch_subject_data');
    Route::post('check_archive_subject_data', 'SubjectArchiveController@check_archive_subject_data')->name('check_archive_subject_data');
    Route::post('archive_subject_data', 'SubjectArchiveController@archive_subject_data')->name('archive_subject_data');
});
/* -----------------------------subject company ------------------------------------------------*/

/* ------------------------------------Report Route------------------------------------------------- */
/* ----------------------monthly report------------------------------- */

Route::group(['prefix'=> 'report/card/', 'namespace'=> 'Cib\Report\Card\subject\monthly', 'as'=>'report.card.'], function(){
    Route::get('monthly-subject', 'SubjectReportController@index')->name('monthly_subject');
    Route::post('monthly-subject', 'SubjectReportController@monthly_subject_info')->name('monthly_subject_info');
});

Route::group(['prefix'=> 'report/card/', 'namespace'=> 'Cib\Report\Card\subject\monthly', 'as'=>'report.card.'], function(){
    Route::get('monthly-contract', 'ContractReportController@index')->name('monthly_contract');
    Route::post('monthly-contract', 'ContractReportController@monthly_contract_info')->name('monthly_contract_info');
});

/* ----------------------end monthly report------------------------------- */

/* ----------------------summary report------------------------------- */
Route::group(['prefix'=> 'report/card/summary', 'namespace'=> 'Cib\Report\Card\Summary', 'as'=>'report.card.'], function(){
    Route::get('index', 'SummaryReportController@index')->name('summary');
    Route::get('summary_info', 'SummaryReportController@summary_info')->name('summary_info');
    Route::get('summary_excel/{status}/{date}/{branch_code}', 'SummaryReportController@summaryExcel')->name('summary_excel');
});
/* ----------------------end summary report------------------------------- */


/* -------------------------monthly Close card report route ----------------------------------------*/
Route::group(['prefix'=> 'report/card/', 'namespace'=> 'Cib\Report\Card\close', 'as'=>'report.card.'], function(){
    Route::get('monthly-close', 'CloseCardReportController@index')->name('monthly_close_card');
    Route::post('monthly-close', 'CloseCardReportController@monthly_subject_info')->name('monthly_close_card_info');
});
/* -------------------------monthly Close card report route ----------------------------------------*/



/* ------------------------------------Error free subject Controller--------------------------------  */
Route::group(['prefix'=> 'report/card/subject', 'namespace'=> 'Cib\Report\Card\ErrorFreeSubject', 'as'=>'report.card.'], function(){
    Route::get('error-free', 'SubjectErrorFreeReportController@index')->name('contract_error_free');
    Route::post('error-free', 'SubjectErrorFreeReportController@subject_error_free')->name('subject_error_free');
});

/* ------------------------------------Error free subject Controller--------------------------------  */


/* ------------------------------------Error free subject Controller--------------------------------  */
Route::group(['prefix'=> 'report/card/contract', 'namespace'=> 'Cib\Report\Card\ErrorFreeContract', 'as'=>'report.card.'], function(){
    Route::get('error-free', 'ContractErrorFreeReportController@index')->name('contract_error_free');
    Route::post('error-free', 'ContractErrorFreeReportController@subject_error_free')->name('contract_error_free');
});

/* ------------------------------------Error free subject Controller--------------------------------  */

############################################ Amendment Data ############################################

/* ------------------------------------ Subject Data Eidt---------------------------------------------------------  */
Route::group(['prefix'=> 'amendment/card', 'namespace'=> 'Cib\Amendment\Card', 'as'=>'amendment.card.'], function(){
    Route::get('index', 'SubjectEditController@index')->name('index');
    Route::post('index', 'SubjectEditController@show_subject')->name('show_subject');
    Route::post('update', 'SubjectEditController@update')->name('update');
   
});
/* ------------------------------------Subject Data Eidt--------------------------------  */


/* ------------------------------------ Subject individual Data Eidt---------------------------------------------------------  */
Route::group(['prefix'=> 'amendment/individual', 'namespace'=> 'Cib\Amendment', 'as'=>'amendment.individual.'], function(){
    Route::get('index', 'SubjectIndividualEditController@index')->name('index');
    Route::post('index', 'SubjectIndividualEditController@search_info')->name('search-info');
    Route::post('edit-info', 'SubjectIndividualEditController@edit_info')->name('edit-info');
    Route::post('update', 'SubjectIndividualEditController@update')->name('update');
    Route::post('modal', 'SubjectIndividualEditController@modal')->name('modal');
    Route::post('modify', 'SubjectIndividualEditController@modify')->name('modify');
    Route::post('row', 'SubjectIndividualEditController@row')->name('row');
    Route::get('search', 'SubjectIndividualEditController@search')->name('search');
});
/* ------------------------------------Subject individual Data Eidt--------------------------------  */


/* ------------------------------------ Subject Personal Data Eidt---------------------------------------------------------  */
Route::group(['prefix'=> 'amendment/personal', 'namespace'=> 'Cib\Amendment', 'as'=>'amendment.personal.'], function(){
    Route::get('index', 'SubjectPersonalEditController@index')->name('index');
    Route::post('index', 'SubjectPersonalEditController@show_subject')->name('show_subject');
    Route::post('update', 'SubjectPersonalEditController@update')->name('update');
    Route::post('modal', 'SubjectPersonalEditController@modal')->name('modal');
    Route::post('modify', 'SubjectPersonalEditController@modify')->name('modify');
    Route::post('row', 'SubjectPersonalEditController@row')->name('row');
    Route::get('search', 'SubjectPersonalEditController@search')->name('search');
});
/* ------------------------------------Subject Personal Data Eidt--------------------------------  */


/* ------------------------------------ Subject Personal Data Eidt---------------------------------------------------------  */
Route::group(['prefix'=> 'amendment/company', 'namespace'=> 'Cib\Amendment', 'as'=>'amendment.company.'], function(){
    Route::get('index', 'SubjectCompanyEditController@index')->name('index');
    Route::post('index', 'SubjectCompanyEditController@show_subject')->name('show_subject');
    Route::post('update', 'SubjectCompanyEditController@update')->name('update');
    Route::post('modal', 'SubjectCompanyEditController@modal')->name('modal');
    Route::post('modify', 'SubjectCompanyEditController@modify')->name('modify');
    Route::post('row', 'SubjectCompanyEditController@row')->name('row');
    Route::get('search', 'SubjectCompanyEditController@search')->name('search');
});
/* ------------------------------------Subject Personal Data Eidt--------------------------------  */




/* ------------------------------------ Contract Data Eidt---------------------------------------------------------  */
Route::group(['prefix'=> 'amendment/card/contract', 'namespace'=> 'Cib\Amendment', 'as'=>'amendment.card.contract.'], function(){
    Route::get('index', 'ContractEditController@index')->name('index');
    Route::post('index', 'ContractEditController@search_info')->name('search-info');
    Route::post('edit-info', 'ContractEditController@edit_info')->name('edit-info');
    Route::post('update', 'ContractEditController@update')->name('update');
   
});
/* ------------------------------------Contract Data Eidt--------------------------------  */


/* ------------------------------------ Installment Data Eidt---------------------------------------------------------  */
Route::group(['prefix'=> 'amendment/installmentcontract', 'namespace'=> 'Cib\Amendment', 'as'=>'amendment.installment.contract.'], function(){
    Route::get('index', 'InstallmentEditController@index')->name('index');
    Route::post('index', 'InstallmentEditController@show_contract')->name('show_contract');
    Route::post('update', 'InstallmentEditController@update')->name('update');
    Route::post('modal', 'InstallmentEditController@modal')->name('modal');
    Route::post('modify', 'InstallmentEditController@modify')->name('modify');
    Route::post('row', 'InstallmentEditController@row')->name('row');
    Route::get('search', 'InstallmentEditController@search')->name('search');
});
/* ------------------------------------Installment Data Eidt--------------------------------  */


/* ------------------------------------ nonInstallment Data Eidt---------------------------------------------------------  */
Route::group(['prefix'=> 'amendment/noninstallmentcontract', 'namespace'=> 'Cib\Amendment', 'as'=>'amendment.noninstallment.contract.'], function(){
    Route::get('index', 'NonInstallmentEditController@index')->name('index');
    Route::post('index', 'NonInstallmentEditController@show_contract')->name('show_contract');
    Route::post('update', 'NonInstallmentEditController@update')->name('update');
    Route::post('modal', 'NonInstallmentEditController@modal')->name('modal');
    Route::post('modify', 'NonInstallmentEditController@modify')->name('modify');
    Route::post('row', 'NonInstallmentEditController@row')->name('row');
    Route::get('search', 'NonInstallmentEditController@search')->name('search');
});
/* ------------------------------------nonInstallment Data Eidt--------------------------------  */

############################################ Amendment Data ############################################


/* ------------------------------------Report Route------------------------------------------------- */
/*----------------------------------- end  cib archive route  -----------------------------------------------*/

############################################## Manual entry screen route #########################
Route::group(['prefix'=>'manual/screen/subject', 'namespace'=> 'Cib\ManualScreen', 'as'=> 'manual.screen.subject.'], function(){
    Route::get('create', 'SubjectEntryScreenController@create')->name('create');
    Route::post('create', 'SubjectEntryScreenController@store')->name('store');
    Route::post('fi_subject_code', 'SubjectEntryScreenController@getFiSusbject')->name('fi_subject_code');
});

Route::group(['prefix'=>'manual/screen/contract', 'namespace'=> 'Cib\ManualScreen', 'as'=> 'manual.screen.contract.'], function(){
    Route::get('create', 'ContractEntryScreenController@create')->name('create');
    Route::post('create', 'ContractEntryScreenController@store')->name('store');
    Route::post('fi_code_code', 'ContractEntryScreenController@getFiContract')->name('fi_contract_code');
});

############################################## Manual entry screen route #########################
########################################## serch loan status #######################################
Route::group(['prefix'=>'report/search/loan', 'namespace'=>'Cib\Report', 'as'=>'report.search.loan.'], function(){
    Route::get('index', 'SearchLoanController@index')->name('loan');
    Route::post('index', 'SearchLoanController@search')->name('search');

});
########################################## serch loan status #######################################




// Start -:- CibDataPullController
Route::get('cib/warehouse/data/pull/create', 'Cib\Warehouse\CibDataPullController@create')->name('cib.warehouse.data.pull.create');
Route::post('cib/warehouse/data/pull/store', 'Cib\Warehouse\CibDataPullController@store')->name('cib.warehouse.data.pull.store');
// End -:- CibDataPullController

// Start -:- CibDataPushController
Route::get('cib/warehouse/data/push/create', 'Cib\Warehouse\CibDataPushController@create')->name('cib.warehouse.data.push.create');
Route::post('cib/warehouse/data/push/store', 'Cib\Warehouse\CibDataPushController@store')->name('cib.warehouse.data.push.store');
// End -:- CibDataPushController

// Coding by Sizar
// Start -:- CibDataTextController
Route::get('cib/text/data/download/index', 'Cib\Text\CibDataTextController@index')->name('cib.text.data.download.create');
Route::post('cib/warehouse/data/text/store', 'Cib\Warehouse\CibDataPushController@store')->name('cib.warehouse.data.push.store');
Route::get('cib/text/data/generate/subject/index','Cib\Text\CibDataTextController@index_subject')->name('cib.text.data.generate.index_subject');
// End -:- CibDataTextController


// Start -:- CibDataMigrationController
Route::get('cib/data/migration/file/create', 'Cib\Upload\CibDataMigrationController@create')->name('cib.data.migration.file.create');
Route::post('cib/data/migration/file/store', 'Cib\Upload\CibDataMigrationController@store')->name('cib.data.migration.file.store');
Route::get('cib/data/migration/file/index', 'Cib\Upload\CibDataMigrationController@index')->name('cib.data.migration.file.index');
Route::post('cib/data/migration/file/search', 'Cib\Upload\CibDataMigrationController@search')->name('cib.data.migration.file.search');
Route::post('cib/data/migration/file/update', 'Cib\Upload\CibDataMigrationController@update')->name('cib.data.migration.file.update');
// End -:- CibDataMigrationController

// Start -:- CibSubjectFetchModifyController
Route::get('cib/subject/fetch/data/modification/edit', 'Cib\Modification\CibSubjectFetchModifyController@edit')->name('cib.subject.fetch.data.modification.edit');
Route::post('cib/subject/fetch/data/modification/update', 'Cib\Modification\CibSubjectFetchModifyController@update')->name('cib.subject.fetch.data.modification.update');
// End -:- CibSubjectFetchModifyController


// Start -:- CibBillUploadController
Route::get('cib/bill/data/uplaod', 'Cib\Upload\CibBillUploadController@create')->name('cib.bill.data.uplaod');
Route::post('cib/bill/data/store', 'Cib\Upload\CibBillUploadController@store')->name('cib.bill.data.store');
// End -:- CibBillUploadController



// Start -:- CibDataMigrationTxtController
Route::get('cib/data/migration/txt/create', 'Cib\Upload\CibDataMigrationTxtController@create')->name('cib.data.migration.txt.create');
Route::post('cib/data/migration/txt/store', 'Cib\Upload\CibDataMigrationTxtController@store')->name('cib.data.migration.txt.store');
// End -:- CibDataMigrationTxtController


// Start -:- CibGuarantorBorrowerController
Route::get('cib/guarantor/coborrower/create', 'Cib\ManualScreen\CibGuarantorBorrowerController@create')->name('cib.guarantor.coborrower.create');
Route::post('cib/guarantor/coborrower/store', 'Cib\ManualScreen\CibGuarantorBorrowerController@store')->name('cib.guarantor.coborrower.store');
Route::post('cib/guarantor/coborrower/fetch', 'Cib\ManualScreen\CibGuarantorBorrowerController@fetch')->name('cib.guarantor.coborrower.fetch');
Route::post('cib/guarantor/coborrower/info', 'Cib\ManualScreen\CibGuarantorBorrowerController@info')->name('cib.guarantor.coborrower.info');
// End -:- CibGuarantorBorrowerController



// Start -:- CibShareholderPropretishipController
Route::get('cib/shareholder/propretiship/create', 'Cib\ManualScreen\CibShareholderPropretishipController@create')->name('cib.shareholder.propretiship.create');
Route::post('cib/shareholder/propretiship/store', 'Cib\ManualScreen\CibShareholderPropretishipController@store')->name('cib.shareholder.propretiship.store');
// End -:- CibShareholderPropretishipController



//  Subject personal 


Route::group(['prefix'=> 'record_type', 'as'=> 'record_type.'], function(){
    Route::post('subject/change', 'Cib\TransferRecordType\RecordTypeController@subject_change')->name('subject.change');
});


############################################ Shear holder report ########################################
Route::post('show_company_shearholder', 'Cib\Report\ShearHolderReportController@index')->name('show.company.shearholder');
############################################ Shear holder report ########################################




Route::get('cib/summary/report/main_branch_generate', 'Cib\Report\CibSummaryReportController@mainGenerate')->name('cib.summary.report.main-generate');
Route::get('cib/summary/report/main_branch_download', 'Cib\Report\CibSummaryReportController@mainDownload')->name('cib.summary.report.main-download');


Route::get('cib/summary/report/report_branch_generate', 'Cib\Report\CibSummaryReportController@reportGenerate')->name('cib.summary.report.report-generate');
Route::get('cib/summary/report/report_branch_download', 'Cib\Report\CibSummaryReportController@reportDownload')->name('cib.summary.report.report-download');

