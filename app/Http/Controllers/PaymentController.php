<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PayTechService;

class PaymentController extends Controller
{
    //
    public function __construct(PayTechService $payTechService)
    {
        $this->payTechService = $payTechService;
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
