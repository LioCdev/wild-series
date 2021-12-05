<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Program;
use App\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @route("/category", name = "category_")
 * 
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/", name = "index")
     * @return Response
     */
    public function index(): Response
    {
        $categoryList = $this->getDoctrine()->getRepository(Category::class)->findAll();

        return $this->render('category/index.html.twig', [
            'controller_name' => 'CategoryController',
            'categoryList' => $categoryList]);
    }

    /**
     * @route("/new", name = "new")
     * @return Response
     */
    public function new(Request $request): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($category);
            $entityManager->flush();
            return $this->redirectToRoute('category_index');
        }
        return $this->render('category/new.html.twig', [
            "form" => $form->createView(),
        ]);
    }

    /**
     * @route("/{categoryName}", name = "show")
     * @return Response
     */
    public function show(string $categoryName): Response
    {
        $category = $this->getDoctrine()->getRepository(Category::class)->findOneBy(['name' => $categoryName]);

        if (!$category) {
            // throw $this->createNotFoundException(
            //     'No program with id : '.$categoryName.' found in program\'s table.'
            // );
            return $this->render('/404.html.twig');
        } 

        $categoryContent = $this->getDoctrine()->getRepository(Program::class)->findBy(['category' => $category], ['id' => 'DESC'], 3);
        return $this->render('category/show.html.twig', ['categoryContent' => $categoryContent, 'category' => $category]);
    }

}
