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

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Region Type.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class RegionType extends AbstractType
{
    /**
     * @var string
     */         
    protected $class;

    
    /**
     * Constructor.
     * 
     * @param string  $class
     */
    public function __construct($class)
    {
        $this->class = $class;
    }    
    
    /**
     * {@inheritDoc}
     */    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder           
            ->add('name', null, array(                 
                'label' => 'ir_zone.form.region.name'
            )) 
            ->add('code', null, array(                 
                'label' => 'ir_zone.form.region.code'
            ))         
            ->add('zone', 'ir_zone_choice', array(                 
                'label' => 'ir_zone.form.region.zone'
            ))                 
            ->add('enabled', null, array(                 
                'label' => 'ir_zone.form.region.enabled'
            ));
    }

    /**
     * {@inheritdoc}
     */       
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->class,
            'intention' => 'region',
        ));        
    }       
    
    /**
     * {@inheritDoc}
     */    
    public function getName()
    {
        return 'ir_zone_region';
    }    
}
