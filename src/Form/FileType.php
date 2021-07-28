<?php

namespace App\Form;

use App\Entity\File as EntityFile;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Vich\UploaderBundle\Form\Type\VichFileType;

class FileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('projectFile', VichFileType::class, [
                'required'     => false,
                'allow_delete' => true,
                'download_uri' => false,
                'constraints' => [new File([
                    'maxSize' => '1M',
                    'maxSizeMessage' => 'File size can not exceed 1M',
                ])]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EntityFile::class,
        ]);
    }
}
