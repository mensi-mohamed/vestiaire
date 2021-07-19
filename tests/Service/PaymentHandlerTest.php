<?php


namespace App\Tests\Service;

use App\Repository\CurrencyRepository;
use App\Repository\SellerRepository;
use App\Service\PaymentHandler;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @coversDefaultClass \App\Service\PaymentHandler
 * @covers ::__construct
 *
 * @group service
 */
class PaymentHandlerTest extends TestCase
{
    use ProphecyTrait;
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var SellerRepository
     */
    private $sellerRepository;
    
    /**
     * @var CurrencyRepository
     */
    private $currencyRepository;

    /**
     * @var PaymentHandler
     */
    private $service;

    /**
     * Configure the test.
     */
    protected function setUp(): void
    {
        $this->em = $this->prophesize(EntityManagerInterface::class);
        $this->sellerRepository = $this->prophesize(SellerRepository::class);
        $this->currencyRepository = $this->prophesize(CurrencyRepository::class);

        $this->service = new PaymentHandler($this->em->reveal(), $this->sellerRepository->reveal(),
        $this->currencyRepository->reveal());
    }

    /**
     * @test
     *
     * @covers ::handlePayouts
     * @covers ::doPayments
     */
    public function handlePayoutsWithEmptyItemList()
    {
        //Given
        $items = [];

        //When
        $result = $this->service->handlePayouts($items);

        //Then
        $this->assertTrue($result);

    }

}