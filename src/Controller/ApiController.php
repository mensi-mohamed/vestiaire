<?php


namespace App\Controller;

use App\Entity\Article;
use App\Entity\Item;
use App\Entity\Payout;
use App\Serializer\Normalizer\ArticleNormalizer;
use App\Service\PaymentHandler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ApiController extends AbstractController
{
    /**
     * @Route("/api/v1/payout", name="api_v1_payout_action", methods={"POST"})
     */
    public function AddPaymentAction(Request $request, PaymentHandler $paymentHandler)
    {
        try {
            $paymentHandler->handlePayouts($request->get('items'));

        } catch (\Exception $e) {
            return new JsonResponse(sprintf('An error has occurred : %s', $e->getMessage()), 500);
        }
        return new JsonResponse();
    }
}
