<?php

namespace AfiliadosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AfiliadosBundle\Form\AfiliadosType;
use Symfony\Component\HttpFoundation\Request;
use AfiliadosBundle\Entity\Afiliados;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class AfiliadosController extends Controller
{
    /**
     * @Route("/homepage", name="homepage_index")
     */
    public function indexAction()
    {
        return $this->render('@Afiliados/Plantillas/homepage.html.twig');
    }

    //CREAR FORMULARIO DE CONTACTO
    /**
     * @Route("/new", name="afiliado_new")
     */
    public function newAction(Request $request)
    {
        $afiliado = new Afiliados;           
        $form =$this->createForm(AfiliadosType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
        
        $afiliado = $form->getData();

        $em = $this->getDoctrine()->getManager();
        $em->persist($afiliado);
        $em->flush();

        $this->addFlash('notice', 'El registro se ha cargado correctamente!');

        return $this->redirectToRoute('afiliado_show');

        }
        return $this->render('@Afiliados/Plantillas/new.html.twig', array("form"=>$form->createView()));
    }

    //MOSTRAR TODOS LOS REGISTROS
    /**
     * @Route("/show", name="afiliado_show")
     */

    public function showAction()
        {
        $afiliado = $this->getDoctrine()
        ->getRepository('AfiliadosBundle:Afiliados')
        ->findAll();

        return $this->render('@Afiliados/Plantillas/show.html.twig',
            array('afiliado' => $afiliado)
            );

        }   

    //VER UN REGISTRO
    /**
    * @Route("/view/{id}" , name="afiliado_view")
    */
        public function viewAction($id) 
        {
            $afiliado = $this->getDoctrine()
            ->getRepository('AfiliadosBundle:Afiliados')
            ->find($id);
            
            if (!$afiliado) {
            throw $this->createNotFoundException(
            'No hay registros con el siguiente id: ' . $id
                );
            }
        return $this->render(
                '@Afiliados/Plantillas/view.html.twig',
                array('afiliado' => $afiliado)
                );
        }

        /**
        * @Route("/delete/{id}" , name="afiliado_delete")
        */
        public function deleteAction($id) 
        {
            $em = $this->getDoctrine()->getManager();
            $afiliado = $em->getRepository('AfiliadosBundle:Afiliados')->find($id);
            
            if (!$afiliado) {
                throw $this->createNotFoundException(
                'No hay registros con el siguiente id: ' . $id
                 );
            }else{
                'El registro ha sido eliminado';
            }
            $em->remove($afiliado);
            $em->flush();
            $this->addFlash('notice', 'El registro se ha eliminado correctamente!');
            return $this->redirectToRoute('afiliado_show');
        }


        /**
        * @Route("/update/{id}", name="afiliado_update")
        */
        public function updateAction(Request $request,$id) 
        {
            $em = $this->getDoctrine()->getManager();
            $afiliado = $em->getRepository('AfiliadosBundle:Afiliados')->find($id);
                
                if (!$afiliado) {
                    throw $this->createNotFoundException(
                    'No se encuentran registros con el siguiente id: ' . $id
                    );
                    }
            $form = $this->createFormBuilder($afiliado)
                ->add('nombre',TextType::class)
                ->add('apellido',TextType::class)
                ->add('dni', TextType::class)
                ->add('fechaNacimiento', DateType::class)
                ->add('genero', ChoiceType::class,  ['label'=>'*Genero',
                 'choices'=>[
                     'Femenino'=> 'femenino',
                     'Masculino'=>'masculino',
                     'No Binario'=>'no binario',
                    ]
                    ])
                ->add('email', EmailType::class)
                ->add('enviar',SubmitType::class, array('label' => 'Guardar'))
                ->getForm();

            $form->handleRequest($request);
                
                if ($form->isSubmitted()) {
                    $afiliado = $form->getData();
                    $em->flush();
             $this->addFlash('notice', 'El registro se ha modificado correctamente!');
            return $this->redirectToRoute('afiliado_show');
        }
        
        return $this->render(
            '@Afiliados/Plantillas/edit.html.twig',
            array('form' => $form->createView())
            );
    }
}