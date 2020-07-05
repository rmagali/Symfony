<?php

namespace AfiliadosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class AfiliadosType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nombre',TextType::class, array(
             'attr' => array(
                    'placeholder' => 'Marcos') , 'label' => '*Nombre' ))
        ->add('apellido',TextType::class, array(
             'attr' => array(
                    'placeholder' => 'Pérez') , 'label' => '*Apellido' ))
        ->add('dni', TextType::class, array(
             'attr' => array(
                    'placeholder' => '25289412') , 'label' => '*DNI' , 
                    'invalid_message'=>'Ingresar el numero sin puntos'))
        ->add('fechaNacimiento', DateType::class, array(
            'widget' => 'single_text',
            'label' => '*Fecha de Nacimiento',
            ))
        ->add('genero', ChoiceType::class,
                 ['label'=>'*Genero',
                 'choices'=>[
                     'Femenino'=> 'femenino',
                     'Masculino'=>'masculino',
                     'No Binario'=>'no binario',
                    ]
                    ])
        ->add('email', EmailType::class, array(
             'attr' => array(
                    'placeholder' => 'xxx@xx.com') , 'label' => '*Correo electronico' ))
        ->add('enviar',SubmitType::class);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AfiliadosBundle\Entity\Afiliados'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'afiliadosbundle_afiliados';
    }


}
