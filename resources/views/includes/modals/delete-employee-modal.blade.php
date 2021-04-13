<div class="modal fade" id="deleteEmployeeModal-{{$employee->id}}" tabindex="-1" role="dialog" aria-labelledby="deleteEmployeeModal-{{$employee->id}}Label" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteEmployeeModal-{{$employee->id}}Label">Delete Employee</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-left">
          <form method="post" action="functions/delete-employee/{{$employee->id}}">
              @csrf
              <h5>Are you sure you want to delete this employee record?</h5>
              <small>Note: This action cannot be undone.</small>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <button type="submit" class="btn btn-primary">Yes</button>
        </form>
      </div>
    </div>
  </div>
</div>