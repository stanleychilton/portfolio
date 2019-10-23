<html>
<head>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
</head>
<body class="container-fluid">
    <h1>Email Verification</h1>
        Click here to verify user account.
        <a href="{{url($email_token)}}">
            {{url($email_token)}}
        </a> 
</body>
</html>