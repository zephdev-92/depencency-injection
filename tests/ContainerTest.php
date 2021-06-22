<?php

namespace App\DependencyInjection\Tests;

use PHPUnit\Framework\TestCase;
use App\DependencyInjection\Container;
use App\DependencyInjection\NotFoundException;
use App\DependencyInjection\Tests\Fixtures\Router;
use App\DependencyInjection\Tests\Fixtures\DataBase;
use App\DependencyInjection\Tests\Fixtures\Foo;
use App\DependencyInjection\Tests\Fixtures\RouterInterface;
use Psr\Container\NotFoundExceptionInterface;

class ContainerTest extends TestCase
{
   public function test()
   {
      $container = new Container();

      $container->addAlias(RouterInterface::class, Router::class);

      $container->getDefinition(Foo::class)->setShared(false);

      $container
         ->addParameter("dbUrl", "url")
         ->addParameter("dbName", "name")
         ->addParameter("dbUser", "user")
         ->addParameter("dbPassword", "password");

      $database1 = $container->get(DataBase::class);
      $database2 = $container->get(DataBase::class);
      $this->assertInstanceOf(DataBase::class, $database1);
      $this->assertInstanceOf(DataBase::class, $database2);
      $this->assertEquals(spl_object_id($database1), spl_object_id($database2));

      $this->assertInstanceOf(Router::class, $container->get(RouterInterface::class));


      $foo1 = $container->get(Foo::class);
      $foo2 = $container->get(Foo::class);
      $this->assertNotEquals(spl_object_id($foo1), spl_object_id($foo2));
   }


   public function testIfParameterNotFound()
   {
      $container = new Container();
      $this->expectException(NotFoundExceptionInterface::class);
      $container->getParameter("fait");
   }

   public function testIfClassNotFound()
   {
      $container = new Container();
      $this->expectException(NotFoundExceptionInterface::class);
      $container->get(Bar::class);
   }
}
