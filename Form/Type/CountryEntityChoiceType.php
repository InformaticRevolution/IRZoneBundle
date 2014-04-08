<?php

/*
 * This file is part of the IRZoneBundle package.
 * 
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\ZoneBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Country Entity Choice Type.
 * 
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class CountryEntityChoiceType extends CountryChoiceType
{
    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);
        
        $resolver->setDefaults(array(
            'query_builder' => function(EntityRepository $er) {
                return $er->createQueryBuilder('c')
                    ->where('c.enabled = :enabled')
                    ->setParameter('enabled', true)
                    ->orderBy('c.name', 'ASC');
            },
        ));
    }   
    
    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'entity';
    }
}