<?php

namespace troiswa\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use troiswa\BackBundle\Form\ContactType;
use troiswa\BackBundle\Form\FeedbackType;

//use Symfony\Component\HttpFoundation\Response;

class MainController extends Controller
{
    public function indexAction(Request $request)
    {
        /*
        $idprod=5;
        $em=$this->getDoctrine()->getManager();
        $query=$em->createQuery("SELECT prod FROM troiswaBackBundle:Product prod WHERE prod.quantity> :idproduct")->setParameter("idproduct",$idprod);
        $products=$query->getResult();
        */

        $em=$this->getDoctrine()->getManager();
        $productQuantity=$em->getRepository("troiswaBackBundle:Product")->findProductByQuantity(5);
        dump($productQuantity);

        $countZero=$em->getRepository("troiswaBackBundle:Product")->countZero();

        dump($countZero);


        $em=$this->getDoctrine()->getManager();
        $numberCategory=$em->getRepository('troiswaBackBundle:Category')->countCategory();
        dump($numberCategory);



        $em=$this->getDoctrine()->getManager();
        $countActiveProduct=$em->getRepository("troiswaBackBundle:Product")->countActiveProduct();
        dump($countActiveProduct);

        $em=$this->getDoctrine()->getManager();
        $countBothActiveProduct=$em->getRepository("troiswaBackBundle:Product")->countBothActiveProduct();
        dump($countBothActiveProduct);

        $em=$this->getDoctrine()->getManager();
        $numberCategory=$em->getRepository('troiswaBackBundle:Category')->countCategory();
        dump($numberCategory);

        $em=$this->getDoctrine()->getManager();
        $findProductBetweenPrice=$em->getRepository('troiswaBackBundle:Product')->findProductBetweenPrice(10,20);
        dump($findProductBetweenPrice);

        $em=$this->getDoctrine()->getManager();
        $getStrinCategory=$em->getRepository('troiswaBackBundle:Category')->getStringCategory();
        dump($getStrinCategory);

        die();

        return $this->render("troiswaBackBundle:Main:index.html.twig",["productQuantity"=>$productQuantity]);
    }

    public function contactAction(Request $request)
    {
        $formContact=$this->createForm(new ContactType(),null,["attr" =>["novalidate"=>"novalidate"]]);
            //"attr" =>["novalidate"=>"novalidate"] // desactive les validations html



        $formContact->handleRequest($request);
        // equivaut à
       /* if($request->isMethod("POST"))
        {
            $formContact->submit($request);*/
            if($formContact->isValid())
            {
                $data=$formContact->getData();
                //$data=$request->request->all();
                dump($data);
                //die();
                $message = \Swift_Message::newInstance()
                    ->setSubject($data["choices"])
                    ->setFrom($data["email"])
                    ->setTo('mrheatseek2@gmail.com')
                    //->setBody($data["contenu"])
                //->setBody($this->renderView('TroiswaBackBundle:Mails:email.html.twig', []));

                ->setBody(
                $this->renderView('troiswaBackBundle:Mails:contact-email.html.twig', ["data"=>$data]), 'text/html')
                ->addPart(
                    $this->renderView('troiswaBackBundle:Mails:contact-email.txt.twig', ["data"=>$data]), 'text/plain');

                // setBody enverra le message sous forme HTML
                // addPart enverra le message sous forme txt

                //recupertion d'un service
                $this->get('mailer')->send($message);

                //
                $this->get("session")->getFlashBag()->add("success","votre email a bien été envoyé");

                return $this->redirectToRoute("troiswa_back_contact");
                // ancienne ecriture
                //$this->generateUrl("nom de la route")
            }
       // }

        return $this->render("troiswaBackBundle:Main:contact.html.twig",["formContact"=>$formContact->createView()]);
    }
    public function feedbackAction(Request $request)
    {
        $formContact=$this->createForm(new FeedbackType(),null,["attr" =>["novalidate"=>"novalidate"]]);


        $formContact->handleRequest($request);

        if($formContact->isValid())
        {
            $data=$formContact->getData();

            dump($data);

            $message = \Swift_Message::newInstance()
                ->setSubject("T")
                ->setFrom($data["email"])
                ->setTo('mrheatseek2@gmail.com')


                ->setBody(
                    $this->renderView('troiswaBackBundle:Mails:feedback-email.html.twig', ["data"=>$data]), 'text/html')
                ->addPart(
                    $this->renderView('troiswaBackBundle:Mails:feedback-email.txt.twig', ["data"=>$data]), 'text/plain');


            $this->get('mailer')->send($message);


            $this->get("session")->getFlashBag()->add("success","votre remarque a bien été envoyé");

            //dump($data);
            //die();
            $logger = $this->get("logger");
            if($data["sujet"]=="A")
            {
                $logger->info('Nous avons récupéré le logger');
            }
            elseif($data["sujet"]=="F")
            {
                $logger->error('Une erreur est survenue');
            }
            return $this->redirectToRoute("troiswa_back_feedback");

        }


        return $this->render("troiswaBackBundle:Main:feedback.html.twig",["formContact"=>$formContact->createView()]);
    }
}

