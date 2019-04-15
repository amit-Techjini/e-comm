<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use AppBundle\Entity\Category;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class AddSubCategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options=null)
    {
        $builder
        ->add("category",EntityType::class, [
            'class' => Category::class,
            'placeholder'=>'select category',
            'choice_label' => 'name',
            ])
        // ->add("category",TextType::class)
        ->add('name',TextType::class,[
            'label' => 'Sub Category (laptop,mobile,etc..)'
        ])
        ->add("save", SubmitType::class)
        ;
    }
}