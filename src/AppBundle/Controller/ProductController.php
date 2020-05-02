<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ProductController extends FOSRestController {

    /**
   * REST action which returns type by id.
   * Method: GET, url: /api/products/{id}.{_format}
   *
   * @ApiDoc(
   *   resource = true,
   *   description = "Gets a product for a given id",
   *   output = "AppBundle\Entity\Product",
   *   statusCodes = {
   *     200 = "Returned when successful",
   *     404 = "Returned when the page is not found"
   *   }
   * )
   *
   * @param $id
   * @return mixed
   */
    public function getProductAction($id) {
        /** @var ProductRepository $productRepository */
        $productRepository = $this->getDoctrine()->getRepository(Product::class);
        $product = NULL;
        try {
        $product = $productRepository->find($id);
        } catch (\Exception $exception) {
        $product = NULL;
        }

        if (!$product) {
        throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.', $id));
        }

        $normalizer = new ObjectNormalizer();
        // $encoder = new JsonEncoder();

        $serializer = new Serializer([$normalizer]);
        
        // $json = $serializer->serialize($product, 'json');

        // $product = $serializer->deserialize($json, Product::class, 'json');

        // $product = $serializer->serialize(
        //     $product,
        //     null,
        //     ['groups' => ['group1']]
        // );

        $product = $serializer->normalize($product, null, ['groups' => 'api']);
        
        return new JsonResponse(['code' => 200, 'product' => $product]);
    }
  
    /**
     * @Rest\Get("/users")
     */
    public function getUsersAction()
    {
        $restresult = $this->getDoctrine()->getRepository('AppBundle:User')->findAll();
        if ($restresult === null) {
            return new View("there are no users exist", Response::HTTP_NOT_FOUND);
        }
        return $restresult;
    }
}