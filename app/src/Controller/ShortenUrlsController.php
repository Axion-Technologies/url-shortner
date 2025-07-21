<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ShortUrlsRepository;
use App\Entity\ShortUrls;
use App\Entity\Users;



class ShortenUrlsController extends AbstractController
{
    /**
     * @Route("/product", name="app_product")
     */
    public function index(ShortUrlsRepository $repository): Response
    {
        // $shortened_urls = $repository->findAll();
        $shortened_urls = $repository->findBy([], ['id' => 'DESC']);

        return $this->render('shortenurls/index.html.twig', [
            'shortened_urls' => $shortened_urls,
        ]);
    }


    public function show($id, ShortUrlsRepository $repository): Response
    {

        $shortened_url = $repository->find($id);

        if ($shortened_url === null) {
            throw $this->createNotFoundException('No details found');
        }

        return $this->render('shortenurls/show.html.twig', [
            'shortened_url' => $shortened_url
        ]);
    }

}
