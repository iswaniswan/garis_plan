/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";


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

    function loadEvents(){
        $.ajax({
            url: 'Home/calendar_events',
            type: "GET",
            dataType: "json"
        }).done(function(response){
            const r = response;
            let nationalEvents = [];
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
                nationalEvents.push(event);
                if(r[i].type === 'company'){
                    companyEvents.push(event);
                }
            }
            $("#myCalendar").fullCalendar({
                height: 'auto',
                header: {
                  left: 'prev,next today',
                  center: 'title',
                  right: 'month,agendaWeek,agendaDay'
                },
                selectable: true,
                editable: false,
                events:nationalEvents,
                eventLimit:true,
                eventAfterRender: function(event, element) {
                    $(element).tooltip({
                        title: event.description,
                        container: "body"
                    });
                }
            });  
            loadUpcomingSchedule(companyEvents);            
        });
    };
    loadCalendar(content_page);   

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
