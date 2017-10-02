<?php
namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\Comment;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class ProductController extends Controller
{
    /**
     * @Route(path="/", name="home")
     **/
    public function indexAction()
    {
        $FiveLastProducts = $this->get('doctrine')
            ->getRepository(Product::class)
            ->findByFiveLast();
        return $this->render('home.html.twig', array(
            'FiveLastProducts' => $FiveLastProducts,
            'category' => $this->getDoctrine()->getRepository(Category::class)->findAll(),
        ));
    }

    /**
     * @Route(path="/products", name="products")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listProductAction()
    {
        return $this->render(
            'products.html.twig',
            [
                'products' => $this->getDoctrine()->getRepository(Product::class)->findAll(),
            ]
        );
    }

    /**
     * @Route(
     *     path="/product/{id}",
     *     name="product"
     * )
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showProductAction($id, Request $request)
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);


        if ($form->isValid()) {
            /** @var Comment $comment */
            $comment = $form->getData();
            $manager = $this->getDoctrine()->getManager();

            $comment->setIdRelated($id);

            $manager->persist($comment);//déclaration nouvelle entitée
            $manager->flush();//enregistre
            return $this->redirect($request ->getUri());
        }

        return $this->render(
            'product.html.twig',
            [
                'product' => $this->getDoctrine()->getRepository(Product::class)->find($id),
                'comments' =>$this->getDoctrine()->getRepository(Comment::class)->findByIdRelated($id),
                'FormComment' => $form->createView()
            ]
        );
    }

    /**
     * @Route(
     *     path="/product/add/",
     *     name="addProduct"
     * )
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createProductAction(Request $request)
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $product = $form->getData();
            $manager = $this->getDoctrine()->getManager();

            $file = $product->getImage();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                $this->getParameter('kernel.root_dir') . '/../public/uploads',
                $fileName);
            $product->setImage($fileName);

            $manager->persist($product);//déclaration nouvelle entitée
            $manager->flush();//enregistre
            return $this->redirectToRoute('products');
        }
        return $this->render('add.html.twig', ['toto' => $form->createView()]);
    }

}