﻿
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
	<style>
body {background-color: powderblue;}
h1   {color: blue;}
p    {color: red;}

.center
{
	text-align: center;
}
</style>
  </head>
  <body>
  
  
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

  
  
<!--  
 -->

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

		// Simple flash message function

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

		
		
$.fn.isItAnEmail = function($potentialEmail){ 
		// Simple regex to determine whether a text is an email
		let emailRegex = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
		return emailRegex.test( $potentialEmail );
}
		// Wait for document to load
			$(document).ready(function ()
			{
				$("#username").keyup(function()
				{
					// If nothing is input or the email isn't validated, disable the submit button
				
					let currentUsername = $("#username").val(); 

					//console.log(currentUsername);

					// If we have nothing or no email, we'll disable the submit button
					if(currentUsername === "" || 
					!$.fn.isItAnEmail($("#username").val()) )
					//if($(this).val() == "" || !validateEmail($(this).val()))
					{
						//console.log("Hey");


						//console.log($.fn.isItAnEmail("ammar@gmail.com"));
						$('#login').prop('disabled', true);
					}
					else
					{
						$('#login').prop('disabled', false);
					}
				})

			

				$("#login").on('click', function()
				{
					let username =$("#username").val().trim();
					let password  =$("#passname").val().trim();
					if( username != "" && password != "" )
					{
						$.ajax({
							url:'login.php',
							method:'POST',
							data:{
								username:username,password:password},
								// Following execution of the query
							success:function(response){
								console.log(response);

								console.log(username + " " + password);
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
					   // No need to make a request if nothing there
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
if(isset($_POST['login']))
{
	$uname = $_POST[username];
	$pass = $_POST[password];
	exit($uname . " = " . $pass);
}
?>