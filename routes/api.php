<?php

use App\Http\Controllers\Api\AnswerController;
use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\AudioController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ExamingController;
use App\Http\Controllers\Api\FormExamController;
use App\Http\Controllers\Api\MaterialController;
use App\Http\Controllers\Api\MaterialImgController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\QuestionController;
use App\Http\Controllers\Api\QuestionImageController;
use App\Http\Controllers\Api\StudentAnswerController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\UserPaymentController;
use App\Http\Controllers\Api\SitePhoneController;
use App\Http\Controllers\Api\SitelocationController;
use App\Http\Controllers\Api\SitemailController;
use App\Http\Controllers\Api\ImageController;
use App\Http\Controllers\Api\PaypalController;
use App\Http\Controllers\Api\ScoreController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::post('/login', [AuthController::class, 'login']);
Route::post('/signup', [AuthController::class, 'signup']);
Route::get('/activate/{token}', [ActivationController::class, 'activate']);


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });


    Route::controller(UserController::class)->group(function () {
        Route::apiResource('/users', UserController::class);
        Route::put('/usersActive/{user}', 'activeUser');
        Route::put('/usersDelete/{user}', 'deleteUser');
        // to Chart Api
        Route::get('/usersNumber', 'userNumber');
        Route::get('/usersDeleted', 'showDeletedUser');
    });



    Route::controller(FormExamController::class)->group(function () {
        Route::apiResource('/formExam', FormExamController::class);
        Route::get('/formExam-name/{form_name}', 'showByName');
        Route::get('/ActiveGeneralForms', 'getActiveGeneralForms');
        Route::get('/ActiveAcademyForms', 'ActiveAcademyForms');
        Route::get('/AcademicReadingExam', 'AcademicReadingExam');
        Route::get('/AcademicListeningExam', 'AcademicListeningExam');
        Route::get('/AcademicWritingExam', 'AcademicWritingExam');
        Route::get('/AcademicSpeakingExam', 'AcademicSpeakingExam');
        Route::get('/GeneralReadingExam', 'GeneralReadingExam');
        Route::get('/GeneralListeningExam', 'GeneralListeningExam');
        Route::get('/GeneralWritingExam', 'GeneralWritingExam');
        Route::get('/GeneralSpeakingExam', 'GeneralSpeakingExam');
        // to Chart Api
        Route::get('/formNumber', 'formNumber');
    });
    Route::controller(QuestionController::class)->group(function () {
        Route::apiResource('/question', QuestionController::class);
        Route::get('/formExam/{form_name}/question', 'showByForm');
    });
    Route::controller(MaterialController::class)->group(function () {
        Route::apiResource('/material', MaterialController::class)->except('update');
        Route::get('/formExam/{form_exams_id}/material',  'showByForm');
        Route::put('/formExam/{content}/update',  'update');
    });

    Route::controller(UserPaymentController::class)->group(function () {
        Route::apiResource('/UserPayment', UserPaymentController::class);
        Route::delete('/user-payments/{userPayment}',  'destroy');
        Route::get('/user/{user_id}/UserPayment',  'showByUser');
        Route::post('/UserTry', [UserPaymentController::class, 'tryStore']);
        // to Chart Api
        Route::get('/UserPaymentNumber', 'userPaymentNumber');
    });

    Route::controller(ExamingController::class)->group(function () {
        Route::apiResource('/examing', ExamingController::class);
        Route::get('/examingNumber', 'examingNumber');
        Route::get('/examingnotcorrection', 'examingUnCorrection');
        Route::get('/examingcorrection', 'examingCorrection');
        Route::get('/scoreExam/{examing}', 'showScore');
        Route::get('/userscoreExam/{examing}', 'showUserScore');
    });

    Route::controller(StudentAnswerController::class)->group(function () {
        Route::get('/form-examing/{form_id}/Students-answer', 'showByForm');
    });

    Route::controller(MessageController::class)->group(function () {
        Route::apiResource('/Message', MessageController::class);
        Route::delete('/Message-delete/{message}', 'destroy');
        Route::get('/Message-pending', 'messagePending');
        Route::put('/Message-update/{message}', 'update');
    });

    Route::controller(AppointmentController::class)->group(function () {
        Route::apiResource('/Appointment', AppointmentController::class);
        Route::put('/activeAppoint/{appointment}', 'activeAppoint');
        Route::delete('/Appointment-delete/{appointment}', 'destroy');
        Route::get('/Appointment-pending', 'Appointmentpending');
        Route::get('/Appointment-active', 'Appointmentactive');
        Route::get('/Appointment-InToday', 'AppointmentInToday');
        Route::get('/Appointment-done', 'Appointmentdone');
        Route::get('/Appointment-delete', 'Appointmentdelete');
    });

    Route::controller(PaypalController::class)->group(function () {
        Route::apiResource('/paypal', PaypalController::class);
        Route::put('/paypal-update/{paypal}', 'update');
    });

    Route::controller(ScoreController::class)->group(function () {
        Route::apiResource('/score', ScoreController::class);
        Route::get('/scoreGeneralReading', 'getGeneralReading');
        Route::get('/scoreAcademicReading', 'getAcademicReading');
        Route::get('/scoreListening', 'getListening');
        Route::put('/score-update/{score}', 'update');
    });

    Route::controller(MaterialImgController::class)->group(function () {
        Route::apiResource('/materialimage', MaterialImgController::class);
        Route::get('/materialimagegalary', 'gallery');
        Route::delete('/material-image/{materialImg}', 'destroy');
    });

    Route::controller(QuestionImageController::class)->group(function () {
        Route::apiResource('/questionimage', QuestionImageController::class);
        Route::get('/questionimagegalary', 'gallery');
        Route::delete('/question-image/{questionImage}', 'destroy');
    });

    Route::controller(ImageController::class)->group(function () {
        Route::apiResource('/image', ImageController::class);
        Route::get('/imagegalary', 'gallery');
        Route::delete('/image/{image}', 'destroy');
    });

    Route::controller(AudioController::class)->group(function () {
        Route::apiResource('/controlleraudio', AudioController::class);
        Route::delete('/controller-audio/{audio}', 'destroy');
    });

    Route::get('/formExam/{question_id}/answer', [AnswerController::class, 'showByQuestion']);
    Route::apiResource('/sitePhone', SitePhoneController::class);
    Route::apiResource('/siteEmail', SitemailController::class);
    Route::delete('/deleteEmail/{sitemail}', [SitemailController::class, 'destroy']);
    Route::apiResource('/siteLocation', SitelocationController::class);
    Route::delete('/deleteLocation/{sitelocation}', [SitelocationController::class, 'destroy']);
});