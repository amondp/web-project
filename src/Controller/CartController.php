<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Orders;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class CartController extends AbstractController
{
	private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }
	
    /**
     * @Route("/cartController", name="cartController") methods={"GET","POST"}
     */
    public function index(SessionInterface $session)
    {
        $request = Request::createFromGlobals(); // the envelope, and were looking inside it.

        // catch the variables we sent from the JavaScript.
        $placedby = $request->request->get('placedby', 'this is the default');
        $orderdetails = $request->request->get('orderdetails', 'this is the default');
        $address = $request->request->get('deliveryaddress', 'this is the default');
      
      // Break apart the serialized order
		$data = explode("=", $orderdetails); //<--- this is what order details look like
        foreach($data as $record) {    
            $item = array_pad(explode('-',$record),3, null);
            echo 'Item: ' . $item[0] . '<br>';
            echo 'Qty: ' . $item[1] . '<br>';
			echo 'Subtotal: ' . $item[2] . '<br>';
        }        
           
        
        // to work the objects
        $entityManager = $this->getDoctrine()->getManager();

        // create blank entity of type "Orders"
        $order = new Orders();
        
        $order->setPlacedby($placedby);
        $order->setOrderdetails(substr($orderdetails, 0, -1));
		$order->setDeliveryaddress($address);

      
        $entityManager->persist($order);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();
       
        return new Response(
            'all ok' . $orderdetails
        );
    }
}
