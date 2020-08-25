/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";


$(document).ready(function(){
    //global var
    var events_combined = [];
    
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
    /**
     * 
     * initialize calendar
     * 
     */
    function loadCalendar(element){
        $.ajax({
            url: 'Home/calendar',
            type: "GET",
            dataType: "text"
        }).done(function(response){
            element.append(response);
            loadEvents();
        }); 
    };

    function loadUpcomingSchedule(data){
        let schEl = $('#mySchedule');
        let newEl, dtStr;
        for(let i=0; i<data.length; i++){
            dtStr = (data[i].start === data[i].end ? data[i].start : data[i].start + ' - ' + data[i].end);
            newEl = '<div><h5 class="list-schedule">'+
                dtStr+'</h5><p class="section-lead"><strong>'+
                data[i].title+'</strong><br/>'+data[i].description+'</p></div>';
            schEl.append(newEl);
        }
    }

    function getDataHRIS(){
        let url_api = 'http://172.73.1.94/rest/rest-izin.php/data?tgl=2020-07-01&tgl_end=2020-08-10';
        $.ajax({
            url:url_api,
            cache: false,
            type:'GET',
            dataType:'JSON',
            crossDomain:true,
        }).done(function(response_api){             
            const dt_json = response_api.data;
            console.log('d : ' + dt_json.length);

            // cek data hris
            let users = [];
            let counts = {};
            for(let i=0; i<dt_json.length; i++){
                if(dt_json[i].nik === '150913' || 
                    dt_json[i].nik === '000370' || 
                    dt_json[i].nik === '191101' || 
                    dt_json[i].nik === '201136'){
                    continue;
                }
                let h_name, h_div, h_dtstart, h_dtend, h_dest;
                h_name = dt_json[i].nama;
                h_div = dt_json[i].nama_bag;
                h_dtstart = dt_json[i].tgl;
                h_dtend = dt_json[i].tgl_end;

                // cek data hris
                users.push(h_name);

                let desc = h_name+', '+h_div ;
                let ev = {
                    title:'H',
                    start:h_dtstart,
                    end:h_dtend,
                    description: desc,
                    backgroundColor: '#fd7e14',
                    borderColor: '#fd7e14',
                    textColor: '#fafafa'
                };
                events_combined.push(ev);
            }

            // cek data hris
            jQuery.each(users, function(key, value){
                if (!counts.hasOwnProperty(value)) {
                    counts[value] = 1;
                } else {
                    counts[value]++;
                }
            });
            console.log(counts);

            console.log("combined 2 : " + events_combined.length);
            renderCalendar(events_combined);   
        });
    }

    function loadEvents(){
        $.ajax({
            url: 'Home/calendar_events',
            type: "GET",
            dataType: "json"
        }).done(function(response){
            const r = response;
            let companyEvents = [];
            for(let i=0; i<r.length; i++){
                let event = {
                    title:r[i].celebration,
                    start:r[i].date_start,
                    end:r[i].date_end,
                    description: (r[i].note !== null ? r[i].note : r[i].celebration),
                    backgroundColor: (r[i].type === 'nasional' ? '#fc544b' : '#3abaf4'),
                    borderColor: (r[i].type === 'nasional' ? '#fc544b' : '#3abaf4'),
                    textColor: '#fafafa'
                };
                events_combined.push(event);
                if(r[i].type === 'company'){
                    companyEvents.push(event);
                }
            }   
            loadUpcomingSchedule(companyEvents);  
            console.log("combined 1 : " + events_combined.length);
            getDataHRIS();
        });
    };

    loadCalendar(content_page); 

    function renderCalendar(events){
        const dt_events = events;        
        console.log("events render : " + dt_events.length);
        $("#myCalendar").fullCalendar({
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
            eventLimitText:"more",
            // eventAfterRender: function(event, element) {
            //     $(element).tooltip({
            //         title: event.description,
            //         container: "body"
            //     });
            // }
            eventRenderWait: 300,
            eventClick: function(event, jsEvent, view){
                console.log(event, jsEvent, view)
            }
        });  
    }
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

}(jQuery));
