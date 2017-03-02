<?php

namespace AppBundle\Repository;

/**
 * PlaceRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PlaceRepository extends \Doctrine\ORM\EntityRepository
{


    public function getPlaces(){
        $qb = $this -> _em -> createQueryBuilder()
            -> select('p')
            -> from('AppBundle:Place', 'p');
        return $qb -> getQuery() -> getResult();
    }

}
