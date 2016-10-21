<?php

/**
 * Este archivo es parte del Módulo Libros.
 * (c) Johan Alvarez <llstarscreamll@hotmail.com>
 * Licensed under The MIT License (MIT).

 * @package    Módulo Libros.
 * @version    0.1
 * @author     Johan Alvarez.
 * @license    The MIT License (MIT).
 * @copyright  (c) 2015-2016, Johan Alvarez <llstarscreamll@hotmail.com>.
 * @link       https://github.com/llstarscreamll.
 */

namespace Books;

use \FunctionalTester;
use Page\Functional\Books\Index as Page;

class IndexCest
{
    public function _before(FunctionalTester $I)
    {
        new Page($I);
        $I->amLoggedAs(Page::$adminUser);
    }

    public function _after(FunctionalTester $I)
    {
    }

    /**
     * Prueba los datos mostrados en el index del módulo.
     * @param    FunctionalTester $I
     * @return  void
     */
    public function index(FunctionalTester $I)
    {
        $I->am('admin de '.trans('book/views.module.name'));
        $I->wantTo('ver datos en el index del modulo '.trans('book/views.module.name'));
        
        // creo el registro de prueba
        Page::haveBook($I);

        $I->amOnPage(Page::$moduleURL);
        $I->see(Page::$title['txt'], Page::$title['selector']);

        // veo los respectivos datos en la tabla
        foreach (Page::getIndexTableData() as $field => $value) {
            $I->see($value, Page::$table.' tbody tr.item-1 td.'.$field);
        }
    }
}