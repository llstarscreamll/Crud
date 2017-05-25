<?php

namespace Library\Book;

use Library\ApiTester;
use App\Containers\Library\Models\Book;

/**
 * ListAndSearchBookCest Class.
 * 
 * @author  [name] <[<email address>]>
 */
class ListAndSearchBooksCest
{
    /**
     * @var  string
     */
	private $endpoint = 'v1/books';

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

    public function listAndSearchBook(ApiTester $I)
    {
    	$data = factory(Book::class, 10)->create();

        $I->sendGET($this->endpoint);

        $I->seeResponseCodeIs(200);
        $response = json_decode($I->grabResponse());
        $I->assertCount(10, $response->data);
    }
}