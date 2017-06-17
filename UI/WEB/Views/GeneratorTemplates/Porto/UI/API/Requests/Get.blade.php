<?= "<?php\n" ?>

namespace App\Containers\{{ $crud->containerName() }}\UI\API\Requests{{ $crud->solveGroupClasses() }};

use App\Ship\Parents\Requests\Request;

/**
 * {{ str_replace('.php', '', $crud->apiRequestFile('Get', $plural = false)) }} Class.
 * 
 * @author [name] <[<email address>]>
 */
class {{ str_replace('.php', '', $crud->apiRequestFile('Get', $plural = false)) }} extends Request
{
	/**
     * Define which Roles and/or Permissions has access to this request.
     *
     * @var  array
     */
    protected $access = [
        'roles' => 'admin',
        'permissions' => '{{ $crud->slugEntityName(true) }}.details',
    ];

    /**
     * Id's that needs decoding before applying the validation rules.
     *
     * @var  array
     */
    protected $decode = [
        'id',
    ];

    /**
     * Defining the URL parameters (`/stores/999/items`) allows applying
     * validation rules on them and allows accessing them like request data.
     *
     * @var  array
     */
    protected $urlParameters = [
        'id',
    ];

    /**
     * @return  array
     */
    public function rules()
    {
        return [
            'id' => 'required|exists:{{ $crud->tableName }},id'
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
