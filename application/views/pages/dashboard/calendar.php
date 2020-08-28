<!-- override css -->
<style>

</style>

<div class="section-header">
    <h1 class="">Dashboard</h1>
</div>
<div class="row" id="calendar-box">
    <div class="col-md-8 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h4>Calendar</h4>
            </div>
            <div class="card-body">
            <div class="fc-overflow">
                <div id="myCalendar">
                    <div class="row justify-content-center">
                        <div class="col-4">
                            <div class="d-flex align-items-center">
                                <strong>Loading...</strong>
                                <div class="spinner-border ml-auto" role="status" aria-hidden="true"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h4>Upcoming schedule</h4>
            </div>
            <div class="card-body">
            <div class="fc-overflow">
                <div id="mySchedule"></div>
            </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12" id="box-table-calendar" style="display:none;"></div>
</div>

<script type="text/javascript">

$(document).ready(function(){

});

</script>