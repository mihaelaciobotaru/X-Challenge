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
}

