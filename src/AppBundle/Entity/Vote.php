<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Vote
 *
 * @ORM\Table(name="vote")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VoteRepository")
 */
class Vote
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
     * @var bool
     *
     * @ORM\Column(name="isUp", type="boolean")
     */
    private $isUp;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="date")
     */
    private $createdAt;

    /**
     * @var ChallengeAnswer
     * @ORM\JoinColumn(name="answer_id", referencedColumnName="id")
     * @ORM\ManyToOne(targetEntity="ChallengeAnswer", inversedBy="votes")
     */
    private $answer;

    /**
     * @var User
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * @ORM\ManyToOne(targetEntity="User", inversedBy="votes")
     */
    private $user;


    public function _construct()
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
     * Set isUp
     *
     * @param boolean $isUp
     *
     * @return Vote
     */
    public function setIsUp($isUp)
    {
        $this->isUp = $isUp;

        return $this;
    }

    /**
     * Get isUp
     *
     * @return bool
     */
    public function getIsUp()
    {
        return $this->isUp;
    }

    /**
     * @return ChallengeAnswer
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * @param ChallengeAnswer $answer
     */
    public function setAnswer($answer)
    {
        $this->answer = $answer;
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

