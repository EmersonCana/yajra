<div class="modal fade" id="editEmployeeModal-{{$employee->id}}" tabindex="-1" role="dialog" aria-labelledby="editEmployeeModal-{{$employee->id}}Label" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editEmployeeModal-{{$employee->id}}Label">Edit Employee</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-left">
          <form method="post" action="functions/edit-employee/{{$employee->id}}">
              @csrf
            <div class="row">
                <div class="col-lg-5 col-sm-12">
                    <label for="first_name">First Name:</label>
                    <input type="text" name="edit_first_name" class="form-control" maxlength="30" value="{{$employee->first_name}}">
                </div>
                <div class="col-lg-5 col-sm-12">
                    <label for="last_name">Last Name:</label>
                    <input type="text" name="edit_last_name" class="form-control" maxlength="30" value="{{$employee->last_name}}">
                </div>
                <div class="col-lg-2 col-sm-12">
                    <label for="middle_initial">M.I:</label>
                    <input type="text" name="edit_middle_initial" class="form-control" maxlength="30" value="{{$employee->middle_initial}}">
                </div>
            </div>
            <br>    
            <div class="row">
                <div class="col-lg-6 col-sm-12">
                    <label for="position">Position:</label>
                    <input type="text" name="edit_position" class="form-control" maxlength="30" value="{{$employee->position}}">
                </div>
                <div class="col-lg-6 col-sm-12">
                    <label for="rate">Rate:</label>
                    <input type="number" name="edit_rate" class="form-control" maxlength="30" placeholder="P" value="{{$employee->rate}}">
                </div>
            </div>
        
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Edit</button>
        </form>
      </div>
    </div>
  </div>
</div>