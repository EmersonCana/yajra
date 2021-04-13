<div class="modal fade" id="addEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addEmployeeModalLabel">Add Employee</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-left">
          <form method="post" action="{{route('addEmployee')}}">
              @csrf
            <div class="row">
                <div class="col-lg-5 col-sm-12">
                    <label for="first_name">First Name:</label>
                    <input type="text" name="first_name" class="form-control" maxlength="30">
                </div>
                <div class="col-lg-5 col-sm-12">
                    <label for="last_name">Last Name:</label>
                    <input type="text" name="last_name" class="form-control" maxlength="30">
                </div>
                <div class="col-lg-2 col-sm-12">
                    <label for="middle_initial">M.I:</label>
                    <input type="text" name="middle_initial" class="form-control" maxlength="30">
                </div>
            </div>
            <br>    
            <div class="row">
                <div class="col-lg-6 col-sm-12">
                    <label for="position">Position:</label>
                    <input type="text" name="position" class="form-control" maxlength="30">
                </div>
                <div class="col-lg-6 col-sm-12">
                    <label for="rate">Rate:</label>
                    <input type="number" name="rate" class="form-control" maxlength="30" placeholder="P">
                </div>
            </div>
        
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Add</button>
        </form>
      </div>
    </div>
  </div>
</div>