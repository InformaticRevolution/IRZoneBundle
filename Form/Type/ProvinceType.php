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
 * Province Type.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class ProvinceType extends AbstractType
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
                'label' => 'ir_zone.form.province.name'
            )) 
            ->add('code', null, array(                 
                'label' => 'ir_zone.form.province.code'
            ))         
            ->add('zone', 'ir_zone_choice', array(  
                'empty_value' => '',
                'label' => 'ir_zone.form.province.zone'
            ))                 
            ->add('enabled', null, array(                 
                'label' => 'ir_zone.form.province.enabled'
            ));
    }

    /**
     * {@inheritdoc}
     */       
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->class,
            'intention' => 'province',
        ));        
    }       
    
    /**
     * {@inheritDoc}
     */    
    public function getName()
    {
        return 'ir_zone_province';
    }    
}
