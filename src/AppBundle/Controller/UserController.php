<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


use AppBundle\Entity\User;
use AppBundle\Form\SellerRegisterType;

class UserController extends Controller
{

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(){
        return $this->render('user/index.html.twig');
    }

    /**
     *  @Route("/user/login", name="user_login")
     */
    public function sellerLoginAction(Request $request, AuthenticationUtils $authUtils)
    {  
        $seller = $this->getUser();
        $error = $authUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authUtils->getLastUsername();
                   
        return $this->render('user/login.html.twig' ,array(
            '_username' => $lastUsername,
            'error'     => $error
        ));
    }


    /**
     * @Route("/user/redirect", name="user_redirect")
     */
    public function userDashboardAction(){
        
        //rediect to customer dashboard is login as customer
        if ($this->get('security.authorization_checker')->isGranted('ROLE_CUSTOMER')) {
            return $this->redirectToRoute("customer_dashboard");
        }
        
        //rediect to customer dashboard is login as seller
        if ($this->get('security.authorization_checker')->isGranted('ROLE_SELLER')) {
            return $this->redirectToRoute("seller_dashboard");
        }

        //rediect to customer dashboard is login as admin
        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute("admin_dashboard");
        }

    }
    /**
     * @Route("/user/logout", name="user_logout")
     */
    public function userLogoutAction(){

    }

}
