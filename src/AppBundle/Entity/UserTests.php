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
     * @ORM\Column(name="solved_date", type="date")
     */
    private $solvedDate;

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
     * @var User
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * @ORM\ManyToOne(targetEntity="User", inversedBy="solvedTests")
     */
    private $user;

    /**
     * @var Test
     * @ORM\JoinColumn(name="test_id", referencedColumnName="id")
     * @ORM\ManyToOne(targetEntity="Test", inversedBy="userTests")
     */
    private $test;


    public function __construct()
    {
        $this->createdAt = new \DateTime("now");
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
     * @return \DateTime
     */
    public function getSolvedDate()
    {
        return $this->solvedDate;
    }

    /**
     * @param \DateTime $solvedDate
     */
    public function setSolvedDate($solvedDate)
    {
        $this->solvedDate = $solvedDate;
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

    /**
     * @return Test
     */
    public function getTest()
    {
        return $this->test;
    }

    /**
     * @param Test $test
     */
    public function setTest($test)
    {
        $this->test = $test;
    }
}

