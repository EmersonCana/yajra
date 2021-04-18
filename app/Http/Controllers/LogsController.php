<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Employee;
use App\Attendance;
use App\Logs;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class LogsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function logInOut(Request $request) {
        $log = new Logs;
        $employee = Employee::find($request->employee_id);
        if($employee) {
            $log->employee_id = $request->employee_id;
            $log->long = $request->long;
            $log->lat = $request->lat;
            $log->mac = "0:0:0:0:0:0";
            $log->ip = $request->ip;
            $log->agent = $request->agent;
            $log->save();

            $checkIfLogged = Attendance::where('employee_id','=',$request->employee_id)->whereDate('time_in', Carbon::today()->isoFormat('Y-M-D HH:mm:ss'));
            $getRecentLog = Logs::latest('created_at')->first();

            if($checkIfLogged->count() > 0) {
                $attendance = $checkIfLogged->first();
                $attendance->time_out = $getRecentLog->created_at;
                $attendance->save();

                $getEmployeeRate = Employee::find($attendance->employee_id)->rate;
                $st = Carbon::parse($attendance->start_time);
                $timein = Carbon::parse($attendance->time_in);
                $lates = $getEmployeeRate / 480 * $st->diffInMinutes($timein);
                $et = Carbon::parse($attendance->end_time);
                $timeout = Carbon::parse($attendance->time_out);
                $otOrUt = $getEmployeeRate/480*$et->diffInMinutes($timeout);
                if($timeout < $et) {
                    $attendance->pay = $getEmployeeRate - $lates - $otOrUt;
                }else{
                    $attendance->pay = $getEmployeeRate - $lates + $otOrUt;
                }
                $attendance->save();
                return redirect()->back()->with('success','Logged Out!');
            }else{
                $attendance = new Attendance;
                $attendance->employee_id = $request->employee_id;
                $attendance->time_in = $getRecentLog->created_at;
                $attendance->start_time = Carbon::parse('today 8am', 'Asia/Manila');
                $attendance->end_time = Carbon::parse('today 5pm', 'Asia/Manila');
                $attendance->long = $request->long;
                $attendance->lat = $request->lat;
                $attendance->save();
                return redirect()->back()->with('success','Login Success!');
            }
            
        }else{
            return redirect()->back()->with('error','Employee ID not found!');
        }
        
    }

}
