<html lang="en">
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link href="https://netdna.bootstrapcdn.com/bootstrap/3.0.1/css/bootstrap.min.css" rel="stylesheet">
    <title>ARTIK Cloud First Web App</title>
</head>
<body>
    <h1>Hello!</h1>
    <p>Please <a href="https://accounts.artik.cloud/authorize?response_type=token&client_id=xxxxx">login</a></p>

    <script>
    query = window.location.hash.split("#");
    if (query[1]) { 
        // accounts sends an URL fragment in the login callback,
        // Now make web browser to load a new url
        window.location = "hello.php?"+query[1];
    }
    </script>
</body>
</html>