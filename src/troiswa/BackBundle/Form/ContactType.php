<?php

namespace troiswa\BackBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ContactType extends AbstractType
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
            ->add("subject","choice",[
                "choices" => ["T"=>"Technique","C"=>"Commercial","P"=>"Partenariat"],
                "constraints"=> new Assert\Choice([
                    "choices"=>["T","C","P"]
                ])
            ])
            ->add("email","email",[
                "constraints"=>[ new Assert\NotBlank(),
                    new Assert\Email(["message"=> "Coucou '{{ value }}' n'est pas un email valide"])

                ]
            ])
            ->add("content","textarea",[
                "constraints"=>[ new Assert\NotBlank(),
                    new Assert\Length(["min"=>50,"minMessage"=>'Votre texte doit faire au moins {{ limit }} caractères'])

                ]
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