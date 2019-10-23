@if($flag==0)
    {!!Form::open(array('action'=>['SiteGovernance@flaglisting'], 'method'=>'POST'))!!}
        {{ Form::hidden('id', $ID) }}
        {{ Form::hidden('model', $model) }}
        {{ Form::hidden('flag', 1) }}
        {{Form::submit('Approve Listing', ['class'=> 'btn btn-info'])}}
    {!!Form::close()!!}
@else
    {!!Form::open(['action'=>['SiteGovernance@flaglisting'], 'method'=>'POST'])!!}
        {{ Form::hidden('id', $ID) }}
        {{ Form::hidden('model', $model) }}
        {{ Form::hidden('flag', 0) }}
        {{Form::submit('Hide Listing', ['class'=> 'btn btn-dark'])}}
    {!!Form::close()!!}
@endif

