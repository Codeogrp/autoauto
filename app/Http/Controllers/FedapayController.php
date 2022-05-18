<?php

namespace App\Http\Controllers;
use PDF;
use FedaPay\FedaPay;
use App\Models\Payment;
use FedaPay\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;


class FedapayController extends Controller
{
        // public Transaction $transaction;

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
                $transaction = Transaction::create(
                $this->fedapayTransactionData( $request)
            );
            $payment = Payment::create([ 
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'email' => $request->email,
                'tel' => $request->tel,
                'amount' => $request->amount,
                'payment_method' => $request->payment_method,
                'message' => $request->message,
                'campaigns' => $request->campaigns,
                'transaction_number' =>date('ymdis').'_'.substr($request->firstname,0 , 3).'_'.substr($request->lastname,0 , 3),
                'status' => "nouveau",
            ]);
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
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
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

    
    public function callback(Request $request){


        $transaction_id = $request->input('id');
        $message = '';

        try {
            $transaction = Transaction::retrieve($transaction_id);

            $detailtrans = array(
                "reference"=>$transaction->reference,
                "receipt_url"=>$transaction->receipt_url, 
                "status"=>$transaction->status,
                "mode"=>$transaction->mode,
                "operation"=>$transaction->operation, 
                "commission"=>$transaction->commission,
                "created_at"=>$transaction->created_at,
                "updated_at"=>$transaction->updated_at,
                "approved_at"=>$transaction->approved_at
            );
            // $detailtransaction = json_encode($detailtrans);

            // dd($transaction,$transaction->reference,$detailtransaction,);

            $payment = Payment::where('feda_id', $transaction->id)->first();
            if($request->close == 'true'){
                $payment -> update(['status' => 'annuler']);
                $message = 'Transaction annulée.';
            } else {
                    switch($transaction->status) {
                        case 'approved':
                            $detailtransaction = json_encode($detailtrans);
                            $payment -> update([
                                'detailtransaction' => $detailtransaction,
                                'status' => 'payer'
                            ]);
                            $message = 'Transaction approuvée.';
                        break;
                        case 'canceled':
                            $payment -> update(['status' => 'annuler']);
                            $message = 'Transaction annulée.';
                        break;
                        case 'pending':
                            $payment -> update(['status' => 'encour']);
                            $message = 'Transaction encours.';
                        break;
                        case 'declined':
                            $payment -> update(['status' => 'annuler']);
                            $message = 'Transaction déclinée.';
                        break;
                    }
        }

        } catch(\Exception $e) {
            $message = $e->getMessage();
        }

        return view('callback', compact('message', 'transaction_id'));
    }

    public function invoice( $transaction_id ,Request $request){
        $payment = Payment::where('feda_id', $transaction_id)->first();
                    $entite =[ 
                        'name'=>'AutoAuto',
                        'email'=>'autoauto@gmail.com',
                        'tel'=>'987-987-930-302',
                        'adresse'=>'14/A, Poor Street City Tower, New York USA',
                    ];
        
                    $utilisateur =[ 
                        'transaction_number'=>$payment->transaction_number,
                        'campaigns'=>$payment->campaigns,
                        'firstname'=>$payment->firstname,
                        'lastname'=>$payment->lastname,
                        'email'=>$payment->email,
                        'amount'=>$payment->amount,
                        'tel'=>$payment->tel,
                        'payment_method'=>$payment->payment_method,
                        'message'=>$payment->message
                    ];
                
                    $data= [
                            'title' => 'Don AutoAuto ',
                            'date' => date('d/m/Y'),
                            'email'=> 'nnicolepatry@gmail.com',
                            'body'=>'nous vous envoyons votre facture',
                            'utilisateur' => $utilisateur,
                            'entite' => $entite
                    ];
                    if($request->has('download')){
                        $pdf = PDF::loadView('invoices',$data);
                        Mail::send('mail', $data, function ($message) use ($data, $pdf) {
                            $message->to($data["email"], $data["email"])
                                ->subject($data["title"])
                                ->attachData($pdf->output(), "AutoAuto.pdf");
                        });
                        
                        Session::flash('flash_message', ' Merci pour votre don.');
                        Session::flash('flash_type', 'alert-success');
                        return $pdf->download('pdfview.pdf');
                    }
                return view('invoices',compact('utilisateur','data','entite','transaction_id'));
    }

}
