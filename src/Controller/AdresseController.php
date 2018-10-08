<?php

namespace App\Controller;

use App\Entity\Adresse;
use App\Entity\Contact;
use App\Form\AdresseType;
use App\Repository\AdresseRepository;
use App\Repository\ContactRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/adresse")
 */
class AdresseController extends AbstractController
{
    /**
     * @Route("/contact-{contact_id}", name="adresse_index", methods="GET")
     */
    public function index(Request $request, AdresseRepository $adresseRepository, ContactRepository $contactRepository): Response
    {

        $contact = $contactRepository->findBy([
            'utilisateur' => $this->getUser(),
            'id' => $request->get('contact_id')
        ]);
/*
print '<pre>';
var_dump($contact);
exit;
*/
        if ($contact != null) {
            $adresses = $adresseRepository->findBy([
                'contact' => $request->get('contact_id')
            ]);
            return $this->render('adresse/index.html.twig', [
                'adresses'      => $adresses,
                'contact_id'    => $request->get('contact_id'),
//                'fullname'      => $contact->getNom() . ' ' . $contact->getPrenom(),
            ]);
        } else
            return $this->redirectToRoute('contact_index');
    }

    /**
     * @Route("/new/contact-{contact_id}", name="adresse_new", methods="GET|POST")
     */
    public function new(Request $request, ContactRepository $contactRepository): Response
    {

        $adresse = new Adresse();

/*
        $form = $this->createForm(AdresseType::class, $adresse)
        ->add('contact', HiddenType::class, [
            'data' => $request->get('contact_id'),
        ]);
*/
        $form = $this->createForm(AdresseType::class, $adresse);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $contact = $contactRepository->findBy([
                'utilisateur' => $this->getUser(),
                'id' => $request->request->get('contact_id')
            ]);

            $contact2 = new Contact;
print '<pre>';
var_dump($contact);
var_dump($contact2);

//            $adresse->setContact($contact2);
            $adresse->setContact($contact2);

var_dump($adresse);
exit;
            $em = $this->getDoctrine()->getManager();
            $em->persist($adresse);
            $em->flush();

            return $this->redirectToRoute('adresse_index');
        }

        return $this->render('adresse/new.html.twig', [
            'adresse' => $adresse,
            'form' => $form->createView(),
            'contact_id' => $request->get('contact_id')
        ]);
    }

    /**
     * @Route("/{id}", name="adresse_show", methods="GET")
     */
    public function show(Adresse $adresse): Response
    {
        return $this->render('adresse/show.html.twig', ['adresse' => $adresse]);
    }

    /**
     * @Route("/{id}/edit", name="adresse_edit", methods="GET|POST")
     */
    public function edit(Request $request, Adresse $adresse): Response
    {
        $form = $this->createForm(AdresseType::class, $adresse);
        $form->handleRequest($request);

        if ($this->getUser()->getId() == $adresse->getContact()->getUtilisateur()->getId()) {

            if ($form->isSubmitted() && $form->isValid()) {

                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('adresse_edit', ['id' => $adresse->getId()]);
            }

            return $this->render('adresse/edit.html.twig', [
                'adresse' => $adresse,
                'form' => $form->createView(),
            ]);
        } else {
            return $this->redirectToRoute('contact_index');
        }
    }

    /**
     * @Route("/{id}", name="adresse_delete", methods="DELETE")
     */
    public function delete(Request $request, Adresse $adresse): Response
    {

        if ($this->getUser()->getId() == $adresse->getContact()->getUtilisateur()->getId()) {

            if ($this->isCsrfTokenValid('delete'.$adresse->getId(), $request->request->get('_token'))) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($adresse);
                $em->flush();
            }

            return $this->redirectToRoute('adresse_index', ['contact_id' => $adresse->getContact()->getId()]);
        } else {
            return $this->redirectToRoute('contact_index');
        }
    }
}
