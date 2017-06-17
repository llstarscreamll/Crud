<?php
/* @var $crud App\Containers\Crud\Providers\FormRequestGenerator */
/* @var $fields [] */
/* @var $test [] */
/* @var $request Request */
?>
<?='<?php'?>


<?= $crud->getClassCopyRightDocBlock() ?>


namespace <?= config('modules.crud.config.parent-app-namespace') ?>\Http\Requests;

use Illuminate\Http\Response;
use Illuminate\Foundation\Http\FormRequest;
use <?= config('modules.crud.config.parent-app-namespace') ?>\Models\<?= $crud->modelClassName() ?>;
<?php if ($request->get('use_x_editable', false)) { ?>
<?php if ($crud->areWeUsingCoreModule()) { ?>
use llstarscreamll\Core\Traits\FormRequestXEditableSetup;
<?php } else { ?>
use <?= config('modules.crud.config.parent-app-namespace') ?>\Traits\FormRequestXEditableSetup;<?= config('modules.crud.config.parent-app-namespace') ?>\Traits\FormRequestXEditableSetup;
<?php } ?>
<?php } else { ?>
<?php if ($crud->areWeUsingCoreModule()) { ?>
use llstarscreamll\Core\Traits\FormRequestBasicSetup;
<?php } else { ?>
use <?= config('modules.crud.config.parent-app-namespace') ?>\Traits\FormRequestBasicSetup;
<?php } ?>
<?php } ?>

class <?= $crud->modelClassName()."Request" ?> extends FormRequest
{
<?php if ($request->get('use_x_editable', false)) { ?>
    use FormRequestXEditableSetup;
<?php } else { ?>
    use FormRequestBasicSetup;
<?php } ?>

    /**
     * @var <?= config('modules.crud.config.parent-app-namespace') ?>\Models\<?= $crud->modelClassName() ?>

     */
    private $<?= $crud->modelVariableName() ?>;

    /**
     * El prefijo para los campos de búsqueda.
     *
     * @var string
     */
    private $prefix;

    /**
     * @var array
     */
    private $routesAuthMap = [
        '<?= $crud->route() ?>.store' => '<?= $crud->route() ?>.create',
        '<?= $crud->route() ?>.update' => '<?= $crud->route() ?>.edit',
    ];

    /**
     * Ruta de acceso a ficheros de lengaje de mensajes de validación.
     *
     * @var string
     */
    private $messagesLangPath = '<?= $crud->getLangAccess() ?>.messages';

    /**
     * Ruta de acceso a ficheros de lengaje de nombres de atributos de validación.
     *
     * @var string
     */
    private $attributesLangPath = '<?= $crud->getLangAccess() ?>.attributes';

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
<?php if ($crud->areEnumFields($fields)) { ?>
        $this-><?= $crud->modelVariableName() ?> = new <?= $crud->modelClassName() ?>;
<?php } ?>
        $this->prefix = <?= $crud->getSearchFieldsPrefixConfigString() ?>;
        
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
            $this->prefix.'.<?= $field->name ?>.from' => <?= $crud->getValidationRules($field, 'index') ?>,
            $this->prefix.'.<?= $field->name ?>.to' => <?= $crud->getValidationRules($field, 'index') ?>,
<?php } elseif ($field->type == "enum") { ?>
            $this->prefix.'.<?= $field->name ?>.*' => <?= $crud->getValidationRules($field, 'index') ?>,
<?php } elseif ($field->type == "tinyint") { ?>
            $this->prefix.'.<?= $field->name ?>_true' => <?= $crud->getValidationRules($field, 'index') ?>,
            $this->prefix.'.<?= $field->name ?>_false' => <?= $crud->getValidationRules($field, 'index') ?>,
<?php } else { ?>
            $this->prefix.'.<?= $field->name ?>' => <?= $crud->getValidationRules($field, 'index') ?>,
<?php } ?>
<?php } ?>
            $this->prefix.'.sort' => ['string'],
<?php if ($crud->hasDeletedAtColumn($fields)) { ?>
            $this->prefix.'.trashed_records' => ['in:onlyTrashed,withTrashed'],
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
            '<?= $field->name ?>' => <?= $crud->getValidationRules($field, 'store') ?>,
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
            '<?= $field->name ?>' => <?= $crud->getValidationRules($field, 'update') ?>,
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
<?php if ($crud->hasDeletedAtColumn($fields)) { ?>

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
