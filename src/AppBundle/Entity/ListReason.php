<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ListReason
 *
 * @ORM\Table(name="list_reason", )
 * @ORM\Entity(repositoryClass="AppBundle\Entity\ListReasonRepository")
 */
class ListReason
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=75, nullable=false)
     * @Assert\NotBlank()
     * @Assert\Length(min="5", max="75")
     */
    private $nameReason;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    private $isUserReason=0;


    /**
     * @param int $value
     * @return $this
     */
    public function setId($value)
    {
        $this->id = $value;
        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setNameReason($value)
    {
        $this->nameReason = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getNameReason()
    {
        return $this->nameReason;
    }

    /**
     * @param int $value
     * @return $this
     */
    public function setIsUserReason($value=0)
    {
        $this->isUserReason = $value;
        return $this;
    }

    /**
     * @return int
     */
    public function getIsUserReason()
    {
        return $this->isUserReason;
    }

    /**
     * ListReason constructor.
     */
    public function __construct()
    {
        $this->isUserReason = 0;
    }
}

