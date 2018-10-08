<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UtilisateurRepository")
 * @UniqueEntity(
 *  fields={"pseudo"},
 *  message="Ce pseudo est déjà utilisé par une autre personne"
 * )
 */
class Utilisateur implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pseudo;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="10", minMessage="Votre mot de passe doit comporter entre 10 et 20 caractères")
     * @Assert\Length(max="20", maxMessage="Votre mot de passe doit comporter entre 10 et 20 caractères")
     */
    private $motdepasse;

    /**
     * @Assert\EqualTo(propertyPath="motdepasse", message="Les mots de passe ne sont pas identiques")
     */
    public $confirmation_motdepasse;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getMotdepasse(): ?string
    {
        return $this->motdepasse;
    }

    public function setMotdepasse(string $motdepasse): self
    {
        $this->motdepasse = $motdepasse;

        return $this;
    }


    public function getUsername(): ?string
    {
        return $this->getPseudo();
    }

    public function getPassword(): ?string
    {
        return $this->getMotdepasse();
    }

    public function eraseCredentials(){}

    public function getSalt(){}

    public function getRoles(){
        return ['ROLE_USER'];
    }
}
