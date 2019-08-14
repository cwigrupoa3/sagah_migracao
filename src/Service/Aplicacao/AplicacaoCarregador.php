<?php

namespace App\Service\Aplicacao;

use App\Entity\Aplicacao;
use App\Service\Base\Abstracts\AbstractCarregador;
use Doctrine\ORM\EntityManagerInterface;

class AplicacaoCarregador extends AbstractCarregador
{

    //--------------------------------------------------------------------------------------------------------//

    public function __construct(\Doctrine\ORM\EntityManagerInterface $em)
    {
        parent::__construct($em, Aplicacao::class);
    }

    //--------------------------------------------------------------------------------------------------------//

    //--------------------------------------------------------------------------------------------------------//

    //--------------------------------------------------------------------------------------------------------//

}