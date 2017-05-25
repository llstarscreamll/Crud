<?php

namespace Library\Book;

use Library\ApiTester;
use App\Containers\Library\Models\Book;

/**
 * DeleteBookCest Class.
 * 
 * @author  [name] <[<email address>]>
 */
class DeleteBookCest
{
    /**
     * @var  string
     */
	private $endpoint = 'v1/books/{id}';

    /**
     * @var  App\Containers\User\Models\User
     */
    private $user;

    public function _before(ApiTester $I)
    {
    	$this->user = $I->loginAdminUser();
        $I->initBookData();
        $I->haveHttpHeader('Accept', 'application/json');
    }

    public function _after(ApiTester $I)
    {
    }

    public function deleteBook(ApiTester $I)
    {
    	$data = factory(Book::class)->create();

        $I->sendDELETE(str_replace('{id}', $data->getHashedKey(), $this->endpoint));
        $I->seeResponseCodeIs(202);

        $deletedItem = $I->grabRecord('books', ['id' => $data->id]);
        $I->assertNotNull($deletedItem['deleted_at']);
    }
}
