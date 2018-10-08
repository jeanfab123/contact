<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\InscriptionType;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecuriteController extends AbstractController
{

    /**
     * @Route("/inscription", name="securite_inscription")
     */
    public function inscription(Request $requete, ObjectManager $gestionnaire, UserPasswordEncoderInterface $encodeur)
    {

        $utilisateur = new Utilisateur();

        $form = $this->createForm(InscriptionType::class, $utilisateur);

        $form->handleRequest($requete);

        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encodeur->encodePassword($utilisateur, $utilisateur->getMotdepasse());
            $utilisateur->setMotdepasse($hash);
            $gestionnaire->persist($utilisateur);
            $gestionnaire->flush();
            return $this->redirectToRoute('securite_connexion');
        }

        return $this->render('securite/inscription.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/connexion", name="securite_connexion")
     */
    public function connexion()
    {
        return $this->render('securite/connexion.html.twig');
    }

    /**
     * @Route("/deconnexion", name="securite_deconnexion")
     */

    public function deconnexion()
    {
        
    }

}
