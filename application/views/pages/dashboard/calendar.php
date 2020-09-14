<div class="section-header">
    <h1 class="">Dashboard</h1>
    <div id="FormRoom"></div>
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
        <div class="row">
            <div class="col-12">
                <div class="card card-success">
                    <div class="card-header">
                        <h4>Upcoming schedule</h4>
                    </div>
                    <div class="card-body">
                    <div class="fc-overflow">
                        <div id="schedule-next"></div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-warning">
                    <div class="card-header">
                        <h4>Last events</h4>
                    </div>
                    <div class="card-body">
                    <div class="fc-overflow">
                        <div id="schedule-prev"></div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12" id="box-table-calendar" style="display:none;"></div>
</div>

<script type="text/javascript" src="assets/js/components/dashboard/dashboard.js">
</script>
<script type="text/javascript">
    $(document).ready(function(){
        loadEvents();    
    })
</script>
<script type="module" defer>
    import { FormEvent } from "/assets/js/components/dashboard/formEvent.js"
    import { FormRoom } from "/assets/js/components/dashboard/formRoom.js"
    
    $('body').on('click', 'button[name="event"]', async function() {
        const params = {
            date: $(this).attr('data-date')
        }
        
        const form = await new FormEvent(params).render();
        $('body .modal-content').empty().append(form);
        
    });

    $('body').on('click', 'button[name="room_reservation"]', async function() {
        const params = {
            date: $(this).attr('data-date')
        }
        
        const form = await new FormRoom(params).render();
        $('body .modal-content').empty().append(form);
        
    });

</script>
