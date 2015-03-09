@extends('app')

@section('content')

<div class="container">
    
    <div class="row">
        <div class="col-md-10 col-md-offset-1"> 

<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-xs-10"><h3 class="panel-title">View roles</h3></div>
            <div class="col-xs-2">
                <a href="{{route(config('larbac.routes.routeRoles').'.create')}}" class="btn btn-primary btn-sm pull-right">Create role</a>
            </div>
        </div>
    </div>
    <div class="panel-body">

      
        @if(count($roles) == 0)
        <p>You do not have any roles created. <a href="{{route(config('larbac.routes.routeRoles').'.create')}}" class="btn btn-primary btn-sm">Create role</a><p>
            @else
            
<!--            Table view-->
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Role</th>
                    <th>Description</th>
                    <th colspan="2"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($roles as $r)                
                <tr>
                    <td class="col-xs-1">{{$r->id}}</td>
                    <td class="col-xs-2">{{$r->name}}</td>
                    <td class="col-xs-5">{{$r->description}}</td>
                    <td class="col-xs-1">
                        <a href="{{route(config('larbac.routes.routeRoles').'.edit', $r->id)}}" class="btn btn-primary btn-sm ">Edit</a>
                    </td>
                    <td class="col-xs-1">
                        {!! Form::open(array('route' => array(config('larbac.routes.routeRoles').'.destroy', $r->id), 'method' => 'DELETE')) !!}
                        <button class="btn btn-danger btn-sm btnDelete" type="submit" >Delete Role</button>
                        {!! Form::close() !!}                        

                </tr>
                @endforeach                     
            </tbody>
        </table>     
<!--        Table view ends-->
               
        @endif
    </div>
</div>
            
        </div>                    
    </div>
</div>
                
            
<!-- Modal -->
<div class="modal fade" id="dlgModal">
    <div class="modal-dialog">
        <div class="modal-content">
            
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">@if(isset($title)) {{$title}} @else {{'Delete action'}} @endif</h4>
            </div>
            
            
            
            <div class="modal-body">
                <p>@if(isset($message)) {{$message}} @else {{'Are you sure ? '}} @endif</p>
            </div>
            
            
            
            
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal"> No </button>
                <button type="button" class="btn btn-danger btnDeleteConfirm">Delete</button>
            </div>
            
            
            
            
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- /.modal -->

@stop


@section('footer-js')
@parent
<script src={{asset("vendor/larbac/js/helpers/dialogDelete.js")}}></script>
@stop