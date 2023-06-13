<?php

namespace App\Form;

use App\Entity\Info;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class InfoType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, $this->getConfiguration("Titre", "Titre de l'evenement"))
            ->add('intro', TextType::class, $this->getConfiguration("Introduction", "Introduction de l'evenement"))
            ->add('content', TextType::class, $this->getConfiguration("Contenu", "Contenu de l'evenement"))
            ->add('image', UrlType::class, $this->getConfiguration("URL de l'image", "Image de couverture"))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Info::class,
        ]);
    }
}
