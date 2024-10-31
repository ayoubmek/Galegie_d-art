<?php

namespace App\Controller;
use App\Entity\Artwork;
use App\Form\ArtworkType;
use App\Repository\ArtworkRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class MainController extends AbstractController
{
  #[Route('/main', name: 'app_main')]
  public function index(): Response
  {
    return $this->render('main/index.html.twig', [
      'controller_name' => 'MainController',
    ]);
  }


  #[Route('/SignIn', name: 'app_SignIn')]
  public function SignIn(): Response
  {
    return $this->render('authentication/SignIn.html.twig', [
      'controller_name' => 'MainController',
    ]);
  }
  #[Route('/SignUp', name: 'app_SignUp')]
  public function SignUp(): Response
  {
    return $this->render('authentication/SignUp.html.twig', [
      'controller_name' => 'MainController',
    ]);
  }



  #[Route('/artwork', name: 'app_artwork')]
  public function artwork(): Response
  {
    return $this->render('artwork.html.twig', [
      'controller_name' => 'MainController',
    ]);
  }
  
  #[Route('/contact', name: 'app_contact')]
  public function contact(): Response
  {
    return $this->render('front_office/contact.html.twig', [
      'controller_name' => 'MainController',
    ]);
  }
}
