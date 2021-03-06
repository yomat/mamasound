<?php

namespace AppBundle\Repository;

/**
 * GroupeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class GroupeRepository extends \Doctrine\ORM\EntityRepository
{

    public function getGroupes(){
        $qb = $this -> _em -> createQueryBuilder()
            -> select('g')
            -> from('AppBundle:Groupe', 'g');
        return $qb -> getQuery() -> getResult();
    }

    public function getGroupesJSON(){
        $qb = $this -> _em -> createQueryBuilder()
            -> select('g')
            -> from('AppBundle:Groupe', 'g');
        return $qb -> getQuery() -> getArrayResult();
    }

    public function getGroupesLike($search_term){
        $qb = $this -> _em -> createQueryBuilder()
            -> select('g')
            -> from('AppBundle:Groupe', 'g')
            -> where('g.name LIKE :search_term')
            -> setParameter('search_term', '%'.$search_term.'%')
            -> orderBy('g.name', 'ASC')
        ;
        return $qb -> getQuery() -> getResult();
    }

    public function getGroupesLikeJSON($search_term){
        $qb = $this -> _em -> createQueryBuilder()
            -> select('g')
            -> from('AppBundle:Groupe', 'g')
            -> where('g.name LIKE :search_term')
            -> setParameter('search_term', '%'.$search_term.'%')
            -> orderBy('g.name', 'ASC')
        ;
        return $qb -> getQuery() -> getArrayResult();
    }

}
