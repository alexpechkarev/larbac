@extends('app')

@section('content')

<div class="container">
    
    <div class="row">
        <div class="col-md-10 col-md-offset-1"> 

<div class="panel panel-default">
    <div class="panel-heading">Create permission</div>
    <div class="panel-body">
        {!! Form::open(array('route' => config('larbac.routes.routePermission').'.store', "role"=>"form")) !!}

        
            <div class="form-group">
                <label for="name">Name</label>
            </div> 
        
            <div class="form-group">
                {!! Form::text('name', null, array('class'=>'form-control', 
                                                    'id'=>'name', 
                                                     'placeholder'=>'Enter permission name'))!!}                
                {{$errors->first('name', '<p class="text-danger">:message</p>')}}
            </div>         
        
            <div class="form-group">
                <label for="description">Description</label>
                {!! Form::text('description', null, array('class'=>'form-control', 
                                                            'id'=>'description', 
                                                             'placeholder'=>'Enter permission description'))!!}                
                {{$errors->first('description', '<p class="text-danger">:message</p>')}}
            </div>
        
       
        
            <button type="submit" class="btn btn-primary btn-sm">Add permission</button>
        {!! Form::close() !!}
    </div>
</div>

            
        </div>                    
    </div>
</div>                
@stop
