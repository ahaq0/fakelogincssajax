
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="robots" content="follow">

    <title>Auphan Software coding task</title>
    <base href="/" />
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
  <style>
  body {background-color: #F4FAFA;}
  </style>
  
  <div class="container">
    <div class="row">
      <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
        <div class="card card-signin my-5">
          <div class="card-body">
            <h5 class="card-title text-center">Sign In</h5>
            <form class="form-signin" method = "post" action ="login.php">
              <div class="form-label-group">
                <input type="text" id="username" class="form-control" placeholder="Email address" required autofocus>
                <label for="inputEmail"></label>
              </div>

              <div class="form-label-group">
                <input type="password" id="passname" class="form-control" placeholder="Password" required>
                <label for="inputPassword"></label>
              </div>
           
              <button class="btn btn-lg btn-primary btn-block text-uppercase" type="button" id = "login">Sign in</button>
              <hr class="my-4">
			  <div id="statusDisplay"> </div> 
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  
  
<!-- Put this at the end so it loads last-->
	  <script
  src="http://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>

	<script type="text/javascript">

// Simple email validation function via Regex
	(function validateEmail($email) {
  var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
  return emailReg.test( $email );
})(jQuery);

// Simple flash message function to display messages i.e. login / logout

	(function($) {
    $.fn.flash_message = function(options) {      
      options = $.extend({
        text: 'Done',
        time: 1000,	
        how: 'before',
        class_name: ''
      }, options);
      
      return $(this).each(function() {
        if( $(this).parent().find('.flash_message').get(0) )
          return;
        
        var message = $('<span />', {
          'class': 'flash_message ' + options.class_name,
          text: options.text
        }).hide().fadeIn('fast');
        
        $(this)[options.how](message);
        
        message.delay(options.time).fadeOut('normal', function() {
          $(this).remove();
        });
        
      });
    };
})(jQuery);

		
		
// Short function to determine whether a string is an emal via regex
$.fn.isItAnEmail = function($potentialEmail){ 
		let emailRegex = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
		return emailRegex.test( $potentialEmail );
}

// Once we're done loading
$(document).ready(function ()
{
	// Handling email functionality.
	$("#username").keyup(function()
	{
	
		let currentUsername = $("#username").val(); 
		// If we have nothing or no email, we'll disable the submit button
		if(currentUsername === "" || !$.fn.isItAnEmail($("#username").val()) )
		{
			$('#login').prop('disabled', true);
		}
		else
		{
			$('#login').prop('disabled', false);
		}
	})

	// Handling sign in functionality
	$("#login").on('click', function()
	{
		// Get the username and password
		let username =$("#username").val().trim();
		let password  =$("#passname").val().trim();
		if( username != "" && password != "" )
		{
			// Send AJAX POST request
			$.ajax({
				url:'login.php',
				method:'POST',
				data:{
					username:username,
					password:password
				},
					// Following execution of the request, looking at our output we show success / failure
					success:function(response)
					{
						if(username === "hr@auphansoftware.com" 
						&& password === "hello")
						{
							$('#statusDisplay').flash_message({ 
							text: 'Login Success!',
							how: 'append'});
						}
						else
						{
							$('#statusDisplay').flash_message({ 
							text: 'Incorrect Username/Password',
							how: 'append'});
						}
					},
				dataType : 'text'
			});
		}
		// There's no point in making a empty request so we alert the user instead.
		else
		{
			$('#statusDisplay').flash_message({ 
			text: 'Please input something :(',
			how: 'append'
		});
		}
	});

	});
</script>
</body>
</html>


<?php
// Assuming login is declared, we can fetch the the output
if(isset($_POST['login']))
{
	$uname = $_POST[username];
	$pass = $_POST[password];
	// Small test to see if I'm getting the values from the AJAX request correctly.
	exit($uname . " = " . $pass);
}
?>