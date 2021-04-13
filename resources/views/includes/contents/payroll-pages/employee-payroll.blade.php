<script src="{{asset('/asset/now-ui/js/core/jquery.min.js')}}"></script>
<div class="row">
    <div class="col-12">
        <div id="dynamic-content">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-3 offset-4">
                            <label for="date_from">From</label> 
                            <input type="date" class="form-control" id="date_from" >
                        </div>
                        <div class="col-3">
                            <label for="date_to">To</label> 
                            <input type="date" class="form-control" id="date_to">
                        </div>
                        <div class="col-2 text-center">
                            <button type="button" id="get_records" onclick="getFromDates()" class="btn btn-primary">Generate</button>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <div class="container" id="payroll-list"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script defer>
function getFromDates() {
    $.ajax({
        url: "/function/get-from-dates/"+$('#date_from').val()+"/"+$('#date_to').val(),
        type: "GET",
        dataType: "html",
        success: function(data){
            $('#payroll-list').html(data);
        },
        error: function(xhr, status, error) {
            var err = eval("(" + xhr.responseText + ")");
            alert(err.Message);
            console.log(not);
        }
    });
}
</script>