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

/*
try {
    $soapServer = new \SoapServer('http://api.deepupteam.com/testemail.wsdl');
} catch (Exception $e) {
    echo 'Exception reçue : ',  $e->getMessage(), "\n";
} finally {
//print 'http://'.$_SERVER['HTTP_HOST'].'/testemail.wsdl';
print '<pre>';
var_dump($soapServer);
}
exit;
        //$soapServer = new \SoapServer('http://'.$_SERVER['HTTP_HOST'].'/testemail.wsdl');
*/

        $soapServer = new \SoapServer('http://api.deepupteam.com/testemail.wsdl');

        $soapServer->setObject($testEmailService);

/*
print '<pre>';
var_dump($soapServer);
exit;
*/

        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml; charset=ISO-8859-1');

        ob_start();
        $soapServer->handle();
        $response->setContent(ob_get_clean());
/*
print '<pre>';
var_dump($response);
exit;
*/
        return $response;

    }
}