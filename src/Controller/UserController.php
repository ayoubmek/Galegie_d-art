<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class UserController extends AbstractController
{
  private $entityManager;

  public function __construct(EntityManagerInterface $entityManager)
  {
    $this->entityManager = $entityManager;
  }

  #[Route('/employes', name: 'app_employes', methods: ['GET'])]
  public function index(): Response
  {
     $users = $this->entityManager->getRepository(User::class)->findAll();

     return $this->render('admin/employes.html.twig', [
      'users' => $users,
    ]);
  }

  #[Route('/new', name: 'user_new', methods: ['GET', 'POST'])]
  public function new(Request $request): Response
  {
    $user = new User();
    $form = $this->createForm(UserType::class, $user);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $user->setPassword(
        password_hash($user->getPassword(), PASSWORD_BCRYPT)
      );

      $this->entityManager->persist($user);
      $this->entityManager->flush();

      return $this->redirectToRoute('user_index');
    }

    return $this->render('user/new.html.twig', [
      'user' => $user,
      'form' => $form->createView(),
    ]);
  }

  #[Route('/{id}', name: 'user_show', methods: ['GET'])]
  public function show(User $user): Response
  {
    return $this->render('user/show.html.twig', [
      'user' => $user,
    ]);
  }

  #[Route('/{id}/edit', name: 'user_edit', methods: ['GET', 'POST'])]
  public function edit(Request $request, User $user): Response
  {
    $form = $this->createForm(UserType::class, $user);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      if ($user->getPassword()) {
        $user->setPassword(
          password_hash($user->getPassword(), PASSWORD_BCRYPT)
        );
      }
      $this->entityManager->flush();

      return $this->redirectToRoute('user_index');
    }

    return $this->render('user/edit.html.twig', [
      'user' => $user,
      'form' => $form->createView(),
    ]);
  }


  #[Route('deletee/{id}', name: 'app_user_delete', methods: ['GET','POST'])]
  public function delete($id , ManagerRegistry $managerRegistry , UserRepository $userRepository): Response
  {
    $entityManager =$managerRegistry->getManager();
    $user= $userRepository->find($id) ;
    $entityManager->remove($user);
    $entityManager->flush();
    return $this->redirectToRoute('app_employes', [], Response::HTTP_SEE_OTHER);
  }

  #[Route('/users/search', name: 'app_user_search', methods: ['GET'])]
  public function search(Request $request, UserRepository $userRepository): Response
  {
    // Get the search term from the query parameters
    $searchTerm = $request->query->get('query');

    // Find users by username, email, or role matching the search term
    $users = $userRepository->findBySearchTerm($searchTerm);

    return $this->render('admin/employes.html.twig', [
      'users' => $users,
    ]);
  }
}
