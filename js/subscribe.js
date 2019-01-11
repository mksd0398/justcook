jQuery(document).ready(function($) {
    "use strict";
    $('form.subscribeForm').submit(function() {
        var ferror = false,
        emailExp = /^[^\s()<>@,;:\/]+@\w[\w\.-]+\.[a-z]{2,}$/i;
  
        $(this).find('.form-group').children('input').each(function() { 
            var i = $(this);
            var rule = i.attr('data-rule');
            if (rule !== undefined) {
                var ierror = false;
                var pos = rule.indexOf(':', 0);
                if (pos >= 0) {
                    var exp = rule.substr(pos + 1, rule.length);
                    rule = rule.substr(0, pos);
                } else {
                    rule = rule.substr(pos + 1, rule.length);
                }
  
                switch (rule) {
                    case 'required':
                        if (i.val() === '') {
                            ferror = ierror = true;
                        }
                        break;
                    case 'minlen':
                        if (i.val().length < parseInt(exp)) {
                          ferror = ierror = true;
                        }
                        break;
            
                    case 'email':
                        if (!emailExp.test(i.val())) {
                          ferror = ierror = true;
                        }
                        break;
                    }
                i.next('.validation').html((ierror ? (i.attr('data-msg') !== undefined ? i.attr('data-msg') : 'wrong Input') : '')).show('blind');
            }
        });        
            
      
      if (ferror) return false;
      else var str = $(this).serialize();
      console.log(str);
      $.ajax({
        type: "POST",
        url: "http://localhost/justcook/api/writing/subscriptionWriting.php",
        data: str,
        success: function(msg) {
          if (msg.message == "OK") {
            $("#sendmessage").text("Thank for your query we will get back to you soon !!").show();
            $("#errormessage").hide();
            $("#queryForms").hide();
            off();
          } else {
            $("#errormessage").text("We are so sory!! can you please try again later").show();
          }
        }
      });
      return false;
    });
  
  });
  
  

function on() {
    document.getElementById("overlay").style.display = "block";
}

function off() {
    document.getElementById("overlay").style.display = "none";
}

