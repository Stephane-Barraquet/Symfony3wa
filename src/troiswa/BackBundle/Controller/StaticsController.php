<?php


namespace troiswa\BackBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class StaticsController extends Controller
{
    public function cgvAction()
    {
    return $this->render("troiswaBackBundle:Main:cgv.html.twig",[
        "firstname" =>"stephane",
        "age" => 27,
        "lastname" =>"barraquet"
    ]);
}
    public function cguAction()
    {
        return $this->render("troiswaBackBundle:Main:cgu.html.twig");
    }

    public function trainingAction($string)
    {
        echo $string;
        return $this->render("troiswaBackBundle:Training:training.html.twig");
    }
    public function heritageTemplateAction()
    {

        return $this->render("troiswaBackBundle:Statics:heritageTemplate.html.twig");
    }
    public function testTemplateAction()
    {

        return $this->render("troiswaBackBundle:Statics:testTemplate.html.twig");
    }
}
