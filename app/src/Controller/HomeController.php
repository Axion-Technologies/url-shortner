<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Repository\ShortUrlsRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\ShortUrls;
use App\Service\CreateVisitorsLog;


class HomeController extends AbstractController
{
	
	public function index(): Response
	{
		return $this->render('home/index.html.twig');
	}


	/**
	 * the method that forwards the short url to the actual url
	 * */
	public function url_forward($code, ShortUrlsRepository $repository, CreateVisitorsLog $log_helper): Response
	{
		$short_code = $code;

		$url_details = $repository->findOneBy(['short_code' => $short_code]);

        if ($url_details === null) {
            throw $this->createNotFoundException('Url not found');
        }
        else {
        	//record visits
        	//$log_helper->create_log();

        	//redirect to long url
        	$url = $url_details->getUrl();
        	return new RedirectResponse($url);
        }
	}

}