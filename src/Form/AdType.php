<?php

namespace App\Form;

use App\Entity\Ad;
use App\Form\ImageType;
use App\Form\ApplicationType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class AdType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, $this->getConfiguration("Titre", "Titre de votre annonce"))
            ->add('slug', TextType::class, $this->getConfiguration("Adresse Web", "http://www.loremflickr.com", [
                'required' => false
            ]))
            ->add('coverImage', UrlType::class, $this->getConfiguration("URL de l'image", "Image de couverture"))
            ->add('introduction', TextType::class, $this->getConfiguration("Introduction", "Entrez une introduction pour votre annonce"))
            ->add('content', TextareaType::class, $this->getConfiguration("Contenu", "Donner la description de votre annonce"))
            ->add('rooms', IntegerType::class, $this->getConfiguration("Chambre", "Nombre de chambres"))
            ->add('price', MoneyType::class, $this->getConfiguration("Prix", "Entrez le prix"))
            ->add('images', CollectionType::class, [
                'entry_type' => ImageType::class,
                'allow_add' => true,
                'allow_delete' => true
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}
