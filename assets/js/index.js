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
                $(this).custom_callback(valid_url, content_page);console.log("valid_url", valid_url)
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

    $.fn.get_user_notification = async function(){
        const data = await fetchUserNotification();
        console.log("data", data);
        let notif = [];
        data.map((value, index, arr)=>{
            if(value.is_read == 0){
                notif.push(arr[index]);
            }
        });
        if(notif.length >= 1){
            console.log("alert new notification")
            const html = new Components().notification(notif.slice(0, 5));
            $(this).html(html);
        }
    }

}(jQuery));