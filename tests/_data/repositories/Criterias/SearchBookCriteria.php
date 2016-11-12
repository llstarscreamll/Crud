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

namespace App\Repositories\Criterias;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Illuminate\Support\Collection;

/**
 * Class SearchBookCriteria
 *
 * @author Johan Alvarez <llstarscreamll@hotmail.com>
 */
class SearchBookCriteria implements CriteriaInterface
{
    /**
     * @var Illuminate\Support\Collection
     */
    private $input;

    /**
     * Crea nueva instancia de SearchBookCriteria.
     *
     * @param  Request $request
     */
    public function __construct(Collection $input)
    {
        $this->input = $input;
    }

    /**
     * Apply criteria in query repository
     *
     * @param Book $model
     * @param RepositoryInterface $repository
     *
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->query();

        // buscamos basados en los datos que señale el usuario
        $this->input->get('ids') && $model->whereIn('id', $this->input->get('ids'));

        $this->input->get('reason_id') && $model->whereIn('reason_id', $this->input->get('reason_id'));

        $this->input->get('name') && $model->where('name', 'like', '%'.$this->input->get('name').'%');

        $this->input->get('author') && $model->where('author', 'like', '%'.$this->input->get('author').'%');

        $this->input->get('genre') && $model->where('genre', 'like', '%'.$this->input->get('genre').'%');

        $this->input->get('stars') && $model->where('stars', $this->input->get('stars'));

        $this->input->get('published_year')['informative'] && $model->whereBetween('published_year', [
            $this->input->get('published_year')['from'],
            $this->input->get('published_year')['to']
        ]);

        $this->input->get('enabled_true') && $model->where('enabled', true);
        ($this->input->get('enabled_false') && !$this->input->has('enabled_true')) && $model->where('enabled', false);
        ($this->input->get('enabled_false') && $this->input->has('enabled_true')) && $model->orWhere('enabled', false);

        $this->input->get('status') && $model->whereIn('status', $this->input->get('status'));

        $this->input->get('synopsis') && $model->where('synopsis', 'like', '%'.$this->input->get('synopsis').'%');

        $this->input->get('approved_at')['informative'] && $model->whereBetween('approved_at', [
            $this->input->get('approved_at')['from'],
            $this->input->get('approved_at')['to']
        ]);

        $this->input->get('approved_by') && $model->whereIn('approved_by', $this->input->get('approved_by'));

        $this->input->get('created_at')['informative'] && $model->whereBetween('created_at', [
            $this->input->get('created_at')['from'],
            $this->input->get('created_at')['to']
        ]);

        $this->input->get('updated_at')['informative'] && $model->whereBetween('updated_at', [
            $this->input->get('updated_at')['from'],
            $this->input->get('updated_at')['to']
        ]);

        $this->input->get('deleted_at')['informative'] && $model->whereBetween('deleted_at', [
            $this->input->get('deleted_at')['from'],
            $this->input->get('deleted_at')['to']
        ]);

        // registros en papelera
        $this->input->has('trashed_records') && $model->{$this->input->get('trashed_records')}();
        // ordenamos los resultados
        $model->orderBy($this->input->get('sort', 'created_at'), $this->input->get('sortType', 'desc'));

        return $model;
    }
}
