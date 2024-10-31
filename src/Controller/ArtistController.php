<?php

namespace App\Controller;
use App\Entity\Artist;
use App\Form\ArtistType;
use App\Repository\ArtistRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class ArtistController extends AbstractController
{
    #[Route('/artist', name: 'app_artist')]
    public function index(ArtistRepository $artistRepository): Response
    {
        $artists = $artistRepository->findAll();

        return $this->render('artist.html.twig', [
            'artists' => $artists,
        ]);
    }


  #[Route('/accueil', name: 'app_accueil', methods: ['GET'])]
  public function accueil(ArtistRepository $artistRepository): Response
  {
    $artists = $artistRepository->findAll();
     $artistArtworks = [];
     foreach ($artists as $artist) {
      $artistArtworks[$artist->getId()] = $artist->getArtworks();
    }
     return $this->render('front_office/accueil.html.twig', [
      'artists' => $artists,
      'artistArtworks' => $artistArtworks,
    ]);
  }

  #[Route('/artist/{id}/edit', name: 'artist_edit', methods: ['GET', 'POST'])]
  public function update(int $id, Request $request, ArtistRepository $artistRepository, EntityManagerInterface $entityManager): Response
  {
    // Retrieve the artist by ID
    $artist = $artistRepository->find($id);

    if (!$artist) {
      throw $this->createNotFoundException('Artist not found');
    }
    $form = $this->createForm(ArtistType::class, $artist);
    $form->handleRequest($request);

     if ($form->isSubmitted() && $form->isValid()) {
      $entityManager->persist($artist);
      $entityManager->flush();

       return $this->redirectToRoute('app_artist');
    }

    return $this->render('artist/edit.html.twig', [
      'form' => $form->createView(),
      'artist' => $artist,
    ]);
  }


  #[Route('/artist/new', name: 'artist_new', methods: ['GET', 'POST'])]
  public function new(Request $request, EntityManagerInterface $entityManager): Response
  {
     $artist = new Artist();

     $form = $this->createForm(ArtistType::class, $artist);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
       $entityManager->persist($artist);
      $entityManager->flush();

       return $this->redirectToRoute('app_artist');
    }

     return $this->render('artist/new.html.twig', [
      'form' => $form->createView(),
    ]);
  }


  #[Route('/artist/delete/{id}', name: 'artist_delete', methods: ['GET', 'POST'])]
  public function delete($id, ManagerRegistry $managerRegistry, ArtistRepository $artistRepository): Response
  {
    $entityManager = $managerRegistry->getManager();
    $artist = $artistRepository->find($id);

    if ($artist) {
      $entityManager->remove($artist);
      $entityManager->flush();
    }
    $this->addFlash('success', 'Artist deleted successfully!');

    return $this->redirectToRoute('app_artist', [], Response::HTTP_SEE_OTHER);
  }

}
