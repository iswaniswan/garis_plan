"use strict";
/**
 * Class Event
 */
class Event {

    constructor(
        title, start, end, description, extendedProps, backgroundColor, borderColor, textColor){
        this.title = title;
        this.start = start;
        this.end = end ;
        this.description = description;
        this.extendedProps = extendedProps;
        this.backgroundColor = backgroundColor;
        this.borderColor = borderColor;
        this.textColor = textColor;
    };

    title; start; end; description; extendedProps; backgroundColor; borderColor; textColor;

    toObject(){
        return {
            title: this.title,
            start: this.start,
            end: this.end,
            extendedProps: this.extendedProps,
            backgroundColor: this.backgroundColor,
            borderColor:  this.borderColor,
            textColor: this.textColor
        };
    }
}

/**
 *  CONSTANT
 */
const SERVER_API = 'http://192.168.1.43:1381/';
/**
 * 
 *  utility funciton
 * 
 */

function dateTimeStrToDateStr(dateTimeStr){
    let dateStr = moment(dateTimeStr).format('YYYY-MM-DD');
    return moment(dateStr).format('YYYY-MM-DD');
}

function include(arr,obj) {
    return (arr.indexOf(obj) != -1);
}

function renderCalendar(events){    
    $("#myCalendar").empty().fullCalendar({
        height: 'auto',
        header: {
          left: 'prev,next today',
          center: 'title',
          right: 'month,agendaWeek,agendaDay'
        },
        selectable: true,
        editable: false,
        events:events,
        eventLimit:true,
        views:{
            month:{
                eventLimit:3,
            }
        },
        eventLimitText:"more",
        // eventAfterRender: function(event, element) {
        //     $(element).tooltip({
        //         title: event.description,
        //         container: "body"
        //     });
        // }
        eventRenderWait: 300,
        eventClick: function(event){
            showCalendarDateDetail(event);
        }
    });  
}

async function showCalendarDateDetail(event){
    console.log("showCalendarDateDetail -> event", event)
    // dom table
    let ev = new Event(
        event.title, event.start, event.end, event.description, event.extendedProps, event.backgroundColor, event.borderColor, event.textColor
    );
    const dt_event = ev.extendedProps;
    const cmp_table = await `
        <div class="card">
            <div class="card-header">
                <h4 id="table-title">${ev.title} <span class="ml-2 text-dark">(${moment(ev.start, 'YYYY-MM-DD').format('D MMM YYYY')})</span></h4>
                <div class="card-header-action">
                    <a class="btn btn-icon btn-info" href="#" onClick="calendarShow(this)"><i class="fas fa-times"></i> Back </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="table-detail-event">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Department</th>
                                <th>From</th>
                                <th>Until</th>
                                <th>Destination</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${dt_event.extendedProps.map((e, i) => {
                               return `<tr>
                                    <td>${i+=1}</td>
                                    <td>${e.name}</td>
                                    <td>${e.department}</td>
                                    <td>${e.start}</td>
                                    <td>${e.end}</td>
                                    <td>${e.destination}</td>
                                </tr>`
                            }).join("")}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    `;
    // dom table    
    calendarHide(cmp_table);
}

function titleHris(titleStr, counter){
    let strCounter = titleStr.replace('hris +', '') || 0;
    let newCounter = parseInt(strCounter) + counter;
    return 'hris +' + newCounter.toString();
}
/**
 * 
 * initialize calendar
 * 
 */
function loadComponentCalendar(element){
    $.ajax({
        url: 'Home/calendar',
        type: "GET",
        dataType: "text"
    }).done(function(response){
        element.append(response);
    }); 

    loadEvents();

};

function getComponentTable(){
    $.ajax({
        url: 'Home/component_table',
        type: 'GET',
        dataType: 'text'
    }).done(function(response){
        $('#table-calendar').html(response);
        calendarHide();
    });
}

function calendarHide(element){
    // from component calendar page
    $('#calendar-box').fadeOut('fast', function(){
        $('#box-table-calendar').append(element).show('slow');
        let dtl_table = $('#table-detail-event');
        if(dtl_table.length == 1){
            dtl_table.dataTable();
        }
    })
}

function calendarShow(element){
    let table = $(element).parents('.card');
    table.fadeOut('fast', function(){
        $('#calendar-box').fadeIn('slow');
        table.remove();
    })
    // from component calendar page
}

function loadUpcomingSchedule(data){
    let schEl = $('#mySchedule');
    data.sort((a, b) => {
        return (moment(a, 'YYYY-MM-DD') - moment(b, 'YYYY-MM-DD') ? 1 : -1);
    })
    .forEach(item => {
        let mStart = moment(item.start, 'YYYY-MM-DD');
        let mEnd = moment(item.end, 'YYYY-MM-DD');
        let dtStr = (item.start === item.end ? 
            mStart.format('D MMM YY') : mStart.format('D MMM YY') + ' - ' + mEnd.format('D MMM YY')
            );
        let entry = `<div><h5 class="list-schedule">${dtStr}</h5><p class="section-lead">
            <strong>${item.title}</strong><br/>${item.description}</p></div>`;
        schEl.append(entry);
    });
}

async function loadEvents(){
    let events = []; // izin hris unsplit
    let companyEvents = [];
    let holidayEvents = [];

    const dt_calendar = await fetchCalendarEvents();
    // console.log(dt_calendar);
    dt_calendar.forEach(r => {
        let dtStartStr = dateTimeStrToDateStr(r.date_start);
        let dtEndStr = dateTimeStrToDateStr(r.date_end);
        let description = (r.note !== null ? r.note : r.celebration);
        let backgroundColor = (r.type === 'nasional' ? '#fc544b' : '#3abaf4');
        let borderColor = backgroundColor;
        let textColor = '#fafafa';

        let event = new Event(
            r.celebration, dtStartStr, dtEndStr, description, description, backgroundColor, borderColor, textColor
        );
        if(r.type === 'company'){
            companyEvents.push(event);
        }else{
            holidayEvents.push(event);
        }
    }); 
    loadUpcomingSchedule(companyEvents);

    const dt_hris = await fetchDataHris();
    dt_hris.data.forEach(data => {
        let backgroundColor= '#fd7e14';
        let borderColor= backgroundColor;
        let textColor= '#fafafa';
        let h_extProps = {
            name: data.nama,
            start: data.tgl,
            end: data.tgl_end,
            description: '',
            department: data.nama_bag,
            destination: data.tujuan,
        }; 
        let event = new Event(
            "hris +1", data.tgl, data.tgl_end, null, h_extProps, backgroundColor, borderColor, textColor
        );
        if(event.start !== event.end){
            let eventToSplit = $(this).buildExtendEventsFullCalendar(event);
            events.push(...eventToSplit);
        }else{
            events.push(event);
        }
    });

    // grouped events
    let eventsIndex = [];
    let hrisEvent = [];
    events.map(x => {
        if(include(eventsIndex, x.start)){
            let inTo = eventsIndex.map(function(e) { 
                        return e;
                    }).indexOf(x.start);
            let titleSrc = hrisEvent[inTo].title;
            hrisEvent[inTo].title = titleHris(titleSrc, 1);
            let ext = [].concat(hrisEvent[inTo].extendedProps, x.extendedProps);
            hrisEvent[inTo].extendedProps = ext;
        }else{
            let ev = new Event(
                "hris +1", x.start, x.end, null, x.extendedProps, x.backgroundColor, x.borderColor, x.textColor
            );
            hrisEvent.push(ev);
            eventsIndex.push(ev.start);
        }
    });

    let events_combined = [].concat(companyEvents, holidayEvents);
    events_combined = [].concat(events_combined, hrisEvent);
    renderCalendar(events_combined);
};

async function fetchDataHris(){
    const res = await fetch(SERVER_API + 'assets/json/data_izin.json');
    const data = await res.json();
    return data;
}

async function fetchUserHris(){
    const res = await fetch(SERVER_API + 'assets/json/hris_user.json');
    const data = await res.json();
    return data;
}

async function fetchCalendarEvents(){
    const res = await fetch('Home/calendar_events');
    const data = await res.json();
    return data;
}

$(document).ready(function(){  
    /**
     * 
     * sidebar menu click
     * 
     */
    let sidebar_menu = $("#sidebar_menu a");
    let content_page = $("#main_content");

    sidebar_menu.each(function(){
        $(this).click(function(event){
            event.preventDefault();
            let valid_url = $(this).attr("href");
            if(valid_url !== "#"){
                $(this).custom_callback(valid_url, content_page);
            }
        });
    });    
    
    loadComponentCalendar(content_page); 

});

(function($){

    $.fn.custom_callback = function(url, element){
        $.ajax({
            url: url,
            type: "GET",
            dataType: "text",
            success: function(){
                element.empty();
            }
        }).done(function(response){
            element.append(response);
        });
    };

    $.fn.buildExtendEventsFullCalendar = function(event){

        let eventRanged = new Event(
            event.title, event.start, event.end, event.description, event.extendedProps, event.backgroundColor, event.borderColor, event.textColor
        );
        let eventDiff = moment(eventRanged.end, 'YYYY-MM-DD').diff(
            moment(eventRanged.start, 'YYYY-MM-DD'), 'days'
        );
        let description = eventRanged.description;
        let extEvent = [];
        for(let i=0; i<=eventDiff; i++){
            let currDate = moment(eventRanged.start, 'YYYY-MM-DD').add(i, 'days');
            let currDateStr = currDate.format('YYYY-MM-DD');
            let event = new Event(
                eventRanged.title, currDateStr, currDateStr, description, eventRanged.extendedProps,
                eventRanged.backgroundColor, eventRanged.borderColor, eventRanged.textColor
            );
            extEvent.push(event);
        }
        // return as array of Event
        return extEvent; 
    }

}(jQuery));


