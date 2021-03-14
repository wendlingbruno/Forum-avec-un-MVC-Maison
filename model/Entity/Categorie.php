<?php
namespace Model\Entity;

use App\AbstractEntity;


class Categorie extends AbstractEntity{

    private $id;
    private $nomcategorie;
    private $Nbsujets;

    /*public function __construct($id_categorie, $nom_categorie){
        $this->id_categorie = $id_categorie;
        $this->nom_categorie = $nom_categorie;
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

    /**
     * Get the value of Nbsujets
     */ 
    public function getNbsujets()
    {
        return $this->Nbsujets;
    }

    /**
     * Set the value of Nbsujets
     *
     * @return  self
     */ 
    public function setNbsujets($Nbsujets)
    {
        $this->Nbsujets = $Nbsujets;

        return $this;
    }
}