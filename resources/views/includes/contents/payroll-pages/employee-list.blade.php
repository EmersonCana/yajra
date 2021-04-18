<div class="row">
    <div class="col-12">
        <div id="dynamic-content">
            <div class="text-right">
                <button data-toggle="modal" data-target="#addEmployeeModal" class="btn btn-none btn-md"><i class="now-ui-icons ui-1_simple-add"></i></button>
                @include('includes.modals.add-employee-modal')
            </div>
            <div class="card">
                <div class="card-body">
                    <table class="cell-border compact stripe" id="employees_table">
                        <thead>
                            <th>ID</th>
                            <th>Last Name</th>
                            <th>First Name</th>
                            <th>Middle Initial</th>
                            <th>Position</th>
                            <th>Rate</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @foreach($employees as $employee)
                            <tr>
                                <td>{{$employee->id}}</td>
                                <td>{{$employee->last_name}}</td>
                                <td>{{$employee->first_name}}</td>
                                <td>{{$employee->middle_initial}}</td>
                                <td>{{$employee->position}}</td>
                                <td class="text-right">P {{$employee->rate}}</td>
                                <td class="text-center"><button type="button" data-toggle="modal" data-target="#editEmployeeModal-{{$employee->id}}" class="btn btn-sm"><i class="now-ui-icons design-2_ruler-pencil"></i></button><button type="button" data-toggle="modal" data-target="#deleteEmployeeModal-{{$employee->id}}"  class="btn btn-sm"><i class="now-ui-icons ui-1_simple-remove"></i></button></td>
                            </tr>
                            @include('includes.modals.edit-employee-modal')
                            @include('includes.modals.delete-employee-modal')
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
