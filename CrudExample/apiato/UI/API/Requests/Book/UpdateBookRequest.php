<?php

namespace App\Containers\Library\UI\API\Requests\Book;

use App\Ship\Parents\Requests\Request;

/**
 * UpdateBookRequest Class.
 * 
 * @author  [name] <[<email address>]>
 */
class UpdateBookRequest extends Request
{
	/**
     * Define which Roles and/or Permissions has access to this request.
     *
     * @var    array
     */
    protected $access = [
        'roles' => 'admin',
        'permissions' => 'books.update',
    ];

    /**
     * Id's that needs decoding before applying the validation rules.
     *
     * @var    array
     */
    protected $decode = [
        'id',
        'reason_id',
        'approved_by',
    ];

    /**
     * Defining the URL parameters (`/stores/999/items`) allows applying
     * validation rules on them and allows accessing them like request data.
     *
     * @var    array
     */
    protected $urlParameters = [
        'id'
    ];

    /**
     * @return    array
     */
    public function rules()
    {
        return [
			'reason_id' => 'numeric|exists:reasons,id',
			'name' => 'required|string',
			'author' => 'required|string',
			'genre' => 'required|string',
			'stars' => 'numeric|min:1|max:5',
			'published_year' => 'required|date:Y',
			'enabled' => 'boolean',
			'status' => 'required|string',
			'unlocking_word' => 'required|string|confirmed',
			'synopsis' => 'string',
			'approved_at' => 'date:Y-m-d H:i:s',
			'approved_by' => 'exists:users,id',
			'approved_password' => 'string|confirmed',
        ];
    }

    /**
     * @return    bool
     */
    public function authorize()
    {
        return $this->check([
            'hasAccess',
        ]);
    }
}
