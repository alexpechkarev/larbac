@extends('app')

@section('content')
<link href={{asset("vendor/larbac/css/bootstrap/bootstrap.min.css")}} rel="stylesheet"> 
<link href={{asset("vendor/larbac/css/duallistbox/bootstrap-duallistbox.min.css")}} rel="stylesheet"> 
<div class="container">
    
    <div class="row">
        <div class="col-md-10 col-md-offset-1">  


<div class="panel panel-default">
    <div class="panel-heading">User: {{$name}}</div>
    <div class="panel-body">
        {!! Form::open(array('route' => array(config('larbac.routes.routeUser').'.update', $id), 'role' => 'form', 'method' => 'PUT')) !!}

        
        <div class="form-group">
        {!!Form::select('roles[]', $availRoles, $assignedRoles, 
            array('multiple'=>'multiple', "size"=>5, "style"=>"display:none"))
        !!}                
            {{$errors->first('roles[]', '<p class="text-danger">:message</p>')}}

        </div>         
         
        
        
            <button type="submit" class="btn btn-primary btn-sm">Save</button>
        {!! Form::close() !!}
    </div>
</div>

            
        </div>                    
    </div>

</div>

@stop

@section('footer-js')
@parent
<script src={{asset("vendor/larbac/js/duallistbox/jquery.bootstrap-duallistbox.min.js")}}></script>
<script>
    $(function () {
        
            var roles = $('select[name="roles[]"]').bootstrapDualListbox({
                nonSelectedListLabel: 'Available roles',
                selectedListLabel: 'Assigned roles',
                preserveSelectionOnMove: 'moved',
                moveOnSelect: true,
//                nonSelectedFilter: 'ion ([7-9]|[1][0-2])'
            });
          

    });
</script>
@stop