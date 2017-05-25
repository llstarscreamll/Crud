<?php

namespace Library\Book;

use Library\ApiTester;
use App\Containers\Library\Models\Book;

/**
 * GetBookCest Class.
 * 
 * @author  [name] <[<email address>]>
 */
class GetBookCest
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

    public function getBook(ApiTester $I)
    {
    	$data = factory(Book::class)->create();

        $I->sendGET(str_replace('{id}', $data->getHashedKey(), $this->endpoint));

        $I->seeResponseCodeIs(200);

        $I->seeResponseContainsJson(['reason_id' => $I->hashKey($data->reason_id)]);
        $I->seeResponseContainsJson(['name' => $data->name]);
        $I->seeResponseContainsJson(['author' => $data->author]);
        $I->seeResponseContainsJson(['genre' => $data->genre]);
        $I->seeResponseContainsJson(['stars' => $data->stars]);
        $I->seeResponseContainsJson(['enabled' => $data->enabled]);
        $I->seeResponseContainsJson(['status' => $data->status]);
        $I->seeResponseContainsJson(['synopsis' => $data->synopsis]);
        $I->seeResponseContainsJson(['approved_by' => $I->hashKey($data->approved_by)]);
    }
}
