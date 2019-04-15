<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


use AppBundle\Entity\User;
use AppBundle\Entity\Product;
use AppBundle\Entity\Address;
use AppBundle\Entity\SellerProduct;


use AppBundle\Form\UserRegisterType;
use AppBundle\Form\AddressType;

use AppBundle\Repository\UserRepository;
use AppBundle\Repository\AddressRepository;


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
        /**
     * @Route("/customer/profile", name="customer_profile")
     */
    public function customerProfileAction(){
       
        $id = $this->getUser()->getId();

        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        $userAddress = $this->getDoctrine()->getRepository(Address::class)->findActiveAddresses($this->getUser());

        return $this->render('customer/profile.html.twig',[
            "user" => $this->getUser(),
            "userAddress" => $userAddress
        ]);
    }
    
    /**
     * @Route("/customer/add/address", name="customer_add_address")
     */
    public function customerAddAddressAction(Request $request){

        // to store the address
        $address = new Address(); 
        
        //form to store address
        $form = $this->createForm(AddressType::class,$address); 

        $form->handleRequest($request);
        if($form->isSubmitted()){
            //to get the current user id
            $user = $this->getUser();

            $address = $form->getData();
            
            // $address->setUserId($userId);
            $address->setUser($user); // user object is sent and due to manytoone relation only id will be there.
            $address->setStatus(AddressRepository::ACTIVE);
            $em = $this->getDoctrine()->getManager();
            $em->persist($address);
            $em->flush($address);

            return $this->redirectToRoute('customer_profile');

        }
        return $this->render('customer/add-address.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("customer/buy/{productId}", name="customer_buy")
     */
    public function customerBuyAction($productId) {
        return;
    }
}
