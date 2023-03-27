<?php

namespace Hanoivip\PaymentMethodPagar;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Request;
use PagarMe\Client as PagarMeClient;

class PagarController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    private function getSetting()
    {
        if (App::environment() == 'production')
        {
            return config('payment.methods.pagar');
        }
        else 
        {
            return config('payment.methods.pagar_sandbox');
        }
    }
    
    public function callback(Request $request)
    {
        $config = $this->getSetting();
        $client = new PagarMeClient($config['private_key']);
        $postbackPayload = $request->getContent();
        $signature = $request->header('HTTP_X_HUB_SIGNATURE');
        $postbackIsValid = $client->postbacks()->validate($postbackPayload, $signature);
        return $postbackIsValid;
    }
}