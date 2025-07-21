<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;



class LoginController extends AbstractController
{
    
    public function index(Request $request): JsonResponse
    {

        return new JsonResponse(['message' => 'Hello worlds']);
    }


    /*public function show($id, ProductRepository $repository): Response
    {

        $product = $repository->find($id);

        if ($product === null) {
            throw $this->createNotFoundException('Product not found');
        }

        return $this->render('product/show.html.twig', [
            'product' => $product
        ]);
    }


    public function new(Request $request, EntityManagerInterface $em): Response
    {
        if ($request->isMethod('POST')) {
            $name = $request->request->get('name');
            $size = $request->request->get('size');
            $description = $request->request->get('description');

            $product = new Product();
            $product->setName($name);
            $product->setSize($size);
            $product->setDescription($description);

            $em->persist($product);
            $em->flush();

            return new Response("Product created successfully");
        }

        return $this->render('product/new.html.twig');
    }*/

}
