<?php

namespace App\Controller;
use App\Entity\Artist;
use App\Form\ArtistType;
use App\Repository\ArtistRepository;
use App\Entity\Artwork;
use App\Form\ArtworkType;
use App\Repository\ArtworkRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\Extension\Core\Type\NumberType;


class ArtworkController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/artwork', name: 'artwork_index', methods: ['GET'])]
    public function index(): Response
    {
        $artworks = $this->entityManager->getRepository(Artwork::class)->findAll();

        return $this->render('artwork.html.twig', [
            'artworks' => $artworks,
        ]);
    }

  #[Route('/dashboard', name: 'app_dashboard')]
  public function dashboard(ArtistRepository $artistRepository): Response
  {
    $artists = $artistRepository->findAll();
    $artistArtworks = [];
    foreach ($artists as $artist) {
     $artistArtworks[$artist->getId()] = $artist->getArtworks();
   }
    return $this->render('dashboard.html.twig', [
     'artists' => $artists,
     'artistArtworks' => $artistArtworks,
   ]);
  }
    #[Route('/artwork/new', name: 'artwork_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $artwork = new Artwork();
        $form = $this->createForm(ArtworkType::class, $artwork);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($artwork);
            $this->entityManager->flush();

            return $this->redirectToRoute('artwork_index');
        }
        return $this->render('artwork/new.html.twig', [
            'artwork' => $artwork,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/artwork/{id}', name: 'artwork_show', methods: ['GET'])]
    public function show(Artwork $artwork): Response
    {
        return $this->render('artwork/show.html.twig', [
            'artwork' => $artwork,
        ]);
    }

    #[Route('/artwork/{id}/edit', name: 'artwork_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Artwork $artwork): Response
    {
        $form = $this->createForm(ArtworkType::class, $artwork);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->redirectToRoute('artwork_index');
        }

        return $this->render('artwork/edit.html.twig', [
            'artwork' => $artwork,
            'form' => $form->createView(),
        ]);
    }


    #[Route('delete/{id}', name: 'artwork_delete', methods: ['GET','POST'])]
    public function delete($id , ManagerRegistry $managerRegistry , ArtworkRepository $artworkRepository): Response
    {
      $entityManager =$managerRegistry->getManager();
      $artwork= $artworkRepository->find($id) ;
      $entityManager->remove($artwork);
      $entityManager->flush();
      return $this->redirectToRoute('artwork_index', [], Response::HTTP_SEE_OTHER);
    }
}
