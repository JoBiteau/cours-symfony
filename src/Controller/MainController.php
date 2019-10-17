<?php

namespace App\Controller;

use App\Entity\Ville;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/main", name="main")
     */
    public function index()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/MainController.php',
        ]);
    }

    /**
     * @Route("/test", name="test")
     */
    public function test()
    {
        dd(phpinfo());
        $dbname = "test";
        $username = "dev";
        $password = "";
        $connex = $this->connexion( $dbname, $username, $password );
        dd($connex);

//        $mail = new PHPMailer(true);
//        phpinfo();
//        dump("route ok");die;
//        die;
        $t="plop";
        dump("${t}");
        dump("salut ${t}s");
        dd("test dd");

        return $this->render('test.html.twig');
    }

    /**
     * @Route("/form", name="form")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function form(Request $request)
    {
        $personne = new Personne();
        $form = $this->createForm(PersonneType::class, $personne);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($personne);
            $entityManager->flush();

            return $this->redirectToRoute("players_index");
        }

        return $this->render('form.html.twig',[

            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/MainController.php',
        ]);
    }

   /**
     * @Route("/ex1", name="exo")
     */
    public function ex1()
    {
        $em = $this->getDoctrine()->getManager();
//
//        $results = array(
//            array(
//                "ville"=>"SAINT-TRIVIER-SUR-MOIGNANS",
//                "departement"=>"01",
//                "latitude"=>"46.0667",
//                "longitude"=>"4.9",
//                "population"=>"1900",
//                "densite"=>"44"),
//            array("ville"=>"OULCHES-LA-VALLEE-FOULON","departement"=>"02","latitude"=>"49.4333","longitude"=>"3.75","population"=>"100","densite"=>"14"),
//            array("ville"=>"MARIOL","departement"=>"03","latitude"=>"46.0167","longitude"=>"3.5","population"=>"800","densite"=>"80"),
//            array("ville"=>"BELLAFFAIRE","departement"=>"04","latitude"=>"44.4167","longitude"=>"6.18333","population"=>"100","densite"=>"10"),
//            array("ville"=>"LE POET","departement"=>"05","latitude"=>"44.2833","longitude"=>"5.88333","population"=>"700","densite"=>"46"),
//            array("ville"=>"ALCAY-ALCABEHETY-SUNHARETTE","departement"=>"64","latitude"=>"43.095","longitude"=>"-0.908889","population"=>"200","densite"=>"6"),
//            array("ville"=>"LES ANGLES","departement"=>"65","latitude"=>"43.0833","longitude"=>"0.016667","population"=>"100","densite"=>"40"),
//            array("ville"=>"LA QUEUE-EN-BRIE","departement"=>"94","latitude"=>"48.7833","longitude"=>"2.58333","population"=>"11400","densite"=>"1242"),
//            array("ville"=>"LOC-EGUINER-SAINT-THEGONNEC","departement"=>"29","latitude"=>"48.4667","longitude"=>"-3.96667","population"=>"300","densite"=>"39"),
//            array("ville"=>"SAINT-HILAIRE-DE-LA-NOAILLE","departement"=>"33","latitude"=>"44.6012","longitude"=>"0.00166667","population"=>"400","densite"=>"32"),
//            array("ville"=>"MARCIAC","departement"=>"32","latitude"=>"43.5333","longitude"=>"0.166667","population"=>"1200","densite"=>"60"),
//            array("ville"=>"RAMONVILLE-SAINT-AGNE","departement"=>"31","latitude"=>"43.55","longitude"=>"1.46667","population"=>"11600","densite"=>"1856"),
//            array("ville"=>"MARENNES","departement"=>"17","latitude"=>"45.8167","longitude"=>"-1.11667","population"=>"5500","densite"=>"279"),
//            array("ville"=>"HALLENNES-LEZ-HAUBOURDIN","departement"=>"59","latitude"=>"50.3333","longitude"=>"3.75","population"=>"300","densite"=>"101"),
//            array("ville"=>"PAU","departement"=>"64","latitude"=>"43.3","longitude"=>"-0.366667","population"=>"84000","densite"=>"2575"),
//            array("ville"=>"HERES","departement"=>"65","latitude"=>"43.55","longitude"=>"0","population"=>"100","densite"=>"21")
//        );
//
//        foreach ($results as $result){
//            $ville = new Ville();
//            $ville->setVille($result['ville']);
//            $ville->setDepartement($result['departement']);
//            $ville->setLatitude($result['latitude']);
//            $ville->setLongitude($result['longitude']);
//            $ville->setPopulation($result['population']);
//            $ville->setDensite($result['densite']);
//
//            $em->persist($ville);
//        }
//
//        $em->flush();

        $villes = $em->getRepository(Ville::class)->findBy([],['ville'=>'asc']);
//        dd($villes);
        return $this->render('ex1.html.twig',[
            'villes' => $villes,
        ]);
    }

}
