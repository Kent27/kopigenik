<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;
use App\Plan;
use App\Shipment;
use Carbon\Carbon;

class TransactionController extends Controller
{
	public function __construct(){
		$this->middleware('auth')->except(['index', 'ajaxPlan']);
	}

    //show subsribe page
    public function index(){
        //pass plans id for option tag
        $plans = Plan::pluck('id');

        //pass address if logged in
        if(isset(auth()->user()->address)){
            $address = auth()->user()->address;
    	   return view('subscribe',compact(['plans','address']));
        }

        return view('subscribe',compact('plans'));
    }

    //perform ajax everytime option value changes
    public function ajaxPlan(){
        if($plan_price = (Plan::find(request('plan')))->price){
            return $plan_price;
        }

        return '';
    }

    //perform transaction
    public function store(Request $request){

        //validate request
        $request->validate([
            'select1' => 'required',
            'subscribe_duration' => 'required|integer|between:1,3',

            'name' => 'required',
            'address' => 'required',
            'province' => 'required',
            'city' => 'required',
            'district' => 'required',
            'zipcode' => 'required',
            'phone' => 'required'
        ]);
      
        //check option value exists in Plan id's
        $plans_id = Plan::pluck('id');

        if($plans_id->contains(request('select1'))){
             $plan_selected = Plan::find(request('select1'));

            //insert transaction
            $current_transaction = Transaction::create([
                'user_id' => auth()->id(),
                'plan_id' => $plan_selected->id,
                'subscribe_duration' => request('subscribe_duration'),
                'price' => $plan_selected->price + 9000,
                'status' => 'to be confirmed',
                'time_bought' => Carbon::now()
            ]);

            //fill pivot table
            //$current_transaction->plan()->attach(request('select1'));

            //Shipment
            if(request('subscribe_duration') == 1){
                Shipment::create([
                    'transaction_id' => $current_transaction->id,
                    'address' => request('address'),
                    'province' => request('province'),
                    'city' => request('city'),
                    'district' => request('district'),
                    'zipcode' => request('zipcode'),
                    'phone' => request('phone'),
                    'total_shipment_left' => 2,                    
                    'additional_note' => request('additional_note')
                ]);
            }else if(request('subscribe_duration') == 2){
                Shipment::create([
                    'transaction_id' => $current_transaction->id,
                    'address' => request('address'),
                    'province' => request('province'),
                    'city' => request('city'),
                    'district' => request('district'),
                    'zipcode' => request('zipcode'),
                    'phone' => request('phone'),
                    'total_shipment_left' => 4,                    
                    'additional_note' => request('additional_note')
                ]);
            }else if(request('subscribe_duration') == 3){
                Shipment::create([
                    'transaction_id' => $current_transaction->id,
                    'address' => request('address'),
                    'province' => request('province'),
                    'city' => request('city'),
                    'district' => request('district'),
                    'zipcode' => request('zipcode'),
                    'phone' => request('phone'),
                    'total_shipment_left' => 6,                    
                    'additional_note' => request('additional_note')
                ]);
            }

            //redirect to its confirmation
            return redirect('/payment-confirmation/' . $current_transaction->id);
        }


        //option plan value has error
        return back()
            ->withErrors(['message' => 'The plan you are choosing is not available']);
       
    }

    //show user's payment confirmation list
    public function indexConfirm(){

        //list user's transaction and the status
    	$transactions = Transaction::where('user_id',auth()->id())->get();
    	return view('payment-confirmation-index',compact('transactions'));
    }

    //show payment confirmation page
    public function showConfirm(Transaction $transaction){

    	//check if it's incorrect user , if yes, then fail
    	if($transaction->user_id != auth()->id()){
    		return redirect('/')
    			->withErrors(['message' => 'Sorry, you cannot access that page']);
    	}

        //set 1 day confirmation time
        $time_confirmed_max = Carbon::parse($transaction->time_bought)->addDay(2)->format('j M Y, H:i:s');

    	return view('payment-confirmation',compact('transaction','time_confirmed_max'));
    }

    //perform payment confirmation process
    public function storeConfirm(Transaction $transaction){

        //check if it's incorrect user or confirmed transaction, if yes, then fail
        if($transaction->user_id != auth()->id() || $transaction->status != 'to be confirmed'){
            return redirect('/')
                ->withErrors(['message' => 'Sorry, you cannot access that page']);
        }

        //confirm the transaction by user
        $transaction->status = 'to be approved';
        $transaction->time_confirmed = Carbon::now();
        $transaction->save();
        return redirect()->home();
    }

    //Admin Section

    public function indexTransaction(){

        //pass transactions according to their status
        $transactions_tbc = Transaction::where('status','to be confirmed')->get();
        $transactions_tba = Transaction::where('status','to be approved')->get();
        $transactions_approved = Transaction::where('status','approved')->get();

        return view('transaction-index',compact(['transactions_tbc','transactions_tba','transactions_approved']));
    }

    public function showTransaction(Transaction $transaction){
        return view('transaction-show',compact('transaction'));
    }

    public function approveTransaction(Transaction $transaction){
        if($transaction->status == 'to be approved'){
            $transaction->status = 'approved';
            $transaction->time_approved = Carbon::now();           

            $transaction->save();
            return redirect('/transactions');
        }

        return back()->withErrors(['message' => 'Please choose valid transaction']);
    }
}
