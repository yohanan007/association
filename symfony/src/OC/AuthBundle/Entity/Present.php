<?php

namespace OC\AuthBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Present
 *
 * @ORM\Table(name="present")
 * @ORM\Entity(repositoryClass="OC\AuthBundle\Repository\PresentRepository")
 */
class Present
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
     * @var \DateTime
     *
     * @ORM\Column(name="jour", type="datetime")
     */
    private $jour;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;
    
    
    /**
     * 
     * @ORM\ManyToMany(targetEntity="OC\UserBundle\Entity\User", inversedBy="presentsConfirmation")
     * @ORM\JoinTable(name="presents_users_confirmation")
     */
    private $usersConfirmation; 
    
    
     /**
     *
     * @ORM\ManyToMany(targetEntity="OC\UserBundle\Entity\User", inversedBy="presents")
     * @ORM\JoinTable(name="presents_users")
     */
    private $users; 
    
    /**
     * @ORM\ManyToOne(targetEntity="evenement", inversedBy="present2s")
     * @ORM\JoinColumn(name="evenement_id", referencedColumnName="id")
     */ 
    private $Evenement; 

     public function __construct()
    {
      
        $this->date = new \DateTime();
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
        $this->usersConfirmation = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set jour
     *
     * @param \DateTime $jour
     *
     * @return Present
     */
    public function setJour($jour)
    {
        $this->jour = $jour;

        return $this;
    }

    /**
     * Get jour
     *
     * @return \DateTime
     */
    public function getJour()
    {
        return $this->jour->format('Y-m-d H:i:s');
    }

    /**
     * Set date
     *
     * @param string $date
     *
     * @return Present
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Add user
     *
     * @param \OC\UserBundle\Entity\User $user
     *
     * @return Present
     */
    public function addUser(\OC\UserBundle\Entity\User $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \OC\UserBundle\Entity\User $user
     */
    public function removeUser(\OC\UserBundle\Entity\User $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Set evenement
     *
     * @param \OC\AuthBundle\Entity\evenement $evenement
     *
     * @return Present
     */
    public function setEvenement(\OC\AuthBundle\Entity\evenement $evenement = null)
    {
        $this->Evenement = $evenement;

        return $this;
    }

    /**
     * Get evenement
     *
     * @return \OC\AuthBundle\Entity\evenement
     */
    public function getEvenement()
    {
        return $this->Evenement;
    }

    /**
     * Add usersConfirmation
     *
     * @param \OC\UserBundle\Entity\User $usersConfirmation
     *
     * @return Present
     */
    public function addUsersConfirmation(\OC\UserBundle\Entity\User $usersConfirmation)
    {
        $this->usersConfirmation[] = $usersConfirmation;

        return $this;
    }

    /**
     * Remove usersConfirmation
     *
     * @param \OC\UserBundle\Entity\User $usersConfirmation
     */
    public function removeUsersConfirmation(\OC\UserBundle\Entity\User $usersConfirmation)
    {
        $this->usersConfirmation->removeElement($usersConfirmation);
    }

    /**
     * Get usersConfirmation
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsersConfirmation()
    {
        return $this->usersConfirmation;
    }
}
