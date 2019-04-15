<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


use AppBundle\Entity\User;
use AppBundle\Entity\Product;
use AppBundle\Entity\SellerProduct;


use AppBundle\Form\UserRegisterType;
use AppBundle\Repository\UserRepository;


class CustomerController extends Controller
{


    /**
     * @Route("/customer/register", name="user_register")
     */
    public function sellerRegisterAction(Request $request)
    {
        //created a seller 
        $seller = new User();

        //created a seller register type
        $form = $this->createForm(UserRegisterType::class,$seller);

        // To handle the form data 
        $form->handleRequest($request);
            
        if($form->isSubmitted()){
            // create entity manager to insert the data 
            $entityManager = $this->getDoctrine()->getManager();
            $seller->setUserType(UserRepository::CUSTOMER);
            $entityManager->persist($seller);
            $entityManager->flush($seller);

            return $this->redirectToRoute('customer_dashboard');
        }
        return $this->render('customer/register.html.twig',[
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/customer/dashboard", name="customer_dashboard")
     */
    public function customerDashboardAction(){
        $products = $this->getDoctrine()->getRepository(Product::class)->findAll();
        return $this->render('customer/dashboard.html.twig',[
            'products'=>$products
        ]);
    }

    /**
     * @Route("/customer/order/{orderId}", name="customer_order")
     */
    public function customerOrderAction($orderId){
        $product = $this->getDoctrine()->getRepository(Product::class)->find($orderId);
        $sellerProduct = $this->getDoctrine()->getRepository(SellerProduct::class)->find($orderId);
        $sellers = [];
        return $this->render("customer/order.html.twig",[
            'product' => $product,
            'sellerProduct' => $sellerProduct,
        ]);
    }
}
