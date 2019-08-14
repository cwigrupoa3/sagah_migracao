<?php

namespace App\Controller;

use App\Entity\Aplicacao;
use App\Service\Base\Abstracts\AbstractCarregador;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use \Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\Router;
use Symfony\Component\Routing\RouterInterface;

class TesteController extends Controller
{

    //--------------------------------------------------------------------------------------------------------//

    //--------------------------------------------------------------------------------------------------------//

    //--------------------------------------------------------------------------------------------------------//

    //--------------------------------------------------------------------------------------------------------//

    /**
     * @Route("/teste", name="teste")
     */
    public function index()
    {
        $exception = new \App\Exceptions\SagahMigracaoException(\App\Exceptions\SagahMigracaoException::LEVEL_WARNING, 'Erro de teste', '05001');

        $exception->genError('05002', 'Mensagem 1');
        $exception->genError('05003', 'Mensagem 2');
        $exception->genError('05004', 'Mensagem 4');
        $exception->autoThrow();

        return new Response('logs are in /var/log/ENV');
    }

    /**
     * @Route("/teste_conexao", name="teste_conexao")
     */
    public function testeConexao()
    {
        $app = $this->getDoctrine()
            ->getRepository(Aplicacao::class)
            ->findAll();

        var_dump($app);exit;
        return new JsonResponse($app);
    }

}