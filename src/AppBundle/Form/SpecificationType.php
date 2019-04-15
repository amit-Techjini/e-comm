<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Entity\Model;

class SpecificationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options=null)
    {
        $builder
        ->add("model",EntityType::class,[
            "class" => Model::class,
            "placeholder" => 'select sub category',
            'choice_label' => 'name',
           
        ]) 
    ->add("ram",TextType::class)
    ->add("storage",TextType::class)
    ->add("weight",TextType::class)
    ->add("dimension",TextType::class)
    ->add("battery",TextType::class)
    ->add("color",TextType::class)
    ->add("save",SubmitType::class)
        ;
    }
}