<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options=null)
    {
        $builder
        ->add("Address_line1", TextType::class)
        ->add("Address_line2", TextType::class)
        ->add("state", TextType::class)
        ->add("pincode", TextType::class)
        ->add("save", SubmitType::class,[ "label" => "add address" ])
        ;
    }
}