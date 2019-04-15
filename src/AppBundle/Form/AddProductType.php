<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\ORM\EntityManagerInterface;
use NoxLogic\DemoBundle\Entity\SubCategory;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
class AddProductType extends AbstractType
{
    // public function buildForm(FormBuilderInterface $builder, array $options=null)
    // {
        // $em = $this->getDoctrine()->getManager();
        // EntityRepository $er;
        // $category = $em->getRepository(Category::class)->find();
                
        // $builder 
            // ->add("category",ChoiceType::class,$category)
        // ;
    // }

    protected $em;

    function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Name of the user
        $builder->add('name', TextType::class);

        /* Add additional fields... */

        $builder->add('save', SubmitType::class);

        // Add listeners
        $builder->addEventListener(FormEvents::PRE_SET_DATA, array($this, 'onPreSetData'));
        $builder->addEventListener(FormEvents::PRE_SUBMIT, array($this, 'onPreSubmit'));
    }

    protected function addElements(FormInterface $form, SubCategory $subCategory = null) {
        // Remove the submit button, we will place this at the end of the form later
        $submit = $form->get('save');
        $form->remove('save');


        // Add the province element
        $form->add('subCategory', 'entity', array(
            'data' => $subCategory,
            'empty_value' => '-- Choose --',
            'class' => 'AppBundle:SubCategory',
            'mapped' => false)
        );

        // Cities are empty, unless we actually supplied a province
        $cities = array();
        if ($subCategory) {
            // Fetch the cities from specified subCategory
            $repo = $this->em->getRepository('AppBundle:SubCategory');
            // $cities = $repo->findByProvince($subCategory, array('name' => 'asc'));
        }

        // Add the city element
        $form->add('subCategory', 'entity', array(
            'empty_value' => '-- Select a subCategory first --',
            'class' => 'AppBundle:SubCategory',
            'choices' => $cities,
        ));

        // Add submit button again, this time, it's back at the end of the form
        $form->add($submit);
    }

    function onPreSetData(FormEvent $event) {
        $account = $event->getData();
        $form = $event->getForm();

        // We might have an empty account (when we insert a new account, for instance)
        // $province = $account->getCity() ? $account->getCity()->getProvince() : null;
        // $this->addElements($form, $province);
    }


    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
          $resolver->setDefaults(array(
              'data_class' => '\AppBundle\Entity\Product'
          ));
    }


    public function getName()
    {
        return "account_type";
    }


}