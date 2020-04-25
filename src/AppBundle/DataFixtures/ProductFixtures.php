<?php
namespace AppBundle\DataFixtures;

use AppBundle\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 20; $i++) {
            $product = new Product();
            $product->setName('product '.$i);
            $product->setRef('PROD_'.$i);
            $product->setPrice(mt_rand(10, 100));
            $product->setDescription("Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi aliquet magna id purus posuere, eget iaculis justo facilisis. Duis euismod sapien non suscipit lacinia. Pellentesque sem orci, commodo vitae augue ac, facilisis ornare nisi. Duis luctus sapien at ante pellentesque fringilla. Pellentesque nec nunc tellus. Fusce mollis ex vel imperdiet aliquam. Fusce pulvinar, libero a pretium mollis, lorem neque congue felis, tincidunt tincidunt tellus est vitae mi. Duis placerat arcu quam. Interdum et malesuada fames ac ante ipsum primis in faucibus. Ut consectetur dictum mattis.");
            $product->setImage("https://dummyimage.com/600x400/".$i);
            $manager->persist($product);
        }

        $manager->flush();
    }
}