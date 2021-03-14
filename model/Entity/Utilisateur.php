<?php
namespace Model\Entity;

use App\AbstractEntity;


class Utilisateur extends AbstractEntity{

    private $id;
    private $pseudonyme;
    private $mdputilisateur;
    private $emailutilisateur;
    private $dateinscriptionutilisateur;
    private $role;
    private $banniutilisateur;

    /*public function __construct($id_utilisateur, $pseudonyme, $mdp_utilisateur, $email_utilisateur, $date_creation_utilisateur, $role, $banni_utilisateur){
        $this->id_utilisateur = $id_utilisateur;
        $this->pseudonyme = $pseudonyme;
        $this->mdp_utilisateur = $mdp_utilisateur;
        $this->email_utilisateur = $email_utilisateur;
        $this->date_creation_utilisateur = $date_creation_utilisateur;
        $this->role = $role;
        $this->banni_utilisateur = $banni_utilisateur;
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
     * Get the value of pseudonyme
     */ 
    public function getPseudonyme()
    {
        return $this->pseudonyme;
    }

    /**
     * Set the value of pseudonyme
     *
     * @return  self
     */ 
    public function setPseudonyme($pseudonyme)
    {
        $this->pseudonyme = $pseudonyme;

        return $this;
    }

    /**
     * Get the value of mdputilisateur
     */ 
    public function getMdputilisateur()
    {
        return $this->mdputilisateur;
    }

    /**
     * Set the value of mdputilisateur
     *
     * @return  self
     */ 
    public function setMdputilisateur($mdputilisateur)
    {
        $this->mdputilisateur = $mdputilisateur;

        return $this;
    }

    /**
     * Get the value of emailutilisateur
     */ 
    public function getEmailutilisateur()
    {
        return $this->emailutilisateur;
    }

    /**
     * Set the value of emailutilisateur
     *
     * @return  self
     */ 
    public function setEmailutilisateur($emailutilisateur)
    {
        $this->emailutilisateur = $emailutilisateur;

        return $this;
    }

    /**
     * Get the value of datecreationutilisateur
     */ 
    public function getDatecreationutilisateur()
    {
        return $this->datecreationutilisateur;
    }

    /**
     * Set the value of datecreationutilisateur
     *
     * @return  self
     */ 
    public function setDatecreationutilisateur($datecreationutilisateur)
    {
        $this->datecreationutilisateur = $datecreationutilisateur;

        return $this;
    }

    /**
     * Get the value of role
     */ 
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set the value of role
     *
     * @return  self
     */ 
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get the value of banniutilisateur
     */ 
    public function getBanniutilisateur()
    {
        return $this->banniutilisateur;
    }

    /**
     * Set the value of banniutilisateur
     *
     * @return  self
     */ 
    public function setBanniutilisateur($banniutilisateur)
    {
        $this->banniutilisateur = $banniutilisateur;

        return $this;
    }

    /**
     * Get the value of dateinscriptionutilisateur
     */ 
    public function getDateinscriptionutilisateur()
    {
        return $this->dateinscriptionutilisateur;
    }

    /**
     * Set the value of dateinscriptionutilisateur
     *
     * @return  self
     */ 
    public function setDateinscriptionutilisateur($dateinscriptionutilisateur)
    {
        $this->dateinscriptionutilisateur = $dateinscriptionutilisateur;

        return $this;
    }
}