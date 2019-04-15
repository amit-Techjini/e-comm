<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use AppBundle\Entity\Category;
use AppBundle\Entity\SubCategory;
use AppBundle\Entity\Brand;
use AppBundle\Entity\Product;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ProductType extends AbstractType
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
                'choice_label' => 'name',
                'mapped' => false
            ]) 
            ->add("brand",EntityType::class,[
                "class" => Brand::class,
                "placeholder" => 'select sub category',
                'choice_label' => 'name',
               
            ]) 
        ->add("name",TextType::class)
        ->add("brand",EntityType::class,[
            "class" => Brand::class,
            "placeholder" => 'select sub category',
            'choice_label' => 'name',
           
        ]) 
    ->add("name",TextType::class)
    ->add("description",TextType::class)
    ->add("photo",FileType::class,array('data_class' => null,'required' => false))
    ->add("price",TextType::class)
    ->add("save",SubmitType::class) ->add("description",TextType::class)
        ->add("photo",FileType::class,['label'=>"product pic here"])
        ->add("price",TextType::class)
        ->add("save",SubmitType::class)
        ;
    }
}