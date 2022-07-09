<?php

namespace App\Form;

use App\Entity\Catalog;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CastomPizzaFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', null, [
                'label' => 'Name of your pizza', 'data' => 'pizza 1'
            ])
            ->add('Ingr', null, [
                'label' => 'Add ingridients',
            ])
            ->add('Quantity', IntegerType::class, ['mapped' => false, 'data' => 1])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Catalog::class,
        ]);
    }
}
