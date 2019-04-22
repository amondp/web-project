<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Login;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class BackEnd extends AbstractController
{
	private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }
	
    /**
     * @Route("/backEnd", name="catch") methods={"GET","POST"}
     */
    public function index(SessionInterface $session)
    {
		$request = Request::createFromGlobals(); // the envelope, and were looking inside it.

        $type = $request->request->get('type', 'none');
		
		if ($type == 'register'){
			//perform register process
			
			//get variables
			$username = $request->request->get('username', 'none');
			$password = $request->request->get('password', 'none');
			$acctype = $request->request->get('acctype', 'none');
			
			
			//put in database
			$entityManager = $this -> getDoctrine() -> getManager();
			
			$login = new Login();
			$login->setUsername($username);
			$login->setPassword($password);
			$login->setAcctype($acctype);
			
			$entityManager->persist($login);
			
			$entityManager->flush();
			
			return new Response(
		'Register Page was called');
		}
		else if ($type == 'login'){
			
			//get username & password
			$username = $request->request->get('username', 'none');
			$password = $request->request->get('password', 'none');
			
			//comparison of variable against DB records
			$repo = $this->getDoctrine() -> getRepository(Login::class); // the type of the entity
				$person = $repo->findOneBy([
			
				'username'=>$username,
				'password'=>$password,
				]);
				
				// save the user ID to the session
                // KEY-VALUE
                
                // KEY - IS the name we give it
                // $variable - is what we want to save.
                $session->set('username', $username);
				
				return new Response(
				$person->getAcctype()//sends back account type
				);
			
		}
	}
}