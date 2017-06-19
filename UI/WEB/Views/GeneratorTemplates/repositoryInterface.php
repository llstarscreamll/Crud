<?php
/* @var $crud App\Containers\Crud\Providers\TestsGenerator */
/* @var $fields [] */
/* @var $request Request */
?>
<?='<?php'?>


<?= $crud->getClassCopyRightDocBlock() ?>


namespace <?= config('modules.crud.config.parent-app-namespace') ?>\Repositories\Contracts;

use Prettus\Repository\Contracts\RepositoryInterface;
use Illuminate\Support\Collection;

/**
 * Interfaz <?= $crud->modelClassName()."Repository\n" ?>
 *
 * @author <?= config('modules.crud.config.author') ?> <<?= config('modules.crud.config.author_email') ?>>
 */
interface <?= $crud->modelClassName() ?>Repository extends RepositoryInterface
{
    public function getRequested(Collection $request, array $columns = ['*'], int $rows = 15);

    public function getSelectList();

    public function getEnumValuesArray(string $column);

    public function getEnumFieldSelectList(string $column);
    
    public function destroy($ids);
<?php if ($crud->hasDeletedAtColumn($fields)) { ?>
    
    public function restore($ids);
<?php } ?>
}
