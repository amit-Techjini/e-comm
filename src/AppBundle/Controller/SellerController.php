<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


use AppBundle\Entity\User;
use AppBundle\Entity\Address;
use AppBundle\Entity\Product;
use AppBundle\Entity\Model;
use AppBundle\Entity\SellerProduct;
use AppBundle\Entity\Specification;

use AppBundle\Form\UserRegisterType;
use AppBundle\Form\AddressType;
use AppBundle\Form\AddProductType;
use AppBundle\Form\SellerProductType;

use AppBundle\Repository\UserRepository;

class SellerController extends Controller
{
    /**
     * @Route("/seller/register", name="seller_register")
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
            $seller->setUserType(UserRepository::SELLER);
            
            $entityManager->persist($seller);
            $entityManager->flush($seller);

            return $this->redirectToRoute('user_login');
        }

        return $this->render('seller/register.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/seller/dashboard", name="seller_dashboard")
     */
    public function sellerDashboardAction(){

        $models = $this->getDoctrine()->getRepository(Model::class)->findAll();
        return $this->render('seller/dashboard.html.twig',[
            'models' => $models
        ]);
    }

    /**
     * @Route("/seller/add-product", name="seller_add_product")
     */
    public function sellerAddProductAction(){
        $product = new Product();
        $form = $this->createForm(AddProductType::class,$product); 
        return $this->render('seller/add-product.html.twig',[
            "form" => $form->createView()
        ]);
    }
    /**
     * @Route("/seller/add/{modelId}/model", name="seller_add_model")
     */
    public function sellerAddModelAction($modelId, Request $request){
        // $product = new Product();
        // $form = $this->createForm(AddProductType::class,$product); 
        // return $this->render('seller/add-product.html.twig',[
        //     "form" => $form->createView()
        // ]);

        $sellerProduct = new SellerProduct();

        $form = $this->createForm(SellerProductType::class,$sellerProduct);
        $model =$this->getDoctrine()->getRepository(Model::class)->find($modelId);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $sellerProduct = $form->getData();
            $sellerProduct->setModelId($modelId);
            $sellerProduct->setSellerId($this->getUser()->getId());
            $em =  $this->getDoctrine()->getManager();
            $em->persist($sellerProduct);
            $em->flush($sellerProduct);

            // return $this->redirectToRoute("seller_add_model");
        }
        
        
        return $this->render('seller/add-seller-product.html.twig',[
            'form' => $form->createView(),
            'model' => $model,
            // 'specification'=>$this->getDoctrine()->getRepository(Specification::class)->findSpecfication($modelId)
        ]);
    }

    /**
     * @Route("/seller/profile", name="seller_profile")
     */
    public function sellerProfileAction(){
       
        $id = $this->getUser()->getId();

        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        $userAddress = $this->getDoctrine()->getRepository(Address::class)->findAll($id);

        return $this->render('seller/profile.html.twig',[
            "user" => $user,
            "userAddress" => $userAddress
        ]);
    }
    
    /**
     * @Route("/seller/add/address", name="seller_add_address")
     */
    public function sellerAddAddressAction(Request $request){

        // to store the address
        $address = new Address(); 
        
        //form to store address
        $form = $this->createForm(AddressType::class,$address); 

        $form->handleRequest($request);
        if($form->isSubmitted()){
            //to get the current user id
            $userId = $this->getUser()->getId();

            $address = $form->getData();
            
            $address->setUserId($userId);
            $address->setStatus('active');
            $em = $this->getDoctrine()->getManager();
            $em->persist($address);
            $em->flush($address);

            return $this->redirectToRoute('seller_profile');

        }
        return $this->render('seller/add-address.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/seller/view/product", name="seller_view_product")
     */

    public function sellerViewProduct(){
        $sellerId = $this->getUser()->getId();
        $sellerProducts = $this->getDoctrine()->getRepository(SellerProduct::class)->findAllProduct($sellerId);
        $models= [];
        foreach ($sellerProducts as $sellerProduct){
            $id = $sellerProduct->getId();
            $model = $this->getDoctrine()->getRepository(Model::class)->find($id);
            array_push($models,$model->getName());
        }
        return $this->render("seller/view-product.html.twig",[
            'sellerProducts' => $sellerProducts,
            'models'=> $models
        ]);

    }
    // /**
    //  * @Route("/seller/logout", name="seller_logout")
    //  */
    // public function sellerLogoutAction(){

    // }

}
