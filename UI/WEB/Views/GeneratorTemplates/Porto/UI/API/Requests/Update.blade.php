<?= "<?php\n" ?>

namespace App\Containers\{{ $gen->containerName() }}\UI\API\Requests{{ $gen->solveGroupClasses() }};

use App\Ship\Parents\Requests\Request;

/**
 * {{ str_replace('.php', '', $gen->apiRequestFile('Update', $plural = false)) }} Class.
 * 
 * @author [name] <[<email address>]>
 */
class {{ str_replace('.php', '', $gen->apiRequestFile('Update', $plural = false)) }} extends Request
{
	/**
     * Define which Roles and/or Permissions has access to this request.
     *
     * @var  array
     */
    protected $access = [
        'roles' => 'admin',
        'permissions' => '{{ $gen->slugEntityName() }}.update',
    ];

    /**
     * Id's that needs decoding before applying the validation rules.
     *
     * @var  array
     */
    protected $decode = [
        'id',
@foreach ($fields as $field)
@if($field->namespace && $field->fillable)
        '{{ $field->name }}',
@endif
@endforeach
    ];

    /**
     * Defining the URL parameters (`/stores/999/items`) allows applying
     * validation rules on them and allows accessing them like request data.
     *
     * @var  array
     */
    protected $urlParameters = [
        'id'
    ];

    /**
     * @return  array
     */
    public function rules()
    {
        return [
@foreach ($fields as $field)
@if(!empty($field->validation_rules) && $field->fillable)
			'{{ $field->name }}' => '{{ $field->validation_rules }}',
@endif
@endforeach
        ];
    }

    /**
     * @return  bool
     */
    public function authorize()
    {
        return $this->check([
            'hasAccess',
        ]);
    }
}
