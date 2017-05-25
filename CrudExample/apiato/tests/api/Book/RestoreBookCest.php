<?php

namespace Library\Book;

use Library\ApiTester;
use App\Containers\Library\Models\Book;

/**
 * RestoreBookCest Class.
 * 
 * @author  [name] <[<email address>]>
 */
class RestoreBookCest
{
    /**
     * @var  string
     */
	private $endpoint = 'v1/books/{id}/restore';

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

    public function restoreBook(ApiTester $I)
    {
    	$item = factory(Book::class)->create();
    	Book::destroy($item->id);

        $I->sendPOST(str_replace('{id}', $item->getHashedKey(), $this->endpoint));
        $I->seeResponseCodeIs(200);

        $restoredItem = $I->grabRecord('books', ['id' => $item->id]);
        $I->assertNull($restoredItem['deleted_at']);

        $data = array_intersect_key($item->toArray(), array_flip($item->getFillable()));
        $I->seeRecord('books', $data);
    }
}