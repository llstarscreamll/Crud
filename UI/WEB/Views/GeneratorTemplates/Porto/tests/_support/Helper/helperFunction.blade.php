    /**
     * Init the {{ $gen->entityName() }} data dependencies.
     *
     * @return void
     */
    public function init{{ $gen->entityName() }}Data()
    {
        Artisan::call('db:seed', ['--class' => {{ $gen->entityName() }}PermissionsSeeder::class]);
@foreach ($fields->unique('namespace') as $field)
@if($field->namespace)
        factory({{ class_basename($field->namespace) }}::class, 3)->create();
@endif
@endforeach
    }
