<?php
// src/Controller/CategoryController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Category;
use App\Entity\Program;

/**
 * @Route("/categories", name="category_")
 */
class CategoryController extends AbstractController
{
     /**
     * @Route("/", name="category_index")
     * @return Response
     */
    public function index(): Response
    {
        $categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();

        return $this->render('category/index.html.twig', 
            ['categories' => $categories]
        );
    }

    /**
     * @Route("/show/{categoryName}", name="show")
     * @return Response
     */
    public function show(string $categoryName): Response
    {
        
        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findOneBy(['name' => $categoryName]);
           
        $programs = $this->getDoctrine()
           ->getRepository(Program::class)
           ->findBy(['category' => $category->getId()],
                    ['id' => 'DESC'],
                    3);
           


        if (!$categoryName) {
            throw $this->createNotFoundException(
               'No program with name : '.$categoryName.' found in this category.'
            );
        }    
        return $this->render('category/show.html.twig', 
        ['programs' => $programs]);

    }
}