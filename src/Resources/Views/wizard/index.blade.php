@extends(config('modules.CrudGenerator.config.layout'))

@section('title') Generar CRUD @stop

@section('style')

@endsection

@section('content')	
<div class="content col-sm-6">
    <div class="panel panel-default">
        
        <div class="panel-heading">
            CrudGenerator
        </div>

        <div class="panel-body">
            @include (config('modules.CrudGenerator.config.layout-namespace').'partials.notifications')
			
            {!! Form::open(['route' => 'crudGenerator.showOptions', 'method' => 'GET']) !!}
                
                <div class="col-sm-8 col-sm-offset-2">    
                    @include('crud::wizard.partials.create-edit-form')

                    <div class="clearfix"></div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            Generar
                        </button>
                    </div>
                </div>

			{!! Form::close() !!}
			
        </div>
    </div>
</div>

@endsection

@section('script')

    <script type="text/javascript">
    
        $(".bootstrap_switch").bootstrapSwitch();
        
    </script>

@stop()