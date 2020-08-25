/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";


$(document).ready(function(){   
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

    function getDataHRIS(events_params){
        const eventToMerge = events_params;
        // let url_api = 'http://172.73.1.94/rest/rest-izin.php/data?tgl=2020-07-01&tgl_end=2020-08-10';
        let url_api = 'http://assetsmanagement.lan/assets/json/data_izin.json';
        $.ajax({
            url:url_api,
            cache: false,
            type:'GET',
            dataType:'JSON',
            crossDomain:true,
        }).done(function(response_api){             
            const dt_json = response_api.data;
            // console.log('d : ' + dt_json.length);

            // cek data hris
            let events = [];
            let eventToSplit = [];
            for(let i=0; i<50; i++){
                let h_name, h_div, h_dtstart, h_dtend, h_dest;
                h_name = dt_json[i].nama;
                h_div = dt_json[i].nama_bag;
                h_dtstart = dt_json[i].tgl;
                h_dtend = dt_json[i].tgl_end;

                // cek data hris
                // jika event lebih dari h+1
                if(h_dtstart !== h_dtend){
                    console.log("lebih dari h+1");
                }
                
                let desc = h_name+', '+h_div ;
                let ev = {
                    title:'H',
                    start:h_dtstart,
                    end:h_dtend,
                    description: '',
                    backgroundColor: '#fd7e14',
                    borderColor: '#fd7e14',
                    textColor: '#fafafa',
                    extendedProps: {
                        start:h_dtstart,
                        end:h_dtend,
                        description: desc,
                        department: h_div,
                      },
                };

                let obj = events.find(x => x.start === h_dtstart);
                let index = events.indexOf(obj);
                if(index >= 0){
                    let objs = obj.extendedProps;
                    let arrObj = [].concat(objs, ev.extendedProps);
                    let countArr = arrObj.length;
                    events.fill(obj.title = 'H +' + countArr, index, index++);
                    events.fill(obj.extendedProps = arrObj, index, index++);
                }else{
                    events.push(ev);
                }

            }
            // console.log(events);
            // console.log("e combined : " + eventToMerge);
            let events_combined = [].concat(eventToMerge, events);
            // console.log("e combined after : " + events_combined);
            renderCalendar(events_combined);   
        });
    }

    function dateTimeStrToDateStr(dateTimeStr){
        let dateStr = moment(dateTimeStr).format('YYYY-MM-DD');
        return moment(dateStr).format('YYYY-MM-DD');
    }

    function loadEvents(){
        let events = [];
        $.ajax({
            url: 'Home/calendar_events',
            type: "GET",
            dataType: "json"
        }).done(function(response){
            const r = response;
            let companyEvents = [];
            for(let i=0; i<r.length; i++){
                let dtStartStr = dateTimeStrToDateStr(r[i].date_start);
                let dtEndStr = dateTimeStrToDateStr(r[i].date_end);
                let event = {
                    title:r[i].celebration,
                    start: dtStartStr,
                    end:dtEndStr,
                    description: (r[i].note !== null ? r[i].note : r[i].celebration),
                    backgroundColor: (r[i].type === 'nasional' ? '#fc544b' : '#3abaf4'),
                    borderColor: (r[i].type === 'nasional' ? '#fc544b' : '#3abaf4'),
                    textColor: '#fafafa'
                };
                events.push(event);
                if(r[i].type === 'company'){
                    companyEvents.push(event);
                }
            }   
            loadUpcomingSchedule(companyEvents);  
            getDataHRIS(events);
        });
    };

    loadCalendar(content_page); 

    function renderCalendar(events){
        const dt_events = events;        
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
