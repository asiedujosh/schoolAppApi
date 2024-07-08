<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;
use App\Http\Controllers\clientController;
use App\Http\Controllers\examController;
use App\Http\Controllers\subjectController;
use App\Http\Controllers\yearController;
use App\Http\Controllers\topicController;
use App\Http\Controllers\notificationController;
use App\Http\Controllers\sliderController;
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
use App\Http\Controllers\pagesController;


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
Route::get('/getAllSlider', [sliderController::class, 'index']);
Route::get('/mobileGetAllLinkedExamSubject',[examSubjectPriceController::class, 'mobileIndex']);
Route::get('/getAllLinkedExamSubject',[examSubjectPriceController::class, 'index']);

Route::get('/getAllMessage', [notificationController::class, 'index']);
Route::get('/getAllPriviledge',[priviledgeController::class, 'index']);
Route::get('/getAllMobilePriviledge',[priviledgeController::class, 'mobileIndex']);
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
Route::get('/getAbout', [pagesController::class, 'getAbout']);
Route::get('/getTeam', [pagesController::class, 'getTeam']);
Route::get('/getTNC', [pagesController::class, 'getTNC']);
Route::get('/getContact', [pagesController::class, 'getContact']);
Route::get('/getTestimonial',[pagesController::class, 'getTestimonial']);
Route::get('/getHeroBanner', [pagesController::class, 'getHeroBanner']);
Route::get('/getProducts', [pagesController::class, 'getProducts']);
Route::get('/getBannerType', [pagesController::class, 'getBannerType']);


/** Get oral quiz records */
Route::get('/getOralRecordsOfUser', [oralQuizRecordsController::class, 'quizOralRecordsOfUser']);
Route::get('/getOralRecordReview', [oralQuizRecordsController::class, 'getOralRecordReview']);


/**Reset Password */
Route::post('passwordForgot', [forgotPasswordController::class, 'sendResetLinkEmail']);
Route::post('passwordReset', [resetPasswordController::class, 'reset']);
/** End reset Password */

Route::post('/addMessage', [notificationController::class, 'store']);
Route::post('/addSlider', [notificationController::class, 'store']);
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
Route::post('/addAbout', [pagesController::class, 'addAbout']);
Route::post('/addTeam', [pagesController::class, 'addTeam']);
Route::post('/addTnc', [pagesController::class, 'addTnc']);
Route::post('/addContact', [pagesController::class, 'addContact']);
Route::post('/addTestimonial', [pagesController::class, 'addTestimonial']);
Route::post('/addHeroBanner', [pagesController::class, 'addHeroBanner']);
Route::post('/addProducts', [pagesController::class, 'addProducts']);
Route::post('/addBannerType', [pagesController::class, 'addBannerType']);

/** Edit Records */

/** Special case */
Route::post('/oralQuestionUpdate/{id}',[questionController::class, 'updateOralQuestion']);
/** End Special Case */
Route::put('/sliderUpdate/{id}',[sliderController::class, 'updateSlider']);
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
Route::put('/updateUser/{id}',[userController::class, 'updateUser']);
Route::put('/updatePassword/{id}',[userController::class, 'updatePassword']);
Route::put('/linkExamSubjectUpdate/{id}',[examSubjectPriceController::class, 'updateExamSubjectLink']);
Route::put('/durationUpdate/{id}',[examSubjectPriceController::class, 'updateDuration']);
Route::put('/pricingUpdate/{id}',[examSubjectPriceController::class, 'updatePricing']);
Route::put('/aboutUpdate/{id}', [pagesController::class, 'updateAbout']);
Route::put('/teamUpdate/{id}', [pagesController::class, 'updateTeam']);
Route::put('/tncUpdate/{id}', [pagesController::class, 'updateTnc']);
Route::put('/contactUpdate/{id}', [pagesController::class, 'updateContact']);
Route::put('/testimonialUpdate/{id}', [pagesController::class, 'updateTestimonial']);
Route::put('/heroBannerUpdate/{id}', [pagesController::class, 'updateHeroBanner']);
Route::put('/productsUpdate/{id}', [pagesController::class, 'updateProducts']);
Route::put('/bannerTypeUpdate/{id}', [pagesController::class, 'updateBannerType']);

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
Route::delete('/deleteRecord', [quizRecordsController::class, 'deleteRecords']);
Route::delete('/deleteOralRecord', [oralQuizRecordsController::class, 'deleteOralRecords']);
Route::delete('/deleteNews/{id}', [newsController::class, 'deleteNews']);
Route::delete('/deleteExamSubjectLink/{id}', [examSubjectPriceController::class, 'deleteExamSubjectLink']);
Route::delete('/deleteDuration/{id}', [examSubjectPriceController::class, 'deleteDuration']);
Route::delete('/deletePricing/{id}', [examSubjectPriceController::class, 'deletePricing']);
Route::delete('/deletePriviledge/{id}', [priviledgeController::class, 'deletePriviledge']);
Route::delete('/deleteMessage/{id}', [notificationController::class, 'deleteNotification']);
Route::delete('/deleteSlider/{id}', [sliderController::class, 'deleteSlider']);
Route::delete('/deleteAbout/{id}', [pagesController::class, 'deleteAbout']);
Route::delete('/deleteTeam/{id}', [pagesController::class, 'deleteTeam']);
Route::delete('/deleteTnc/{id}', [pagesController::class, 'deleteTnc']);
Route::delete('/deleteContact/{id}', [pagesController::class, 'deleteContact']);
Route::delete('/deleteTestimonial/{id}', [pagesController::class, 'deleteTestimonial']);
Route::delete('/deleteHeroBanner/{id}', [pagesController::class, 'deleteHeroBanner']);
Route::delete('/deleteProducts/{id}', [pagesController::class, 'deleteProducts']);
Route::delete('/deleteBannerType/{id}', [pagesController::class, 'deleteBannerType']);


Route::middleware(['auth:sanctum'])->get('/retrieve', [clientController::class, 'getUserDetails']);
Route::post('/logout', [clientController::class, 'logout'])->middleware('auth:sanctum');



