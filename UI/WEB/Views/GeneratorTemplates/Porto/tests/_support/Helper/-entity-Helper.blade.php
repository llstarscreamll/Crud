<?= "<?php\n" ?>

namespace {{ $gen->containerName() }}\Helper;

@foreach ($fields->unique('namespace') as $field)
@if($field->namespace)
use {{ $field->namespace }};
@endif
@endforeach
use App\Containers\{{ $gen->containerName() }}\Data\Seeders\{{ $gen->entityName() }}PermissionsSeeder;
use Artisan;

/**
 * {{ $gen->entityName() }}Helper Class.
 * 
 * @author [name] <[<email address>]>
 */
class {{ $gen->entityName() }}Helper extends \Codeception\Module
{
    /**
     * Inits the {{ $gen->entityName() }} dependency data.
     *
     * @return void
     */
    public function initData()
    {
    	Artisan::call('db:seed', ['--class' => {{ $gen->entityName() }}PermissionsSeeder::class]);
@foreach ($fields->unique('namespace') as $field)
@if($field->namespace)
        factory({{ class_basename($field->namespace) }}::class, 3)->create();
@endif
@endforeach
    }
}
