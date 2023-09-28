<?php
namespace App\Entity;





class Proprietaire
{
	private ?int $id;
	private ?string $nom;
	private ?string $prenom;
    private ?string $rue;
    private ?string $email;
    private ?int $telephone;
	private ?Ville $laVille;
    private ?GestionProprio $laGestionProprio;
	
	public function __construct(?int $id, ?string $nom, ?string $rue = null,?string $prenom = null,?string $email = null,?int $telephone = null, GestionProprio $laGestionProprio = null, Ville $laVille = null)
	{
		$this->id = $id;
		$this->nom = $nom;
		$this->rue = $rue;
		$this->prenom = $prenom;
		$this->email = $email;
		$this->telephone = $telephone;
        $this->laGestionProprio = $laGestionProprio;
		$this->laVille = $laVille;
     
	}
	public function getId(): int
	{
		return $this->id;
	}
	public function setId(int $id): void
	{
		$this->id = $id;
	}
	public function getNom(): string
	{
		return $this->nom;
	}
	public function setNom(string $nom): void
	{
		$this->nom = $nom;
	}
	public function getPrenom(): string
	{
		return $this->prenom;
	}
	public function setPrenom(string $prenom): void
	{
		$this->prenom = $prenom;
	}
    public function getRue(): string
	{
		return $this->rue;
	}
	public function setRue(string $rue): void
	{
		$this->rue = $rue;
	}
        //-- references --//
	public function getVille(): Ville 
    {
        return $this->laVille;
    }
		
	public function setVille(Ville $laVille): void
	{
		$this->laVille = $laVille;
	}
    public function getGestionProprio(): GestionProprio
    {
		return $this->laGestionProprio;
    }
	    //----//
	public function setGestionProprio(GestionProprio $laGestionProprio): void
	{
		$this->laGestionProprio = $laGestionProprio;
	}
    
	public function getEmail(): string
	{
		return $this->email;
	}
	public function setEmail(string $email): void
	{
		$this->email = $email;
    }
	public function getTelephone(): int
	{
		return $this->telephone;
	}
	public function setTelephone(string $telephone): void
	{
		$this->telephone = $telephone;
    }

}
