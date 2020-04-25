<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use Doctrine\Common\Collections\Criteria;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {   
        $productRepository = $this->getDoctrine()->getRepository(Product::class);
        
        $productsSlider = $productRepository->findBy(array(), array('id' => 'DESC'), 3);

        $form = $this->createFormBuilder()
            ->add('search', SearchType::class, array(
                    'constraints' => new Length(array('min' => 3)
                    ),
                    'attr' => array('placeholder' => 'Rechercher un produit') 
            ))
            ->add('send', SubmitType::class, array('label' => 'Envoyer'))
            ->add('order', ChoiceType::class, array(
                'choices' => array(
                    'Trier par prix' => '',
                    'Croissant ' => 'ASC',
                    'Décroissant' => 'DESC',
                ),
                'label' => 'Trier par prix'
            ))
            ->getForm();

        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid())
        {            
            $search = $form['search']->getData();
            $order = $form['order']->getData();
            $criteria = new Criteria();
            $criteria->orWhere($criteria->expr()->contains('name', $search))
                     ->orWhere($criteria->expr()->contains('description', $search))
                     ->orderBy(array('price' => $order));
            $products = $productRepository->matching($criteria);    
        }
        else
        {
            $products = $productRepository->findAll();
        }

        return $this->render('default/index.html.twig', [
            'products' => $products, 
            'productsSlider' => $productsSlider,
            'form' => $form->createView()
        ]);
    }

}
