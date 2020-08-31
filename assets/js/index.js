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