<html>
<head>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
</head>
<body class="container-fluid">
    <h1>Job Listings</h1>

    <h2>Here are some of the new job listings at I.T. Professionals Palmerston North</h2>  
    @inject('company', 'App\Models\Company')
    @foreach ($jobs as $job)
        <h3><i>{{$job->position}}</i></h3>
        <strong>Posted on </strong> {{$job->created_at}}<br>
        Posted by <Strong>{{$company::find($job->companyID)->first()->name}}</strong>
    @endforeach
</body>
</html>