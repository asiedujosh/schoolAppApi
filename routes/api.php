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


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::post('/userLogin', [userController::class, 'login']);
// Route::post('/userStore', [userController::class, 'store']);
Route('/run-migration',function(){
    Artisan::call('optimize:clear');
    Artisan::call('migrate:fresh --seed');

    return "Migrations executed successfully";
});

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
Route::get('/searchExam', [examController::class,'searchExam']);
Route::get('/searchSubject', [subjectController::class,'searchSubject']);
Route::get('/searchYear', [yearController::class,'searchYear']);
Route::get('/searchQuestion', [questionController::class,'searchQuestion']);
Route::get('/searchTopic', [topicController::class,'searchTopic']);

//** Exams */
Route::get('/getAllExam',[examController::class, 'index']);
Route::get('/getAllSubject',[subjectController::class, 'index']);
Route::get('/getAllYear',[yearController::class, 'index']);
Route::get('/getAllTopic',[topicController::class, 'index']);
Route::get('/getAllQuestion',[questionController::class, 'index']);
Route::get('/countQuestions',[questionController::class, 'countQuestions']);
Route::get('/getSelectedQuestion',[questionController::class, 'selectedQuestions']);


/** Get Records */
Route::get('/getAllUsers',[userController::class, 'index']);
Route::get('/getAllStaff',[clientController::class, 'index']);
Route::get('/getRecordsOfUser', [quizRecordsController::class, 'quizRecordsOfUser']);
Route::get('/getRecordReview', [quizRecordsController::class, 'getRecordReview']);

Route::post('/addExam', [examController::class, 'store']);
Route::post('/addSubject', [subjectController::class, 'store']);
Route::post('/addYear', [yearController::class, 'store']);
Route::post('/addTopic', [topicController::class, 'store']);
Route::post('/addQuestion', [questionController::class, 'store']);

Route::post('/addQuizRecords', [quizRecordsController::class, 'store']);

/** Edit Records */
Route::put('/examsUpdate/{id}',[examController::class, 'updateExams']);
Route::put('/questionUpdate/{id}',[questionController::class, 'updateQuestion']);
Route::put('/subjectUpdate/{id}',[subjectController::class, 'updateSubject']);
Route::put('/yearUpdate/{id}',[yearController::class, 'updateYear']);
Route::put('/topicUpdate/{id}',[topicController::class, 'updateTopic']);

/**Delete Records  */
Route::delete('/deleteExams',[examController::class, 'deleteExams']);
Route::delete('/deleteQuestion',[questionController::class, 'deleteQuestion']);
Route::delete('/deleteSubject',[subjectController::class, 'deleteSubject']);
Route::delete('/deleteTopic',[topicController::class, 'deleteTopic']);
Route::delete('/deleteYear',[yearController::class, 'deleteYear']);
Route::delete('/deleteUser',[userController::class, 'deleteUser']);
Route::delete('/deleteStaff', [clientController::class, 'deleteClient']);


Route::middleware(['auth:sanctum'])->get('/retrieve', [clientController::class, 'getUserDetails']);
Route::post('/logout', [clientController::class, 'logout'])->middleware('auth:sanctum');



