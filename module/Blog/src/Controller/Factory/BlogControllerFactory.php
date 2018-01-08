<?php
/**
 * Created by PhpStorm.
 * User: armandojrn
 * Date: 29/12/2017
 * Time: 14:25
 */

namespace Blog\Controller\Factory;


use Blog\Controller\BlogController;
use Blog\Model\PostTable;
use Psr\Container\ContainerInterface;

class BlogControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new BlogController(
            $container->get(PostTable::class)
        );
    }
}