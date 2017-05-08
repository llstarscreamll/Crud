<?php

namespace App\Ship\Criterias\Eloquent;

use App\Ship\Parents\Criterias\Criteria;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

/**
 * Class TrashedCriteria
 *
 * @author Johan Alvarez <llstarscreaml@hotmail.com>
 */
class TrashedCriteria extends Criteria
{

    /**
     * @var
     */
    private $trashed;

    /**
     * ThisFieldCriteria constructor.
     *
     * @param $trashed
     */
    public function __construct($trashed)
    {
        $this->trashed = $trashed;
    }

    /**
     * @param                                                   $model
     * @param \Prettus\Repository\Contracts\RepositoryInterface $repository
     *
     * @return  mixed
     */
    public function apply($model, PrettusRepositoryInterface $repository)
    {
        switch ($this->trashed) {
            case 'withTrashed':
                return $model->withTrashed();
                break;

            case 'onlyTrashed':
                return $model->onlyTrashed();
                break;
            
            default:
                return $model;
                break;
        }
    }
}
