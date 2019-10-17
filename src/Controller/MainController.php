<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Ville;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class MainController extends AbstractController
{
    /**
     * @Route("/main", name="main")
     */
    public function index ()
    {
        return $this->json( [
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/MainController.php',
        ] );
    }

    /**
     * @Route("/test", name="test")
     */
    public function test ()
    {
        dd( phpinfo() );
        $dbname = "test";
        $username = "dev";
        $password = "";
        $connex = $this->connexion( $dbname, $username, $password );
        dd( $connex );

//        $mail = new PHPMailer(true);
//        phpinfo();
//        dump("route ok");die;
//        die;
        $t = "plop";
        dump( "${t}" );
        dump( "salut ${t}s" );
        dd( "test dd" );

        return $this->render( 'test.html.twig' );
    }
//
//    /**
//     * @Route("/form", name="form")
//     * @param Request $request
//     * @param EntityManagerInterface $entityManager
//     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response
//     */
//    public function form(Request $request)
//    {
//        $personne = new Personne();
//        $form = $this->createForm(PersonneType::class, $personne);
//        $form->handleRequest($request);
//
//        if($form->isSubmitted() && $form->isValid()) {
//            $entityManager->persist($personne);
//            $entityManager->flush();
//
//            return $this->redirectToRoute("players_index");
//        }
//
//        return $this->render('ex2_form_sign.html.twig',[
//
//            'message' => 'Welcome to your new controller!',
//            'path' => 'src/Controller/MainController.php',
//        ]);
//    }

    /**
     * @Route("/ex1", name="exo")
     */
    public function ex1 ()
    {
        $em = $this->getDoctrine()->getManager();

        $villes = $em->getRepository( Ville::class )->findBy( [], ['ville' => 'asc'] );

        return $this->render( 'ex1.html.twig', [
            'villes' => $villes,
        ] );
    }

    /**
     * @Route("/ex2/sign", name="exo_2_sign")
     */
    public function ex2_form (Request $request, UserPasswordEncoderInterface $pass)
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository( User::class )->findAll();

        $user = new User();

        $form = $this->createForm( UserType::class, $user );
        $form->handleRequest( $request );

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($pass->encodePassword($user, $user->getPassword()));
            $em->persist( $user );
            $em->flush();
            return $this->redirectToRoute( "exo_2_admin" );
        }

        return $this->render( 'ex2_form_sign.html.twig', [
            'form' => $form->createView(),
            'users' => $users,
        ] );
    }

    /**
     * @Route("/ex2/admin", name="exo_2_admin")
     */
    public function ex2_admin ()
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository( User::class )->findAll();
        return $this->render( 'ex2_admin.html.twig', [
            'users' => $users,
        ] );
    }
    /**
     * @Route("/ex2/log", name="exo_2_log")
     */
    public function ex2_log (AuthenticationUtils $authenticationUtils)
    {
        return $this->render( 'ex2_form_log.html.twig', [
            'last_user' => $authenticationUtils->getLastUsername(),
            'error' => $authenticationUtils->getLastAuthenticationError()
        ] );
    }
}
