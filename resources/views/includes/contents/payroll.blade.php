<div class="row">
    <div class="col-lg-4 col-sm-12">
        <button class="btn btn-primary btn-lg w-100" id="list_employee">Employee List</button>
    </div>
    <div class="col-lg-4 col-sm-12">
        <button class="btn btn-primary btn-lg w-100" id="list_records">Records</button>
    </div>
    <div class="col-lg-4 col-sm-12">
        <button class="btn btn-primary btn-lg w-100" id="list_payroll">Payroll</button>
    </div>
</div>

<div class="row">
    <div class="col-12">
        @if (\Session::has('success'))
            <div class="alert alert-warning" id="success">
                <ul>
                    <li>{!! \Session::get('success') !!}</li>
                </ul>
            </div>
        @endif
        <div class="small">Click an action above to interact.</div>

    </div>
</div>
<employee_list>
    @include('includes.contents.payroll-pages.employee-list')
</employee_list>
<employee_records>
    @include('includes.contents.payroll-pages.employee-records')
</employee_records>
<employee_payroll>
    @include('includes.contents.payroll-pages.employee-payroll')
</employee_payroll>
