<?php

namespace troiswa\BackBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class FeedbackType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add("firstname","text",[
            "constraints"=>[ new Assert\NotBlank(),
                new Assert\Length(["min"=>2,"minMessage"=>'Votre prénom doit faire au moins {{ limit }} caractères'])

            ]
        ])
            ->add("lastname","text",[
                "constraints"=>[ new Assert\NotBlank(),
                    new Assert\Length(["min"=>5,"minMessage"=>'Votre nom doit faire au moins {{ limit }} caractères'])

                ]
            ])
            ->add("email","email",[
                "constraints"=>[ new Assert\NotBlank(),
                    new Assert\Email(["message"=> "Coucou '{{ value }}' n'est pas un email valide"])

                ]
            ])
            ->add("url","url",[
                "constraints"=>[ new Assert\NotBlank(),


                ]
            ])
            ->add("subject","choice",[
                "choices" => ["A"=>"bug Affichage","F"=>"bug fonctionnel","N"=>"rien ne marche"],
                "multiple" =>false,
                "expanded" =>true,
                "constraints"=> [ new Assert\NotBlank(),
                    new Assert\Choice([
                        "choices"=>["A","F","N"]
                    ])
                ]])
            ->add("description","textarea",[
                "constraints"=>[ new Assert\NotBlank(),
                    new Assert\Length(["min"=>50,"minMessage"=>'Votre texte doit faire au moins {{ limit }} caractères'])

                ]
            ])
            ->add('date_bug', 'datetime', [
                //'data' => new \DateTime("now"),
                'widget' => 'single_text',
                //'years' => range(date("Y")-10,date("Y")+10),
                "constraints" =>[ new Assert\DateTime()]
            ])
            ->add("send","submit")

            ->getForm();
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([]);
    }

    public function getName()
    {
        return 'form_contact';
    }
}