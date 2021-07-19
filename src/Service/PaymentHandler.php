<?php


namespace App\Service;


use App\Entity\Item;
use App\Entity\Payout;
use App\Repository\CurrencyRepository;
use App\Repository\SellerRepository;
use Doctrine\ORM\EntityManagerInterface;

class PaymentHandler
{
    const PAYOUT_LIMIT =1000000;

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
     * PaymentHandler constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em, SellerRepository $sellerRepository,
                                CurrencyRepository $currencyRepository)
    {
        $this->em = $em;
        $this->sellerRepository = $sellerRepository;
        $this->currencyRepository = $currencyRepository;
    }


    /**
     * @param Item[] $items
     *
     * @return bool
     */
    public function handlePayouts(array $items): bool
    {
        $paymentData = [];

        foreach ($items as $item) {
            $paymentData[$item->getSeller()->getId()][$item->getCurrency()->getId()] += $item->getPrice();
        }

        return $this->doPayments($paymentData);
    }


    private function doPayments (array $paymentData): bool
    {
        $payouts = [];
        foreach ($paymentData as $sellerId => $sellerData) {
            $seller = $this->sellerRepository->find($sellerId);

            foreach ($sellerData as $currencyId => $amount){
                $currency = $this->currencyRepository->find($currencyId);

                if ($amount < self::PAYOUT_LIMIT) {
                    $this->em->persist(Payout::create($seller, $currency, $amount));
                } else {
                    $i = $nbPayout = intval($amount/self::PAYOUT_LIMIT)+1;

                    while ($i>0) {
                        $this->em->persist(Payout::create($seller, $currency, $amount/$nbPayout));
                    }
                }
            }

        }

        $this->em->flush();

        return true;
    }
}