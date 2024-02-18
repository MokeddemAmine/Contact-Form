
// function of needs-validation of the form
$(document).ready(function(){
  (function() {
    'use strict';
    window.addEventListener('load',function() {
      // Get the forms we want to add validation styles to
      var forms = document.getElementsByClassName('needs-validation');
      // Loop over them and prevent submission
      var validation = Array.prototype.filter.call(forms, function(form) {
        form.addEventListener('submit', function(event) {
          if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
          }
          form.classList.add('was-validated');

          // our code for the message textarea 
          // start
            $('.asterisk').hide();
            var message = $('#contact-message');
            var invalidfeed = $('.invalid-feed');
            if(message.val().length < 10){
              message.css({
                border:'1px solid red',
                backgroundImage:'none',
                boxShadow:'none'
              });
              invalidfeed.html('message must have 10 characters or more');
              invalidfeed.css('fontSize','80%');
              
              
            }
            $('#contact-message').keyup(function(){
              if($(this).val().length < 10){
                $(this).css({
                  border:'1px solid red',
                  backgroundImage:'none',
                  boxShadow:'none'
                });
                invalidfeed.html('message must have 10 characters or more');
                invalidfeed.css({
                  fontSize:'80%',
                  color:'red'
                });
              }else{
                $(this).css({
                  border:'1px solid green',
                })
                invalidfeed.html('<span class="text-success">valid</span>');
              }
            })
          //end

        }, false);
      });
    }, false);
  })();

})
