<?php

/*
 * This file is part of the IRZoneBundle package.
 * 
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\ZoneBundle\Tests\Controller\Admin;

use IR\Bundle\ZoneBundle\Tests\Functional\WebTestCase;

/**
 * Country Controller Test.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class CountryControllerTest extends WebTestCase
{
    const FORM_INTENTION = 'country';
    
    
    protected function setUp()
    {
        parent::setUp();
        
        $this->loadFixtures('country');
    } 
    
    public function testListAction()
    {
        $crawler = $this->client->request('GET', '/admin/countries/');

        $this->assertResponseStatusCode(200);
        $this->assertCount(3, $crawler->filter('table tbody tr'));
    }
    
    public function testShowAction()
    {
        $this->client->request('GET', '/admin/countries/1');
        
        $this->assertResponseStatusCode(200);
    }       

    public function testNewActionGetMethod()
    {
        $crawler = $this->client->request('GET', '/admin/countries/new');
        
        $this->assertResponseStatusCode(200);
        $this->assertCount(1, $crawler->filter('form'));
    }     
    
    public function testNewActionPostMethod()
    {        
        $this->client->request('POST', '/admin/countries/new', array(
            'ir_zone_country_form' => array (
                'name'    => $this->faker->country(),
                'isoCode' => $this->faker->countryCode(),
                'zone'    => 1,
                '_token'  => $this->generateCsrfToken(static::FORM_INTENTION),
            ) 
        ));  
        
        $this->assertResponseStatusCode(302);
        
        $this->client->followRedirect();
        
        $this->assertResponseStatusCode(200);
        $this->assertCurrentUri('/admin/countries/4');
    }     

    public function testEditActionGetMethod()
    {   
        $crawler = $this->client->request('GET', '/admin/countries/1/edit');
        
        $this->assertResponseStatusCode(200);
        $this->assertCount(1, $crawler->filter('form'));        
    }      
    
    public function testEditActionPostMethod()
    {        
        $this->client->request('POST', '/admin/countries/1/edit', array(
            'ir_zone_country_form' => array (
                'name'    => $this->faker->country(),
                'isoCode' => $this->faker->countryCode(),
                'zone'    => 1,            
                '_token'  => $this->generateCsrfToken(static::FORM_INTENTION),
            ) 
        ));     
        
        $this->assertResponseStatusCode(302);
        
        $this->client->followRedirect();
        
        $this->assertResponseStatusCode(200);
        $this->assertCurrentUri('/admin/countries/1');
    }       

    public function testDeleteAction()
    {
        $this->client->request('GET', '/admin/countries/1/delete');
        
        $this->assertResponseStatusCode(302);
        
        $crawler = $this->client->followRedirect();
        
        $this->assertResponseStatusCode(200);
        $this->assertCurrentUri('/admin/countries/');
        $this->assertCount(2, $crawler->filter('table tbody tr'));
    }      

    public function testNotFoundHttpWhenCountryNotExist()
    {
        $this->client->request('GET', '/admin/countries/foo');
        $this->assertResponseStatusCode(404);        
        
        $this->client->request('GET', '/admin/countries/foo/edit');
        $this->assertResponseStatusCode(404);

        $this->client->request('GET', '/admin/countries/foo/delete');
        $this->assertResponseStatusCode(404);      
    }     
}
