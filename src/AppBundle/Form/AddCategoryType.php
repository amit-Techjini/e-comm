<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AddCategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options=null)
    {
        $builder
        ->add("name", TextType::class)
        ->add("save", SubmitType::class,[ "label" => "add category" ])
        ;
    }
}