<?php
/**
 * Created by PhpStorm.
 * User: Emmanuel
 * Date: 21/08/13
 * Time: 11:47
 */

class Doctrine
{
    public $em = null;
    public $tool = null;

    public function __construct()
    {
        // load database configuration from CodeIgniter
        //require_once APPPATH.'config/database.php';
        // Is the config file in the environment folder?
        if (!defined('ENVIRONMENT') OR !file_exists($file_path = APPPATH . 'config/' . ENVIRONMENT . '/database.php')) {
            require APPPATH . 'config/database.php';
        }

        // Set up class loading. You could use different autoloaders, provided by your favorite framework,
        // if you want to.

        require_once './vendor/doctrine/common/lib/Doctrine/Common/ClassLoader.php';

        $classLoader = new \Doctrine\Common\ClassLoader('Doctrine', './vendor/doctrine/common/lib');
        $classLoader->register();

        $entitiesClassLoader = new \Doctrine\Common\ClassLoader('Entities', APPPATH . 'models');
        $entitiesClassLoader->register();

        foreach (glob(APPPATH . 'modules/*', GLOB_ONLYDIR) as $m) {
            $module = str_replace(APPPATH . 'modules/models', 'Entities', $m);
            $loader = new \Doctrine\Common\ClassLoader($module, APPPATH . 'modules/models');
            $loader->register();
        }

        $evm = new \Doctrine\Common\EventManager();

        $proxiesClassLoader = new \Doctrine\Common\ClassLoader('Proxies', APPPATH . 'models');
        $proxiesClassLoader->register();

        // Set up caches
        $config = new \Doctrine\ORM\Configuration;
        if (ENVIRONMENT == "development") {
            $cache = new \Doctrine\Common\Cache\ArrayCache;
        } else {
            $cache = new \Doctrine\Common\Cache\ApcCache;
        }
        $config->setMetadataCacheImpl($cache);
        $config->setQueryCacheImpl($cache);

        // Set up driver
        /*$reader = new \Doctrine\Common\Annotations\AnnotationReader($cache);
        $reader->setDefaultAnnotationNamespace('Doctrine\ORM\Mapping\\');*/

        // Set up models
        $entities = array(APPPATH . 'models/Entities');
        foreach (glob(APPPATH . 'modules/*/models/Entities', GLOB_ONLYDIR) as $m) {
            array_push($entities, $m);
        }
        //$driver = new \Doctrine\ORM\Mapping\Driver\AnnotationDriver($reader, $models);
        $driveImpl = $config->newDefaultAnnotationDriver($entities);

        $config->setMetadataDriverImpl($driveImpl);

        // Proxy configuration
        $config->setProxyDir(APPPATH . 'models/proxies');
        $config->setProxyNamespace('Proxies');

        if (ENVIRONMENT == "development") {
            $config->setAutoGenerateProxyClasses(true);
        } else {
            $config->setAutoGenerateProxyClasses(false);
        }

        // Set up logger
        $logger = new \Doctrine\DBAL\Logging\EchoSQLLogger();
        $config->setSQLLogger($logger);

        // Database connection information
        // Driver Selection
        // pdo_mysql, pdo_sqlite, pdo_pgsql, pdo_oci, oci8, ibm_db2, pdo_ibm, pdo_sqlsrv, mysqli, drizzle_pdo_mysql, sqlsrv
        $connectionOptions = array(
            'driver'        => 'pdo_mysql',
            'user'          => $db['default']['username'],
            'password'      => $db['default']['password'],
            'host'          => $db['default']['hostname'],
            'dbname'        => $db['default']['database'],
            'charset'       => $db['default']['char_set'],
            'driverOptions' => array(
                'charset' => $db['default']['char_set'],
            ),
        );

        // Create EntityManager
        $this->em = \Doctrine\ORM\EntityManager::create($connectionOptions, $config);

        // Force UTF-8
        $this->em->getEventManager()->addEventSubscriber(
            new \Doctrine\DBAL\Event\Listeners\MysqlSessionInit('utf8', 'utf8_unicode_ci')
        );

        // Schema Tool
        $this->tool = new \Doctrine\ORM\Tools\SchemaTool($this->em);
    }
} 