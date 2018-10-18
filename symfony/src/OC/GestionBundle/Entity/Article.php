<?php

namespace OC\GestionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * Article
 *
 * @ORM\Table(name="article")
 * @ORM\Entity(repositoryClass="OC\GestionBundle\Repository\ArticleRepository")
 */
class Article
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
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="text")
     */
    private $contenu;
    
    /**
     * @ORM\ManyToOne(targetEntity="Section", inversedBy="articles")
     * @ORM\JoinColumn(name="section_id", referencedColumnName="id")
     */
    private $section;
    
    /**
     *@ORM\OneToMany(targetEntity="Image", mappedBy="article",cascade={"persist", "remove"})
     */ 
    private $images; 
    
     public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->date = new \DateTime();
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Article
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Article
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
     * Set contenu
     *
     * @param string $contenu
     *
     * @return Article
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get contenu
     *
     * @return string
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * Set section
     *
     * @param \OC\GestionBundle\Entity\Section $section
     *
     * @return Article
     */
    public function setSection(\OC\GestionBundle\Entity\Section $section = null)
    {
        $this->section = $section;

        return $this;
    }

    /**
     * Get section
     *
     * @return \OC\GestionBundle\Entity\Section
     */
    public function getSection()
    {
        return $this->section;
    }

    /**
     * Add image
     *
     * @param \OC\GestionBundle\Entity\Image $image
     *
     * @return Article
     */
    public function addImage(\OC\GestionBundle\Entity\Image $image)
    {
        $this->images[] = $image;

        return $this;
    }

    /**
     * Remove image
     *
     * @param \OC\GestionBundle\Entity\Image $image
     */
    public function removeImage(\OC\GestionBundle\Entity\Image $image)
    {
        $this->images->removeElement($image);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImages()
    {
        return $this->images;
    }
}
