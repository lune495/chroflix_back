<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PayTechService;

class PaymentController extends Controller
{
    public $apiSecret  = '5f7c2f342fb550d8ddfd8aa6a88cd1157466e20c68163c2864fab2cb12e9f4fb';
    public $apiKey = 'f6f991952e622ca2145b3bc33539c1f99b55ac4874d6137f05938abda48d6e2c';
    public function __construct(PayTechService $payTechService)
    {

        $this->payTechService = $payTechService($apiSecret,$apiKey);
    }

    public function processPayment(Request $request)
    {
        // Valider les données de paiement
        $validatedData = $request->validate([
            'amount' => 'required|numeric',
            // Ajoutez d'autres règles de validation selon vos besoins
        ]);
        // Appeler le service PayTech pour effectuer la demande de paiement
        $paymentResponse = $this->payTechService->createPayment($validatedData);

        // Vérifier si la demande de paiement a réussi
        if ($paymentResponse['success']) {
            // Rediriger l'utilisateur vers la page de paiement
            return response()->json([
                'redirect_url' => $paymentResponse['redirect_url'],
            ]);
        } else {
            // Gérer les erreurs de demande de paiement
            return response()->json([
                'error' => 'Erreur lors de la demande de paiement',
            ], 500);
        }
    }
}
