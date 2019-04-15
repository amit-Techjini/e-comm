<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


use AppBundle\Entity\User;
use AppBundle\Entity\Address;
use AppBundle\Form\UserRegisterType;
use AppBundle\Form\AddressType;
use AppBundle\Repository\UserRepository;

class SellerApiController extends Controller
{

    // /**
    //  * @Route("/seller/update", methods="POST")
    //  */
    // public function sellerUpdateFunction(Request $request){
    //     $data = json_decode($request->getContent());
    //     echo data;
    //     die;
    //     $em = $this->getDoctrine()->getManager();
    //     $user = $em->getRepository()->find();

    //     $em->flush();

    // }



}
