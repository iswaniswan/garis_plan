<!-- override css -->
<style>
a.fc-event {
    border-radius: 8px;
    /* round edges */
    height:8px;
    width: 8px;
    /* fixed width */
    color: transparent;
    /* hide text */
}
div.fc-content-skeleton > table > tbody > tr {
    display: inline-block;
}
</style>

<div class="section-header">
    <h1 class="">Dashboard</h1>
</div>
<div class="row">
    <div class="col-md-8 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h4>Calendar</h4>
            </div>
            <div class="card-body">
            <div class="fc-overflow">
                <div id="myCalendar"></div>
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

<script type="text/javascript">

$(document).ready(function(){

});

</script>