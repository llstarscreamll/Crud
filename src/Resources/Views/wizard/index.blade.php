@extends(config('llstarscreamll.CrudGenerator.config.layout'))

@section('title') Generar CRUD @stop

@section('style')

@endsection

@section('content')
    
    <div class="content-header">
		<h1><a href="{{route('crudGenerator.index')}}">CrudGenerator</a></h1>
	</div>
	
    <div class="content">
        
        <div class="box">
            
            <div class="box-header">

                <div class="row">

                </div>

                @include (config('llstarscreamll.CrudGenerator.config.layout-namespace').'layout.notifications')

            </div>

            <div class="panel-body">
				
                {!! Form::open(['route' => 'crudGenerator.showOptions', 'method' => 'GET']) !!}
                    
                    <div class="col-md-8 col-md-offset-2">    
                    @include('CrudGenerator::wizard.partials.create-edit-form')
                    <div class="clearfix"></div>
                    <div class="form-group col-sm-3">
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