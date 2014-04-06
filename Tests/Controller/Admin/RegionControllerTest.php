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
 * Region Controller Test.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class RegionControllerTest extends WebTestCase
{
    const FORM_INTENTION = 'region';
    
    
    protected function setUp()
    {
        parent::setUp();
        
        $this->loadFixtures('region');
    } 

    public function testNewActionGetMethod()
    {
        $crawler = $this->client->request('GET', '/admin/countries/1/regions/new');
        
        $this->assertResponseStatusCode(200);
        $this->assertCount(1, $crawler->filter('form'));
    }     

    public function testNewActionPostMethod()
    {        
        $this->client->request('POST', '/admin/countries/1/regions/new', array(
            'ir_zone_region_form' => array (
                'name'   => $this->faker->state(),
                'code'   => $this->faker->stateAbbr(),
                'zone'   => 2,
                '_token' => $this->generateCsrfToken(static::FORM_INTENTION),
            ) 
        ));  
        
        $this->assertResponseStatusCode(302);
        
        $this->client->followRedirect();
        
        $this->assertResponseStatusCode(200);
        $this->assertCurrentUri('/admin/countries/1');
    }   

    public function testEditActionGetMethod()
    {   
        $crawler = $this->client->request('GET', '/admin/countries/1/regions/1/edit');
        
        $this->assertResponseStatusCode(200);
        $this->assertCount(1, $crawler->filter('form'));        
    }     
    
    public function testEditActionPostMethod()
    {        
        $this->client->request('POST', '/admin/countries/1/regions/1/edit', array(
            'ir_zone_region_form' => array (
                'name'   => $this->faker->state(),
                'code'   => $this->faker->stateAbbr(),
                'zone'   => 2,
                '_token' => $this->generateCsrfToken(static::FORM_INTENTION),
            ) 
        ));     
        
        $this->assertResponseStatusCode(302);
        
        $this->client->followRedirect();
        
        $this->assertResponseStatusCode(200);
        $this->assertCurrentUri('/admin/countries/1');
    }      
    
    public function testDeleteAction()
    {
        $this->client->request('GET', '/admin/countries/1/regions/1/delete');
        
        $this->assertResponseStatusCode(302);
        
        $crawler = $this->client->followRedirect();
        
        $this->assertResponseStatusCode(200);
        $this->assertCurrentUri('/admin/countries/1');
        $this->assertCount(2, $crawler->filter('table.regions tbody tr'));
    } 

    public function testNotFoundHttpWhenCountryNotExist()
    {
        $this->client->request('GET', '/admin/countries/foo/regions/new');
        $this->assertResponseStatusCode(404);    
    }     
    
    public function testNotFoundHttpWhenRegionNotExist()
    {
        $this->client->request('GET', '/admin/countries/1/regions/foo/edit');
        $this->assertResponseStatusCode(404);

        $this->client->request('GET', '/admin/countries/1/regions/foo/delete');
        $this->assertResponseStatusCode(404);      
    }     
}
