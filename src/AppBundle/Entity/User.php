<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User implements UserInterface, AdvancedUserInterface ,\Serializable
{
    const TYPE_ADMIN = 1;
    const TYPE_MASTER = 2;
    const TYPE_APPRENTICE = 3;
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
     * @ORM\Column(name="username", type="string", length=255, unique=true)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=255, nullable=true)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=255, nullable=true)
     */
    private $lastName;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=4096)
     */
    private $plainPassword;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updatedAt", type="datetime")
     */
    private $updatedAt;


    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     * @var int
     *
     * @ORM\Column(name="type", type="integer")
     */
    private $type;

    /**
     * An API token that can be used for this user
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $token;

    /**
     * @var Test
     *
     * @ORM\OneToMany(targetEntity="Test", mappedBy="user")
     */
    private $createdTests;

    /**
     * @var UserTests
     *
     * @ORM\OneToMany(targetEntity="UserTests", mappedBy="user")
     */
    private $solvedTests;

    /**
     * @var ChallengeAnswer
     *
     * @ORM\OneToMany(targetEntity="ChallengeAnswer", mappedBy="user")
     */
    private $challengeAnswers;


    /**
     * @var Challenge
     *
     * @ORM\OneToMany(targetEntity="Challenge", mappedBy="user")
     */
    private $createdChallenges;

    /**
     * @var Vote
     *
     * @ORM\OneToMany(targetEntity="Vote", mappedBy="user")
     */
    private $votes;

    /**
     * @var Question
     *
     * @ORM\OneToMany(targetEntity="Question", mappedBy="user")
     */
    private $questions;

    /**
     * @var Ranking
     * @ORM\JoinColumn(name="rank_id", referencedColumnName="id")
     * @ORM\OneToOne(targetEntity="Ranking", inversedBy="user")
     */
    private $rank;

    public function __construct()
    {
        $this->createdAt = new \DateTime("now");
        $this->updatedAt = new \DateTime("now");
        $this->isActive = true;
        $this->createdTests = new  ArrayCollection();
        $this->createdChallenges = new ArrayCollection();
        $this->solvedTests = new ArrayCollection();
        $this->challengeAnswers = new ArrayCollection();
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
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @return mixed
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param mixed $plainPassword
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * Set gender
     *
     * @param string $gender
     *
     * @return User
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set birthday
     *
     * @param \DateTime $birthday
     *
     * @return User
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * Get birthday
     *
     * @return \DateTime
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @return boolean
     */
    public function isIsActive()
    {
        return $this->isActive;
    }

    /**
     * @param boolean $isActive
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    }

    /**
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param $type
     */
    public function setType($type)
    {
        $this->type = $type;
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
     * @return ChallengeAnswer
     */
    public function getChallengeAnswers()
    {
        return $this->challengeAnswers;
    }

    /**
     * @param ChallengeAnswer $challengeAnswers
     */
    public function setChallengeAnswers($challengeAnswers)
    {
        $this->challengeAnswers = $challengeAnswers;
    }

    public function getRoles()
    {
        $roles = array("ROLE_USER");
        switch ($this->type){
            case self::TYPE_ADMIN:
                $roles[] = "ROLE_ADMIN";
                break;
            case self::TYPE_MASTER:
                $roles[] = "ROLE_MASTER";
                break;
            case self::TYPE_APPRENTICE:
                $roles[] = "ROLE_APPRENTICE";
                break;
        }

        return $roles;
    }

    public function eraseCredentials()
    {
    }

    public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

    public function isEnabled()
    {
        return $this->isActive;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @return Test
     */
    public function getCreatedTests()
    {
        return $this->createdTests;
    }

    /**
     * @param Test $createdTests
     */
    public function setCreatedTests($createdTests)
    {
        $this->createdTests = $createdTests;
    }

    /**
     * @return UserTest
     */
    public function getSolvedTests()
    {
        return $this->solvedTests;
    }

    /**
     * @param UserTest $tests
     */
    public function setSolvedTests($solvedTests)
    {
        $this->solvedTests = $solvedTests;
    }

    /**
     * @return Challenge
     */
    public function getCreatedChallenges()
    {
        return $this->createdChallenges;
    }

    /**
     * @param Challenge $createdChallenges
     */
    public function setCreatedChallenges($createdChallenges)
    {
        $this->createdChallenges = $createdChallenges;
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


    /**
     * @return Question
     */
    public function getQuestions()
    {
        return $this->questions;
    }

    /**
     * @param Question $questions
     */
    public function setQuestions($questions)
    {
        $this->questions = $questions;
    }


    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }


    /**
     * @return Ranking
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * @param Ranking $rank
     */
    public function setRank($rank)
    {
        $this->rank = $rank;
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            $this->isActive,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            $this->isActive,
            ) = unserialize($serialized);
    }
}

