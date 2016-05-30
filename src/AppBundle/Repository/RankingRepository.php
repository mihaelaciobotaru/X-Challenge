<?php

namespace AppBundle\Repository;

/**
 * RankingRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class RankingRepository extends \Doctrine\ORM\EntityRepository
{
    public function getUserInTopForTests($testScore)
    {
        $query = $this->createQueryBuilder('u')
            ->select("count(u.id) + 1 as no")
            ->where("u.testScores > :param")
            ->setParameter("param", $testScore);

        return $query->getQuery()->getSingleScalarResult();
    }

    public function getUserInTopForVotes($voteScore)
    {
        $query = $this->createQueryBuilder('u')
            ->select("count(u.id) + 1 as no")
            ->where("u.voteScores > :param")
            ->setParameter("param", $voteScore);

        return $query->getQuery()->getSingleScalarResult();
    }

    public function getUserInTopForActivity($activityScore)
    {
        $query = $this->createQueryBuilder('u')
            ->select("count(u.id) + 1 as no")
            ->where("u.activityScores > :param")
            ->setParameter("param", $activityScore);

        return $query->getQuery()->getSingleScalarResult();
    }

    public function getTestRanking()
    {
        $qb = $this->createQueryBuilder('r');
        $qb
            ->select('u.id, u.username, r.testScores')
            ->leftJoin(
                'AppBundle\Entity\User',
                'u',
                'WITH',
                'r.user = u.id'
            )
            ->orderBy('r.testScores', 'DESC');

        return $qb->getQuery()->getResult();
    }

    public function getVoteRanking()
    {
        $qb = $this->createQueryBuilder('r');
        $qb
            ->select('u.id, u.username, r.voteScores')
            ->leftJoin(
                'AppBundle\Entity\User',
                'u',
                'WITH',
                'r.user = u.id'
            )
            ->orderBy('r.voteScores', 'DESC');

        return $qb->getQuery()->getResult();
    }

    public function getActivityRanking()
    {
        $qb = $this->createQueryBuilder('r');
        $qb
            ->select('u.id, u.username, r.activityScores')
            ->leftJoin(
                'AppBundle\Entity\User',
                'u',
                'WITH',
                'r.user = u.id'
            )
            ->orderBy('r.activityScores', 'DESC');

        return $qb->getQuery()->getResult();
    }
    public function getGeneralRanking()
    {
        $qb = $this->createQueryBuilder('r');
        $qb
            ->select('u.id, u.username, (r.activityScores + r.voteScores + r.testScores) as total')
            ->leftJoin(
                'AppBundle\Entity\User',
                'u',
                'WITH',
                'r.user = u.id'
            )
            ->orderBy('total', 'DESC');

        return $qb->getQuery()->getResult();
    }
}
