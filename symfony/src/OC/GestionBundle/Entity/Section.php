<?php

namespace OC\GestionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Section
 *
 * @ORM\Table(name="section")
 * @ORM\Entity(repositoryClass="OC\GestionBundle\Repository\SectionRepository")
 */
class Section
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
     * @ORM\OneToMany(targetEntity="Section", mappedBy="sSection")
     */ 
    private $sSections;
    
    /**
     * @ORM\ManyToOne(targetEntity="Section", inversedBy="sSections")
     */ 
    private $sSection;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="text")
     */
    private $contenu;
    
    
    
    /**
     *@ORM\OneToMany(targetEntity="Article", mappedBy="section") 
     */ 
    private $articles;
    
    public function __construct()
    {
        $this->articles = new ArrayCollection();
        $this->sSections = new ArrayCollection();
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
     * @return Section
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
     * Set name
     *
     * @param string $name
     *
     * @return Section
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set contenu
     *
     * @param string $contenu
     *
     * @return Section
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
     * Add article
     *
     * @param \OC\GestionBundle\Entity\Article $article
     *
     * @return Section
     */
    public function addArticle(\OC\GestionBundle\Entity\Article $article)
    {
        $this->articles[] = $article;

        return $this;
    }

    /**
     * Remove article
     *
     * @param \OC\GestionBundle\Entity\Article $article
     */
    public function removeArticle(\OC\GestionBundle\Entity\Article $article)
    {
        $this->articles->removeElement($article);
    }

    /**
     * Get articles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getArticles()
    {
        return $this->articles;
    }

    /**
     * Add sSection
     *
     * @param \OC\GestionBundle\Entity\Section $sSection
     *
     * @return Section
     */
    public function addSSection(\OC\GestionBundle\Entity\Section $sSection)
    {
        $this->sSections[] = $sSection;

        return $this;
    }

    /**
     * Remove sSection
     *
     * @param \OC\GestionBundle\Entity\Section $sSection
     */
    public function removeSSection(\OC\GestionBundle\Entity\Section $sSection)
    {
        $this->sSections->removeElement($sSection);
    }

    /**
     * Get sSections
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSSections()
    {
        return $this->sSections;
    }

    /**
     * Set sSection
     *
     * @param \OC\GestionBundle\Entity\Section $sSection
     *
     * @return Section
     */
    public function setSSection(\OC\GestionBundle\Entity\Section $sSection = null)
    {
        $this->sSection = $sSection;

        return $this;
    }

    /**
     * Get sSection
     *
     * @return \OC\GestionBundle\Entity\Section
     */
    public function getSSection()
    {
        return $this->sSection;
    }
}
