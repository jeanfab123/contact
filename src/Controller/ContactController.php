<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Service\TestEmailService;
use App\Repository\AdresseRepository;
use App\Repository\ContactRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class ContactController
 * Gestion de toutes les méthodes liées à la partie "contact" (listing, ajout, modification, suppression)
 * @Route("/contact")
 */
class ContactController extends AbstractController
{
    /**
     * @Route("/", name="contact_index", methods="GET")
     */
    public function index(ContactRepository $contactRepository): Response
    {

        $contacts = $contactRepository->findBy(
            ['utilisateur' => $this->getUser()]
        );

        return $this->render('contact/index.html.twig', ['contacts' => $contacts]);
    }

    /**
     * @Route("/new", name="contact_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {

        $contact = new Contact();
        $contact->setUtilisateur($this->getUser());
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($contact);
            $em->flush();

            return $this->redirectToRoute('contact_index');
        }

        return $this->render('contact/new.html.twig', [
            'contact' => $contact,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="contact_show", methods="GET")
     */
    public function show(Contact $contact): Response
    {

        return $this->render('contact/show.html.twig', ['contact' => $contact]);
    }

    /**
     * @Route("/{id}/edit", name="contact_edit", methods="GET|POST")
     */
    public function edit(Request $request, ContactRepository $contactRepository): Response
    {

        $contact = $contactRepository->findOneBy([
            'utilisateur' => $this->getUser(),
            'id' => $request->get('id')
        ]);

        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('contact_edit', ['id' => $contact->getId()]);
        } elseif ($contact != null) {
            return $this->render('contact/edit.html.twig', [
                'contact' => $contact,
                'form' => $form->createView(),
            ]);
        } else
            return $this->redirectToRoute('contact_index');
    }

    /**
     * @Route("/{id}", name="contact_delete", methods="DELETE")
     */
    public function delete(Request $request, ContactRepository $contactRepository, AdresseRepository $adresseRepository): Response
    {

        $contact = $contactRepository->findOneBy([
            'utilisateur' => $this->getUser(),
            'id' => $request->get('id')
        ]);

        if ($contact != null) {
            if ($this->isCsrfTokenValid('delete'.$contact->getId(), $request->request->get('_token'))) {

                $adresses = $adresseRepository->findOneBy([
                    'contact' => $contact
                ]);

                $em = $this->getDoctrine()->getManager();
                if ($adresses) {
                    $em->remove($adresses);
                }
                $em->remove($contact);
                $em->flush();
            }
        }

        return $this->redirectToRoute('contact_index');
    }

    /**
     * @Route("/test-contact-email/{email}", name="test_contact_email", methods="GET")
     */
    public function testContactEmail(Request $request) {

        $soapClient = new \SoapClient('http://'.$_SERVER['HTTP_HOST'].'/soap?wsdl');

        $result = $soapClient->call('test', array('email', $request->get('email')));
    }

    /**
     * Teste l'email et renvoie un Json
     * @param object $testEmailService
     * @return Json
     * @Route("/test/{email}", name="test_contact_email_rest", methods="GET")
     */
    public function testContactEmailRest(TestEmailService $testEmailService, Request $request) {
        $testEmailResult = $testEmailService->test($request->get('email'));
        if ($testEmailResult) {
            $tabTestEmailResult['result'] = 1;
        } else {
            $tabTestEmailResult['result'] = 0;
        }

        return new JsonResponse($tabTestEmailResult, 200);
    }
}
