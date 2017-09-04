var bot = {
    
    send: function(message){
      
      var $spinner = $("<div class='clearfix'><div class='message_bot_wait'><div class='spinner'><div class='bounce1'></div><div class='bounce2'></div><div class='bounce3'></div></div></div></div>")
      $("#dialog").append($spinner);
      
      $.ajax({
          url: bot_url,
          dataType: 'json',
          method: 'POST',
          data: JSON.stringify({"text": message}),
          success: function(message){
                $spinner.remove();
                $("#dialog").append("<div class='clearfix'><div class='message_bot'>" + message.text + "</div></div>");
                
                var tagName = $("#message").prop("tagName").toLowerCase();
                var newTagName = "input";
                
                if(message.replyType && message.replyType == "text"){
                    newTagName = "textarea";
                }
                
                if(tagName != newTagName){
                    var $newInputElement = $("<" + newTagName + "/>");
                    $.each($("#message")[0].attributes, function() {
                        if(this.specified) {
                           $newInputElement.attr(this.name, this.value);
                          }
                    });
                    $("#message").replaceWith($newInputElement);
                }
          }
      });
      
      
    },
    
    submit: function(e){
        e.preventDefault();
        var message = $("#message").val();
        
        $("#dialog").append("<div class='clearfix'><div class='message_self'>" + message + "</div></div>");
        $("#message").val("");
        bot.send(message);
    }
};
$(document).ready(function(){
    $("form").submit(bot.submit);
    bot.send("BOT_START");
});
