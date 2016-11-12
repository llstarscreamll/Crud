<?php
/* @var $gen llstarscreamll\Crud\Providers\TestsGenerator */
/* @var $fields [] */
/* @var $request Request */
?>
<?='<?php'?>


<?= $gen->getClassCopyRightDocBlock() ?>


namespace <?= config('modules.crud.config.parent-app-namespace') ?>\Repositories\Contracts;

use Prettus\Repository\Contracts\RepositoryInterface;
use Illuminate\Support\Collection;

/**
 * Interfaz <?= $gen->modelClassName()."Repository\n" ?>
 *
 * @author <?= config('modules.crud.config.author') ?> <<?= config('modules.crud.config.author_email') ?>>
 */
interface <?= $gen->modelClassName() ?>Repository extends RepositoryInterface
{
    public function getRequested(Collection $request, array $columns = ['*'], int $rows = 15);

    public function getSelectList();

    public function getEnumValuesArray(string $column);

    public function getEnumFieldSelectList(string $column);
<?php if ($gen->hasDeletedAtColumn($fields)) { ?>
    
    public function destroy($ids);
    
    public function restore($ids);
<?php } ?>
}
