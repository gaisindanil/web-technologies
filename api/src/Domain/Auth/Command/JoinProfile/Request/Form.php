<?php

declare(strict_types=1);

namespace App\Domain\Auth\Command\JoinProfile\Request;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class Form extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class)
            ->add('contactPerson', TextType::class, [
                'required' => false,
            ])
            ->add('contactPhone', TextType::class, [
                'required' => false,
            ])
            ->add('ogrn', TextType::class)
            ->add('inn', TextType::class)
            ->add('kpp', TextType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Command::class,
        ]);
    }
}
