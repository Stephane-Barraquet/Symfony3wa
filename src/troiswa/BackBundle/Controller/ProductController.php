<?php

namespace troiswa\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use troiswa\BackBundle\Entity\Product;
use troiswa\BackBundle\Form\ProductType;


class ProductController extends Controller
{


    public function productAction()
    {
        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository("troiswaBackBundle:Product")->findAll();


        return $this->render("troiswaBackBundle:Product:product.html.twig", [
            "products" => $products
        ]);
    }

    public function infosAction($idprod)
    {
        $em = $this->getDoctrine()->getManager();
        $oneProduct = $em->getRepository("troiswaBackBundle:Product")->find($idprod);

        if (empty($oneProduct))// $oneProduct==false -> test si var oneProduct est vide
        {

            throw $this->createNotFoundException("Ce produit n'existe pas");
        }


        return $this->render("troiswaBackBundle:Product:infoProduct.html.twig",["oneProduct"=>$oneProduct]);
    }

    public function addAction(Request $request)
    {
        $product = new Product();


        $formProduct = $this->createForm(new ProductType(), $product, ["attr" => ["novalidate" => "novalidate"]])
            ->add("send", "submit");


        $formProduct->handleRequest($request);

        if ($formProduct->isValid()) {

            // perform some action, such as saving the task to the database


            $em = $this->getDoctrine()->getManager();
            $em->persist($product);

            $em->flush();

            //die("good");

            $this->get("session")->getFlashBag()->add("success", "votre produit a bien été ajouté");

            //return $this->redirectToRoute('troiswa_back_addProduct');
        }

        return $this->render("troiswaBackBundle:Product:addProduct.html.twig", ["formProduct" => $formProduct->createView()]);
    }

    public function editAction($idprod,Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository("troiswaBackBundle:Product")->find($idprod);

        if (empty($product))// product==false -> test si var oneProduct est vide
        {

            throw $this->createNotFoundException("Ce produit n'existe pas");
        }
        $formUpdateProduct=$this->createForm(new ProductType(),$product,["attr"=>["novalidate"=>"novalidate"]])
                            ->add("send","submit");

        $formUpdateProduct->handleRequest($request);
        if($formUpdateProduct->isValid())
        {
            //$em->persist($product);
            $em->flush();

            $this->get("session")->getFlashBag()->add("success", "votre produit a bien été édité");
        }

        return $this->render("troiswaBackBundle:Product:editProduct.html.twig", ["formUpdate" => $formUpdateProduct->createView()]);
    }
    public function deleteAction($idprod,Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository("troiswaBackBundle:Product")->find($idprod);
        $em->remove($product);
        $em->flush();

            $this->get("session")->getFlashBag()->add("success", "votre produit a bien été supprimé");


        return $this->redirectToRoute('troiswa_back_viewProduct');
    }
    public function activeAction()
    {
        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository("troiswaBackBundle:Product")->findBy(["active"=>true],["price"=>"ASC"],10,1);

        dump($products);
        //die();

        return $this->render("troiswaBackBundle:Product:product.html.twig", [
            "products" => $products
        ]);
    }
    public function limitAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository("troiswaBackBundle:Product")->findby(["active"=>false],["price"=>"ASC"],$request->query->get("limit"), 1);


        return $this->render("troiswaBackBundle:Product:limitProduct.html.twig", [
            "products" => $products
        ]);
    }



    public function changeStateProductAction($idprod,$action)
    {

        $product= new Product();
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository("troiswaBackBundle:Product")
            //->findOneBy(["id"=>$idprod]);
            ->find($idprod);


        $product->setActive($action);

        $em->persist($product);

        $em->flush();



        // Récupérer le produit ayant l'id $idprod
        // Changer son état grâce à setActive et la variable $action
        // je flush

        return $this->redirectToRoute('troiswa_back_viewProduct');
        // redirectToRoute
    }
}