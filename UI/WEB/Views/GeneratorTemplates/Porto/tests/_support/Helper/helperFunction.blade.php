    /**
     * Init the {{ $crud->entityName() }} data dependencies.
     *
     * @return void
     */
    public function init{{ $crud->entityName() }}Data()
    {
        Artisan::call('db:seed', ['--class' => {{ $crud->entityName() }}PermissionsSeeder::class]);
        // more stuff here
    }
