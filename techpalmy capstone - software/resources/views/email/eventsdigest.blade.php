<html>
<head>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
</head>
<body class="container-fluid">
    <h1>Events and Courses</h1>

    <h2>Here are the latest events and courses on the I.T. Professionals Palmerston North website</h2>  

    @foreach ($events as $event)
        <h3><i>{{$event->name}}</i></h3>
        <strong>Posted on </strong> {{$event->created_at}}<br>
        <strong>Happening on </strong> {{$event->date}}<br>
        <strong>Location At </strong>{{$event->location}}<br>
        <hr> 
    @endforeach
</body>
</html>