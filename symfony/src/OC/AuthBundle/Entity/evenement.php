<?php

namespace OC\AuthBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * evenement
 *
 * @ORM\Table(name="oc_evenement")
 * @ORM\Entity(repositoryClass="OC\AuthBundle\Repository\evenementRepository")
 */
class evenement
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
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateDebut", type="datetime")
     */
    private $dateDebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateFin", type="datetime")
     */
    private $dateFin;
    
    /**
     *@ORM\OneToMany(targetEntity="Present", mappedBy="Evenement", cascade={"persist","remove"})
     */ 
    private $present2s;
    
    /**
     *@ORM\Column(name="publie", type="boolean", options={"default":false})
     * 
     */ 
    private $publie;
    
     public function __construct()
    {
        
        $this->date = new \DateTime();
        $this->present2s = new ArrayCollection();
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
     * Set nom
     *
     * @param string $nom
     *
     * @return evenement
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return evenement
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set date
     *
     * @param string $date
     *
     * @return evenement
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
     * Set dateDebut
     *
     * @param \DateTime $dateDebut
     *
     * @return evenement
     */
    public function setDateDebut($dateDebut)
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    /**
     * Get dateDebut
     *
     * @return \DateTime
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * Set dateFin
     *
     * @param \DateTime $dateFin
     *
     * @return evenement
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    /**
     * Get dateFin
     *
     * @return \DateTime
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }

   

    /**
     * Add present2
     *
     * @param \OC\AuthBundle\Entity\Present $present2
     *
     * @return evenement
     */
    public function addPresent2(\OC\AuthBundle\Entity\Present $present2)
    {
        $this->present2s[] = $present2;

        return $this;
    }

    /**
     * Remove present2
     *
     * @param \OC\AuthBundle\Entity\Present $present2
     */
    public function removePresent2(\OC\AuthBundle\Entity\Present $present2)
    {
        $this->present2s->removeElement($present2);
    }

    /**
     * Get present2s
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPresent2s()
    {
        return $this->present2s;
    }

    /**
     * Set publie
     *
     * @param boolean $publie
     *
     * @return evenement
     */
    public function setPublie($publie)
    {
        $this->publie = $publie;

        return $this;
    }

    /**
     * Get publie
     *
     * @return boolean
     */
    public function getPublie()
    {
        return $this->publie;
    }
}
