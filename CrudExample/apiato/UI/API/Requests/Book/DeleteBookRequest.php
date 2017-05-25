<?php

namespace App\Containers\Library\UI\API\Requests\Book;

use App\Ship\Parents\Requests\Request;

/**
 * Class DeleteBookRequest.
 * 
 * @author  [name] <[<email address>]>
 */
class DeleteBookRequest extends Request
{

    /**
     * Define which Roles and/or Permissions has access to this request..
     *
     * @var    array
     */
    protected $access = [
        'roles' => 'admin',
        'permissions' => 'book.delete',
    ];

    /**
     * Id's that needs decoding before applying the validation rules.
     *
     * @var    array
     */
    protected $decode = [
        'id',
    ];

    /**
     * Defining the URL parameters (`/stores/999/items`) allows applying
     * validation rules on them and allows accessing them like request data.
     *
     * @var    array
     */
    protected $urlParameters = [
        'id',
    ];

    /**
     * @return    array
     */
    public function rules()
    {
        return [
            'id' => 'required|exists:books,id',
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
