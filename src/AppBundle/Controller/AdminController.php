<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


use AppBundle\Entity\User;
use AppBundle\Entity\Address;
use AppBundle\Entity\Category;
use AppBundle\Entity\SubCategory;
use AppBundle\Entity\SellerProduct;
use AppBundle\Entity\Brand;
use AppBundle\Entity\Model;
use AppBundle\Entity\Product;
use AppBundle\Entity\Cart;
use AppBundle\Entity\Specification;

use AppBundle\Form\UserRegisterType;
use AppBundle\Form\AddressType;
use AppBundle\Form\UserEditType;
use AppBundle\Form\AddCategoryType;
use AppBundle\Form\AddSubCategoryType;
use AppBundle\Form\AddProductType;
use AppBundle\Form\BrandType;
use AppBundle\Form\ProductType;
use AppBundle\Form\ModelType;
use AppBundle\Form\SpecificationType;

use AppBundle\Service\FileUploader;
use AppBundle\Repository\UserRepository;
use AppBundle\Repository\ProductRepository;

class AdminController extends Controller
{
    /**
     * @Route("/admin/register", name="admin_register")
     */
    public function adminRegisterAction(Request $request)
    {
        //created a seller 
        $admin = new User();

        //created a seller register type
        $form = $this->createForm(UserRegisterType::class,$admin);

        // To handle the form data 
        $form->handleRequest($request);
            
        if($form->isSubmitted()){
            // create entity manager to insert the data 
            $entityManager = $this->getDoctrine()->getManager();
            $admin->setUserType(UserRepository::ADMIN);
            
            $entityManager->persist($admin);
            $entityManager->flush($admin);

            return $this->redirectToRoute('user_login');
        }

        return $this->render('admin/register.html.twig',[
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route("/admin/dashboard", name="admin_dashboard")
     */
    public function adminDashboardAction(){
        return $this->render("admin/dashboard.html.twig");
    }


    /**
    * @Route("/admin/product", name="admin_product")
    */
    public function adminProductAction(Request $request){
        return $this->render('admin/product.html.twig');
    }


   /**
     * @Route("/admin/seller", name="admin_seller")
     */
    public function adminSellerAction(){
        $sellers = $this->getDoctrine()->getRepository(User::class)->findAllSeller();
        return $this->render("admin/seller.html.twig",[
            'sellers' => $sellers
        ]);
    }
    /**
     * @Route("/admin/add/address/{userId}", name="admin_add_address")
     */
    public function adminAddAddressAction($userId,Request $request){
        $address = new Address();
        $form = $this->createForm(AddressType::class, $address);

        $form->handleRequest($request);
        if($form->isSubmitted()){
            $address =$form->getData();
            $address->setStatus("active");
            $address->setUserId($userId);
            $em = $this->getDoctrine()->getManager();
            $em->persist($address);
            $em->flush($address);
            return $this->redirectToRoute('admin_view_seller',array("userId" => $userId));

        }
        return $this->render('admin/add-address.html.twig',[
            'form' =>$form->createView()
        ]);
    }
    /**
     * @Route("/admin/view/{userId}", name="admin_view_seller", requirements={"userId"="\d+"})
     */
    public function adminViewSellerAction($userId){
        $data = null;
        $user = $this->getDoctrine()->getRepository(User::class)->find($userId);
        if($user->getUserType() == UserRepository::SELLER){
            $data = $this->getDoctrine()->getRepository(SellerProduct::class)->findAllProduct($userId);
        } 
        if($user->getUserType() == UserRepository::CUSTOMER){
            $data = $this->getDoctrine()->getRepository(Cart::class)->findAll();
        }
        $activeAddresses = $this->getDoctrine()->getRepository(Address::class)->findActiveAddresses($user);
        $deactiveAddresses = $this->getDoctrine()->getRepository(Address::class)->findDeactiveAddresses($user);
   
        return $this->render("admin/view-seller.html.twig",[
            'user' => $user,
            'activeAddresses' => $activeAddresses,
            'deactiveAddresses' => $deactiveAddresses,
            'data' => $data

        ]);
    }

    /**
     * @Route("/admin/edit/{userId}", name="admin_edit_user")
     */
    public function adminEditUserAction(Request $request, $userId){
        
        $user = $this->getDoctrine()->getRepository(User::class)->find($userId);
        
        $form = $this->createForm(UserEditType::class,$user); 
        
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $user = $form->getData();

            $em = $this->getDoctrine()->getManager();

            $em->flush();

            return $this->redirectToRoute('admin_view_seller',array("userId" => $userId));

        }
        return $this->render('admin/edit-user.html.twig',[
            'form' => $form->createView()
        ]); 
    }
    /**
     * @Route("/admin/active/{userId}/address/{addressId}", name="admin_active_seller_address")
     */
    public function adminActiveSellerAddressAction($addressId, $userId){

        $addressActive = $this->getDoctrine()->getRepository(Address::class)->setAddressActive($addressId);

        return $this->redirectToRoute('admin_view_seller',array("userId" => $userId));
        
    }

       /**
     * @Route("/admin/customer", name="admin_customer")
     */
    public function adminCustomerAction(){
        // return $this->render("admin/dashboard.html.twig");
        $customers = $this->getDoctrine()->getRepository(User::class)->findAllCustomer();
        return $this->render("admin/customer.html.twig",[
            'customers' => $customers
        ]);
    }

    /**
     * @Route("/admin/profile", name="admin_profile")
     */
    public function adminProfileAction(){
        return $this->render("admin/dashboard.html.twig");
    }



    /**
     * @Route("/admin/edit/{userId}/address/{addressId}", name="admin_edit_address")
     */
    public function adminEditAddress(Request $request, $userId, $addressId){
           
        $address = $this->getDoctrine()->getRepository(Address::class)->find($addressId);

        $form = $this->createForm(AddressType::class,$address); 
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em = $this->getDoctrine()->getManager();
            $address = $form->getData();
            $em->flush();

            return $this->redirectToRoute('admin_view_seller',array("userId" => $userId));
 
        }
        return $this->render('admin/edit-address.html.twig',[
            'form'=>$form->createView()
        ]);

    }

    /**
     * @Route("/admin/deactive/{userId}/address/{addressId}", name="admin_deactive_address")
     */
    public function adminDeactiveAddress(Request $request, $userId, $addressId){
           
        $address = $this->getDoctrine()->getRepository(Address::class)->find($addressId);
        $address->setStatus('deactive');
        $em = $this->getDoctrine()->getManager();
        $em->flush();

            return $this->redirectToRoute('admin_view_seller',array("userId" => $userId));
   }


   /**
    * @Route("/admin/add-view/category", name="admin_add_view_category")
    */
    public function adminAddCategoryAction(Request $request){

        $category = new Category();

        $form = $this->createForm(AddCategoryType::class, $category);
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();
        $form->handleRequest($request);
        if($form->isSubmitted()){

            $category = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush($category);
            
            return $this->redirectToRoute("admin_product");
        }
        return $this->render('admin/add-view-category.html.twig',[
            'form' => $form->createView(),
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/admin/edit/category/{categoryId}", name="admin_edit_category")
     */
    public function adminEditCategoryAction(Request $request, $categoryId){
        $category = $this->getDoctrine()->getRepository(Category::class)->find($categoryId);

        $form = $this->createForm(AddCategoryType::class, $category);
        $form->handleRequest($request);

        if($form->isSubmitted()){
            $em = $this->getDoctrine()->getManager();
            $category = $form->getData();
            $em->flush();
            
            return $this->redirectToRoute("admin_add_view_category");
        }

        return $this->render('admin/edit-category.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/add-view/sub-category", name="admin_add_view_sub_category")
     */

    public function adminAddViewSubCategoryAction(Request $request){
        $subCategory = new SubCategory();

        $form = $this->createForm(AddSubCategoryType::class, $subCategory);
        $subCategories = $this->getDoctrine()->getRepository(SubCategory::class)->findAllSubCategory();
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em = $this->getDoctrine()->getManager();
            $subCategory = $form->getData();

            $em->persist($subCategory);
            $em->flush($subCategory);

            return $this->redirectToRoute("admin_add_view_sub_category");
        }

        return $this->render('admin/add-view-sub-category.html.twig',[
            'form' => $form->createView(),
            'subCategories' => $subCategories
        ]);
    }

    /**
     * @Route("admin/edit/sub-category/{subCategoryId}", name="admin_edit_sub_category")
     */
    public function adminEditSubCategoryAction($subCategoryId, Request $request){
        
        $subCategory = $this->getDoctrine()->getRepository(SubCategory::class)->find($subCategoryId);
        
        $form = $this->createForm(AddSubCategoryType::class, $subCategory);

        $form->handleRequest($request);

        if($form->isSubmitted()) {
            $subCategory = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("admin_add_view_sub_category");
        }
        return $this->render("admin/edit-sub-category.html.twig",[
            'form' => $form->createView()
        ]);
    }

    // /**
    //  * @Route("/admin/logout", name="admin_logout")
    //  */
    // public function adminLogoutAction(){

    // }
    /**
     * @Route("/admin/add-view/brand", name="admin_add_view_brand")
     */
    public function adminAddViewBrandAction(Request $request){
        $brand = new Brand;
        $form = $this->createForm(BrandType::class,$brand);
        $brands = $this->getDoctrine()->getRepository(Brand::class)->findAll();

        $form->handleRequest($request);
        if($form->isSubmitted()){
            $brand = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($brand);
            $em->flush($brand);
        }
        return $this->render('admin/add-view-brand.html.twig',[
            'form' => $form->createView(),
            'brands' => $brands
        ]);
    }

    // --------------------------------------------------------------------------------------
    // 
    //  add-view product for admin
    // 
    // --------------------------------------------------------------------------------------


    /**
     * @Route("/admin/add/product", name="admin_add_product")
     */
    public function adminAddProductAction(Request $request, FileUploader $fileUploader){

        $product = new Product;

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if($form->isSubmitted()) {
            $product = $form->getData();
            $file = $product->getPhoto();
            $fileName = $fileUploader->upload($file);
    
            $product->setPhoto($fileName);
            $product->setStatus(ProductRepository::ACTIVE);
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush($product);
        }
        
        return $this->render('admin/add-product.html.twig',[
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/{productId}/product", name="admin_particular_product", requirements={"productId"="\d+"})
     */
    public function adminEditProductAction($productId) {
        $product = $this->getDoctrine()->getRepository(Product::class)->find($productId);

        $form = $this->createForm(ProductType::class,$product);

        return $this->render('admin/edit-product.html.twig',[
            'form' => $form->createView()
        ]);
        //need to work in this area........
    }

    /**
     * @Route("/admin/view/product",name="admin_view_product")
     */
    public function adminViewProductAction(){
        $products = $this->getDoctrine()->getRepository(Product::class)->findAll();
        return $this->render('admin/view-product.html.twig',[
            'products' => $products
        ]);
    
    }


    // --------------------------------------------------------------------------------------
    // 
    //  add-view model for admin
    // 
    // --------------------------------------------------------------------------------------


    /**
     * @Route("/admin/add/model", name="admin_add_model")
     */
    public function adminAdModelAction(Request $request, FileUploader $fileUploader){

        $model = new Model;

        $form = $this->createForm(ModelType::class, $model);
        $form->handleRequest($request);

        if($form->isSubmitted()) {
            $model = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($model);
            $em->flush($model);
        }
        
        return $this->render('admin/add-model.html.twig',[
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/edit/{modelId}/model", name="admin_particular_model", requirements={"modelId"="\d+"})
     */
    public function adminEditModelAction($modelId, Request $request) {
        $model = $this->getDoctrine()->getRepository(Model::class)->find($modelId);

        $form = $this->createForm(ModelType::class,$model);

        $form->handleRequest($request);
        if($form->isSubmitted()){
            $model = $form->getData();
            dump($model);
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("admin_view_model");

        }
        return $this->render('admin/edit-model.html.twig',[
            'form' => $form->createView()
        ]);
        //need to work in this area........
    }

    /**
     * @Route("/admin/view/model",name="admin_view_model")
     */
    public function adminViewModelAction(){
        $models = $this->getDoctrine()->getRepository(Model::class)->findAllModel();
        return $this->render('admin/view-model.html.twig',[
            'models' => $models
        ]);
    
    }




    // --------------------------------------------------------------------------------------
    // 
    //  add-view specification for admin
    // 
    // --------------------------------------------------------------------------------------


    /**
     * @Route("/admin/add/specification", name="admin_add_specification")
     */
    public function adminAddSpecificationAction(Request $request, FileUploader $fileUploader){

        $specification = new Specification;

        $form = $this->createForm(SpecificationType::class, $specification);
        $form->handleRequest($request);

        if($form->isSubmitted()) {
            $specification = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($specification);
            $em->flush($specification);
        }
        
        return $this->render('admin/add-specification.html.twig',[
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/edit/{specificationId}/specification", name="admin_particular_specification", requirements={"modelId"="\d+"})
     */
    public function adminEditSpecificationAction($specificationId, Request $request) {
        $specification = $this->getDoctrine()->getRepository(Specification::class)->find($specificationId);

        $form = $this->createForm(SpecificationType::class,$specification);

        $form->handleRequest($request);
        if($form->isSubmitted()){
            $specification = $form->getData();
            dump($specification);
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("admin_view_specification");

        }
        return $this->render('admin/edit-specification.html.twig',[
            'form' => $form->createView()
        ]);
        //need to work in this area........
    }

    /**
     * @Route("/admin/view/specification",name="admin_view_specification")
     */
    public function adminViewSpecificationAction(){
        $specifications = $this->getDoctrine()->getRepository(Specification::class)->findAll();
        return $this->render('admin/view-specification.html.twig',[
            'specifications' => $specifications
        ]);
    
    }
}
