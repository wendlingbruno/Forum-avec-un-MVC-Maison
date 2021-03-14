<?php
namespace Model\Entity;

use App\AbstractEntity;


class Sujet extends AbstractEntity{
    private $id;
    private $titresujet;
    private $datesujet;
    private $statutsujet;
    private $resolusujet;
    private $utilisateur;
    private $categorie;
    private $nbMessages2;
    private $nomcategorie;

    /*public function __construct($id_sujet, $titre_sujet, $date_sujet, $statut_sujet, $resolu_sujet, $id_utilisateur, $id_categorie){
        $this->id_sujet = $id_sujet;
        $this->titre_sujet = $titre_sujet;
        $this->date_sujet = $date_sujet;
        $this->statut_sujet = $statut_sujet;
        $this->resolu_sujet = $resolu_sujet;
        $this->id_utilisateur = $id_utilisateur;
        $this->id_categorie = $id_categorie;
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
     * Get the value of titresujet
     */ 
    public function getTitresujet()
    {
        return $this->titresujet;
    }

    /**
     * Set the value of titresujet
     *
     * @return  self
     */ 
    public function setTitresujet($titresujet)
    {
        $this->titresujet = $titresujet;

        return $this;
    }

    /**
     * Get the value of datesujet
     */ 
    public function getDatesujet()
    {
        return $this->datesujet;
    }

    /**
     * Set the value of datesujet
     *
     * @return  self
     */ 
    public function setDatesujet($datesujet)
    {
        $this->datesujet = $datesujet;

        return $this;
    }

    /**
     * Get the value of statutsujet
     */ 
    public function getStatutsujet()
    {
        return $this->statutsujet;
    }

    /**
     * Set the value of statutsujet
     *
     * @return  self
     */ 
    public function setStatutsujet($statutsujet)
    {
        $this->statutsujet = $statutsujet;

        return $this;
    }

    /**
     * Get the value of resolusujet
     */ 
    public function getResolusujet()
    {
        return $this->resolusujet;
    }

    /**
     * Set the value of resolusujet
     *
     * @return  self
     */ 
    public function setResolusujet($resolusujet)
    {
        $this->resolusujet = $resolusujet;

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
     * Get the value of categorie
     */ 
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * Set the value of categorie
     *
     * @return  self
     */ 
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;

        return $this;
    }


    /**
     * Get the value of nbMessages2
     */ 
    public function getNbMessages2()
    {
        return $this->nbMessages2;
    }

    /**
     * Set the value of nbMessages2
     *
     * @return  self
     */ 
    public function setNbMessages2($nbMessages2)
    {
        $this->nbMessages2 = $nbMessages2;

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