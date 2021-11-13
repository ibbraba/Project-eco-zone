<?php

namespace App\Form;

use App\Entity\Article;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\DomCrawler\Field\ChoiceFormField;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextareaType::class)
            ->add('imgbg', TextareaType::class)
            ->add('preview', TextareaType::class)
            ->add('content', CKEditorType::class, array(

                'config'      => array('uiColor' => '#001dff', 'toolbar' => 'full', ),
            ))
//            ->add('date',  ['default' => new \DateTime('now')])

            ->add('categorie', ChoiceType::class, [
                'choices' => [
                    'Catégorie' => [
                        'Actualités' => 'Actualités',
                        'Bourse' => 'Bourse',
                        'Economie' => 'Economie',
                        "Entreprises" => 'Entreprises',
                        "Livres" => 'Livres',
                    ] ]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
