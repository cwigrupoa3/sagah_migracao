<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Service\Base\Interfaces\EntityInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AplicacaoRepository")
 */
class Aplicacao implements UserInterface, EntityInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $nome;

    /**
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @var Usuario
     */
    private $usuario;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getNome(): string
    {
        return $this->nome;
    }

    /**
     * @param string $nome
     */
    public function setNome($nome): void
    {
        $this->nome = $nome;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }

    public function eraseCredentials()
    {
        
    }

    public function getRoles()
    {
        return ['ROLE_LEARNER'];
    }

    public function getSalt()
    {
        return '123456789';
    }

    public function getUsername(): string
    {
        return 'Delator Pi';
    }

    public function isEqualTo(UserInterface $user): bool
    {
        return true;
    }

    /**
     * @return Usuario
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @return Aplicacao
     */
    public function setUsuario($usuario = null): Aplicacao
    {
        $this->usuario = $usuario;

        return $this;
    }
}