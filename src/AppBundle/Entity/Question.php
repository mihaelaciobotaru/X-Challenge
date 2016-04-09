<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Question
 *
 * @ORM\Table(name="question")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\QuestionRepository")
 */
class Question
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
     * @ORM\Column(name="text", type="string", length=255)
     */
    private $text;

    /**
     * @var float
     *
     * @ORM\Column(name="score", type="float")
     */
    private $score;

    /*The answerList field will be a JSON containing AnswerText + a boolean value (correct answer/incorrect answer)*/

    /**
     * @var string
     *
     * @ORM\Column(name="answer", type="string", length=2500)
     */
    private $answerList;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="date")
     */
    private $createdAt;

    /**
     * @var Test
     * @ORM\JoinColumn(name="test_id", referencedColumnName="id", nullable=true)
     * @ORM\ManyToOne(targetEntity="Test", inversedBy="questions")
     */
    private $test;


    /**
     * @var Category
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="questions")
     */
    private $category;

    /**
     * @var User
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * @ORM\ManyToOne(targetEntity="User", inversedBy="questions")
     */
    private $user;


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
     * Set text
     *
     * @param string $text
     *
     * @return Question
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set score
     *
     * @param float $score
     *
     * @return Question
     */
    public function setScore($score)
    {
        $this->score = $score;

        return $this;
    }

    /**
     * Get score
     *
     * @return float
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * Set answer
     *
     * @param string $answerList
     *
     * @return Question
     */
    public function setAnswerList($answerList)
    {
        $this->answerList = $answerList;

        return $this;
    }

    /**
     * Get answerList
     *
     * @return string
     */
    public function getAnswerList()
    {
        return $this->answerList;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Question
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

    /**
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param Category $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
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

