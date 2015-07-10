<?php

namespace troiswa\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use troiswa\BackBundle\Entity\Category;
use troiswa\BackBundle\Form\CategoryType;


class CategoryController extends Controller
{
    public function addCategoryAction(Request $request)
    {
        $category=new Category();

        $formCategory= $this->createForm(new CategoryType(),$category,["attr"=>["novalidate"=>"novalidate"]])
            ->add("send","submit");

        $formCategory->handleRequest($request);

        if($formCategory->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);

            $em->flush();


            $this->get("session")->getFlashBag()->add("success", "votre categorie a bien été ajouté");
        }



        return $this->render("troiswaBackBundle:Category:addCategory.html.twig",["formCategory"=>$formCategory->createView()]);


    }



    public function viewCategoryAction()
    {

        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository("troiswaBackBundle:Category")->findAll();


        return $this->render("troiswaBackBundle:Category:viewCategory.html.twig", [
            "categories" => $categories
        ]);


    }
    public function viewOneCategoryAction($idcat)
    {

        $em = $this->getDoctrine()->getManager();
        $oneCategory = $em->getRepository("troiswaBackBundle:Category")->find($idcat);


        return $this->render("troiswaBackBundle:Category:viewOneCategory.html.twig", [
            "oneCategory" => $oneCategory
        ]);


    }
    public function updateCategoryAction($idcat,Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository("troiswaBackBundle:Category")->find($idcat);

        if (empty($category))// product==false -> test si var oneProduct est vide
        {

            throw $this->createNotFoundException("Cette category n'existe pas");
        }
        $formUpdateCategory=$this->createForm(new CategoryType(),$category,["attr"=>["novalidate"=>"novalidate"]])
            ->add("send","submit");

        $formUpdateCategory->handleRequest($request);
        if($formUpdateCategory->isValid())
        {
            //$em->persist($product);
            $em->flush();

            $this->get("session")->getFlashBag()->add("success", "votre category a bien été édité");
        }

        return $this->render("troiswaBackBundle:Category:updateCategory.html.twig", ["formUpdate" => $formUpdateCategory->createView()]);
    }
    public function deleteCategoryAction($idcat)
    {
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository("troiswaBackBundle:Product")->find($idcat);
        $em->remove($category);
        $em->flush();

        $this->get("session")->getFlashBag()->add("success", "votre categorie a bien été supprimé");


        return $this->redirectToRoute('troiswa_back_viewCategory');
    }



    public function includeCategoryRenderAction()
    {

        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository("troiswaBackBundle:Category")->findAll();


        return $this->render("troiswaBackBundle:Category:includeCategoryRender.html.twig", [
            "categories" => $categories
        ]);


    }

}
