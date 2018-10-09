<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\TestEmailService;

class TestEmailController extends AbstractController
{
    /**
     * @Route("/soap")
     */
    public function index(TestEmailService $testEmailService)
    {

        $soapServer = new \SoapServer('http://api.deepupteam.com/testemail.wsdl');

        $soapServer->setObject($testEmailService);

        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml; charset=ISO-8859-1');

        ob_start();
        $soapServer->handle();
        $response->setContent(ob_get_clean());

        return $response;

    }
}