<?php

namespace App\Form;

use App\Entity\Country;
use App\Entity\Language;
use App\Entity\Skill;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if (!$options['is_organization']) {
            $builder
                ->add('firstname')
                ->add('lastname');
        } else {
            $builder
                ->add('organization', OrganizationType::class);
        }
        $builder
            ->add('email')
            ->add('biography')
            ->add('country', EntityType::class, [
                'class' => Country::class,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
            ])
            ->add('languages', EntityType::class, [
                'class' => Language::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('skills', EntityType::class, [
                'class' => Skill::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'is_organization' => true,
        ]);
    }
}
