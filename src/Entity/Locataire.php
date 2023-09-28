<?php
namespace App\Entity;

class Locataire
{
	private ?int $id;
    private ?string $nom;
    private ?string $prenom;
    private ?string $email;
    private ?string $telephone;
    private ?string $rue;
    private ?float $salaireMens;
	private ?Impression $lImpression;
	private ?CategorieSocioProfessionnelle $laCategSocioPro;
    private ?Ville $laVille;


	public function __construct(?int $id,string $nom= null,string $prenom= null,string $email= null,string $telephone= null,string $rue= null,float $salaireMens= null,Impression $lImpression= null,CategorieSocioProfessionnelle $laCategSocioPro= null,Ville $laVille= null)
	{
		$this->id = $id;
		$this->nom = $nom;
		$this->prenom = $prenom;
		$this->email = $email;
		$this->telephone = $telephone;
		$this->rue = $rue;
		$this->salaireMens = $salaireMens;
		$this->lImpression = $lImpression;
		$this->laCategSocioPro = $laCategSocioPro;
        $this->laVille = $laVille;
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
     * Get the value of nom
     */ 
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set the value of nom
     *
     * @return  self
     */ 
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get the value of prenom
     */ 
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set the value of prenom
     *
     * @return  self
     */ 
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of telephone
     */ 
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set the value of telephone
     *
     * @return  self
     */ 
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get the value of rue
     */ 
    public function getRue()
    {
        return $this->rue;
    }

    /**
     * Set the value of rue
     *
     * @return  self
     */ 
    public function setRue($rue)
    {
        $this->rue = $rue;

        return $this;
    }



	/**
	 * Get the value of lImpression
	 */ 
	public function getLImpression() :Impression
	{
		return $this->lImpression;
	}

	/**
	 * Set the value of lImpression
	 *
	 * @return  self
	 */ 
	public function setLImpression($lImpression)
	{
		$this->lImpression = $lImpression;

		return $this;
	}

	/**
	 * Get the value of laCategSocioPro
	 */ 
	public function getLaCategSocioPro()
	{
		return $this->laCategSocioPro;
	}

	/**
	 * Set the value of laCategSocioPro
	 *
	 * @return  self
	 */ 
	public function setLaCategSocioPro($laCategSocioPro)
	{
		$this->laCategSocioPro = $laCategSocioPro;

		return $this;
	}

    /**
     * Get the value of ville
     */ 

    /**
     * Get the value of salaireMens
     */ 
    public function getSalaireMens()
    {
        return $this->salaireMens;
    }

    /**
     * Set the value of salaireMens
     *
     * @return  self
     */ 
    public function setSalaireMens($salaireMens)
    {
        $this->salaireMens = $salaireMens;

        return $this;
    }

    /**
     * Get the value of laVille
     */ 
    public function getLaVille()
    {
        return $this->laVille;
    }

    /**
     * Set the value of laVille
     *
     * @return  self
     */ 
    public function setLaVille($laVille)
    {
        $this->laVille = $laVille;

        return $this;
    }
}
