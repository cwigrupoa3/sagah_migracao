<?php

namespace App\Service\Autenticacao;

use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\Security\Http\Authentication\SimplePreAuthenticatorInterface;
use Symfony\Component\Security\Core\Authentication\Token\PreAuthenticatedToken;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use App\Entity\Aplicacao;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use \Psr\Log\LoggerInterface;

/**
 * TokenAutenticador
 */
class TokenAutenticador implements AuthenticationFailureHandlerInterface, SimplePreAuthenticatorInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManagerInterface;

    //--------------------------------------------------------------------------------------------------------//

    public function __construct(EntityManagerInterface $entityManagerInterface, LoggerInterface $logger) {
        $this->entityManagerInterface = $entityManagerInterface;
        $this->logger = $logger;
    }

    //--------------------------------------------------------------------------------------------------------//

    private function getApplicationByNome($nome)
    {
        $app = $this->entityManagerInterface->getRepository(Aplicacao::class);
        return $app->findOneBy(['nome' => $nome]);
    }

    //--------------------------------------------------------------------------------------------------------//

    //--------------------------------------------------------------------------------------------------------//

    public function onAuthenticationFailure(\Symfony\Component\HttpFoundation\Request $request, \Symfony\Component\Security\Core\Exception\AuthenticationException $exception): \Symfony\Component\HttpFoundation\Response
    {
        throw new \App\Exceptions\AcessoNegadoException;
    }

    public function createToken(\Symfony\Component\HttpFoundation\Request $request, $providerKey)
    {
        $nome = $request->headers->get('nome');

        if(!$nome){
            throw new \App\Exceptions\AcessoNegadoException;
        } 

        $resapp = $this->getApplicationByNome($nome);

        if (!$resapp) {
            $this->logger->error('Não foi encontrado usuario para autenticar a aplicação', array(
                'nome' => $nome,
                'password' => $request->headers->get('password'),
                'todo' => 'Validar os valores do header do request e comparar com DB'
            ));
            throw new \App\Exceptions\AcessoNegadoException;
        }       
        
        return new PreAuthenticatedToken(
            $resapp->getNome(),
            $resapp->getPassword(),
            $providerKey
        );
    }

    public function authenticateToken(\Symfony\Component\Security\Core\Authentication\Token\TokenInterface $token, \Symfony\Component\Security\Core\User\UserProviderInterface $userProvider, $providerKey)
    {
        $request = Request::createFromGlobals();
        
        $nome = $request->headers->get('nome');
        $password = $request->headers->get('password');

        if($token->getCredentials() != $password){
            throw new \App\Exceptions\AcessoNegadoException;
        }

        /* @var $app Aplicacao */
        $app = $resapp = $this->getApplicationByNome($nome);

        return new PreAuthenticatedToken(
            $app,
            $password,
            $providerKey,
            ['ROLE_R']
        );
    }

    public function supportsToken(\Symfony\Component\Security\Core\Authentication\Token\TokenInterface $token, $providerKey)
    {
        return $token instanceof PreAuthenticatedToken && $token->getProviderKey() === $providerKey;
    }
}