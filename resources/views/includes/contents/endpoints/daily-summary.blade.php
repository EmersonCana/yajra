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