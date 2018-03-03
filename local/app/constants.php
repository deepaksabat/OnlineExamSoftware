<?php

 $base = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https' : 'http';
 $base .= '://'.$_SERVER['HTTP_HOST'] . str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
 // $base =  '/';

define('PREFIX', $base);

// dd($_SERVER);
//Design Source File Paths
define('CSS', PREFIX.'css/');
define('JS', PREFIX.'js/');
define('FONTAWSOME', PREFIX.'font-awesome/css/');
define('IMAGES', PREFIX.'images/');
define('AJAXLOADER', IMAGES.'ajax-loader.svg');
define('AJAXLOADER_FADEIN_TIME', 100);
define('AJAXLOADER_FADEOUT_TIME', 100);


define('UPLOADS', PREFIX.'uploads/');
define('EXAM_UPLOADS', UPLOADS.'exams/');
define('IMAGE_PATH_UPLOAD_SERIES', UPLOADS.'exams/series/');
define('IMAGE_PATH_UPLOAD_SERIES_THUMB', UPLOADS.'exams/series/thumb/');

define('IMAGE_PATH_UPLOAD_EXAMSERIES_DEFAULT', UPLOADS.'exams/series/default.png');

define('IMAGE_PATH_UPLOAD_LMS_CATEGORIES', UPLOADS.'lms/categories/');
define('IMAGE_PATH_UPLOAD_LMS_DEFAULT', UPLOADS.'lms/categories/default.png');
define('IMAGE_PATH_UPLOAD_LMS_CONTENTS', UPLOADS.'lms/content/');

define('IMAGE_PATH_UPLOAD_LMS_SERIES', UPLOADS.'lms/series/');
define('IMAGE_PATH_UPLOAD_LMS_SERIES_THUMB', UPLOADS.'lms/series/thumb/');

define('IMAGE_PATH_PROFILE', UPLOADS.'users/');
define('IMAGE_PATH_PROFILE_THUMBNAIL', UPLOADS.'users/thumbnail/');
define('IMAGE_PATH_PROFILE_THUMBNAIL_DEFAULT', UPLOADS.'users/thumbnail/default.png');

define('IMAGE_PATH_SETTINGS', UPLOADS.'settings/');



define('DOWNLOAD_LINK_USERS_IMPORT_EXCEL', PREFIX.'downloads/excel-templates/users_template.xlsx');
define('DOWNLOAD_LINK_SUBJECTS_IMPORT_EXCEL', PREFIX.'downloads/excel-templates/subjects_template.xlsx');
define('DOWNLOAD_LINK_TOPICS_IMPORT_EXCEL', PREFIX.'downloads/excel-templates/topics_template.xlsx');
define('DOWNLOAD_LINK_QUESTION_IMPORT_EXCEL', PREFIX.'downloads/excel-templates/');


define('DOWNLOAD_EMPTY_DATA_DATABASE', PREFIX.'downloads/database/install.sql');
define('DOWNLOAD_SAMPLE_DATA_DATABASE', PREFIX.'downloads/database/install_dummy_data.sql');



define('CURRENCY_CODE', '$ ');
define('RECORDS_PER_PAGE', '8');
define('STUDENT_ROLE_ID', '5');

define('GOOGLE_TRANSLATE_LANGUAGES_LINK', 'https://cloud.google.com/translate/docs/languages');

define('PAYMENT_STATUS_CANCELLED', 'cancelled');
define('PAYMENT_STATUS_SUCCESS', 'success');
define('PAYMENT_STATUS_PENDING', 'pending');
define('PAYMENT_STATUS_ABORTED', 'aborted');
define('PAYMENT_RECORD_MAXTIME', '30'); //TIME IN MINUTES
//define('SUPPORTED_GATEWAYS', ['paypal','payu']); 

define('URL_INSTALL_SYSTEM', PREFIX.'install');
define('URL_FIRST_USER_REGISTER', PREFIX.'install/register');

//MASTER SETTINGS MODULE
define('URL_MASTERSETTINGS_SETTINGS', PREFIX.'mastersettings/settings');
define('URL_MASTERSETTINGS_EMAIL_TEMPLATES', PREFIX.'email/templates');
define('URL_MASTERSETTINGS_TOPICS', PREFIX.'mastersettings/topics');
define('URL_MASTERSETTINGS_SUBJECTS', PREFIX.'mastersettings/subjects');

//QUIZ MODULE
define('URL_QUIZZES', PREFIX.'exams/quizzes');
define('URL_QUIZ_QUESTIONBANK', PREFIX.'exams/questionbank');
define('URL_QUIZ_ADD', PREFIX.'exams/quiz/add');
define('URL_QUIZ_EDIT', PREFIX.'exams/quiz/edit');
define('URL_QUIZ_DELETE', PREFIX.'exams/quiz/delete/');
define('URL_QUIZ_GETLIST', PREFIX.'exams/quiz/getList');
define('URL_QUIZ_UPDATE_QUESTIONS', PREFIX.'exams/quiz/update-questions/');
define('URL_QUIZ_GET_QUESTIONS', PREFIX.'exams/quiz/get-questions');

//QUIZ CATEGORIES
define('URL_QUIZ_CATEGORIES', PREFIX.'exams/categories');
define('URL_QUIZ_CATEGORY_EDIT', PREFIX.'exams/categories/edit');
define('URL_QUIZ_CATEGORY_ADD', PREFIX.'exams/categories/add');
define('URL_QUIZ_CATEGORY_DELETE', PREFIX.'exams/categories/delete/');

//QUESTIONSBANK MODULE
define('URL_QUESTIONBANK_VIEW', PREFIX.'exams/questionbank/view/');
define('URL_QUESTIONBANK_ADD_QUESTION', PREFIX.'exams/questionbank/add-question/');
define('URL_QUESTIONBANK_EDIT_QUESTION', PREFIX.'exams/questionbank/edit-question/');
define('URL_QUESTIONBANK_EDIT', PREFIX.'exams/questionbank/edit');
define('URL_QUESTIONBANK_ADD', PREFIX.'exams/questionbank/add');
define('URL_QUESTIONBANK_GETLIST', PREFIX.'exams/questionbank/getList');
define('URL_QUESTIONBANK_DELETE', PREFIX.'exams/questionbank/delete/');
define('URL_QUESTIONBANK_GETQUESTION_LIST', PREFIX.'exams/questionbank/getquestionslist/');

define('URL_QUESTIONBAMK_IMPORT', PREFIX.'exams/questionbank/import');

//SUBJECTS MODULE
define('URL_SUBJECTS', PREFIX.'mastersettings/subjects');
define('URL_SUBJECTS_ADD', PREFIX.'mastersettings/subjects/add');
define('URL_SUBJECTS_EDIT', PREFIX.'mastersettings/subjects/edit');
define('URL_SUBJECTS_DELETE', PREFIX.'mastersettings/subjects/delete/');

define('URL_SUBJECTS_IMPORT', PREFIX.'mastersettings/subjects/import');


//TOPICS MODULE
define('URL_TOPICS', PREFIX.'mastersettings/topics');
define('URL_TOPICS_LIST', PREFIX.'mastersettings/topics/list');
define('URL_TOPICS_ADD', PREFIX.'mastersettings/topics/add');
define('URL_TOPICS_EDIT', PREFIX.'mastersettings/topics/edit');
define('URL_TOPICS_DELETE', PREFIX.'mastersettings/topics/delete/');
define('URL_TOPICS_GET_PARENT_TOPICS', PREFIX.'mastersettings/topics/get-parents-topics/');

define('URL_TOPICS_IMPORT', PREFIX.'mastersettings/topics/import');
//EMAIL TEMPLATES MODULE
define('URL_EMAIL_TEMPLATES', PREFIX.'email/templates');
define('URL_EMAIL_TEMPLATES_ADD', PREFIX.'email/templates/add');
define('URL_EMAIL_TEMPLATES_EDIT', PREFIX.'email/templates/edit');
define('URL_EMAIL_TEMPLATES_DELETE', PREFIX.'email/templates/delete/');

//INSTRUCTIONS MODULE
define('URL_INSTRUCTIONS', PREFIX.'exam/instructions/list');
define('URL_INSTRUCTIONS_ADD', PREFIX.'exams/instructions/add');
define('URL_INSTRUCTIONS_EDIT', PREFIX.'exams/instructions/edit/');
define('URL_INSTRUCTIONS_DELETE', PREFIX.'exams/instructions/delete/');
define('URL_INSTRUCTIONS_GETLIST', PREFIX.'exams/instructions/getList');

//LANGUAGES MODULE
define('URL_LANGUAGES_LIST', PREFIX.'languages/list');
define('URL_LANGUAGES_ADD', PREFIX.'languages/add');
define('URL_LANGUAGES_EDIT', PREFIX.'languages/edit');
define('URL_LANGUAGES_UPDATE_STRINGS', PREFIX.'languages/update-strings/');
define('URL_LANGUAGES_DELETE', PREFIX.'languages/delete/');
define('URL_LANGUAGES_GETLIST', PREFIX.'languages/getList/');
define('URL_LANGUAGES_MAKE_DEFAULT', PREFIX.'languages/make-default/');
 
//SETTINGS MODULE
define('URL_SETTINGS_LIST', PREFIX.'mastersettings/settings');
define('URL_SETTINGS_VIEW', PREFIX.'mastersettings/settings/view/');
define('URL_SETTINGS_ADD', PREFIX.'mastersettings/settings/add');
define('URL_SETTINGS_EDIT', PREFIX.'mastersettings/settings/edit/');
define('URL_SETTINGS_DELETE', PREFIX.'mastersettings/settings/delete/');
define('URL_SETTINGS_GETLIST', PREFIX.'mastersettings/settings/getList/');
define('URL_SETTINGS_ADD_SUBSETTINGS', PREFIX.'mastersettings/settings/add-sub-settings/');

 


//CONSTANST FOR USERS MODULE
define('URL_USERS', PREFIX.'users');
define('URL_USER_DETAILS', PREFIX.'users/details/');
define('URL_USERS_EDIT', PREFIX.'users/edit/');
define('URL_USERS_ADD', PREFIX.'users/create');
define('URL_USERS_DELETE', PREFIX.'users/delete/');
define('URL_USERS_SETTINGS', PREFIX.'users/settings/');
define('URL_USERS_CHANGE_PASSWORD', PREFIX.'users/change-password/');
define('URL_USERS_LOGOUT', PREFIX.'logout');
define('URL_PARENT_LOGOUT', PREFIX.'parent-logout');
define('URL_USERS_REGISTER', PREFIX.'register');
define('URL_USERS_LOGIN', PREFIX.'login');
define('URL_USERS_UPDATE_PARENT_DETAILS', PREFIX.'users/parent-details/');
define('URL_SEARCH_PARENT_RECORDS', PREFIX.'users/search/parent');

define('URL_USERS_IMPORT', PREFIX.'users/import');
define('URL_USERS_IMPORT_REPORT', PREFIX.'users/import-report');

define('URL_FORGOT_PASSWORD', PREFIX.'users/forgot-password');



			///////////////////
			//STUDENT MODULE //
			///////////////////

//STUDENT NAVIGATION
define('URL_STUDENT_EXAM_CATEGORIES', PREFIX.'exams/student/categories');
define('URL_STUDENT_EXAM_ATTEMPTS', PREFIX.'exams/student/exam-attempts/');
define('URL_STUDENT_ANALYSIS_SUBJECT', PREFIX.'student/analysis/subject/');
define('URL_STUDENT_ANALYSIS_BY_EXAM', PREFIX.'student/analysis/by-exam/');
define('URL_STUDENT_SUBSCRIPTIONS_PLANS', PREFIX.'subscription/plans');
define('URL_STUDENT_LIST_INVOICES', PREFIX.'subscription/list-invoices/');


///////////////////
// STUDENT EXAMS //
///////////////////
define('URL_STUDENT_EXAM_ALL', PREFIX.'exams/student/exams/all');
define('URL_STUDENT_EXAMS', PREFIX.'exams/student/exams/');
define('URL_STUDENT_QUIZ_GETLIST', PREFIX.'exams/student/quiz/getList/');
define('URL_STUDENT_QUIZ_GETLIST_ALL', PREFIX.'exams/student/quiz/getList/all');
define('URL_STUDENT_TAKE_EXAM', PREFIX.'exams/student/quiz/take-exam/');
define('URL_STUDENT_EXAM_GETATTEMPTS', PREFIX.'exams/student/get-exam-attempts/');
define('URL_STUDENT_EXAM_ANALYSIS_BYSUBJECT', PREFIX.'student/analysis/by-subject/');
define('URL_STUDENT_EXAM_ANALYSIS_BYEXAM', PREFIX.'student/analysis/get-by-exam/');
define('URL_STUDENT_EXAM_FINISH_EXAM', PREFIX.'exams/student/finish-exam/');


//PARENT NAVIGATION
define('URL_PARENT_CHILDREN', PREFIX.'parent/children');
define('URL_PARENT_CHILDREN_LIST', PREFIX.'parent/children_list');
define('URL_PARENT_CHILDREN_GETLIST', PREFIX.'parent/children/getList/');
define('URL_SUBSCRIBE', PREFIX.'subscription/subscribe/');

define('URL_PARENT_ANALYSIS_FOR_STUDENTS', PREFIX.'children/analysis');


//STUDENT BOOKMARKS
define('URL_BOOKMARKS', PREFIX.'student/bookmarks/');
define('URL_BOOKMARK_ADD', PREFIX.'student/bookmarks/add');
define('URL_BOOKMARK_DELETE', PREFIX.'student/bookmarks/delete/');
define('URL_BOOKMARK_DELETE_BY_ID', PREFIX.'student/bookmarks/delete_id/');
define('URL_BOOKMARK_AJAXLIST', PREFIX.'student/bookmarks/getList/');
define('URL_BOOKMARK_SAVED_BOOKMARKS', PREFIX.'student/bookmarks/getSavedList');


//EXAM SERIES
define('URL_EXAM_SERIES', PREFIX.'exams/exam-series');
define('URL_EXAM_SERIES_ADD', PREFIX.'exams/exam-series/add');
define('URL_EXAM_SERIES_DELETE', PREFIX.'exams/exam-series/delete/');
define('URL_EXAM_SERIES_EDIT', PREFIX.'exams/exam-series/edit/');
define('URL_EXAM_SERIES_AJAXLIST', PREFIX.'exams/exam-series/getList');
define('URL_EXAM_SERIES_UPDATE_SERIES', PREFIX.'exams/exam-series/update-series/');
define('URL_EXAM_SERIES_GET_EXAMS', PREFIX.'exams/exam-series/get-exams');


define('URL_STUDENT_EXAM_SERIES_LIST', PREFIX.'exams/student-exam-series/list');
define('URL_STUDENT_EXAM_SERIES_VIEW_ITEM', PREFIX.'exams/student-exam-series/');



define('URL_PAYMENTS_CHECKOUT', PREFIX.'payments/checkout/');


define('URL_PAYMENTS_LIST', PREFIX.'payments/list/');
define('URL_PAYNOW', PREFIX.'payments/paynow/');
define('URL_PAYPAL_PAYMENT_SUCCESS', PREFIX.'payments/paypal/status-success');
define('URL_PAYPAL_PAYMENT_CANCEL', PREFIX.'payments/paypal/status-cancel');

define('URL_PAYPAL_PAYMENTS_AJAXLIST', PREFIX.'payments/getList/');

define('URL_PAYU_PAYMENT_SUCCESS', PREFIX.'payments/payu/status-success');
define('URL_PAYU_PAYMENT_CANCEL', PREFIX.'payments/payu/status-cancel');
define('URL_UPDATE_OFFLINE_PAYMENT', PREFIX.'payments/offline-payment/update');

//COUPONS MODULE
define('URL_COUPONS', PREFIX.'coupons/list');
define('URL_COUPONS_ADD', PREFIX.'coupons/add');
define('URL_COUPONS_EDIT', PREFIX.'coupons/edit/');
define('URL_COUPONS_DELETE', PREFIX.'coupons/delete/');
define('URL_COUPONS_GETLIST', PREFIX.'coupons/getList');

define('URL_COUPONS_VALIDATE', PREFIX.'coupons/validate-coupon');
define('URL_COUPONS_USAGE', PREFIX.'coupons/get-usage');
define('URL_COUPONS_USAGE_AJAXDATA', PREFIX.'coupons/get-usage-data');



// Notifications Module
define('URL_ADMIN_NOTIFICATIONS', PREFIX.'admin/notifications');
define('URL_ADMIN_NOTIFICATIONS_ADD', PREFIX.'admin/notifications/add');
define('URL_ADMIN_NOTIFICATIONS_EDIT', PREFIX.'admin/notifications/edit/');
define('URL_ADMIN_NOTIFICATIONS_DELETE', PREFIX.'admin/notifications/delete/');
define('URL_ADMIN_NOTIFICATIONS_GETLIST', PREFIX.'admin/notifications/getList');

//Notifications Student
define('URL_NOTIFICATIONS', PREFIX.'notifications/list');
define('URL_NOTIFICATIONS_VIEW', PREFIX.'notifications/show/');




//LMS MODULE
define('URL_LMS_CATEGORIES', PREFIX.'lms/categories');
define('URL_LMS_CATEGORIES_ADD', PREFIX.'lms/categories/add');
define('URL_LMS_CATEGORIES_EDIT', PREFIX.'lms/categories/edit/');
define('URL_LMS_CATEGORIES_DELETE', PREFIX.'lms/categories/delete/');
define('URL_LMS_CATEGORIES_GETLIST', PREFIX.'lms/categories/getList');

// LMS CONTENT
define('URL_LMS_CONTENT', PREFIX.'lms/content');
define('URL_LMS_CONTENT_ADD', PREFIX.'lms/content/add');
define('URL_LMS_CONTENT_EDIT', PREFIX.'lms/content/edit/');
define('URL_LMS_CONTENT_DELETE', PREFIX.'lms/content/delete/');
define('URL_LMS_CONTENT_GETLIST', PREFIX.'lms/content/getList');


//LMS SERIES
define('URL_LMS_SERIES', PREFIX.'lms/series');
define('URL_LMS_SERIES_ADD', PREFIX.'lms/series/add');
define('URL_LMS_SERIES_DELETE', PREFIX.'lms/series/delete/');
define('URL_LMS_SERIES_EDIT', PREFIX.'lms/series/edit/');
define('URL_LMS_SERIES_AJAXLIST', PREFIX.'lms/series/getList');
define('URL_LMS_SERIES_UPDATE_SERIES', PREFIX.'lms/series/update-series/');
define('URL_LMS_SERIES_GET_SERIES', PREFIX.'lms/series/get-series');
define('VALID_IS_PAID_TYPE', PREFIX.'user/paid/');


//LMS STUDENT SERIES
define('URL_STUDENT_LMS_CATEGORIES', PREFIX.'learning-management/categories');
define('URL_STUDENT_LMS_CATEGORIES_VIEW', PREFIX.'learning-management/view/');
define('URL_STUDENT_LMS_SERIES', PREFIX.'learning-management/series');
define('URL_STUDENT_LMS_SERIES_VIEW', PREFIX.'learning-management/series/');


//Results Constants
define('URL_RESULTS_VIEW_ANSWERS', PREFIX.'student/exam/answers/');

 define('URL_COMPARE_WITH_TOPER', PREFIX.'toppers/compare-with-topper/');

// FEEDBACK SYSTEM
define('URL_FEEDBACK_SEND', PREFIX.'feedback/send');
define('URL_FEEDBACKS', PREFIX.'feedback/list');
define('URL_FEEDBACK_VIEW', PREFIX.'feedback/view-details/');
define('URL_FEEDBACK_DELETE', PREFIX.'feedback/delete/');
define('URL_FEEDBACKS_GETLIST', PREFIX.'feedback/getlist');

//MESSAGES
define('URL_MESSAGES', PREFIX.'messages');
define('URL_MESSAGES_SHOW', PREFIX.'messages/');
define('URL_MESSAGES_CREATE', PREFIX.'messages/create');


define('URL_GENERATE_CERTIFICATE', PREFIX.'result/generate-certificate/');


define('URL_PAYMENT_REPORTS', PREFIX.'payments-report/');
define('URL_ONLINE_PAYMENT_REPORTS', PREFIX.'payments-report/online');
define('URL_ONLINE_PAYMENT_REPORT_DETAILS', PREFIX.'payments-report/online/');
define('URL_ONLINE_PAYMENT_REPORT_DETAILS_AJAX', PREFIX.'payments-report/online/getList/');
define('URL_OFFLINE_PAYMENT_REPORTS', PREFIX.'payments-report/offline');
define('URL_OFFLINE_PAYMENT_REPORT_DETAILS', PREFIX.'payments-report/offline/');
define('URL_OFFLINE_PAYMENT_REPORT_DETAILS_AJAX', PREFIX.'payments-report/offline/getList/');

define('URL_PAYMENT_REPORT_EXPORT', PREFIX.'payments-report/export');
define('URL_GET_PAYMENT_RECORD', PREFIX.'payments-report/getRecord');
define('URL_PAYMENT_APPROVE_OFFLINE_PAYMENT', PREFIX.'payments/approve-reject-offline-request');


define('URL_SEND_SMS', PREFIX.'sms/index');
define('URL_SEND_SMS_NOW', PREFIX.'sms/send');

define('URL_FACEBOOK_LOGIN', PREFIX.'auth/facebook');
define('URL_GOOGLE_LOGIN', PREFIX.'auth/google');


