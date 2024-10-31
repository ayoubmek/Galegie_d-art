<?php

namespace App\Form;

use App\Entity\Artwork;
use App\Entity\Artist;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DecimalType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
 use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Form\Extension\Core\Type\NumberType; // Import NumberType here


class ArtworkType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
    $builder
      ->add('title', TextType::class, [
        'label' => 'Title',
      ])
      ->add('description', TextareaType::class, [
        'label' => 'Description',
      ])
      ->add('price', NumberType::class, [ // Change here to use NumberType
        'label' => 'Price',
        'scale' => 2, // Specify scale if needed (number of decimal places)
        'html5' => true, // Enables HTML5 input type="number"
      ])
      ->add('artist', EntityType::class, [
        'class' => Artist::class,
        'choice_label' => 'name',
        'label' => 'Artist',
        'placeholder' => 'Choose an artist',
      ]);

  }


  public function configureOptions(OptionsResolver $resolver): void
  {
    $resolver->setDefaults([
      'data_class' => Artwork::class,
    ]);
  }
}
