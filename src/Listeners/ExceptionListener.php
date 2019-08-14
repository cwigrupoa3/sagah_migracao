<?php

namespace App\Listeners;

use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Exception\AuthenticationCredentialsNotFoundException;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Exceptions\AcessoNegadoException;

use App\Exceptions\SagahMigracaoException;

use Psr\Log\LoggerInterface;
/**
 * ExceptionListener
 */
class ExceptionListener
{
    private static  $exceptionCaught            = false;
    private         $twig;
    private         $debug;
    private         $event;
    /**
     * @var Router
     */
    private $router;
    
    //--------------------------------------------------------------------------------------------------------//
    
    public function __construct(\Twig_Environment $twig, $debug, Router $router, \Psr\Log\LoggerInterface $logger)
    {
        $this->twig         = $twig;
        $this->debug        = (bool)$debug;
        $this->router       = $router;
        $this->logger       = $logger;
    }
    
    //--------------------------------------------------------------------------------------------------------//
    
    private function getSagahMigracaoExceptionArray(SagahMigracaoException $exception)
    {
        return $exception->getArray();
    }
    
    private function getDefaultExceptionArray($exception) 
    {
        $error = array();

        if($exception instanceof \Symfony\Component\Security\Core\Exception\AccessDeniedException) {
            $error = array(
                'level' => SagahMigracaoException::LEVEL_ERROR,
                'errors' => array( 
                    array( 
                        'code'      => '04001',
                        'message'   => "Acesso negado"
                    )
                )
            );
        } else if ($this->debug) {
            $error = array(
                'level' => SagahMigracaoException::LEVEL_ERROR,
                'errors' => array( 
                    array( 
                        'code'      => '01001',
                        'message'   => $exception->getMessage()
                    )
                )
            );
        } else {
            $error = array(
                'level' => SagahMigracaoException::LEVEL_ERROR,
                'errors' => array(
                    array( 
                        'code'      => '01001',
                        'message'   => 'Ocorreu um erro desconhecido.'
                    )
                )
            );
        }

        return $error;
    }
    
    private function getTemplate($request) 
    {
        return "error/error.json.twig";
    }
    
    private function getExeptionArrayLogin($exception)
    {
        return array(
            'error_structure' => array(
                'level' => SagahMigracaoException::LEVEL_ALERT,
                'errors' => array( 
                    array( 
                        'code'      => '04002',
                        'message'   => 'Sua sessão expirou!'
                    )
                )
            )
        );
    }
    
    private function isAuthException($exception) 
    {
        return ($exception instanceof AuthenticationException || $exception instanceof AuthenticationCredentialsNotFoundException || $exception instanceof AcessoNegadoException);
    }
    
    private function setHeaders() 
    {
        $this->event->getResponse()->headers->set('Content-Type', 'application/json');
    }
    
    private function formatDebugMessage() 
    {
        $exception = $this->event->getException();

        if($exception instanceof SagahMigracaoException)
        {
            $exception->setDebug(true);
        }
    }
    
    private function notifyException($exception) 
    {
//        if($this->notificationActive) {
//            
//            $message = $this->mailer->createMessage()
//                ->setSubject('GrupoA :: Exception :: Exceção detectada')
//                ->setFrom('r.a.moraes@gmail.com')
//                ->setBody(
//                    $this->twig->render(
//                        'error/error.html.twig',
//                        $this->getExeptionArray($exception)
//                    ),
//                    'text/html'
//                );
//
//            $message->addTo( $this->notificationEmail );
//            $this->mailer->send($message);
//        }
    }
    
    //--------------------------------------------------------------------------------------------------------//
    
    //--------------------------------------------------------------------------------------------------------//

    public function onExceptionThrown(GetResponseForExceptionEvent $event)
    {
        $this->event = $event;
        
        $request    = $this->event->getRequest();
        $exception  = $this->event->getException();
           
        $this->logger->error($exception->getMessage(), array(
            'code' => $exception->getCode(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'trace' => $exception->getTrace()                
        ));
        
        try {
            self::$exceptionCaught = true;
        } catch (\Exception $e) {}

        $this->event->setResponse(
            new Response($this->twig->render(
                $this->getTemplate($request),
                $this->getExeptionArray($exception)
            ))
        );

        $this->setHeaders();

        $this->notifyException($exception);
    }

    public function getExeptionArray($exception)
    {
        $is_auth_exception = $this->isAuthException($exception);

        if ($is_auth_exception) {
            return $this->getExeptionArrayLogin($exception);
        }

        if(is_a($exception, "App\Exceptions\SagahMigracaoException")) {
            $array = $this->getSagahMigracaoExceptionArray($exception);
        } else {
            $array = $this->getDefaultExceptionArray($exception);
        }

        return array(
            'error_structure' => array_merge( array('success'=>false), $array)
        );
    }

    public static function getExceptionCaught() 
    {
        return self::$exceptionCaught;
    }
}