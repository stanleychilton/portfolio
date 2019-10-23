<html>
<head>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
</head>
<body class="container-fluid">
    <h3><i>{{$event->name}}</i></h3>
    <strong>Posted on </strong> {{$event->created_at}}<br>
    <strong>Happening on </strong> {{$event->date}}<br>
    <strong>Location At </strong>{{$event->location}}<br>
    <strong>Description: </strong><br>
    {{strip_tags($event->description)}}
    <hr> 
</body>
</html>