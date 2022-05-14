<?php

namespace App\Http\Controllers;
use PDF;
use FedaPay\FedaPay;
use App\Models\Don;
use FedaPay\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;


class FedapayController extends Controller
{
    //
    public function __construct()
    {
        $this->transaction = new Transaction();
        FedaPay::setApiKey(config('fedapay.secret_key'));
        FedaPay::setEnvironment(config('fedapay.environment'));
    }

    public function process(Request $request)
    {
        try {
            // $request->validate([
            //     'title' => 'required|unique:posts|max:200',
            //     'body' => 'required'
            // ]);
        
            $payment = Don::create([ 
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'email' => $request->email,
                'tel' => $request->tel,
                'amount' => $request->amount,
                'payment_method' => $request->payment_method,
                'message' => $request->message,
                'campaigns' => $request->campaigns,
                'transaction_number' =>date('ymdis').'-'.substr($request->firstname,0 , 3).'-'.substr($request->firstname,0 , 3),
            ]);
            $transaction = Transaction::create(
                $this->fedapayTransactionData( $request)
            );
            
            $payment->update(['feda_id' => $transaction->id]);
            $token = $transaction->generateToken();

            return redirect()->away($token->url)->send();
        } catch(\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    private function fedapayTransactionData(Request $request)
    {
        $customer_data = [
            'firstname' => $request->nom,
            'lastname' => $request->prenom,
            'email' => $request->email,
            'phone_number' => [
                'number'  => $request->tel,
                'country' => 'bj'
            ]
        ];

        return [
            'description' => 'Don AutoAuto ...!',
            'amount' => $request->amount,
            'currency' => ['iso' => 'XOF'],
            'callback_url' => url('callback'),
            'customer' => $customer_data
        ];
    }

    
    public function callback(Request $request)
    {
        $transaction_id = $request->input('id');
        $message = '';

        try {
            $transaction = Transaction::retrieve($transaction_id);
            switch($transaction->status) {
                case 'approved':
                    $message = 'Transaction approuvée.';
                    $entite =[ 
                        'name'=>'AutoAuto',
                        'email'=>'autoauto@gmail.com',
                        'tel'=>'987-987-930-302',
                        'adresse'=>'14/A, Poor Street City Tower, New York USA',
                    ];
        
                    $utilisateur =[ 
                        'transaction_number'=>'AutoAuto',
                        'campaigns'=>'mondon',
                        'firstname'=>'autoauto@gmail.com',
                        'lastname'=>'AutoAuto',
                        'email'=>'autoauto@gmail.com',
                        'amount'=>'autoauto@gmail.com',
                        'tel'=>'AutoAuto',
                        'payment_method'=>'autoauto@gmail.com',
                        'message'=>'autoauto@gmail.com'
                    ];
                
                    $data = [
                            'title' => 'Don AutoAuto ',
                            'date' => date('d/m/Y'),
                            'email'=> 'nnicolepatry@gmail.com',
                            'body'=>'nous vous envoyons votre facture',
                            'utilisateur' => $utilisateur,
                            'entite' => $entite
                    ];
                    $pdf = PDF::loadView('invoices',$data);
                    Mail::send('mail', $data, function ($message) use ($data, $pdf) {
                        $message->to($data["email"], $data["email"])
                            ->subject($data["title"])
                            ->attachData($pdf->output(), "invoiceJDD.pdf");
                    });
                    
                    Session::flash('flash_message', ' Merci pour votre don.');
                    Session::flash('flash_type', 'alert-success');
                break;
                case 'canceled':
                    $message = 'Transaction annulée.';
                break;
                case 'declined':
                    $message = 'Transaction déclinée.';
                break;
            }

        } catch(\Exception $e) {
            $message = $e->getMessage();
        }

        return view('callback', compact('message'));
    }


}
