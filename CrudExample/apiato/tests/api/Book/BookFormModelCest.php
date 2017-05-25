<?php

namespace Library\Book;

use Library\ApiTester;
use App\Containers\Library\Models\Book;

/**
 * BookFormModelCest Class.
 * 
 * @author  [name] <[<email address>]>
 */
class BookFormModelCest
{
/**
     * @var  string
     */
    private $endpoint = 'v1/books/form-model';

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

    public function formModelConfigFromBook(ApiTester $I)
    {        
        $I->sendGET($this->endpoint);

        $I->seeResponseCodeIs(200);

        $I->seeResponseJsonMatchesXpath('reason_id');
        $I->seeResponseJsonMatchesXpath('name');
        $I->seeResponseJsonMatchesXpath('author');
        $I->seeResponseJsonMatchesXpath('genre');
        $I->seeResponseJsonMatchesXpath('stars');
        $I->seeResponseJsonMatchesXpath('published_year');
        $I->seeResponseJsonMatchesXpath('enabled');
        $I->seeResponseJsonMatchesXpath('status');
        $I->seeResponseJsonMatchesXpath('unlocking_word');
        $I->seeResponseJsonMatchesXpath('synopsis');
        $I->seeResponseJsonMatchesXpath('approved_at');
        $I->seeResponseJsonMatchesXpath('approved_by');
        $I->seeResponseJsonMatchesXpath('approved_password');
    }
}
