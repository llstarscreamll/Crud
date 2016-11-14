<?php

/**
 * Este archivo es parte de Books.
 * (c) Johan Alvarez <llstarscreamll@hotmail.com>
 * Licensed under The MIT License (MIT).
 *
 * @package    Books
 * @version    0.1
 * @author     Johan Alvarez
 * @license    The MIT License (MIT)
 * @copyright  (c) 2015-2016, Johan Alvarez <llstarscreamll@hotmail.com>
 * @link       https://github.com/llstarscreamll
 */

namespace App\Repositories\Contracts;

use Prettus\Repository\Contracts\RepositoryInterface;
use Illuminate\Support\Collection;

/**
 * Interfaz BookRepository
 *
 * @author Johan Alvarez <llstarscreamll@hotmail.com>
 */
interface BookRepository extends RepositoryInterface
{
    public function getRequested(Collection $request, array $columns = ['*'], int $rows = 15);

    public function getSelectList();

    public function getEnumValuesArray(string $column);

    public function getEnumFieldSelectList(string $column);
    
    public function destroy($ids);
    
    public function restore($ids);
}
