<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Employee;
use App\Attendance;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function viewPayroll() {
        $employees = Employee::all();
        $attendance = Attendance::whereDate('time_in','=',Carbon::today()->isoFormat('Y-M-D'))->get();
        $summary = array();
        
        foreach($attendance as $a) {
            $to = '';
            if(!isset($a->time_out)) {
                $to = null;
            }else{
                $to = Carbon::parse($a->time_out)->format('g:i A');
            }
            $summary[] = array('fullname' => Employee::find($a->employee_id)->last_name.', '.Employee::find($a->employee_id)->first_name.' '.Employee::find($a->employee_id)->middle_initial, 'timein' => Carbon::parse($a->time_in)->format('g:i A'), 'st' => $a->start_time, 'timeout' => $to, 'et' => $a->end_time, 'rate' => Employee::find($a->employee_id)->rate);
        }


        
        
        return view('payroll', compact(['employees', 'attendance', 'summary']));
    }

    public function recordSummary() {
        $attendance = Attendance::whereDate('time_in','=',Carbon::today()->isoFormat('Y-M-D'))->get();
        
        foreach($attendance as $a) {
            $to = '';
            if(!isset($a->time_out)) {
                $to = null;
            }else{
                $to = Carbon::parse($a->time_out)->format('g:i A');
            }
            $summary[] = array('fullname' => Employee::find($a->employee_id)->last_name.', '.Employee::find($a->employee_id)->first_name.' '.Employee::find($a->employee_id)->middle_initial, 'timein' => Carbon::parse($a->time_in)->format('g:i A'), 'st' => $a->start_time, 'timeout' => $to, 'et' => $a->end_time, 'rate' => Employee::find($a->employee_id)->rate);
        }

        return view('includes.contents.endpoints.record-summary', compact(['summary']));
    }

    public function addEmployee(Request $request) {
        $employee = new Employee;
        $employee->first_name = $request->first_name;
        $employee->middle_initial = $request->middle_initial;
        $employee->last_name = $request->last_name;
        $employee->position = $request->position;
        $employee->rate = $request->rate;
        $employee->save();
        return redirect()->back()->with('success','Employee Added Successfully!');
    }

    public function editEmployee(Request $request, $id) {
        $employee = Employee::find($id);
        $employee->first_name = $request->edit_first_name;
        $employee->middle_initial = $request->edit_middle_initial;
        $employee->last_name = $request->edit_last_name;
        $employee->position = $request->edit_position;
        $employee->rate = $request->edit_rate;
        $employee->save();
        return redirect()->back()->with('success','Employee Edited Successfully!');
    }

    public function deleteEmployee($id) {
        $employee = Employee::find($id);
        $employee->delete();
        return redirect()->back()->with('success','Employee Deleted Successfully!');
    }

    public function dailySummary($date) {
        $attendance = Attendance::whereDate('time_in','=',Carbon::parse($date)->isoFormat('Y-M-D'))->get();

        return view('includes.contents.endpoints.daily-summary', compact(['attendance']));
    }

    public function deleteAttendance($id) {
        $attendance = Attendance::find($id);
        $attendance->delete();
        return redirect()->back()->with('success','Attendance Deleted Successfully!');
    }

    public function listAttendance() {
        $attendance = Attendance::whereDate('time_in','=',Carbon::today()->isoFormat('Y-M-D'))->get();
        
        foreach($attendance as $a) {
            echo '
                <tr>
                    <td>'.Employee::find($a->employee_id)->last_name.', '.Employee::find($a->employee_id)->first_name.' '.Employee::find($a->employee_id)->middle_initial.'</td>
                    <td>'.Carbon::parse($a->time_in)->format('g:i A').'</td>
                    <td>';
                        if($a->time_out){
                            echo Carbon::parse($a->time_out)->format('g:i A');
                        }else{
                            echo '<a href="#" id="add-time-out-'.$a->id.'">Add Time Out</a>
                            <input type="time" class="form-control" id="add-time-out-input-'.$a->id.'">
                            ';
                        }
                    echo '
                    </td>
                    <td>
                        <a href="#" data-toggle="modal" data-target=".bd-example-modal-sm">Show Location</a>
                        <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                <iframe src="http://maps.google.com/maps?q='.$a->lat.','.$a->long.'&z=16&output=embed" frameborder="0"></iframe>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <a onclick="deleteAttendance()">&times;</a>
                    </td>
                </tr>
                <script>
                    function deleteAttendance() {
                        $.ajax({
                            url: "functions/delete-attendance/'.$a->id.'",
                            type: "POST",
                            dataType: "html",
                            data: { 
                                "_DELETE": "'.csrf_token() .'"
                            },
                            success: function(data){
                                console.log(data);
                                reloadRecord();
                            },
                            error: function(xhr, status, error) {
                                var err = eval("(" + xhr.responseText + ")");
                                alert(err.Message);
                                console.log(not);
                            }
                        });
                    }
                    $("#add-time-out-input-'.$a->id.'").hide();
                    $("#add-time-out-'.$a->id.'").click( () => {
                        $("#add-time-out-input-'.$a->id.'").show();
                        $("#add-time-out-'.$a->id.'").hide();
                        $("#add-time-out-input-'.$a->id.'").focus();
                    });
                    $("#add-time-out-input-'.$a->id.'").blur( () => {
                        $("#add-time-out-input-'.$a->id.'").hide();
                        $("#add-time-out-'.$a->id.'").show();
                    });
                    $("#add-time-out-input-'.$a->id.'").keyup( (e) => {
                        e.preventDefault()
                        if(e.keyCode == 13) {
                            console.log("enter works");
                            $.ajax({
                                url: "functions/edit-attendance",
                                type: "POST",
                                dataType: "html",
                                data: { 
                                    "_PUT": "'.csrf_token() .'",
                                    "attendanceID" : "'.$a->id.'",
                                    "timeOut" : $("#add-time-out-input-'.$a->id.'").val()
                                    
                                },
                                success: function(data){
                                    console.log(data);
                                    $("#update-attendance").html(data);
                                    ("#add-time-out-input-'.$a->id.'").hide();
                                    ("#add-time-out-'.$a->id.'").show();
                                    reloadRecord();
                                },
                                error: function(xhr, status, error) {
                                    var err = eval("(" + xhr.responseText + ")");
                                    alert(err.Message);
                                    console.log(not);
                                }
                            });
                        }
                    });
                </script>
            ';
        }
    }

    public function addAttendance(Request $request) {
        $attendance = new Attendance;
        $attendance->employee_id = $request->employeeID;
        $attendance->time_in = Carbon::parse($request->timeIn)->isoFormat('Y-M-D HH:mm:ss');
        $attendance->start_time = Carbon::parse('today 8am', 'Asia/Manila');
        $attendance->end_time = Carbon::parse('today 5pm', 'Asia/Manila');
        $attendance->long = $request->long;
        $attendance->lat = $request->lat;
        $attendance->save();

        return redirect()->route('listAttendance');
        
    }

    public function editAttendance(Request $request) {
        $attendance = Attendance::find($request->attendanceID);
        $attendance->time_out = Carbon::parse($request->timeOut)->isoFormat('Y-M-D HH:mm:ss');
        $attendance->save();

        $attendance = Attendance::find($request->attendanceID);
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

        return redirect()->route('listAttendance');
    }
    

    public function getFromDates($from, $to) {
        $att = Attendance::all();
        
        $start = Carbon::parse($from);
        $end = Carbon::parse($to);
        
        $dateRange = CarbonPeriod::create($start, $end);

        $dates = [];

        foreach($dateRange as $date) {
            $dates[] = $date->format('Y-m-d');
        }
        $date_id = 1;
        echo '
        <button type="button" data-toggle="modal" data-target="#paySlipPrint" class="btn btn-danger btn-sm">Batch Print</button>
        <div class="modal fade bd-example-modal-lg" id="paySlipPrint" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                <div class="row">
                    <div class="col-12">
                        <div id="paper">
                            <div class="p-3 text-right">
                                <a href="#" id="print-ps" class="btn btn-warning btn-sm">Print</a>
                                <script>
                                    $("#print-ps").click(function(e) {
                                        e.preventDefault();
                                        $("#payslip").printElement({
                                        wrapper: {
                                            css: "extend",
                                            wrapper: "<div><span class=small>Report Generated Automatically</span><div id=wrapper></div></div>", // the element that going to be wrap `#contacts`
                                            selector: "#wrapper", // inside the `#wrapper` id it will wrap
                                        }
                                        });
                                    });
                                </script>
                            </div>
                            <div class="container p-3" id="payslip">';
                            foreach(Employee::all() as $employee) {
                                $datesCount = 0;
                                foreach($dates as $dc) {
                                    $datesCount += 1;
                                }
                                $ea = Attendance::where('employee_id','=',$employee->id)->whereBetween('time_in', [$start->isoFormat("Y-M-D HH:mm:ss"), $end->isoFormat("Y-M-D HH:mm:ss")])->count();
                                $lt = Attendance::where('employee_id','=',$employee->id)->whereBetween('time_in', [$start->isoFormat("Y-M-D HH:mm:ss"), $end->isoFormat("Y-M-D HH:mm:ss")])->get();
                                $lates = 0;
                                $overtime = 0;
                                $total_pay = 0;
                                foreach($lt as $l) {
                                    $lates += Carbon::parse($l->start_time)->diffInMinutes(Carbon::parse($l->time_in));
                                    if($l->time_out >= $l->end_time) {
                                        $overtime += Carbon::parse($l->end_time)->diffInMinutes(Carbon::parse($l->time_out));
                                    }else{
                                        $overtime -= Carbon::parse($l->end_time)->diffInMinutes(Carbon::parse($l->time_out));
                                    }
                                    $total_pay += $l->pay;
                                    
                                }
                                $absents = $datesCount - $ea;
                                echo '
                                <div class="card bordered">
                                    <div class="card-body">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="h5">'.$employee->last_name.', '.$employee->first_name.' '.$employee->middle_initial.'.</div>
                                                    <span class="small">'.$start->format('Y-M-d').' - '.$end->format('Y-M-d').'</span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    Days Rendered: '.$ea.'<br>
                                                    Total Absents: '.$absents.'<br>
                                                    Total Lates (Minutes/Deduction): '.$lates.' mins/P '.number_format($employee->rate/480*$lates, 2, '.','').'<br>
                                                </div>
                                                <div class="col-6">
                                                    Overtime: '; if($overtime < 0) { echo 0; }else{ echo $overtime.' mins/P '.number_format($employee->rate/480*$overtime, 2, '.',''); } echo '<br>
                                                    Undertime: '; if($overtime < 0) { echo $overtime.' mins/P '.number_format($employee->rate/480*$overtime, 2, '.',''); }else{ echo 0; } echo '<br>
                                                    Rate: P '.number_format($employee->rate, 2, '.','').'<br>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6 offset-6">
                                                    <strong>Total Pay: P '.number_format($total_pay, 2, '.','').'</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                ';
                            }
                            echo '
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
        <table class="table table-stripped" style="font-size: 15px; font-variant: all-small-caps; font-weight: bold;">
            <thead class="thead-dark">
                <tr class="small">
                    <th scope="col">Full Name</th>
                    <th scope="col">Days Rendered</th>
                    <th scope="col">Total Absents</th>
                    <th scope="col">Lates</th>
                    <th scope="col">Overtime</th>
                    <th scope="col">Undertime</th>
                    <th scope="col">Rate/Day</th>
                    <th scope="col">Total Pay</th>
                    ';
        echo'
                </tr>
            </thead>
            <tbody>';
                foreach(Employee::all() as $employee) {
                    $datesCount = 0;
                    foreach($dates as $dc) {
                        $datesCount += 1;
                    }
                    $ea = Attendance::where('employee_id','=',$employee->id)->whereBetween('time_in', [$start->isoFormat("Y-M-D HH:mm:ss"), $end->isoFormat("Y-M-D HH:mm:ss")])->count();
                    $lt = Attendance::where('employee_id','=',$employee->id)->whereBetween('time_in', [$start->isoFormat("Y-M-D HH:mm:ss"), $end->isoFormat("Y-M-D HH:mm:ss")])->get();
                    $lates = 0;
                    $overtime = 0;
                    $total_pay = 0;
                    foreach($lt as $l) {
                        $lates += Carbon::parse($l->start_time)->diffInMinutes(Carbon::parse($l->time_in));
                        if($l->time_out >= $l->end_time) {
                            $overtime += Carbon::parse($l->end_time)->diffInMinutes(Carbon::parse($l->time_out));
                        }else{
                            $overtime -= Carbon::parse($l->end_time)->diffInMinutes(Carbon::parse($l->time_out));
                        }
                        $total_pay += $l->pay;
                        
                    }
                    $absents = $datesCount - $ea;
                    echo '
                        <tr>
                            <td>'.$employee->last_name.', '.$employee->first_name.' '.$employee->middle_initial.'.</td>
                            <td>'.$ea.'</td>
                            <td>'.$absents.'</td>
                            <td>'.$lates.' mins/P '.number_format($employee->rate/480*$lates, 2, '.','').'</td>
                            <td>'; if($overtime < 0) { echo 0; }else{ echo $overtime.' mins/P '.number_format($employee->rate/480*$overtime, 2, '.',''); } echo '</td>
                            <td>'; if($overtime < 0) { echo $overtime.' mins/P '.number_format($employee->rate/480*$overtime, 2, '.',''); }else{ echo 0; } echo '</td>
                            <td>P '.number_format($employee->rate, 2, '.','').'</td>
                            <td>P '.number_format($total_pay, 2, '.','').'</td>
                        </tr>';
                }
        echo '
            </tbody>
        </table>
        
        ';
    }
}
