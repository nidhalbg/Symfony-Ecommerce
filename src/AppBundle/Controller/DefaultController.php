<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use AppBundle\Form\Type\FilterType;
use Doctrine\Common\Collections\Criteria;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {   
        $productRepository = $this->getDoctrine()->getRepository(Product::class);
        
        $productsSlider = $productRepository->findBy(array(), array('id' => 'DESC'), 3);

        $form = $this->createForm(FilterType::class);

        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid())
        {            
            $search = $form['search']->getData();
            $order = $form['order']->getData();
            $criteria = $this->getCreteria($search, $order);
            $products = $productRepository->matching($criteria);    
        }
        else
        {
            $products = $productRepository->findAllOrderedByName();
        }

        return $this->render('default/index.html.twig', [
            'products' => $products, 
            'productsSlider' => $productsSlider,
            'form' => $form->createView()
        ]);
    }

    protected function getCreteria(string $search, string $order)
    {
        $criteria = new Criteria();
        $criteria->orWhere($criteria->expr()->contains('name', $search))
                 ->orWhere($criteria->expr()->contains('description', $search))
                 ->orderBy(array('price' => $order))
        ;

        return $criteria;
    }

}
