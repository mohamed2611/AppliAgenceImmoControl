<?php
namespace App\Entity;
class Ville
{
	private ?int $insee;
	private ?string $nom;
    private ?int $codePostal;
	public function __construct($insee, $nom = null,$codePostal = null)
	{
		$this->insee = $insee;
		$this->nom = $nom;
        $this->codePostal = $codePostal;
	}
	public function getInsee(): int
	{
		return $this->insee;
	}
	public function setId($insee): void
	{
		$this->insee = $insee;
	}
	public function getNom(): string
	{
		return $this->nom;
	}
	public function setNom($nom): void
	{
		$this->nom = $nom;
	}
    public function getCodePostal(): int
	{
		return $this->codePostal;
	}
	public function setCodePostal($codePostal): void
	{
		$this->codePostal = $codePostal;
	}
}
