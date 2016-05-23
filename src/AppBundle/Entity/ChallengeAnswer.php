<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;


/**
 * ChallengeAnswer
 *
 * @ORM\Table(name="challenge_answer")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ChallengeAnswerRepository")
 */
class ChallengeAnswer
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
     * @ORM\Column(name="answer", type="string", length=2550)
     */
    private $answer;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="date")
     */
    private $createdAt;


    /**
     * @var User
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * @ORM\ManyToOne(targetEntity="User", inversedBy="challengeAnswers")
     */
    private $user;

    /**
     * @var Challenge
     * @ORM\JoinColumn(name="challenge_id", referencedColumnName="id")
     * @ORM\ManyToOne(targetEntity="Challenge", inversedBy="challengeAnswers")
     */
    private $challenge;

    /**
     * @var Vote
     *
     * @ORM\OneToMany(targetEntity="Vote", mappedBy="answer")
     */
    private $votes;


    public function __construct()
    {
        $this->createdAt = new \DateTime("now");
        $this->votes = new ArrayCollection();
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
     * Set answer
     *
     * @param string $answer
     *
     * @return ChallengeAnswer
     */
    public function setAnswer($answer)
    {
        $this->answer = $answer;

        return $this;
    }

    /**
     * Get answer
     *
     * @return string
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return ChallengeAnswer
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
     * @return Challenge
     */
    public function getChallenge()
    {
        return $this->challenge;
    }

    /**
     * @param Challenge $challenge
     */
    public function setChallenge($challenge)
    {
        $this->challenge = $challenge;
    }

    /**
     * @return Vote
     */
    public function getVotes()
    {
        return $this->votes;
    }

    /**
     * @param Vote $votes
     */
    public function setVotes($votes)
    {
        $this->votes = $votes;
    }
}

