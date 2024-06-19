<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;
use App\Http\Controllers\clientController;
use App\Http\Controllers\examController;
use App\Http\Controllers\subjectController;
use App\Http\Controllers\yearController;
use App\Http\Controllers\topicController;
use App\Http\Controllers\questionController;
use App\Http\Controllers\quizRecordsController;
use App\Http\Controllers\oralQuizRecordsController;
use App\Http\Controllers\packageController;
use App\Http\Controllers\priviledgeController;
use App\Http\Controllers\newsController;
use App\Http\Controllers\examSubjectPriceController;
use App\Http\Controllers\CodeCheckController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\ForgotPasswordController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::post('/userLogin', [userController::class, 'login']);
// Route::post('/userStore', [userController::class, 'store']);
// Route('/run-migration',function(){
//     Artisan::call('optimize:clear');
//     Artisan::call('migrate:fresh --seed');

//     return "Migrations executed successfully";
// });



// Password reset routes
Route::post('password/email',  [ForgotPasswordController::class, 'index']);
Route::post('password/code/check', CodeCheckController::class);
Route::post('password/reset', [ResetPasswordController::class, 'index']);



Route::get('/',[clientController::class, 'index']);
/*** Users Route */
Route::post('/mobileLogin', [userController::class, 'login']);
Route::post('/mobileRegister', [userController::class, 'store']);

/** Workers Route */
Route::post('/workerLogin', [clientController::class, 'login']);
Route::post('/workerRegister',[clientController::class, 'store']);

/** Search */
Route::get('/searchUser', [userController::class,'searchUser']);
Route::get('/searchClient', [userController::class,'searchClient']);
Route::get('/searchExam', [examController::class, 'searchExam']);
Route::get('/searchSubject', [subjectController::class, 'searchSubject']);
Route::get('/searchYear', [yearController::class, 'searchYear']);
Route::get('/searchDuration', [examSubjectPriceController::class, 'searchDuration']);
Route::get('/searchExamSubject', [examSubjectPriceController::class, 'searchExamSubjectLink']);
Route::get('/searchPricing', [examSubjectPriceController::class, 'searchPricing']);
Route::get('/searchQuestion', [questionController::class, 'searchQuestion']);
Route::get('/searchOralQuestion', [questionController::class, 'searchOralQuestion']);
Route::get('/searchTopic', [topicController::class, 'searchTopic']);
Route::get('/searchPriviledge', [priviledgeController::class, 'searchPriviledge']);

/** Check Whether question no is assigned */
Route::get('/checkQuestionNo',[questionController::class,'checkQuestionNo']);
Route::get('/checkOralQuestionNo',[questionController::class,'checkOralQuestionNo']);
Route::get('/checkYearAvailability',[yearController::class, 'checkYearAvailability']);
Route::get('/checkExamAvailability',[examController:: class, 'checkExamAvailability']);
Route::get('/checkSubjectAvailability',[subjectController:: class, 'checkSubjectAvailability']);


Route::get('/getAllPackage',[packageController::class, 'index']);
Route::get('/getAllNews', [newsController::class, 'index']);
Route::get('/currentPackage', [packageController::class, 'getCurrentPackage']);


//** Exams */
Route::get('/mobileGetAllExam',[examController::class, 'mobileIndex']);
Route::get('/getAllExam',[examController::class, 'index']);

Route::get('/mobileGetAllSubject',[subjectController::class, 'mobileIndex']);
Route::get('/getAllSubject',[subjectController::class, 'index']);

Route::get('/mobileGetAllYear',[yearController::class, 'mobileIndex']);
Route::get('/getAllYear',[yearController::class, 'index']);

Route::get('/mobileGetAllTopic',[topicController::class, 'mobileIndex']);
Route::get('/getAllTopic',[topicController::class, 'index']);

Route::get('/mobileGetAllLinkedExamSubject',[examSubjectPriceController::class, 'mobileIndex']);
Route::get('/getAllLinkedExamSubject',[examSubjectPriceController::class, 'index']);


Route::get('/getAllPriviledge',[priviledgeController::class, 'index']);
Route::get('/getAllQuestion',[questionController::class, 'index']);
Route::get('/getAllOralQuestion',[questionController::class, 'getOralQuestions']);
Route::get('/countQuestions',[questionController::class, 'countQuestions']);
Route::get('/countOralQuestions',[questionController::class, 'countOralQuestions']);
Route::get('/countSubscribers',[packageController::class, 'countSubscribers']);
Route::get('/getSelectedQuestion',[questionController::class, 'selectedQuestions']);
Route::get('/getSelectedOralQuestion',[questionController::class, 'selectedOralQuestions']);

Route::get('/userPurchases', [examSubjectPriceController::class, 'getPurchases']);
Route::get('/getDuration',[examSubjectPriceController::class, 'getDuration']); 
Route::get('/getAllDuration',[examSubjectPriceController::class, 'getDurationPagination']);
Route::get('/getPricing', [examSubjectPriceController::class, 'getPricing']);
Route::get('/getAllPricing', [examSubjectPriceController::class, 'getPricingAll']);
Route::get('/getMySubscription', [examSubjectPriceController::class, 'getMySubscription']);


/** Get Records */
Route::get('/getAllUsers',[userController::class, 'index']);
Route::get('/getAllStaff',[clientController::class, 'index']);
Route::get('/getRecordsOfUser', [quizRecordsController::class, 'quizRecordsOfUser']);
Route::get('/getRecordReview', [quizRecordsController::class, 'getRecordReview']);
Route::get('/getAllSubscribers',[packageController::class, 'getSubscribers']);


/** Get oral quiz records */
Route::get('/getOralRecordsOfUser', [oralQuizRecordsController::class, 'quizOralRecordsOfUser']);
Route::get('/getOralRecordReview', [oralQuizRecordsController::class, 'getOralRecordReview']);


/**Reset Password */
Route::post('passwordForgot', [forgotPasswordController::class, 'sendResetLinkEmail']);
Route::post('passwordReset', [resetPasswordController::class, 'reset']);
/** End reset Password */

Route::post('/addPricePackage', [packageController::class, 'store']);
Route::post('/addExam', [examController::class, 'store']);
Route::post('/addSubject', [subjectController::class, 'store']);
Route::post('/addYear', [yearController::class, 'store']);
Route::post('/addTopic', [topicController::class, 'store']);
Route::post('/addQuestion', [questionController::class, 'store']);
Route::post('/addNews', [newsController::class, 'addNews']);
Route::post('/addQuizRecords', [quizRecordsController::class, 'store']);
Route::post('/addOralQuizRecords', [oralQuizRecordsController::class, 'store']);
Route::post('/linkExamSubject',[examSubjectPriceController::class, 'store']);
Route::post('/storePurchases',[examSubjectPriceController::class, 'storePurchases']);
Route::post('/addDuration',[examSubjectPriceController::class, 'storeDuration']);
Route::post('/storePricing',[examSubjectPriceController::class, 'storePricing']);
Route::post('/subscribe',[examSubjectPriceController::class, 'subscribe']);
Route::post('/addOralQuestion', [questionController::class, 'storeOralQuestion']);
Route::post('/storePriviledge',[priviledgeController::class, 'store']);

/** Edit Records */

/** Special case */
Route::post('/oralQuestionUpdate/{id}',[questionController::class, 'updateOralQuestion']);
/** End Special Case */
Route::put('/clientUpgradePackage/{id}',[packageController::class, 'updateClientPackage']);
Route::put('/staffUpdate/{id}', [clientController::class, 'updateClient']);
Route::put('/packageUpdate/{id}',[packageController::class, 'updatePackage']);
Route::put('/examsUpdate/{id}',[examController::class, 'updateExams']);
Route::put('/questionUpdate/{id}',[questionController::class, 'updateQuestion']);
Route::put('/priviledgeUpdate/{id}',[priviledgeController::class, 'updatePriviledge']);
Route::put('/subjectUpdate/{id}',[subjectController::class, 'updateSubject']);
Route::put('/yearUpdate/{id}',[yearController::class, 'updateYear']);
Route::put('/topicUpdate/{id}',[topicController::class, 'updateTopic']);
Route::put('/updateNews/{id}',[newsController::class, 'updateNews']);
Route::put('/linkExamSubjectUpdate/{id}',[examSubjectPriceController::class, 'updateExamSubjectLink']);
Route::put('/durationUpdate/{id}',[examSubjectPriceController::class, 'updateDuration']);
Route::put('/pricingUpdate/{id}',[examSubjectPriceController::class, 'updatePricing']);

/**Delete Records  */
Route::delete('/deletePackage/{id}',[packageController::class, 'deletePackage']);
Route::delete('/deleteOralQuestion/{id}',[questionController::class, 'deleteOralQuestion']);
Route::delete('/deleteExams/{id}',[examController::class, 'deleteExams']);
Route::delete('/deleteQuestion/{id}',[questionController::class, 'deleteQuestion']);
Route::delete('/deleteSubject/{id}',[subjectController::class, 'deleteSubject']);
Route::delete('/deleteTopic/{id}',[topicController::class, 'deleteTopic']);
Route::delete('/deleteYear/{id}',[yearController::class, 'deleteYear']);
Route::delete('/deleteUser/{id}',[userController::class, 'deleteUser']);
Route::delete('/deleteStaff/{id}', [clientController::class, 'deleteClient']);
Route::delete('/deleteRecord/{id}', [quizRecordsController::class, 'deleteRecords']);
Route::delete('/deleteOralRecord/{id}', [oralQuizRecordsController::class, 'deleteOralRecords']);
Route::delete('/deleteNews/{id}', [newsController::class, 'deleteNews']);
Route::delete('/deleteExamSubjectLink/{id}', [examSubjectPriceController::class, 'deleteExamSubjectLink']);
Route::delete('/deleteDuration/{id}', [examSubjectPriceController::class, 'deleteDuration']);
Route::delete('/deletePricing/{id}', [examSubjectPriceController::class, 'deletePricing']);
Route::delete('/deletePriviledge/{id}', [priviledgeController::class, 'deletePriviledge']);


Route::middleware(['auth:sanctum'])->get('/retrieve', [clientController::class, 'getUserDetails']);
Route::post('/logout', [clientController::class, 'logout'])->middleware('auth:sanctum');



