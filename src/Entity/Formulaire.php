<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
* Formulaire
*
* @ORM\Table(name="formulaire")
* @ORM\Entity(repositoryClass="App\Repository\FormulaireRepository")
*/

class Formulaire
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     *  @var date
     * 
     * @ORM\Column(name="datetime", type="date")
     */
    private $date;

    /**
     *  @var string
     * @Assert\NotBlank()
     * @Assert\Length(max=30)
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     *  @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="contenu", type="text")
     */
    private $contenu;

    /**
     *  @var categorie
     * 
     * @ORM\ManyToOne(targetEntity="Categorie")
     */
    private $categorie;
    

    /**
     * Get Id
     * 
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set date 
     * 
     * @param date $date 
     * @return date
     */
    public function setdate($date)
    {
        $this->date = $date;
        return $this;
    }

    /**
     * Get date
     * 
     * @return date
     */
    public function getdate()
    {
        return $this->date;
    }

    /**
     * Set titre
     * 
     * @param titre $titre
     * @return string
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
        return $this;
    }

    /**
     * Get titre    
     * 
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set contenu
     * 
     * @param contenu $contenu
     * @return text
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;
        return $this;
    }

    /**
     * Get contenu
     * 
     * @return text
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * Set categorie
     * 
     * @param categorie $categorie
     * @return string
     */
    public function setCategorie($categorie){
        $this->categorie = $categorie;
        return $this;
    }

    /**
     * Get categorie
     * 
     * @return string
     */
    public function getCategorie(){
        return $this->categorie;
    }
}

?>