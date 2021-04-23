<script src="{{asset('/asset/now-ui/js/core/jquery.min.js')}}"></script>
<div class="row">
    <div class="col-lg-4 col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <span id="date" class="h6">{{Carbon\Carbon::now()->format('Y M, d D')}}</span>
                        <span class="float-right small">
                            <a href="#" id="edit-date"><i class="now-ui-icons design-2_ruler-pencil"></i> Edit Date</a>
                        </span>
                        <div id="hidden-date">
                            <span class="small">Select date to update</span>
                            <input type="date" name="changedatetime" id="cd" class="form-control">
                        </div>
                        
                        
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-12">
                        <div class="list-group" id="list-tab" role="tablist">
                            <a class="list-group-item list-group-item-action active" id="list-attendance-list" data-toggle="list" href="#list-attendance" role="tab" aria-controls="attendance">Attendance</a>
                            <a class="list-group-item list-group-item-action" id="list-summary-list" data-toggle="list" href="#list-summary" role="tab" aria-controls="summary">Summary</a>
                            <a class="list-group-item list-group-item-action" id="list-settings-list" data-toggle="list" href="#list-settings" role="tab" aria-controls="settings">Settings</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-8 col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="list-attendance" role="tabpanel" aria-labelledby="list-attendance-list">
                        <div class="row">
                            <div class="col-lg-8 col-sm-12">
                            <table class="table table-stripped" style="font-size: 15px; font-variant: all-small-caps; font-weight: bold;">
                                <thead class="thead-dark">
                                    <tr class="small">
                                        <th scope="col">Full Name</th>
                                        <th scope="col">Time In</th>
                                        <th scope="col">Time Out</th>
                                        <th scope="col">GeoLocation</th>
                                    </tr>
                                </thead>
                                <tbody id="update-attendance">
                                @foreach($attendance as $a)
                                    <tr>
                                        <td>{{App\Employee::find($a->employee_id)->last_name.', '.App\Employee::find($a->employee_id)->first_name.' '.App\Employee::find($a->employee_id)->middle_initial}}</td>
                                        <td>{{Carbon\Carbon::parse($a->time_in)->format('g:i A')}}</td>
                                        <td>
                                            @if($a->time_out)
                                                {{Carbon\Carbon::parse($a->time_out)->format('g:i A')}}
                                            @else
                                                <a href="#" id="add-time-out-{{$a->id}}">Add Time Out</a>
                                                <input type="time" class="form-control" id="add-time-out-input-{{$a->id}}">
                                            @endif
                                        </td>
                                        <td>
                                            <a href="#" data-toggle="modal" data-target=".bd-example-modal-sm">Show Location</a>
                                            <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-sm">
                                                    <div class="modal-content">
                                                    <iframe src="http://maps.google.com/maps?q={{$a->lat}},{{$a->long}}&z=16&output=embed" frameborder="0"></iframe>
                                                    <table class="table bg-white">
                                                        <tr>
                                                            <td>Mac Address:</td>
                                                            <td>
                                                            @if(App\Logs::where('employee_id','=',$a->employee_id)->where('created_at',$a->time_in)->first()->mac)
                                                            {{App\Logs::where('employee_id','=',$a->employee_id)->where('created_at',$a->time_in)->first()->mac}}<br>
                                                            @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>IP Address:</td>
                                                            <td>
                                                            @if(App\Logs::where('employee_id','=',$a->employee_id)->where('created_at',$a->time_in)->first()->ip)
                                                            {{App\Logs::where('employee_id','=',$a->employee_id)->where('created_at',$a->time_in)->first()->ip}}
                                                            @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Browser:</td>
                                                            <td>
                                                            @if(App\Logs::where('employee_id','=',$a->employee_id)->where('created_at',$a->time_in)->first()->agent)
                                                            {{App\Logs::where('employee_id','=',$a->employee_id)->where('created_at',$a->time_in)->first()->agent}}
                                                            @endif
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <script defer>
                                        $('#add-time-out-input-{{$a->id}}').hide();
                                        $('#add-time-out-{{$a->id}}').click( () => {
                                            $('#add-time-out-input-{{$a->id}}').show();
                                            $('#add-time-out-{{$a->id}}').hide();
                                            $('#add-time-out-input-{{$a->id}}').focus();
                                        });
                                        $('#add-time-out-input-{{$a->id}}').blur( () => {
                                            $('#add-time-out-input-{{$a->id}}').hide();
                                            $('#add-time-out-{{$a->id}}').show();
                                        });
                                        $('#add-time-out-input-{{$a->id}}').keyup( (e) => {
                                            e.preventDefault()
                                            if(e.keyCode == 13) {
                                                console.log('enter works');
                                                $.ajaxSetup({
                                                    headers: {
                                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                    }
                                                });
                                                $.ajax({
                                                    url: "{{route('editAttendance')}}",
                                                    type: "POST",
                                                    dataType: "html",
                                                    data: { 
                                                        '_token': "{{ csrf_token() }}",
                                                        'attendanceID' : "{{$a->id}}",
                                                        'timeOut' : $('#add-time-out-input-{{$a->id}}').val()
                                                        
                                                    },
                                                    success: function(data){
                                                        console.log(data);
                                                        $('#update-attendance').html(data);
                                                        ('#add-time-out-input-{{$a->id}}').hide();
                                                        ('#add-time-out-{{$a->id}}').show();
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
                                @endforeach
                                </tbody>
                            </table>
                            </div>
                            <div class="col-lg-4 col-sm-12 shadow p-2">
                                <h6>Time In/Out</h6>
                                <hr>
                                <label for="employee_login_list">Employee Name:</label>
                                <select class="form-control" name="employee_login_list" id="employee_login_list">
                                    @foreach($employees as $employee)
                                        <option value="{{$employee->id}}">{{$employee->last_name.', '.$employee->first_name.' '.$employee->middle_initial}}</option>
                                    @endforeach
                                </select>
                                <label for="time_in">Time In:</label>
                                <input type="time" name="time_in" id="time_in" class="form-control">
                                <hr>
                                <h6>Geotag</h6>
                                <label for="long">Longitude:</label>
                                <input type="number" name="long" id="long" class="form-control">
                                <label for="lat">Latitude:</label>
                                <input type="number" name="lat" id="lat" class="form-control">

                                <button class="btn btn-secondary w-100" id="submit_attendance">Add Attendance</button>
                                
                                <script>
                                
                                $('#submit_attendance').click( () => {
                                    const employeeID = $('#employee_login_list').val();
                                    const timeIn = $('#time_in').val();
                                    const long = $('#long').val();
                                    const lat = $('#lat').val();
                                    $.ajaxSetup({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        }
                                    });
                                    $.ajax({
                                        url: "{{route('addAttendance')}}",
                                        type: "post",
                                        dataType: "html",
                                        data: { 
                                            'employeeID' : employeeID,
                                            'timeIn' : timeIn,
                                            'long' : long,
                                            'lat' : lat
                                        },
                                        success: function(data){
                                            $('#update-attendance').html(data);
                                        },
                                        error: function(xhr, status, error) {
                                        var err = eval("(" + xhr.responseText + ")");
                                        alert(err.Message);
                                        }
                                    });
                                })
                                    
                                </script>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="list-summary" role="tabpanel" aria-labelledby="list-summary-list">
                        <div class="row">
                            <div class="col-12">
                                <div class="float-right">
                                    <a href="javascript:void(0);" class="small" onclick="reloadRecord()"><i class="now-ui-icons loader_refresh"></i> Reload</a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <table class="table table-stripped" style="font-size: 15px; font-variant: all-small-caps; font-weight: bold;">
                                    <thead class="thead-dark">
                                        <tr class="small">
                                            <th scope="col">Full Name</th>
                                            <th scope="col">Time In</th>
                                            <th scope="col">Time Out</th>
                                            <th scope="col">L/D</th>
                                            <th scope="col">O/P</th>
                                            <th scope="col">Rate</th>
                                            <th scope="col">Total Pay</th>
                                        </tr>
                                    </thead>
                                    <tbody id="record-summary">
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="list-settings" role="tabpanel" aria-labelledby="list-settings-list">...</div>
                </div>
            </div>
        </div>
    </div>
</div>
<script defer>
$('#cd').change(() => {
    $.ajax({
        url: "endpoint/daily-summary/"+$('#cd').val(),
        type: "GET",
        dataType: "html",
        success: function(data){
            $('#update-attendance').html(data);
        },
        error: function(xhr, status, error) {
            var err = eval("(" + xhr.responseText + ")");
            alert(err.Message);
            console.log(not);
        }
    });
});



function reloadRecord() {
    $.ajax({
        url: "{{route('recordSummary')}}",
        type: "GET",
        dataType: "html",
        success: function(data){
            $('#record-summary').html(data);
        },
        error: function(xhr, status, error) {
            var err = eval("(" + xhr.responseText + ")");
            alert(err.Message);
            console.log(not);
        }
    });
}
reloadRecord();
</script>
