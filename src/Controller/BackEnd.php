<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Login;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BackEnd extends AbstractController
{
    /**
     * @Route("/backEnd", name="catch") methods={"GET","POST"}
     */
    public function index()
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
				
				return new Response(
				$person->getAcctype()//sends back account type
				);
			
		}
	}
}