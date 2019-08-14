<?php

namespace App\Service\Autenticacao;

use App\Entity\Aplicacao;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * AplicacaoService
 */
class AplicacaoProvider implements UserProviderInterface
{
    public function loadUserByUsername($username): \Symfony\Component\Security\Core\User\UserInterface
    {
        return new Aplicacao();
    }

    public function refreshUser(\Symfony\Component\Security\Core\User\UserInterface $user): \Symfony\Component\Security\Core\User\UserInterface
    {
        return $user;
    }

    public function supportsClass($class): bool
    {
        return true;
    }
}