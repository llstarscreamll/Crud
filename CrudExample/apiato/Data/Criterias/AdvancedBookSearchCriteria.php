<?php

namespace App\Containers\Library\Data\Criterias;

use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;
use App\Ship\Parents\Criterias\Criteria;

/**
 * AdvancedBookSearchCriteria Class.
 * 
 * @author  [name] <[<email address>]>
 */
class AdvancedBookSearchCriteria extends Criteria
{
	private $input;

    /**
     * Create new AdvancedBookSearchCriteria instance.
     *
     * @param    Request $request
     */
    public function __construct($input)
    {
        $this->input = $input;
    }

	/**
     * @param  $model
     * @param  PrettusRepositoryInterface $repository
     *
     * @return  Illuminate\Database\Eloquent\Builder
     */
	public function apply($model, PrettusRepositoryInterface $repository)
    {
        $model = $this->input->has('id')
            ? $model->whereIn('id', $this->input->get('ids'))
            : $model;

        $model = $this->input->has('reason_id')
            ? $model->whereIn('reason_id', $this->input->get('reason_id'))
            : $model;

        $model = $this->input->has('name')
            ? $model->where('name', 'like', '%'.$this->input->get('name').'%')
            : $model;

        $model = $this->input->has('author')
            ? $model->where('author', 'like', '%'.$this->input->get('author').'%')
            : $model;

        $model = $this->input->has('genre')
            ? $model->where('genre', 'like', '%'.$this->input->get('genre').'%')
            : $model;

        $model = $this->input->has('stars')
            ? $model->where('stars', $this->input->get('stars'))
            : $model;

        $model = $this->input->has('published_year')
            ? $model->whereBetween('published_year', $this->input->get('published_year'))
            : $model;

        $model = $this->input->has('enabled_true')
            ? $model->where(&#039;enabled&#039;, true)
            : $model;

        $model = $this->input->has('enabled_false' && !$this->input->has('enabled_true')
            ? $model->where(&#039;enabled&#039;, false)
            : $model;

        $model = $this->input->has('enabled_false') && $this->input->has('enabled_true')
            ? $model->orWhere(&#039;enabled&#039;, false)
            : $model;

        $model = $this->input->has('status')
            ? $model->whereIn('status', $this->input->get('status'))
            : $model;

        $model = $this->input->has('synopsis')
            ? $model->where('synopsis', 'like', '%'.$this->input->get('synopsis').'%')
            : $model;

        $model = $this->input->has('approved_at')
            ? $model->whereBetween('approved_at', $this->input->get('approved_at'))
            : $model;

        $model = $this->input->has('approved_by')
            ? $model->whereIn('approved_by', $this->input->get('approved_by'))
            : $model;

        $model = $this->input->has('created_at')
            ? $model->whereBetween('created_at', $this->input->get('created_at'))
            : $model;

        $model = $this->input->has('updated_at')
            ? $model->whereBetween('updated_at', $this->input->get('updated_at'))
            : $model;

        $model = $this->input->has('deleted_at')
            ? $model->whereBetween('deleted_at', $this->input->get('deleted_at'))
            : $model;

        // sort results
        $model->orderBy($this->input->get('orderBy', 'created_at'), $this->input->get('sortedBy', 'desc'));

        return $model;
    }
}