<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ranking
 *
 * @ORM\Table(name="ranking")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RankingRepository")
 */
class Ranking
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var float
     *
     * @ORM\Column(name="testScores", type="float", nullable=true)
     */
    private $testScores;

    /**
     * @var float
     *
     * @ORM\Column(name="voteScores", type="float", nullable=true)
     */
    private $voteScores;

    /**
     * @var float
     *
     * @ORM\Column(name="activityScores", type="float", nullable=true)
     */
    private $activityScores;

    /**
     * @var User
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * @ORM\OneToOne(targetEntity="User", mappedBy="rank")
     */
    private $user;

    public function __construct()
    {
        $this->testScores = 0;
        $this->voteScores = 0;
        $this->activityScores = 0;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set testScores
     *
     * @param float $testScores
     *
     * @return Ranking
     */
    public function setTestScores($testScores)
    {
        $this->testScores += $testScores;

        return $this;
    }

    /**
     * Get testScores
     *
     * @return float
     */
    public function getTestScores()
    {
        return $this->testScores;
    }

    /**
     * Set voteScores
     *
     * @param float $voteScores
     *
     * @return Ranking
     */
    public function setVoteScores($voteScores)
    {
        $this->voteScores += $voteScores;

        return $this;
    }

    /**
     * Get voteScores
     *
     * @return float
     */
    public function getVoteScores()
    {
        return $this->voteScores;
    }

    /**
     * Set activityScores
     *
     * @param float $activityScores
     *
     * @return Ranking
     */
    public function setActivityScores($activityScores)
    {
        $this->activityScores += $activityScores;

        return $this;
    }

    /**
     * Get activityScores
     *
     * @return float
     */
    public function getActivityScores()
    {
        return $this->activityScores;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }
}

