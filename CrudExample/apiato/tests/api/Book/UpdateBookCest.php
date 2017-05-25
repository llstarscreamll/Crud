<?php

namespace Library\Book;

use Library\ApiTester;
use App\Containers\Library\Models\Book;

/**
 * UpdateBookCest Class.
 * 
 * @author  [name] <[<email address>]>
 */
class UpdateBookCest
{
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

    public function updateBook(ApiTester $I)
    {
    	$oldItem = factory(Book::class)->create();
    	$newItem = factory(Book::class)->make();
        $data = $newItem->toArray();
        array_set($data, 'reason_id', $I->hashKey($newItem->reason_id));
        array_set($data, 'unlocking_word_confirmation', $newItem->unlocking_word);
        array_set($data, 'approved_by', $I->hashKey($newItem->approved_by));
        array_set($data, 'approved_password_confirmation', $newItem->approved_password);

        $I->sendPUT(str_replace('{id}', $oldItem->getHashedKey(), $this->endpoint), $data);

        $I->seeResponseCodeIs(200);

        $I->seeResponseContainsJson(['id' => $oldItem->getHashedKey()]);
        $I->seeResponseContainsJson(['reason_id' => $data['reason_id']]);
        $I->seeResponseContainsJson(['name' => $data['name']]);
        $I->seeResponseContainsJson(['author' => $data['author']]);
        $I->seeResponseContainsJson(['genre' => $data['genre']]);
        $I->seeResponseContainsJson(['stars' => $data['stars']]);
        $I->seeResponseContainsJson(['published_year' => $data['published_year']]);
        $I->seeResponseContainsJson(['enabled' => $data['enabled']]);
        $I->seeResponseContainsJson(['status' => $data['status']]);
        $I->seeResponseContainsJson(['synopsis' => $data['synopsis']]);
        $I->seeResponseContainsJson(['approved_at' => $data['approved_at']]);
        $I->seeResponseContainsJson(['approved_by' => $data['approved_by']]);
        $I->seeResponseJsonMatchesXpath('created_at');
        $I->seeResponseJsonMatchesXpath('updated_at');
        $I->seeResponseJsonMatchesXpath('deleted_at');
        
        $I->dontSeeRecord('books', $oldItem->toArray());
        $data = array_intersect_key($newItem->toArray(), array_flip($newItem->getFillable()));
        $I->seeRecord('books', $data);
    }
}
