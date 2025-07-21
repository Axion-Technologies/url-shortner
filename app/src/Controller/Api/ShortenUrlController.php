<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ShortUrlsRepository;
use App\Entity\ShortUrls;
use App\Entity\Users;



class ShortenUrlController extends AbstractController
{

    public function make(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $long_url = $data['long_url'] ?? null;

        if (!$long_url) {
            return new JsonResponse(['status' => 'error', 'message' => 'Provide url that needs to be shortened']);
        }

        $short_code = bin2hex(random_bytes(3)); 

        $user = $em->getRepository(Users::class)->find(1); // Replace 1 with actual user ID. Need to get from JWT token
        if (!$user) {
            return new JsonResponse(['status' => 'error', 'message' => 'User not found']);
        }

        $short_url = new ShortUrls();
        $short_url->setUser($user);
        $short_url->setUrl($long_url);
        $short_url->setShortCode($short_code);

        try {
            $em->persist($short_url);
            $em->flush();
            $short_base_url = $this->getParameter('app.short_url_base');
            $shortened_url = $short_base_url.'/'.$short_code;
            return new JsonResponse(['status' => 'success', 'message' => 'Url shortened successfully', 'shortened_url' => $shortened_url]);
        } catch (\Exception $e) {
            return new JsonResponse(['status' => 'error', 'message' => 'Error: ' . $e->getMessage()]);
        }
    }

}
