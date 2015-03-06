@extends('app')


@section('content')

<div class="container">
    
<div class="row">
        <div class="col-md-10 col-md-offset-1"> 

<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-xs-10"><h3 class="panel-title">View users</h3></div>
            
            
            <div class="col-xs-2">
                <a href="{{url('auth/register')}}" class="btn btn-primary btn-sm pull-right">Create user</a>
            </div>
        </div>
    </div>
    <div class="panel-body">
          
        
        
        @if(count($users) == 0)
        <p>You do not have any users created. <a href="{{url('auth/register')}}" class="btn btn-primary btn-sm">Create user</a><p>
            @else  
<!--            Table begins-->
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th colspan="2"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $u) 
                <tr>
                    <td class="col-xs-1">{{$u->id}}</td>
                    <td class="col-xs-2">{{$u->name}}</td>
                    <td class="col-xs-7">
                        @if(count($u->roles) > 0)
                        
                            @foreach($u->roles as $role)
                                [ {{$role->name}} ]
                            @endforeach
                        
                        @else
                        {{"No role assigned to this user."}}
                        @endif
                    </td>
                    <td class="col-xs-2"><a href="{{route('user.edit', $u->id)}}" class="btn btn-primary btn-sm ">Edit Roles</a></td>
                                           

                </tr>
                @endforeach                    
            </tbody>
        </table>        
<!--        Table ends-->
        
       
        
        @endif
    </div>
</div>

    </div>                    
</div>
    


@stop



