<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Test
 *
 * @ORM\Table(name="test")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TestRepository")
 */
class Test
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
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var int
     *
     * @ORM\Column(name="time", type="integer")
     */
    private $time;

    /**
     * @var int
     *
     * @ORM\Column(name="no_questions", type="integer")
     */
    private $noOfQuestions;

    /**
     * @var float
     *
     * @ORM\Column(name="total_score", type="float")
     */
    private $totalScore;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="date")
     */
    private $createdAt;

    /**
     * @var User
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * @ORM\ManyToOne(targetEntity="User", inversedBy="createdTests")
     */
    private $user;

    /**
     * @var UserTests
     *
     * @ORM\OneToMany(targetEntity="UserTests", mappedBy="test")
     */
    private $userTests;

    /**
     * @var Question
     *
     * @ORM\OneToMany(targetEntity="Question", mappedBy="test")
     */
    private $questions;
    /**
     * @var int
     *
     * @ORM\Column(name="category", type="integer")
     */
    private $category;



    public function __construct()
    {
        $this->createdAt = new \DateTime("now");
        $this->userTests = new ArrayCollection();
        $this->questions = new ArrayCollection();
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
     * Set title
     *
     * @param string $title
     *
     * @return Test
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set time
     *
     * @param integer $time
     *
     * @return Test
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Get time
     *
     * @return int
     */
    public function getTime()
    {
        return $this->time;
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
     * @return UserTests
     */
    public function getUserTests()
    {
        return $this->userTests;
    }

    /**
     * @param UserTests $userTests
     */
    public function setUserTests($userTests)
    {
        $this->userTests = $userTests;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return TestQuestions
     */
    public function getQuestions()
    {
        return $this->questions;
    }

    /**
     * @param TestQuestions $questions
     */
    public function setQuestions($questions)
    {
        $this->questions = $questions;
    }

    /**
     * @return int
     */
    public function getNoOfQuestions()
    {
        return $this->noOfQuestions;
    }

    /**
     * @param int $noOfQuestions
     */
    public function setNoOfQuestions($noOfQuestions)
    {
        $this->noOfQuestions = $noOfQuestions;
    }

    /**
     * @return float
     */
    public function getTotalScore()
    {
        return $this->totalScore;
    }

    /**
     * @param float $totalScore
     */
    public function setTotalScore($totalScore)
    {
        $this->totalScore = $totalScore;
    }

    /**
     * @return int
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param int $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }
}

