#Lumen-Doctrine-DDD-Example
Domain Driven Design Application Example, built with Lumen 5.3 and Doctrine.

###Introduction
Domain Driven Design approach help us write and maintain our core business preserved from technology dependencies. 
With the aid of ubiquitous language you could model your Domain and use thirdy part technologies to fit your needs.
There are some DDD concepts, that application does not implement as: ValueObject, multiple Entites.
The main purpose of this example is to give you a start point in terms of architecture, given the density of DDD, 
a simple example could not exhaust all the subject.
The follow example implements a Store with products and product categories.

###Assumptions
The Application Services are understood as Entrypoint for Domain.
There is one Controller, Service Application and Service Provider by Domain.
Providers map Contracts and Implementations.

###Usage
composer install <br/>

mv Application/Lumen53/env_example Application/Lumen53/.env

To generate the schema<br/>
1. cd Application/Lumen53/
2. php artisan migrate --path="../../database/migrations/"

API Calls <br/>
e.g. GET localhost/Lumen-Doctrine-DDD-Example/Application/Lumen53/public/api/v1/products

###Requirements
"php": ">=5.6.4", <br />
"laravel/lumen-framework": "5.3.*", <br />
"laravel-doctrine/orm": "1.2.*",

###Credits
https://github.com/GrahamCampbell/Laravel-Throttle <br/>
https://github.com/tecnom1k3/sp-simple-jwt <br/>
https://github.com/krisanalfa/lumen-jwt/blob/develop/app/Http/Middleware/CORSMiddleware.php <br/>

###References
DDD <br/>
https://github.com/dddinphp <br/>
http://www.zankavtaskin.com/2013/09/applied-domain-driven-design-ddd-part-1.html <br/>
https://www.youtube.com/watch?v=pL9XeNjy_z4&list=PLx4mLirQvMeV0uNpo1UaculL-djjI8eTz <br/>
https://www.youtube.com/watch?v=yPvef9R3k-M <br/>
https://www.youtube.com/watch?v=dnUFEg68ESM <br/>

Hexagonal Architecture <br/>
http://fideloper.com/hexagonal-architecture <br/>
http://alistair.cockburn.us/Hexagonal+architecture <br/>
https://www.yordipauptit.com/hexagonal-architecture-in-php/ <br/>

Laravel Doctrine <br/>
http://www.laraveldoctrine.org/

XML Doctrine Mapping <br/>
http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/xml-mapping.html

Criteria Array to Doctrine Criteria <br/>
https://gist.github.com/jgornick/8671644

Foreign Key <br/>
https://maltronblog.wordpress.com/2015/02/15/fkrelation/
https://engineering.thetrainline.com/2015/07/23/foreign-keys-dont-go-there/
http://microservices.io/patterns/data/database-per-service.html

Generators <br/>
https://github.com/InfyOmLabs/laravel-generator
https://github.com/motamonteiro/gerador

###Author
Davi dos Santos - davi646@gmail.com

###Contributors
Nicolas Escouto - nicolas.escouto@gmail.com

###Release Notes 
1. Isolation of framework dependency in Application concerns
3. Use of JMS serialization with YML
2. Tests sketch
