<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use AppBundle\Entity\Category;
use AppBundle\Entity\SubCategory;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class BrandType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options=null)
    {
        $builder
        ->add("category",EntityType::class, [
            'class' => Category::class,
            'placeholder'=>'select category',
            'choice_label' => 'name',
            'mapped' => false
            ])
        ->add("subCategory",EntityType::class,[
            "class" => SubCategory::class,
            "placeholder" => 'select sub category',
            'choice_label' => 'name'
        ]) 
        ->add("name",TextType::class)
        ->add("save",SubmitType::class)
        ;
        // $builder->get("category")->addEventListener(
        //     FormEvents::PRE_SET_DATA,
        //     function (FormEvent $event){
        //         $form = $event->getForm();
        //         // $data = $event->getData();
        //         $form->getParent()->add("subCategory", EntityType::class,[
        //             'class' => SubCategory::class ,
        //             'placeholder' => 'please select sub category',
        //             'choice_label' => 'name',
        //             // 'choices' => $form->getData()->getSubCategory()
        //         ]);
        //     } 
        // );

        // $builder->addEventListener(
        //     FormEvents::POST_SET_DATA,
        //     function(FormEvent $event){

        //     $data = $event->getData();
        //     $form = $event->getForm();
        //     $subCategory = $data->getSubCategory();
        //     dump($subCategory);
        //     // // dump($data->getSubCategory());
        //     // $form->add("subCategory",EntityType::class,[
        //     //     'class'=>SubCategory::class,
        //     //     'choice_label' => 'name',
        //     //     'query_builder' => function(){

        //     //     }
        //     // // ])
        //     // ->add('name',TextType::class,[
        //     //     'label' => 'Add Brand:'
        //     // ])
        //     // ->add("save", SubmitType::class)
        //     if($subCategory){
        //         $form->get('category')->setData($subCategory->getCategory());
        //         $choices = $subCategory->getCategory()->getSubCategory(); 
        //     }else{
        //         $choices = [];
        //     }
            
        //     $form->add('subCategory', EntityType::class,[
        //                 'class' => SubCategory::class,
        //                 'placeholder' => 'please select',
        //                 'choices' => $choices
        //             ])
        //             ->add('name',TextType::class)
        //             ->add('save',SubmitType::class)
        //     ;
        // });
    }
}