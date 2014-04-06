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
 * Zone Controller Test.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class ZoneControllerTest extends WebTestCase
{
    const FORM_INTENTION = 'zone';
    
    
    protected function setUp()
    {
        parent::setUp();
        
        $this->loadFixtures('zone');
    } 
    
    public function testListAction()
    {
        $crawler = $this->client->request('GET', '/admin/zones/');

        $this->assertResponseStatusCode(200);
        $this->assertCount(3, $crawler->filter('table tbody tr'));
    }
    
    public function testShowAction()
    {
        $this->client->request('GET', '/admin/zones/1');
        
        $this->assertResponseStatusCode(200);
    }       
    
    public function testNewActionGetMethod()
    {
        $crawler = $this->client->request('GET', '/admin/zones/new');
        
        $this->assertResponseStatusCode(200);
        $this->assertCount(1, $crawler->filter('form'));
    }      
    
    public function testNewActionPostMethod()
    {        
        $this->client->request('POST', '/admin/zones/new', array(
            'ir_zone_form' => array (
                'name'   => $this->faker->sentence(1),
                '_token' => $this->generateCsrfToken(static::FORM_INTENTION),
            ) 
        ));  
        
        $this->assertResponseStatusCode(302);
        
        $this->client->followRedirect();
        
        $this->assertResponseStatusCode(200);
        $this->assertCurrentUri('/admin/zones/4');
    }     
    
    public function testEditActionGetMethod()
    {   
        $crawler = $this->client->request('GET', '/admin/zones/1/edit');
        
        $this->assertResponseStatusCode(200);
        $this->assertCount(1, $crawler->filter('form'));        
    }      
    
    public function testEditActionPostMethod()
    {        
        $this->client->request('POST', '/admin/zones/1/edit', array(
            'ir_zone_form' => array (
                'name'   => $this->faker->sentence(1),              
                '_token' => $this->generateCsrfToken(static::FORM_INTENTION),
            ) 
        ));     
        
        $this->assertResponseStatusCode(302);
        
        $this->client->followRedirect();
        
        $this->assertResponseStatusCode(200);
        $this->assertCurrentUri('/admin/zones/1');
    }       
    
    public function testDeleteAction()
    {
        $this->client->request('GET', '/admin/zones/1/delete');
        
        $this->assertResponseStatusCode(302);
        
        $crawler = $this->client->followRedirect();
        
        $this->assertResponseStatusCode(200);
        $this->assertCurrentUri('/admin/zones/');
        $this->assertCount(2, $crawler->filter('table tbody tr'));
    }      
    
    public function testNotFoundHttpWhenZoneNotExist()
    {
        $this->client->request('GET', '/admin/zones/foo');
        $this->assertResponseStatusCode(404);        
        
        $this->client->request('GET', '/admin/zones/foo/edit');
        $this->assertResponseStatusCode(404);

        $this->client->request('GET', '/admin/zones/foo/delete');
        $this->assertResponseStatusCode(404);      
    }      
}
