<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
 
    if(Auth::check())
    {
        return redirect('dashboard');
    }
    dd('here');
    return redirect(URL_USERS_LOGIN);
});


if(env('DB_DATABASE')=='')
{
   Route::get('/', 'InstallatationController@index');
   Route::get('/install', 'InstallatationController@index');
   Route::post('/install', 'InstallatationController@installProject');
}

if(env('DEMO_MODE')) {
    Event::listen('eloquent.saving: *', function ($model) {
        if(urlHasString('finish-exam') || urlHasString('start-exam'))
          return true;
      return false;


    });
     
}

 // Route::get('install/reg', 'InstallatationController@reg');
 Route::post('install/register', 'InstallatationController@registerUser');
 

Route::get('/', function () {
 
    if(Auth::check())
    {
        return redirect('dashboard');
    }
	return redirect(URL_USERS_LOGIN);
});

Route::get('dashboard','DashboardController@index');
Route::get('dashboard/testlang','DashboardController@testLanguage');


Route::get('auth/{slug}','Auth\AuthController@redirectToProvider');
Route::get('auth/{slug}/callback','Auth\AuthController@handleProviderCallback');



// Authentication Routes...
Route::get('login', 'Auth\AuthController@getLogin');
Route::post('login', 'Auth\AuthController@postLogin');

Route::get('logout', function(){

	if(Auth::check())
		flash(getPhrase('success'),getPhrase('logged_out_successfully'),'success');

	Auth::logout();
	return redirect(URL_USERS_LOGIN);
});

Route::get('parent-logout', function(){
    if(Auth::check())
        flash('Oops..!',getPhrase('parents_module_is_not_available'),'error');
    Auth::logout();
    return redirect(URL_USERS_LOGIN);
});


// Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration Routes...
Route::get('register', 'Auth\AuthController@getRegister');
Route::post('register', 'Auth\AuthController@postRegister');

// Forgot Password Routes...
// Route::get('forgot-password', 'PasswordController@postEmail');
Route::post('users/forgot-password', 'Auth\PasswordController@postEmail');
Route::get('password/reset/{slug?}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');


Route::get('languages/list', 'NativeController@index');
Route::get('languages/getList', [ 'as'   => 'languages.dataTable',
     'uses' => 'NativeController@getDatatable']);
 
Route::get('languages/add', 'NativeController@create');
Route::post('languages/add', 'NativeController@store');
Route::get('languages/edit/{slug}', 'NativeController@edit');
Route::patch('languages/edit/{slug}', 'NativeController@update');
Route::delete('languages/delete/{slug}', 'NativeController@delete');
 
Route::get('languages/make-default/{slug}', 'NativeController@changeDefaultLanguage');
Route::get('languages/update-strings/{slug}', 'NativeController@updateLanguageStrings');
Route::patch('languages/update-strings/{slug}', 'NativeController@saveLanguageStrings');



//Users
Route::get('users/staff/{role?}', 'UsersController@index');
Route::get('users/create', 'UsersController@create');
Route::delete('users/delete/{slug}', 'UsersController@delete');
Route::post('users/create/{role?}', 'UsersController@store');
Route::get('users/edit/{slug}', 'UsersController@edit');
Route::patch('users/edit/{slug}', 'UsersController@update');
Route::get('users/profile/{slug}', 'UsersController@show');
Route::get('users', 'UsersController@index');
Route::get('users/profile/{slug}', 'UsersController@show');
Route::get('users/details/{slug}', 'UsersController@details');

Route::get('users/settings/{slug}', 'UsersController@settings');
Route::patch('users/settings/{slug}', 'UsersController@updateSettings');

Route::get('users/change-password/{slug}', 'UsersController@changePassword');
Route::patch('users/change-password/{slug}', 'UsersController@updatePassword');

Route::get('users/import','UsersController@importUsers');
Route::post('users/import','UsersController@readExcel');

Route::get('users/import-report','UsersController@importResult');

Route::get('users/list/getList/{role_name?}', [ 'as'   => 'users.dataTable',
    'uses' => 'UsersController@getDatatable']);
Route::get('users/parent-details/{slug}', 'UsersController@viewParentDetails');
Route::patch('users/parent-details/{slug}', 'UsersController@updateParentDetails');
Route::post('users/search/parent', 'UsersController@getParentsOnSearch');

// Route::get('users/list/getList/{role_name?}', 'UsersController@getDatatable');

            //////////////////////
            //Parent Controller //
            //////////////////////
Route::get('parent/children', 'ParentsController@index');
Route::get('parent/children/list', 'ParentsController@index');
Route::get('parent/children/getList/{slug}', 'ParentsController@getDatatable');
Route::get('children/analysis', 'ParentsController@childrenAnalysis');
   
                    /////////////////////
                    // Master Settings //
                    /////////////////////
 

//subjects
Route::get('mastersettings/subjects', 'SubjectsController@index');
Route::get('mastersettings/subjects/add', 'SubjectsController@create');
Route::post('mastersettings/subjects/add', 'SubjectsController@store');
Route::get('mastersettings/subjects/edit/{slug}', 'SubjectsController@edit');
Route::patch('mastersettings/subjects/edit/{slug}', 'SubjectsController@update');
Route::delete('mastersettings/subjects/delete/{id}', 'SubjectsController@delete');
Route::get('mastersettings/subjects/getList', [ 'as'   => 'subjects.dataTable',
    'uses' => 'SubjectsController@getDatatable']);

Route::get('mastersettings/subjects/import', 'SubjectsController@import');
Route::post('mastersettings/subjects/import', 'SubjectsController@readExcel');
 
//Topics 
Route::get('mastersettings/topics', 'TopicsController@index');
Route::get('mastersettings/topics/add', 'TopicsController@create');
Route::post('mastersettings/topics/add', 'TopicsController@store');
Route::get('mastersettings/topics/edit/{slug}', 'TopicsController@edit');
Route::patch('mastersettings/topics/edit/{slug}', 'TopicsController@update');
Route::delete('mastersettings/topics/delete/{id}', 'TopicsController@delete');
Route::get('mastersettings/topics/getList', [ 'as'   => 'topics.dataTable',
    'uses' => 'TopicsController@getDatatable']);

Route::get('mastersettings/topics/get-parents-topics/{subject_id}', 'TopicsController@getParentTopics');

Route::get('mastersettings/topics/import', 'TopicsController@import');
Route::post('mastersettings/topics/import', 'TopicsController@readExcel');

                    ////////////////////////
                    // EXAMINATION SYSTEM //
                    ////////////////////////

//Question bank
Route::get('exams/questionbank', 'QuestionBankController@index');
Route::get('exams/questionbank/add-question/{slug}', 'QuestionBankController@create');
Route::get('exams/questionbank/view/{slug}', 'QuestionBankController@show');

Route::post('exams/questionbank/add', 'QuestionBankController@store');
Route::get('exams/questionbank/edit-question/{slug}', 'QuestionBankController@edit');
Route::patch('exams/questionbank/edit/{slug}', 'QuestionBankController@update');
Route::delete('exams/questionbank/delete/{id}', 'QuestionBankController@delete');
Route::get('exams/questionbank/getList',  'QuestionBankController@getDatatable');

Route::get('exams/questionbank/getquestionslist/{slug}', 
     'QuestionBankController@getQuestions');
Route::get('exams/questionbank/import',  'QuestionBankController@import');
Route::post('exams/questionbank/import',  'QuestionBankController@readExcel');


//Quiz Categories
Route::get('exams/categories', 'QuizCategoryController@index');
Route::get('exams/categories/add', 'QuizCategoryController@create');
Route::post('exams/categories/add', 'QuizCategoryController@store');
Route::get('exams/categories/edit/{slug}', 'QuizCategoryController@edit');
Route::patch('exams/categories/edit/{slug}', 'QuizCategoryController@update');
Route::delete('exams/categories/delete/{slug}', 'QuizCategoryController@delete');
Route::get('exams/categories/getList', [ 'as'   => 'quizcategories.dataTable',
    'uses' => 'QuizCategoryController@getDatatable']);

// Quiz Student Categories 
Route::get('exams/student/categories', 'StudentQuizController@index');
Route::get('exams/student/exams/{slug?}', 'StudentQuizController@exams');
Route::get('exams/student/quiz/getList/{slug?}', 'StudentQuizController@getDatatable');
Route::get('exams/student/quiz/take-exam/{slug?}', 'StudentQuizController@instructions');
Route::post('exams/student/start-exam/{slug}', 'StudentQuizController@startExam');
Route::get('exams/student/start-exam/{slug}', 'StudentQuizController@index');

Route::post('exams/student/finish-exam/{slug}', 'StudentQuizController@finishExam');
Route::get('exams/student/reports/{slug}', 'StudentQuizController@reports');


Route::get('exams/student/exam-attempts/{user_slug}/{exam_slug?}', 'StudentQuizController@examAttempts');
Route::get('exams/student/get-exam-attempts/{user_slug}/{exam_slug?}', 'StudentQuizController@getExamAttemptsData');

Route::get('student/analysis/by-exam/{user_slug}', 'StudentQuizController@examAnalysis');
Route::get('student/analysis/get-by-exam/{user_slug}', 'StudentQuizController@getExamAnalysisData');

Route::get('student/analysis/by-subject/{user_slug}/{exam_slug?}/{results_slug?}', 'StudentQuizController@subjectAnalysisInExam');
Route::get('student/analysis/subject/{user_slug}', 'StudentQuizController@overallSubjectAnalysis');

//Student Reports
Route::get('student/exam/answers/{quiz_slug}/{result_slug}', 'ReportsController@viewExamAnswers');


//Quiz 
Route::get('exams/quizzes', 'QuizController@index');
Route::get('exams/quiz/add', 'QuizController@create');
Route::post('exams/quiz/add', 'QuizController@store');
Route::get('exams/quiz/edit/{slug}', 'QuizController@edit');
Route::patch('exams/quiz/edit/{slug}', 'QuizController@update');
Route::delete('exams/quiz/delete/{slug}', 'QuizController@delete');
Route::get('exams/quiz/getList/{slug?}', 'QuizController@getDatatable');

Route::get('exams/quiz/update-questions/{slug}', 'QuizController@updateQuestions');
Route::post('exams/quiz/update-questions/{slug}', 'QuizController@storeQuestions');


Route::post('exams/quiz/get-questions', 'QuizController@getSubjectData');

//Certificates controller
Route::get('result/generate-certificate/{slug}', 'CertificatesController@getCertificate');


//Exam Series 
Route::get('exams/exam-series', 'ExamSeriesController@index');
Route::get('exams/exam-series/add', 'ExamSeriesController@create');
Route::post('exams/exam-series/add', 'ExamSeriesController@store');
Route::get('exams/exam-series/edit/{slug}', 'ExamSeriesController@edit');
Route::patch('exams/exam-series/edit/{slug}', 'ExamSeriesController@update');
Route::delete('exams/exam-series/delete/{slug}', 'ExamSeriesController@delete');
Route::get('exams/exam-series/getList', 'ExamSeriesController@getDatatable');

//EXAM SERIES STUDENT LINKS
Route::get('exams/student-exam-series/list', 'ExamSeriesController@listSeries');
Route::get('exams/student-exam-series/{slug}', 'ExamSeriesController@viewItem');




Route::get('exams/exam-series/update-series/{slug}', 'ExamSeriesController@updateSeries');
Route::post('exams/exam-series/update-series/{slug}', 'ExamSeriesController@storeSeries');
Route::post('exams/exam-series/get-exams', 'ExamSeriesController@getExams');
Route::get('payment/cancel', 'ExamSeriesController@cancel');
Route::post('payment/success', 'ExamSeriesController@success');

            /////////////////////
            // PAYMENT REPORTS //
            /////////////////////
Route::get('payments-report/', 'PaymentsController@overallPayments');

 Route::get('payments-report/online/', 'PaymentsController@onlinePaymentsReport');
 Route::get('payments-report/online/{slug}', 'PaymentsController@listOnlinePaymentsReport');
Route::get('payments-report/online/getList/{slug}', 'PaymentsController@getOnlinePaymentReportsDatatable');

Route::get('payments-report/offline/', 'PaymentsController@offlinePaymentsReport');
Route::get('payments-report/offline/{slug}', 'PaymentsController@listOfflinePaymentsReport');
Route::get('payments-report/offline/getList/{slug}', 'PaymentsController@getOfflinePaymentReportsDatatable');
Route::get('payments-report/export', 'PaymentsController@exportPayments');
Route::post('payments-report/export', 'PaymentsController@doExportPayments');

Route::post('payments-report/getRecord', 'PaymentsController@getPaymentRecord');
Route::post('payments/approve-reject-offline-request', 'PaymentsController@approveOfflinePayment');

            //////////////////
            // INSTRUCTIONS  //
            //////////////////
            
Route::get('exam/instructions/list', 'InstructionsController@index');
Route::get('exam/instructions', 'InstructionsController@index');
Route::get('exams/instructions/add', 'InstructionsController@create');
Route::post('exams/instructions/add', 'InstructionsController@store');
Route::get('exams/instructions/edit/{slug}', 'InstructionsController@edit');
Route::patch('exams/instructions/edit/{slug}', 'InstructionsController@update');
Route::delete('exams/instructions/delete/{slug}', 'InstructionsController@delete');
Route::get('exams/instructions/getList', 'InstructionsController@getDatatable');

 
//BOOKMARKS MODULE
Route::get('student/bookmarks/{slug}', 'BookmarksController@index');
Route::post('student/bookmarks/add', 'BookmarksController@create');
Route::delete('student/bookmarks/delete/{id}', 'BookmarksController@delete');
Route::delete('student/bookmarks/delete_id/{id}', 'BookmarksController@deleteById');
Route::get('student/bookmarks/getList/{slug}',  'BookmarksController@getDatatable');
Route::post('student/bookmarks/getSavedList',  'BookmarksController@getSavedBookmarks');


                //////////////////////////
                // Notifications Module //
                /////////////////////////
Route::get('admin/notifications/list', 'NotificationsController@index');
Route::get('admin/notifications', 'NotificationsController@index');
Route::get('admin/notifications/add', 'NotificationsController@create');
Route::post('admin/notifications/add', 'NotificationsController@store');
Route::get('admin/notifications/edit/{slug}', 'NotificationsController@edit');
Route::patch('admin/notifications/edit/{slug}', 'NotificationsController@update');
Route::delete('admin/notifications/delete/{slug}', 'NotificationsController@delete');
Route::get('admin/notifications/getList', 'NotificationsController@getDatatable');

// NOTIFICATIONS FOR STUDENT
Route::get('notifications/list', 'NotificationsController@usersList');
Route::get('notifications/show/{slug}', 'NotificationsController@display');

 
//BOOKMARKS MODULE
Route::get('toppers/compare-with-topper/{user_result_slug}/{compare_slug?}', 'ExamToppersController@compare');

               
                        ////////////////
                        // LMS MODULE //
                        ////////////////

//LMS Categories
Route::get('lms/categories', 'LmsCategoryController@index');
Route::get('lms/categories/add', 'LmsCategoryController@create');
Route::post('lms/categories/add', 'LmsCategoryController@store');
Route::get('lms/categories/edit/{slug}', 'LmsCategoryController@edit');
Route::patch('lms/categories/edit/{slug}', 'LmsCategoryController@update');
Route::delete('lms/categories/delete/{slug}', 'LmsCategoryController@delete');
Route::get('lms/categories/getList', [ 'as'   => 'lmscategories.dataTable',
    'uses' => 'LmsCategoryController@getDatatable']);

//LMS Contents
Route::get('lms/content', 'LmsContentController@index');
Route::get('lms/content/add', 'LmsContentController@create');
Route::post('lms/content/add', 'LmsContentController@store');
Route::get('lms/content/edit/{slug}', 'LmsContentController@edit');
Route::patch('lms/content/edit/{slug}', 'LmsContentController@update');
Route::delete('lms/content/delete/{slug}', 'LmsContentController@delete');
Route::get('lms/content/getList', [ 'as'   => 'lmscontent.dataTable',
    'uses' => 'LmsContentController@getDatatable']);



//LMS Series 
Route::get('lms/series', 'LmsSeriesController@index');
Route::get('lms/series/add', 'LmsSeriesController@create');
Route::post('lms/series/add', 'LmsSeriesController@store');
Route::get('lms/series/edit/{slug}', 'LmsSeriesController@edit');
Route::patch('lms/series/edit/{slug}', 'LmsSeriesController@update');
Route::delete('lms/series/delete/{slug}', 'LmsSeriesController@delete');
Route::get('lms/series/getList', 'LmsSeriesController@getDatatable');

//LMS SERIES STUDENT LINKS
Route::get('lms/exam-series/list', 'LmsSeriesController@listSeries');
Route::get('lms/exam-series/{slug}', 'LmsSeriesController@viewItem');




Route::get('lms/series/update-series/{slug}', 'LmsSeriesController@updateSeries');
Route::post('lms/series/update-series/{slug}', 'LmsSeriesController@storeSeries');
Route::post('lms/series/get-series', 'LmsSeriesController@getSeries');
Route::get('payment/cancel', 'LmsSeriesController@cancel');
Route::post('payment/success', 'LmsSeriesController@success');


//LMS Student view
Route::get('learning-management/categories', 'StudentLmsController@index');
Route::get('learning-management/view/{slug}', 'StudentLmsController@viewCategoryItems');
Route::get('learning-management/series', 'StudentLmsController@series');
Route::get('learning-management/series/{slug}/{content_slug?}', 'StudentLmsController@viewItem');
Route::get('user/paid/{slug}/{content_slug}', 'StudentLmsController@verifyPaidItem');
Route::get('learning-management/content/{req_content_type}', 'StudentLmsController@content');
Route::get('learning-management/content/show/{slug}', 'StudentLmsController@showContent');

 

//Payments Controller
Route::get('payments/list/{slug}', 'PaymentsController@index');
Route::get('payments/getList/{slug}', 'PaymentsController@getDatatable');

Route::get('payments/checkout/{type}/{slug}', 'PaymentsController@checkout');
Route::get('payments/paynow/{slug}', 'DashboardController@index');
Route::post('payments/paynow/{slug}', 'PaymentsController@paynow');
Route::post('payments/paypal/status-success','PaymentsController@paypal_success');
Route::get('payments/paypal/status-cancel', 'PaymentsController@paypal_cancel');

Route::post('payments/payu/status-success','PaymentsController@payu_success');
Route::post('payments/payu/status-cancel', 'PaymentsController@payu_cancel');
Route::post('payments/offline-payment/update', 'PaymentsController@updateOfflinePayment');

                    
 

                        ////////////////////////////
                        // SETTINGS MODULE //
                        ///////////////////////////


//LMS Categories
Route::get('mastersettings/settings/', 'SettingsController@index');
Route::get('mastersettings/settings/index', 'SettingsController@index');
Route::get('mastersettings/settings/add', 'SettingsController@create');
Route::post('mastersettings/settings/add', 'SettingsController@store');
Route::get('mastersettings/settings/edit/{slug}', 'SettingsController@edit');
Route::patch('mastersettings/settings/edit/{slug}', 'SettingsController@update');
Route::get('mastersettings/settings/view/{slug}', 'SettingsController@viewSettings');
Route::get('mastersettings/settings/add-sub-settings/{slug}', 'SettingsController@addSubSettings');
Route::post('mastersettings/settings/add-sub-settings/{slug}', 'SettingsController@storeSubSettings');
Route::patch('mastersettings/settings/add-sub-settings/{slug}', 'SettingsController@updateSubSettings');
 
Route::get('mastersettings/settings/getList', [ 'as'   => 'mastersettings.dataTable',
     'uses' => 'SettingsController@getDatatable']);

                        ////////////////////////////
                        // EMAIL TEMPLATES MODULE //
                        ///////////////////////////

//LMS Categories
Route::get('email/templates', 'EmailTemplatesController@index');
Route::get('email/templates/add', 'EmailTemplatesController@create');
Route::post('email/templates/add', 'EmailTemplatesController@store');
Route::get('email/templates/edit/{slug}', 'EmailTemplatesController@edit');
Route::patch('email/templates/edit/{slug}', 'EmailTemplatesController@update');
Route::delete('email/templates/delete/{slug}', 'EmailTemplatesController@delete');
Route::get('email/templates/getList', [ 'as'   => 'emailtemplates.dataTable',
    'uses' => 'EmailTemplatesController@getDatatable']);


//Coupons Module
Route::get('coupons/list', 'CouponcodesController@index');
Route::get('coupons/add', 'CouponcodesController@create');
Route::post('coupons/add', 'CouponcodesController@store');
Route::get('coupons/edit/{slug}', 'CouponcodesController@edit');
Route::patch('coupons/edit/{slug}', 'CouponcodesController@update');
Route::delete('coupons/delete/{slug}', 'CouponcodesController@delete');
Route::get('coupons/getList/{slug?}', 'CouponcodesController@getDatatable');

Route::get('coupons/get-usage', 'CouponcodesController@getCouponUsage');
Route::get('coupons/get-usage-data', 'CouponcodesController@getCouponUsageData');
Route::post('coupons/update-questions/{slug}', 'CouponcodesController@storeQuestions');


Route::post('coupons/validate-coupon', 'CouponcodesController@validateCoupon');


//Feedback Module
Route::get('feedback/list', 'FeedbackController@index');
Route::get('feedback/view-details/{slug}', 'FeedbackController@details');
Route::get('feedback/send', 'FeedbackController@create');
Route::post('feedback/send', 'FeedbackController@store');
Route::delete('feedback/delete/{slug}', 'FeedbackController@delete');
Route::get('feedback/getlist', 'FeedbackController@getDatatable');

//SMS Module

Route::get('sms/index', 'SMSAgentController@index');
Route::post('sms/send', 'SMSAgentController@sendSMS');

                        /////////////////////
                        // MESSAGES MODULE //
                        /////////////////////


Route::group(['prefix' => 'messages'], function () {
    Route::get('/', ['as' => 'messages', 'uses' => 'MessagesController@index']);
    Route::get('create', ['as' => 'messages.create', 'uses' => 'MessagesController@create']);
    Route::post('/', ['as' => 'messages.store', 'uses' => 'MessagesController@store']);
    Route::get('{id}', ['as' => 'messages.show', 'uses' => 'MessagesController@show']);
    Route::put('{id}', ['as' => 'messages.update', 'uses' => 'MessagesController@update']);
});


                         ////////////////////
                         // UPDATE PATCHES //
                         ////////////////////
 Route::get('updates/patch1', 'UpdatesController@patch1');




