@extends('app')

@section('content')

<div class="container">
    
    <div class="row">
        <div class="col-md-10 col-md-offset-1"> 

<div class="panel panel-default">
    <div class="panel-heading">Edit permission</div>
    <div class="panel-body">
        {!! Form::open(array('route' => array('permission.update', $id), 'role' => 'form', 'method' => 'PUT')) !!}      
        
            <div class="form-group">
                <label for="name">Name</label>
            </div> 
        
            <div class="form-group">
                {!!Form::text('name', $name ,array('class'=>'form-control'))!!}                
                {{$errors->first('name', '<p class="text-danger">:message</p>')}}
            </div>  
        
            <div class="form-group">
                <label for="description">Description</label>
                {!!Form::text('description', $description, 
                            array("id"=>"description", "class"=>"form-control", 
                                    "placeholder"=>"Enter permission description"));!!}             
                {{$errors->first('description',  '<p class="text-danger">:message</p>')}}
            </div>
        
            <button type="submit" class="btn btn-primary btn-sm">Update permission</button>
        {!! Form::close() !!}
    </div>
</div>
        </div>                    
    </div>
</div>               

@stop