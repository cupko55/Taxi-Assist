<?php

namespace App\Http\Controllers;

use App\Order;
use App\User;
use App\Company;
use App\Http\Requests\OrderRequest;
use Illuminate\Auth\Access\Response;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth',['except'=>'getPrice']);
    }

    /**
     * Vraca sve narudzbe s imenima korisnika i taxi sluzbi vezanim za tu narudzbu
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        $orders=Order::all();
        for($i=0;$i<count($orders);$i++){
            $orders[$i]['user']=User::find($orders[$i]->user_id)->name;
            $orders[$i]['taxi']=Company::find($orders[$i]->company_id)->name;
        }

        return view('order.index',compact('orders'));
    }
    public function show($id){
        $order=Order::find($id);
        $order['user']=User::find($order->user_id)->name;
        $order['taxi']=Company::find($order->company_id)->name;

        return view('order.show',compact('order'));
    }
    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function create(){
        return redirect('/');
    }

    /**
     * Dohvaca kolacic u koji je sprermljena udaljenost
     * Racuna cijenu
     * Sprema narudzbu
     * @param OrderRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(OrderRequest $request){


        $order=$request->all();
        $order['distance']=$_COOKIE['distance'];;
        $order['price']=$this->getPriceCompany($order['distance'],$order['company_id']);
        Auth::user()->orders()->create($order);
        \Session::flash('flash_message','Uspješno ste naručili taxi');
        return redirect('/');
    }



    /**
     * Racuna cijenu za odredenu udaljenost za sve taxi sluzbe
     * @return json
     */
    public function getPrice(){
        $companies=Company::all();
        $distance=$_COOKIE['distance'];
        for($i=0;$i<count($companies);$i++){
            $companies[$i]['price']=$this->getPriceCompany($distance,$companies[$i]['id']);
        }
        return $companies;
    }
    /**
     * Racuna cijenu za odredenu udaljenost i odredenu taxi sluzbu
     * @param $distance
     * @param $company_id
     * @return price
     */
    public function getPriceCompany($distance, $company_id){
        $company=Company::find($company_id);
        if($distance<$company->freeKm){
            $price=$company->startPrice;
        }
        else{
            $distanceToPay=$distance-$company->freeKm;
            $price=$company->startPrice+$company->kmPrice*$distanceToPay;
        }
        return $price;
    }

    /**
     * Brise narudzbu (sofr delete)
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        Order::destroy($id);
        return redirect('order');
    }
}
