@extends('layouts.email',[])
@section('content')
<tr style="text-align: center;">
    <td>
        <p style="font-family: 'Ubuntu';
                              font-size: 16px;
                              color: #000000;
                              margin: auto;
                              margin-top:10px;
                              ">{!!__('userHasCreatedJob',["userName"=>$user->name, "jobTitle"=>$job->title])!!}
        </p>
    </td>
</tr>
@endsection