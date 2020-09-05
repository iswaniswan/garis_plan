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
    
    $.ajax({
        url: 'Home/calendar',
        type: 'GET',
        dataType: 'text'
    }).done(function(response){
        content_page.append(response);
    })

    $('#notification-list').get_user_notification();
    
    // click other to close updated dropdown
    $('body').click(function(){
        $('.dropdown').removeClass('show')
        $('.dropdown-menu').removeClass('show')
    })
    
});

async function actionNotificationNavbar(e){
    const id = $(e).attr('id');
    console.log("actionNotificationNavbar -> id", id)
    let header_notif = $('#section-notification');
    let parent = $(e).parent('.dropdown-list-content');
    if(header_notif.length >= 1){
        $('table').find('#'+id).trigger('click');
    }else{
        let header = `<div class="section-header"><h1 class="">Notification</h1></div>`;
        let form = await new Components().notification_form(id);
        let content = header + form;
        // set notif has read
        fetchNotificationHasRead(id);

        $("#main_content").empty().append(content);
        $(form).toggleButton();
    }
    
    parent.remove();
}

// remove form notification
function removeForm(){
    $('#notification_wrapper').empty();
    $('a[name="activity-event-notification"]').trigger('click');
}

async function setPassiveEvent(e){
    let is_join_input = ($(e).find('input[name="is_join"]').length >= 1);
    if(is_join_input){
        let params = {
            event_id: $(e).find('input[name="event_id"]').val(),
            is_join: $(e).find('input[name="is_join"]').val()
        };
        console.log("setPassiveEvent -> params", params)
        const res = await fetchPassiveEventAdd(params);
        console.log("setPassiveEvent -> res", res)
    }else{
        let params = {
            event_id: $(e).find('input[name="event_id"]').val(),
            is_cancel: $(e).find('input[name="is_cancel"]').val()
        };
        console.log("setPassiveEvent -> params", params)
        const res = await fetchPassiveEventUpdate(params);
        console.log("setPassiveEvent -> res", res)
    }
}

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

    $.fn.get_user_notification = async function(){

        const data = await fetchUserNotification();
        console.log("data notif", data);
        data.sort((a, b) =>{
            return (moment(b.updated_date, 'YYYY-MM-DD HH:mm:ss') - moment(a.updated_date, 'YYYY-MM-DD HH:mm:ss'));
        })

        // notif is open
        let show = $(this).hasClass('show');

        if(data.length >= 1){
            console.log("alert new notification")
            const html = new Components().notification(data.slice(0, 5), show);
            $(this).html(html);
        }else{
            const html = new Components().notification_empty(show);
            $(this).html(html);
        }

        setTimeout(()=>{
            $(this).get_user_notification();
        }, 5000);
    }

    // toggle submit button, form notification
    $.fn.toggleButton = function(){
        $('#customCheck1').on('change', function(){
            let checked = $(this).is(':checked');
            let button = $('#btn_notif_submit');
            if(checked){
                button.prop('disabled', false);
            }else{
                button.prop('disabled', true);
            }
        })
    }

}(jQuery));