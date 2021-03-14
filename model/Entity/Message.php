<?php
namespace Model\Entity;

use App\AbstractEntity;


class Message extends AbstractEntity{
    private $id;
    private $textemessage;
    private $datemessage;
    private $dateeditionmessage;
    private $utilisateur;
    private $sujet;
    private $nomcategorie;

    /*public function __construct($id_message, $texte_message, $date_message, $date_edition_message, $id_utilisateur, $id_sujet){
        $this->id_message = $id_message;
        $this->texte_message = $texte_message;
        $this->date_message = $date_message;
        $this->date_edition_message = $date_edition_message;
        $this->id_utilisateur = $id_utilisateur;
        $this->id_sujet = $id_sujet;
    }*/

    
    public function __construct($data){
        parent::hydrate($data, $this);
    }






  

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of textemessage
     */ 
    public function getTextemessage()
    {
        return $this->textemessage;
    }

    /**
     * Set the value of textemessage
     *
     * @return  self
     */ 
    public function setTextemessage($textemessage)
    {
        $this->textemessage = $textemessage;

        return $this;
    }

    /**
     * Get the value of datemessage
     */ 
    public function getDatemessage()
    {
        return $this->datemessage;
    }

    /**
     * Set the value of datemessage
     *
     * @return  self
     */ 
    public function setDatemessage($datemessage)
    {
        $this->datemessage = $datemessage;

        return $this;
    }

    /**
     * Get the value of dateeditionmessage
     */ 
    public function getDateeditionmessage()
    {
        return $this->dateeditionmessage;
    }

    /**
     * Set the value of dateeditionmessage
     *
     * @return  self
     */ 
    public function setDateeditionmessage($dateeditionmessage)
    {
        $this->dateeditionmessage = $dateeditionmessage;

        return $this;
    }

    /**
     * Get the value of utilisateur
     */ 
    public function getUtilisateur()
    {
        return $this->utilisateur;
    }

    /**
     * Set the value of utilisateur
     *
     * @return  self
     */ 
    public function setUtilisateur($utilisateur)
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    /**
     * Get the value of sujet
     */ 
    public function getSujet()
    {
        return $this->sujet;
    }

    /**
     * Set the value of sujet
     *
     * @return  self
     */ 
    public function setSujet($sujet)
    {
        $this->sujet = $sujet;

        return $this;
    }

    /**
     * Get the value of nomcategorie
     */ 
    public function getNomcategorie()
    {
        return $this->nomcategorie;
    }

    /**
     * Set the value of nomcategorie
     *
     * @return  self
     */ 
    public function setNomcategorie($nomcategorie)
    {
        $this->nomcategorie = $nomcategorie;

        return $this;
    }
}