<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MhUser
 *
 * @ORM\Table(name="mh_user", indexes={@ORM\Index(name="system_user_mh_user_foreign_idx", columns={"m_user_id"})})
 * @ORM\Entity
 */
class MhUser
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
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     */
    private $userId;

    /**
     * @var string
     *
     * @ORM\Column(name="mh_name", type="string", length=45, nullable=true)
     */
    private $mhName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_create", type="datetime", nullable=false)
     */
    private $dateCreate;

    /**
     * @var \MUser
     *
     * @ORM\ManyToOne(targetEntity="MUser")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="m_user_id", referencedColumnName="id")
     * })
     */
    private $mUser;


}

