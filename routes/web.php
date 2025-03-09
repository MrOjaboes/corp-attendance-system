<?php



use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\FingerDevicesControlller;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');
Route::controller(LoginController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login/process', 'process')->name('login.process');
});
Route::get('attended/{user_id}', '\App\Http\Controllers\AttendanceController@attended')->name('attended');
Route::get('attended-before/{user_id}', '\App\Http\Controllers\AttendanceController@attendedBefore')->name('attendedBefore');
Auth::routes(['register' => false, 'reset' => false]);

Route::group(['middleware' => ['auth']], function () {
    Route::group(['middleware' => ['admin']], function () {
        Route::resource('/employees', '\App\Http\Controllers\EmployeeController');
        Route::get('/attendance', '\App\Http\Controllers\AttendanceController@index')->name('attendance');

        Route::get('/admin', '\App\Http\Controllers\AdminController@index')->name('admin');
        // Fingerprint Devices
        Route::resource('/finger_device', '\App\Http\Controllers\BiometricDeviceController');

        Route::delete('finger_device/destroy', '\App\Http\Controllers\BiometricDeviceController@massDestroy')->name('finger_device.massDestroy');
        Route::get('finger_device/{fingerDevice}/employees/add', '\App\Http\Controllers\BiometricDeviceController@addEmployee')->name('finger_device.add.employee');
        Route::get('finger_device/{fingerDevice}/get/attendance', '\App\Http\Controllers\BiometricDeviceController@getAttendance')->name('finger_device.get.attendance');
    });
    Route::group(['middleware' => ['staff']], function () {
        Route::controller(HomeController::class)->group(function () {
            Route::get('/home', 'index')->name('home');
            Route::get('/home/attendance', 'attendance')->name('staff.attendance');
            Route::post('/home/attendance', 'CheckStore')->name('staff.attendance-store');
        });
    });
    
    Route::controller(ProfileController::class)->prefix('profile')->group(function () {
        Route::get('/', 'index')->name('profile');
        Route::post('/update', 'updateProfile')->name('profile.update');
        Route::post('/password', 'updatePassword')->name('profile.update-password');
    });
});
