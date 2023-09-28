<?php
namespace App\Entity;

use App\Entity\Ville;
use App\Entity\Proprietaire;
use App\Entity\TypeAppartement;
use App\Entity\Secteur;



class Appartement
{
	private ?int $id;
	private ?string $rue;
	private ?string $batiment;
	private ?int $etage;
	private ?float $superficie;
	private ?string $orientation;
	private ?int $nbPiece;
	private ?TypeAppartement $leTypeAppartement;
	private ?Proprietaire $leProprietaire ;
	private ?Ville $laVille;
	private ?Secteur $leSecteur;

	public function __construct(?int $id = null,?string $rue = null ,?string $batiment = null ,?int $etage = null,?float $superficie = null,?string $orientation = null,
	?int $nbPiece = null 
	,?TypeAppartement $leTypeAppartement = null,?Proprietaire $proprietaire = null,?Ville $laVille = null ,?Secteur $leSecteur = null)
	{
		$this->id = $id;
		$this->rue=  $rue;
		$this->batiment=  $batiment;
		$this->etage=  $etage;
		$this->superficie = $superficie;
		$this->orientation = $orientation;
		$this->nbPiece =  $nbPiece;
		$this->leTypeAppartement = $leTypeAppartement;
		$this->leProprietaire = $proprietaire;
		$this->laVille = $laVille;
		$this->leSecteur = $leSecteur;
	}
	public function getId(): int
	{
		return $this->id;
	}
	public function setId(int $id): void
	{
		$this->id = $id;
	}

	public function getRue(): string
	{
		return $this->rue;
	}
	public function setRue(string  $rue): void
	{
		$this->$rue = $rue;
	}

	public function getBatiment(): string
	{
		return $this->batiment;
	}
	public function setBatiment(string  $batiment): void
	{
		$this->batiment = $batiment;
	}

	public function getEtage(): string
	{
		return $this->etage;;
	}
	public function setEtage(string  $etage): void
	{
		$this->etage = $etage;
	}


	public function getSuperficie(): float
	{
		return $this->superficie;
	}
	public function setSuperficie(float $superficie): void
	{
		$this->superficie = $superficie;
	}
	public function getOrientation(): string
	{
		return $this->orientation;
	}
	public function setOrientation(string $orientation): void
	{
		$this->orientation = $orientation;
	}


	public function getTypeAppartement(): TypeAppartement
	{
		return $this->leTypeAppartement;
	}
	public function setTypeAppartement(TypeAppartement $leTypeAppartement): void
	{
		$this->leTypeAppartement = $leTypeAppartement;
	}

		
	public function getProprietaire(): Proprietaire
	{
		return $this->leProprietaire;
	}

	public function setProprietaire(Proprietaire $proprietaire): void
	{
		$this->leProprietaire = $proprietaire;
	}


	public function getVille()
{
    return $this->laVille; // Assuming $ville is the property representing the related Ville entity.
}

	public function setVille(Ville $laVille): void
	{
		$this->$laVille = $laVille;

	}


	public function getNbPiece()
	{
		return $this->nbPiece;
	}

	/**
	 * Set the value of nbPiece
	 *
	 * @return  self
	 */ 
	public function setNbPiece($nbPiece)
	{
		$this->nbPiece = $nbPiece;

		return $this;
	}

	public function getSecteur(): Secteur
	{
		return $this->leSecteur;
	}
	public function setSecteur(Secteur $leSecteur): void
	{
		$this->leSecteur = $leSecteur;
	}
}