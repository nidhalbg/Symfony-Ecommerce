<?php
namespace AppBundle\DataFixtures;

use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixtures extends Fixture
{	
	private $encoder;

	public function __construct(UserPasswordEncoderInterface $encoder)
	{
	    $this->encoder = $encoder;
	}
    
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('test');
        $user->setEmail('test@example.com');
        $password = $this->encoder->encodePassword($user, 'pass_1234');
    	$user->setPassword($password);

        $manager->persist($user);
        $manager->flush();
    }
}