<?php

declare(strict_types=1);

namespace App\Domain\Auth\Command\JoinByEmail\Confirm;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class Form extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('d1', NumberType::class, [
                'attr' => [
                    'min' => 1,
                    'max' => 1,
                ],
            ])
            ->add('d2', NumberType::class)
            ->add('d3', NumberType::class)
            ->add('d4', NumberType::class)
            ->add('d5', NumberType::class)
            ->add('d6', NumberType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Command::class,
        ]);
    }
}
