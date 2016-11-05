<?php
/* @var $gen llstarscreamll\CrudGenerator\Providers\TestsGenerator */
/* @var $fields [] */
/* @var $request Request */
?>
<?='<?php'?>


<?= $gen->getClassCopyRightDocBlock() ?>


namespace <?= config('modules.CrudGenerator.config.parent-app-namespace') ?>\Repositories\Contracts;

use Prettus\Repository\Contracts\RepositoryInterface;

interface <?= $gen->modelClassName() ?>Repository extends RepositoryInterface
{
    public function getRequested(Collection $request, array $columns = ['*'], int $rows = 15);

    public function getSelectList();

    public function getEnumValuesArray(string $column);

    public function getEnumFieldSelectList(string $column);

    public function destroy($ids);
    
    public function restore($ids);

}
