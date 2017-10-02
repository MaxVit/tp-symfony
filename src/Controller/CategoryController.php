<?php
namespace App\Controller;


use App\Entity\Category;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class CategoryController extends Controller
{

    /**
     * @Route(path="/category", name="category")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listCategoryAction()
    {
        return $this->render(
            'category.html.twig',
            [
                'categories' => $this->getDoctrine()->getRepository(Category::class)->findAll(),
            ]
        );
    }

    /**
     * @Route(
     *     path="/category/add/",
     *     name="addCategory"
     * )
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createCategoryAction(Request $request)
    {
        $category = new Category();
        $form = $this->createForm(ProductType::class, $category);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $category = $form->getData();
            $manager = $this->getDoctrine()->getManager();

            $manager->persist($category);//déclaration nouvelle entitée
            $manager->flush();//enregistre
            return $this->redirectToRoute('products');
        }
        return $this->render('addCategory.html.twig', ['FormCategory' => $form->createView()]);
    }

    /**
     * @Route(
     *     path="/category/{id}",
     *     name="oneCategory"
     * )
     */

    public function CategoryProduct ($id){

        $category = $this->get('doctrine')
            ->getRepository(Category::class)
            ->find($id);

        return $this->render('OneCategory.html.twig', array(
            'category' => $category
        ));
    }


}