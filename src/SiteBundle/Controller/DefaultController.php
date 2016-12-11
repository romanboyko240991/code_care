<?php

namespace SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Category;
use AppBundle\Entity\ProductCategoryAssociation;
use AppBundle\Entity\User;

class DefaultController extends Controller
{
    /**
     * @Template
     * @Route("/register", name="register")
     */
    public function registerAction(Request $request)
    {
        $user = new User();

        $form = $this->createFormBuilder($user, ['attr' => ['class' => 'register']])
            ->add('username', TextType::class)
            ->add('password', TextType::class)
            ->add('email', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Register'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setIsAdmin(false);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('index_page');
        }

        return ['form' => $form->createView()];
    }
    /**
     * @Template
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return ['last_username' => $lastUsername, 'error' => $error];
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction(){}

    /**
     * @Template
     * @Route("/{page}", name = "index_page",
     *          defaults = {"page": 1},
     *          requirements = {"page": "\d+"})
     */
    public function indexAction($page)
    {
        $productsPerPage = 5;
        $startFromProduct = ($page * $productsPerPage) - $productsPerPage;

        $productsCount = $this->getDoctrine()->getManager()
            ->createQuery('SELECT COUNT(p.id) FROM AppBundle\Entity\Product p')
            ->getSingleScalarResult();

        //if there are products
        if($productsCount > 0) {
            //get number of pages
            $nofPages = ceil($productsCount / $productsPerPage);

            if($page <= 0 || $page > $nofPages) {
                return $this->render('TwigBundle:Exception:error.html.twig',
                    ['status_text' => 'The page does not exist', 'status_code' => 404]
                );
            }

            //get products (LIMIT $startFromProduct, $productsPerPage)
            $products = $this->getDoctrine()->getRepository('AppBundle:Product')
                ->findBy([], [], $productsPerPage, $startFromProduct);

            return ['products' => $products, 'page' => $page, 'nof_pages' => $nofPages];
        }
        else {
            return ['products' => [], 'page' => $page, 'nof_pages' => 0];
        }
    }

    /**
     * @Template
     * @Route("/category/{category_name}",
     *          defaults = {"category_name": ""},
     *          name="category_page")
     */
    public function categoryAction($category_name)
    {
        $categories = $this->getDoctrine()->getRepository('AppBundle:Category')->findAll();

        if(count($categories) > 0) {
            $category = $categories[0];

            foreach($categories as $currCategory) {
                if($currCategory->getName() == $category_name) {
                    $category = $currCategory;
                    break;
                }
            }

            $productsAssociationList = $category->getProductCategoryAssociations();

            return ['categories' => $categories, 'products_associations' => $productsAssociationList];
        }
        else {
            return ['categories' => [], 'products_associations' => []];
        }
    }
}
