    /**
     * Init the {{ $gen->entityName() }} data dependencies.
     *
     * @return void
     */
    public function init{{ $gen->entityName() }}Data()
    {
        Artisan::call('db:seed', ['--class' => {{ $gen->entityName() }}PermissionsSeeder::class]);
        // more stuff here
    }
