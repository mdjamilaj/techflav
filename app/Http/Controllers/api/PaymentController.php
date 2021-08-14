<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct(\TwoCheckout\TwoCheckout $tco)
    {
        $this->tco = $tco;
    }


    public function charge(Request $request)
    {
        try {

           
            $ddd  = $this->tco->sale()->new(  "1544894",  "a80951fc-d40c-4f98-9fee-22a6496f288f",  "222");
            $ddd->addBillingAddress(
                'Testing Tester', 'asdasdf@gmai.com', '54968498494', '123 Test St',  'Columbus',  'USA'
            );
            $charge = $ddd->charge();
            
            
            // $this->tco->sale()->create(array(
            //     "token" => "a80951fc-d40c-4f98-9fee-22a6496f288f",
            //     "currency" => 'USD',
            //     "merchantOrderId" => 1544894,
            //     "total" => "222",
            //     "demo" => true,
            //     "billingAddr" => array(
            //         "name" => 'Testing Tester',
            //         "addrLine1" => '123 Test St',
            //         "city" => 'Columbus',
            //         "state" => 'OH',
            //         "zipCode" => '43123',
            //         "country" => 'USA',
            //         "email" => 'testingtester@2co.com',
            //         "phoneNumber" => '555-555-5555'
            //     ),
            // ));
            $this->assertEquals('APPROVED', $charge['response']['responseCode']);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), [], 500);
        }
    }
}
