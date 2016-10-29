<?php
/* @var $gen llstarscreamll\CrudGenerator\Providers\FormRequestGenerator */
/* @var $fields [] */
/* @var $test [] */
/* @var $request Request */
?>
<?='<?php'?>


<?= $gen->getClassCopyRightDocBlock() ?>


namespace <?= config('modules.CrudGenerator.config.parent-app-namespace') ?>\Http\Requests;

use Illuminate\Http\Response;
use Illuminate\Foundation\Http\FormRequest;
use <?= config('modules.CrudGenerator.config.parent-app-namespace') ?>\Models\<?= $gen->modelClassName() ?>;
<?php if ($request->get('use_x_editable', false)) { ?>
<?php if (class_exists(llstarscreamll\Core\Providers\CoreServiceProvider::class)) { ?>
use llstarscreamll\Core\Traits\FormRequestXEditableSetup;
<?php } else { ?>
use <?= config('modules.CrudGenerator.config.parent-app-namespace') ?>\Traits\FormRequestXEditableSetup;<?= config('modules.CrudGenerator.config.parent-app-namespace') ?>\Traits\FormRequestXEditableSetup;
<?php } ?>
<?php } else { ?>
<?php if (class_exists(llstarscreamll\Core\Providers\CoreServiceProvider::class)) { ?>
use llstarscreamll\Core\Traits\FormRequestBasicSetup;
<?php } else { ?>
use <?= config('modules.CrudGenerator.config.parent-app-namespace') ?>\Traits\FormRequestBasicSetup;
<?php } ?>
<?php } ?>

class <?= $gen->modelClassName()."Request" ?> extends FormRequest
{
<?php if ($request->get('use_x_editable', false)) { ?>
    use FormRequestXEditableSetup;
<?php } else { ?>
    use FormRequestBasicSetup;
<?php } ?>

    /**
     * @var <?= config('modules.CrudGenerator.config.parent-app-namespace') ?>\Models\<?= $gen->modelClassName() ?>

     */
    private $<?= $gen->modelVariableName() ?>;

    /**
     * @var array
     */
    private $routesAuthMap = [
        '<?=$gen->route()?>.store' => '<?=$gen->route()?>.create',
        '<?=$gen->route()?>.update' => '<?=$gen->route()?>.edit',
    ];

    /**
     * Ruta de acceso a ficheros de lengaje de mensajes de validación.
     *
     * @var string
     */
    private $messagesLangPath = '<?= $gen->getLangAccess() ?>/validation.messages';

    /**
     * Ruta de acceso a ficheros de lengaje de nombres de atributos de validación.
     *
     * @var string
     */
    private $attributesLangPath = '<?= $gen->getLangAccess() ?>/validation.attributes';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $route = $this->route()->getName();

        $permission = isset($this->routesAuthMap[$route])
            ? $this->routesAuthMap[$route]
            : $route;

        return auth()->user()->can($permission);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
<?php if ($gen->areEnumFields($fields)) { ?>
        $this-><?= $gen->modelVariableName() ?> = new <?= $gen->modelClassName() ?>;
<?php } ?>
        
        list($controller, $method) = explode("@", $this->route()->getActionName());
        $method = $method.'Rules';

        return $this->{$method}();
    }

    /**
     * Las reglas de validación para el método index.
     *
     * @return array
     */
    private function indexRules()
    {
        return [
<?php foreach ($fields as $field) { ?>
<?php if ($field->type == 'date' || $field->type == 'timestamp' || $field->type == 'datetime') { ?>
            'search.<?= $field->name ?>.from' => <?= $gen->getValidationRules($field, 'index') ?>,
            'search.<?= $field->name ?>.to' => <?= $gen->getValidationRules($field, 'index') ?>,
<?php } elseif ($field->type == "enum") { ?>
            'search.<?= $field->name ?>.*' => <?= $gen->getValidationRules($field, 'index') ?>,
<?php } elseif ($field->type == "tinyint") { ?>
            'search.<?= $field->name ?>_true' => <?= $gen->getValidationRules($field, 'index') ?>,
            'search.<?= $field->name ?>_false' => <?= $gen->getValidationRules($field, 'index') ?>,
<?php } else { ?>
            'search.<?= $field->name ?>' => <?= $gen->getValidationRules($field, 'index') ?>,
<?php } ?>
<?php } ?>
            'search.sort' => ['string'],
<?php if ($gen->hasDeletedAtColumn($fields)) { ?>
            'search.trashed_records' => ['in:onlyTrashed,withTrashed'],
<?php } ?>
        ];
    }

    /**
     * Las reglas de validación para el método store.
     *
     * @return array
     */
    private function storeRules()
    {
        return [
<?php foreach ($fields as $field) { ?>
            '<?= $field->name ?>' => <?= $gen->getValidationRules($field, 'store') ?>,
<?php } ?>
        ];
    }

    /**
     * Las reglas de validación para el método update.
     *
     * @return array
     */
    private function updateRules()
    {
        $rules = [
<?php foreach ($fields as $field) { ?>
            '<?= $field->name ?>' => <?= $gen->getValidationRules($field, 'update') ?>,
<?php } ?>
        ];

<?php if ($request->get('use_x_editable', false)) { ?>
        return $this->ajax() ? $this->setupXEditableAjaxRules($rules) : $rules;
<?php } else { ?>
        return $rules;
<?php } ?>
    }

    /**
     * Las reglas de validación para el método destroy.
     *
     * @return array
     */
    private function destroyRules()
    {
        return [
            'id' => ['array'],
            'id.*' => ['numeric'],
        ];
    }
<?php if ($gen->hasDeletedAtColumn($fields)) { ?>

    /**
     * Las reglas de validación para el método restore.
     *
     * @return array
     */
    private function restoreRules()
    {
        return $this->destroyRules();
    }
<?php } ?>
}
