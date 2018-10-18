<?php

namespace OC\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * User
 *
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="OC\UserBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_de_naissance", type="datetime")
     */
   protected $dateDeNaissance;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=255)
     */
    protected $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=255)
     */
    private $ville;
    
    
    /**
     * 
     * @ORM\ManyToMany(targetEntity="OC\AuthBundle\Entity\Present", mappedBy="users", cascade={"persist"})
     */
    private $presents;
    
     /**
     * 
     * @ORM\ManyToMany(targetEntity="OC\AuthBundle\Entity\Present", mappedBy="usersConfirmation")
     */
    private $presentsConfirmation;
    
    public function __construct()
    {
        parent::__construct();
         $this->presents = new ArrayCollection();
          $this->presentsConfirmation = new ArrayCollection();
        
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
     * Set dateDeNaissance
     *
     * @param \DateTime $dateDeNaissance
     *
     * @return User
     */
    public function setDateDeNaissance($dateDeNaissance)
    {
        $this->dateDeNaissance = $dateDeNaissance;

        return $this;
    }

    /**
     * Get dateDeNaissance
     *
     * @return \DateTime
     */
    public function getDateDeNaissance()
    {
        return $this->dateDeNaissance;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     *
     * @return User
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set ville
     *
     * @param string $ville
     *
     * @return User
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Add present
     *
     * @param \OC\AuthBundle\Entity\Present $present
     *
     * @return User
     */
    public function addPresent(\OC\AuthBundle\Entity\Present $present)
    {
        $present->addUser($this);
        $this->presents[] = $present;

        return $this;
    }

    /**
     * Remove present
     *
     * @param \OC\AuthBundle\Entity\Present $present
     */
    public function removePresent(\OC\AuthBundle\Entity\Present $present)
    {
        $this->presents->removeElement($present);
    }

    /**
     * Get presents
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPresents()
    {
        return $this->presents;
    }

    /**
     * Add presentsConfirmation
     *
     * @param \OC\AuthBundle\Entity\Present $presentsConfirmation
     *
     * @return User
     */
    public function addPresentsConfirmation(\OC\AuthBundle\Entity\Present $presentsConfirmation)
    {
        $this->presentsConfirmation[] = $presentsConfirmation;

        return $this;
    }

    /**
     * Remove presentsConfirmation
     *
     * @param \OC\AuthBundle\Entity\Present $presentsConfirmation
     */
    public function removePresentsConfirmation(\OC\AuthBundle\Entity\Present $presentsConfirmation)
    {
        $this->presentsConfirmation->removeElement($presentsConfirmation);
    }

    /**
     * Get presentsConfirmation
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPresentsConfirmation()
    {
        return $this->presentsConfirmation;
    }
}
