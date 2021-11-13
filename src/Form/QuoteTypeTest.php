<?php

namespace App\Form\Type;

use App\Entity\Article;
use App\Entity\Quote;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class QuoteTypeTest extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('titre', TextType::class, [
                'help' => 'Nommez cette citation',
            ])
            ->add('contenu', CKEditorType::class)
            ->add('auteur', TextType::class);
    }


        public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Quote::class,
        ]);
    }




}