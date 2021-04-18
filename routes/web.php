<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/timein', function(Request $request) {
    $macaddress = substr(exec('getmac'), 0, 17);
    return view('timein', compact(['macaddress']));
});

Route::match(['PUT','POST'], '/time-in-or-out', 'LogsController@logInOut')->name('timeInOut');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/payroll', 'HomeController@viewPayroll')->name('payroll');

Route::post('/functions/add-employee', 'HomeController@addEmployee')->name('addEmployee');
Route::match(['PUT','POST'],'/functions/edit-employee/{id}', 'HomeController@editEmployee')->name('editEmployee');
Route::match(['DELETE','POST'],'/functions/delete-employee/{id}', 'HomeController@deleteEmployee')->name('deleteEmployee');

Route::get('/function/list-attendance','HomeController@listAttendance')->name('listAttendance');
Route::match(['get','POST'],'/functions/add-attendance','HomeController@addAttendance')->name('addAttendance');
Route::match(['PUT','POST'],'/functions/edit-attendance','HomeController@editAttendance')->name('editAttendance');
Route::get('/endpoint/record-summary','HomeController@recordSummary')->name('recordSummary');
Route::get('/endpoint/daily-summary/{date}','HomeController@dailySummary')->name('dailySummary');

Route::get('/function/get-from-dates/{from}/{to}','HomeController@getFromDates')->name('getFromDates');
