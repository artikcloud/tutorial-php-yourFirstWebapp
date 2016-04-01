<?php
  session_start();
?>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link href="https://netdna.bootstrapcdn.com/bootstrap/3.0.1/css/bootstrap.min.css" rel="stylesheet">
    <title>ARTIK Cloud First App redirect page</title>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
</head>
<body>
   <h1>Heard back from ARTIK Cloud</h1>
   <p>Your login succeeded. Got your session token</p>

  <?php
  if (isset($_REQUEST['access_token'])) {
    $_SESSION['access_token'] = $_REQUEST['access_token'];
  }

  require('ArtikCloudProxy.php');
  $proxy = new ArtikCloudProxy();
  $proxy->setAccessToken($_SESSION['access_token']);
  ?> 
	<a class="btn sendMessage">Send a message</a>
	<p id="sendMessageResponse">Response will be put here....</p>

	<script>
	// Sends a message using PHP
    $('.sendMessage').click(function(ev){
    	document.getElementById("sendMessageResponse").innerHTML ="waiting for response";
        $.ajax({url:'post-message.php', success:function(result){
    	    document.getElementById("sendMessageResponse").innerHTML = JSON.stringify(result);
        }});
    });
    </script>

	<a class="btn getMessage">Get a message</a>
	<p id="getMessageResponse">a message will be put here....</p>

	<script>
	// Get a message using PHP
    $('.getMessage').click(function(ev){
    	document.getElementById("getMessageResponse").innerHTML = "waiting for response";
        $.ajax({url:'get-message.php', dataType: "json", success:function(result){
    	    console.log(result);
			// Put code to validate result
			// Get the result and show it
			var message = result.data[0];
			document.getElementById("getMessageResponse").innerHTML = JSON.stringify(message);
            }
        });
    });
    </script>
	
</body>
</html>