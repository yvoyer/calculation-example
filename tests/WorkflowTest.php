<?php

namespace MyNamespace;

use MyNamespace\MyDomain\Command\CalculationCommand;
use MyNamespace\MyDomain\Entity\DormerCalculation;
use MyNamespace\MyDomain\Entity\DormerCalculationPrice;
use MyNamespace\MyDomain\Handler\CalculationHandler;
use MyNamespace\MyDomainBundle\Controller\CalculationController;

final class WorkflowTest extends \PHPUnit_Framework_TestCase
{
    public function test_it_should_do_something()
    {
        $em = new \EntityManager();
        $controller = new CalculationController(new CalculationHandler($em));
        $controller->indexAction(CalculationCommand::BASIC_TYPE);

        $this->assertNotNull(DormerCalculation::$hash);

        /**
         * @var DormerCalculation $createdEntity
         */
        $createdEntity = $em->find(DormerCalculation::$hash);

        $this->assertInstanceOf(DormerCalculation::class, $createdEntity);
        $this->assertCount(1, $createdEntity->getPrices());
        $this->assertContainsOnlyInstancesOf(DormerCalculationPrice::class, $createdEntity->getPrices());
        $this->assertSame(12000, $createdEntity->getTotal());
    }
}
