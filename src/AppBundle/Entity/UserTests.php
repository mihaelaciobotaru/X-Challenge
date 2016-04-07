<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserTests
 *
 * @ORM\Table(name="user_tests")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserTestsRepository")
 */
class UserTests
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
     * @var int
     *
     * @ORM\Column(name="usedTime", type="integer")
     */
    private $usedTime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateSolved", type="date")
     */
    private $dateSolved;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="date")
     */
    private $createdAt;

    /**
     * @var float
     *
     * @ORM\Column(name="userScore", type="float")
     */
    private $userScore;


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
     * Set usedTime
     *
     * @param integer $usedTime
     *
     * @return UserTests
     */
    public function setUsedTime($usedTime)
    {
        $this->usedTime = $usedTime;

        return $this;
    }

    /**
     * Get usedTime
     *
     * @return int
     */
    public function getUsedTime()
    {
        return $this->usedTime;
    }

    /**
     * Set dateSolved
     *
     * @param \DateTime $dateSolved
     *
     * @return UserTests
     */
    public function setDateSolved($dateSolved)
    {
        $this->dateSolved = $dateSolved;

        return $this;
    }

    /**
     * Get dateSolved
     *
     * @return \DateTime
     */
    public function getDateSolved()
    {
        return $this->dateSolved;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return UserTests
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set userScore
     *
     * @param float $userScore
     *
     * @return UserTests
     */
    public function setUserScore($userScore)
    {
        $this->userScore = $userScore;

        return $this;
    }

    /**
     * Get userScore
     *
     * @return float
     */
    public function getUserScore()
    {
        return $this->userScore;
    }
}

