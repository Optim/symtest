<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpFoundation\Request;

class ListReasonRepository extends EntityRepository
{
    /**
     *
     * @param $request Request
     * @param $isUserReason integer
     *
     * @return array
     */
    public function sortFromIndex(Request $request , $isUserReason)
    {
        $query = $this->createQueryBuilder('a');
        if($request->query->has('sort') and $request->query->has('direction'))
        {
            $sortField = $request->get('sort');
            $sortDirection = $request->get('direction');
            $query->addOrderBy($sortField, $sortDirection);
        } else
        {
            $query->addOrderBy('a.nameReason', 'DESC');
        }
        if(isset($isUserReason))
        {
            $query
                ->where('a.isUserReason=:isUserReason')
                ->setParameter(':isUserReason',$isUserReason);
        }
        return $query->getQuery()->getResult();
    }
}
