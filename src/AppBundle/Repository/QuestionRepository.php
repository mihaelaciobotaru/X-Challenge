<?php

namespace AppBundle\Repository;

/**
 * QuestionRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class QuestionRepository extends \Doctrine\ORM\EntityRepository
{
    public function getNullQuestions($cid){
        $query = $this->createQueryBuilder('q')
            ->where('q.test is null')
            ->andWhere('q.category = :cid')
            ->setParameter('cid', $cid)
            ->getQuery();
        return $query->getResult();
    }


    public function getRandomQuestions($noquest){
        $query = $this->createQueryBuilder('q')
                    ->where('q.id in (:noquest)')
                    ->setParameter('noquest', $noquest)
                    ->getQuery();
        return $query->getArrayResult();
    }
}
