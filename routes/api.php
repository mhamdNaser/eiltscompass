<?php

use App\Http\Controllers\Api\AnswerController;
use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\AudioController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\api\ContactController;
use App\Http\Controllers\Api\ExamingController;
use App\Http\Controllers\Api\FormExamController;
use App\Http\Controllers\Api\GeneralController;
use App\Http\Controllers\Api\MaterialController;
use App\Http\Controllers\Api\MaterialImgController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\QuestionController;
use App\Http\Controllers\Api\QuestionImageController;
use App\Http\Controllers\Api\StudentAnswerController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\UserPaymentController;
use App\Http\Controllers\Api\ImageController;
use App\Http\Controllers\API\LanguageController;
use App\Http\Controllers\Api\PaymentMethodsController;
use App\Http\Controllers\Api\ScoreController;
use App\Http\Controllers\API\TranslationsController;
use App\Http\Controllers\Api\VideoController;
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
// Route::get('/activate/{token}', [ActivationController::class, 'activate']);


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Start Language Controller

    Route::controller(LanguageController::class)->group(function () {
        Route::get('/languages', 'index');
        Route::post('/language/store', 'store');
        Route::post('/language/update/{id}', 'update');
        Route::post('/language/show/{id}', 'show');
        Route::get('/language/update_default/{id}', 'update_default');
        Route::get('/language/delete/{id}', 'delete');
    });

    Route::controller(TranslationsController::class)->group(function () {
        Route::get('/translation',  'index');
        Route::post('/translation/show/{slug}', 'show');
        Route::post('/translation/update/{slug}', 'update');
        Route::post('/translation/store', 'store');
    });


    Route::controller(UserController::class)->group(function () {
        Route::apiResource('/users', UserController::class);
        Route::put('/usersActive/{user}', 'activeUser');
        Route::post('/usersDelete', 'deleteUser');
        Route::post('/resetUser', 'resetUser');
        // to Chart Api
        Route::get('/usersNumber', 'userNumber');
        Route::get('/usersDeleted', 'showDeletedUser');
    });

    Route::controller(PaymentMethodsController::class)->group(function () {
        Route::apiResource('/paymentMethod', PaymentMethodsController::class);
    });



    Route::controller(FormExamController::class)->group(function () {
        Route::apiResource('/formExam', FormExamController::class);
        Route::get('/formExam-name/{form_name}', 'showByName');
        // Route::get('/ActiveGeneralForms', 'getActiveGeneralForms');
        // Route::get('/ActiveAcademyForms', 'ActiveAcademyForms');
        // Route::get('/AcademicReadingExam', 'AcademicReadingExam');
        // Route::get('/AcademicListeningExam', 'AcademicListeningExam');
        // Route::get('/AcademicWritingExam', 'AcademicWritingExam');
        // Route::get('/AcademicSpeakingExam', 'AcademicSpeakingExam');
        // Route::get('/GeneralReadingExam', 'GeneralReadingExam');
        // Route::get('/GeneralListeningExam', 'GeneralListeningExam');
        // Route::get('/GeneralWritingExam', 'GeneralWritingExam');
        // Route::get('/GeneralSpeakingExam', 'GeneralSpeakingExam');
        // to Chart Api
        Route::get('/formNumber', 'formNumber');
    });
    Route::controller(QuestionController::class)->group(function () {
        Route::apiResource('/question', QuestionController::class);
        Route::get('/formExam/{form_name}/question', 'showByForm');
    });

    Route::post('/material/store', [MaterialController::class, 'storeMaterial']);
    Route::get('/material/showbyid/{id}', [MaterialController::class, 'showbyid']);
    Route::get('/formExam/{form_exams_id}/material', [MaterialController::class, 'showByForm']);
    Route::put('/formExam/{content}/update', [MaterialController::class, 'update']);
    Route::get('/formExam/delete/{id}', [MaterialController::class, 'deleteMaterial']);


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
        Route::apiResource('/Message', MessageController::class)->except(['destroy']);
        Route::delete('/Message/deleteMessage', 'deleteMessage');
        Route::get('/Message-pending', 'messagePending');
        Route::put('/Message/MessageStatus/{message}', 'updateStatus');
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
        Route::delete('/image/{image}', 'destroy');
    });

    Route::controller(AudioController::class)->group(function () {
        Route::apiResource('/audio', AudioController::class);
        Route::delete('/audio/{audio}', 'destroy');
    });

    Route::controller(VideoController::class)->group(function () {
        Route::apiResource('/video', VideoController::class);
        Route::delete('/video/{video}', 'destroy');
    });

    Route::controller(GeneralController::class)->group(function () {
        Route::get('/cacheRoutes', 'cacheRoutes');
        Route::get('/cacheConfig', 'cacheConfig');
        Route::get('/ClearView', 'ClearView');
        Route::get('/ClearRoute', 'ClearRoute');
        Route::get('/BackupDatabase', 'BackupDatabase');
        Route::get('/restartServer', 'restartServer');
    });

    Route::controller(ContactController::class)->group(function () {
        Route::apiResource('/Contact', ContactController::class);
        Route::delete('/DeleteContact/{contact}', [ContactController::class, 'destroy']);
    });

    Route::get('/formExam/{question_id}/answer', [AnswerController::class, 'showByQuestion']);
});