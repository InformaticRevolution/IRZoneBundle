Getting Started With IRZoneBundle
=================================

## Prerequisites

This version of the bundle requires Symfony 2.1+.

## Installation

1. Download IRZoneBundle using composer
2. Enable the Bundle
3. Create your classes
4. Configure the IRZoneBundle
5. Import IRZoneBundle routing
6. Update your database schema

### Step 1: Download IRZoneBundle using composer

Add IRZoneBundle in your composer.json:

``` js
{
    "require": {
        "informaticrevolution/zone-bundle": "*"
    }
}
```

Now tell composer to download the bundle by running the command:

``` bash
$ php composer.phar update informaticrevolution/zone-bundle
```

### Step 2: Enable the bundle

Enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new IR\Bundle\ZoneBundle\IRZoneBundle(),
    );
}
```

### Step 3: Create your classes

**a) Create your Zone class**

##### Annotations

``` php
<?php
// src/Acme/ZoneBundle/Entity/Zone.php

namespace Acme\ZoneBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use IR\Bundle\ZoneBundle\Model\Zone as BaseZone;

/**
 * @ORM\Entity
 * @ORM\Table(name="acme_zone")
 */
class Zone extends BaseZone
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
}
```

##### Yaml or Xml

``` php
<?php
// src/Acme/ZoneBundle/Entity/Zone.php

namespace Acme\ZoneBundle\Entity;

use IR\Bundle\ZoneBundle\Model\Zone as BaseZone;

/**
 * Zone implementation.
 */
class Zone extends BaseZone
{
}
```

In YAML:

``` yaml
# src/Acme/ZoneBundle/Resources/config/doctrine/Zone.orm.yml
Acme\ZoneBundle\Entity\Zone:
    type:  entity
    table: acme_zone
    id:
        id:
            type: integer
            generator:
                strategy: AUTO
```

In XML:

``` xml
<!-- src/Acme/ZoneBundle/Resources/config/doctrine/Zone.orm.xml -->
<?xml version="1.0" encoding="UTF-8"?>

<doctrine-mapping xmlns="http://doctrine-project.org/schemas/orm/doctrine-mapping"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xsi:schemaLocation="http://doctrine-project.org/schemas/orm/doctrine-mapping http://doctrine-project.org/schemas/orm/doctrine-mapping.xsd">

    <entity name="Acme\ZoneBundle\Entity\Zone" table="acme_zone">
        <id name="id" type="integer" column="id">
            <generator strategy="AUTO" />
        </id> 
    </entity>
    
</doctrine-mapping>
```

**b) Create your Country class**

**Warning:**

> If you override the __construct() method in your Country class, be sure
> to call parent::__construct(), as the base Country class depends on
> this to initialize some fields.

##### Annotations

``` php
<?php
// src/Acme/ZoneBundle/Entity/Country.php

namespace Acme\ZoneBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use IR\Bundle\ZoneBundle\Model\Country as BaseCountry;

/**
 * @ORM\Entity
 * @ORM\Table(name="acme_country")
 */
class Country extends BaseCountry
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="Region", mappedBy="country", cascade={"all"}, orphanRemoval=true)
     * @ORM\OrderBy({"name" = "ASC"})
     */
    protected $regions;


    /**
     * Constructor.
     */  
    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
}
```

##### Yaml or Xml

``` php
<?php
// src/Acme/ZoneBundle/Entity/Country.php

namespace Acme\ZoneBundle\Entity;

use IR\Bundle\ZoneBundle\Model\Country as BaseCountry;

/**
 * Country implementation.
 */
class Country extends BaseCountry
{
    /**
     * Constructor.
     */  
    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
}
```

In YAML:

``` yaml
# src/Acme/ZoneBundle/Resources/config/doctrine/Country.orm.yml
Acme\ZoneBundle\Entity\Country:
    type:  entity
    table: acme_country
    id:
        id:
            type: integer
            generator:
                strategy: AUTO

    oneToMany:
        regions:
            targetEntity: Region
            mappedBy: country
            cascade: [ all ]
            orphanRemoval: true
            orderBy: { name: ASC }
```

In XML:

``` xml
<!-- src/Acme/ZoneBundle/Resources/config/doctrine/Country.orm.xml -->
<?xml version="1.0" encoding="UTF-8"?>

<doctrine-mapping xmlns="http://doctrine-project.org/schemas/orm/doctrine-mapping"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xsi:schemaLocation="http://doctrine-project.org/schemas/orm/doctrine-mapping http://doctrine-project.org/schemas/orm/doctrine-mapping.xsd">

    <entity name="Acme\ZoneBundle\Entity\Country" table="acme_country">
        <id name="id" type="integer" column="id">
            <generator strategy="AUTO" />
        </id> 

        <one-to-many field="regions" target-entity="Region" mapped-by="country" orphan-removal="true">
            <cascade>
                <cascade-all />
            </cascade>   
            <order-by>
                <order-by-field name="name" direction="ASC" />
            </order-by>         
        </one-to-many>
    </entity>
    
</doctrine-mapping>
```

**c) Create your Region class**

##### Annotations

``` php
<?php
// src/Acme/ZoneBundle/Entity/Region.php

namespace Acme\ZoneBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use IR\Bundle\ZoneBundle\Model\Region as BaseRegion;

/**
 * @ORM\Entity
 * @ORM\Table(name="acme_region")
 */
class Region extends BaseRegion
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
}
```

##### Yaml or Xml

``` php
<?php
// src/Acme/ZoneBundle/Entity/Region.php

namespace Acme\ZoneBundle\Entity;

use IR\Bundle\ZoneBundle\Model\Region as BaseRegion;

/**
 * Region implementation.
 */
class Region extends BaseRegion
{
}
```

In YAML:

``` yaml
# src/Acme/ZoneBundle/Resources/config/doctrine/Region.orm.yml
Acme\ZoneBundle\Entity\Region:
    type:  entity
    table: acme_region
    id:
        id:
            type: integer
            generator:
                strategy: AUTO
```

In XML:

``` xml
<!-- src/Acme/ZoneBundle/Resources/config/doctrine/Region.orm.xml -->
<?xml version="1.0" encoding="UTF-8"?>

<doctrine-mapping xmlns="http://doctrine-project.org/schemas/orm/doctrine-mapping"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xsi:schemaLocation="http://doctrine-project.org/schemas/orm/doctrine-mapping http://doctrine-project.org/schemas/orm/doctrine-mapping.xsd">

    <entity name="Acme\ZoneBundle\Entity\Region" table="acme_region">
        <id name="id" type="integer" column="id">
            <generator strategy="AUTO" />
        </id> 
    </entity>
    
</doctrine-mapping>
```

### Step 4: Configure the IRZoneBundle

Add the bundle minimum configuration to your `config.yml` file:

**a) Add the zone configuration**

``` yaml
# app/config/config.yml
ir_zone:
    db_driver: orm # orm is the only available driver for the moment 
    zone_class: Acme\ZoneBundle\Entity\Zone
    country_class: Acme\ZoneBundle\Entity\Country
    region_class: Acme\ZoneBundle\Entity\Region
```

**b) Add the ZoneInterface and CountryInterface path to the RTEL**

``` yaml
# app/config/config.yml
doctrine:
    # ....
    orm:
        # ....
        resolve_target_entities:
            IR\Bundle\ZoneBundle\Model\ZoneInterface: Acme\ZoneBundle\Entity\Zone
            IR\Bundle\ZoneBundle\Model\CountryInterface: Acme\ZoneBundle\Entity\Country
```

### Step 5: Import IRZoneBundle routing files

Add the following configuration to your `routing.yml` file:

``` yaml
# app/config/routing.yml
ir_zone_admin:
    resource: "@IRZoneBundle/Resources/config/routing.xml"
    prefix: /admin
```

### Step 6: Update your database schema

Run the following command:

``` bash
$ php app/console doctrine:schema:update --force
```