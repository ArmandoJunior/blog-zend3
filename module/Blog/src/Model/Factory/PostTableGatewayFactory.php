<?php
/**
 * Created by PhpStorm.
 * User: armandojrn
 * Date: 29/12/2017
 * Time: 14:25
 */

namespace Blog\Model\Factory;


use Blog\Model\Post;
use Psr\Container\ContainerInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class PostTableGatewayFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $dbAdapter = $container->get(AdapterInterface::class);
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Post());
        return new TableGateway('post', $dbAdapter, null, $resultSetPrototype);
    }
}