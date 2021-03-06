<?php

namespace App\Http\Controllers;

use DB;
use App\User;
use App\Order;
use App\OrderLine;
use App\Activation;
use App\Subscription;
use App\ProductRequest;
use App\SubscriptionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //DONUT - CLIENTS ESTATUS
        $usersStatus = (new LarapexChart)->setType('donut')
                ->setDataset([
                    User::where('status', '=', 'active')->where('type', '=', 'client')->count(), 
                    User::where('status', '=', 'inactive')->where('type', '=', 'client')->count()])
                ->setColors(['#7367F0', '#EA5455'])
                ->setLabels(['Actives', 'Inactives']);

        //TOTAL CLIENTS ACTIVES
        $usersActives = User::where('status', '=', 'active')->where('type', '=', 'client')->count();
        //TOTAL CLIENTS INACTIVES
        $usersInactives = User::where('status', '=', 'inactive')->where('type', '=', 'client')->count();
        //TOTAL CLIENTS
        $clientsTotal = User::where('type', '=', 'client')->count();

        //LINE - TOTALS CLIENTS PER MONTH
        $usersPerMonth = (new LarapexChart)->setType('line')
            ->setXAxis([
                'Jan', 'Feb', 'Mar', 'Apr', 'Marc', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
            ])
            ->setDataset([
                [
                    'name'  =>  'Registered Users',
                    'data'  =>  [
                        User::whereMonth('created_at', '01')->where('type', '=', 'client')->count(), 
                        User::whereMonth('created_at', '02')->where('type', '=', 'client')->count(), 
                        User::whereMonth('created_at', '03')->where('type', '=', 'client')->count(),  
                        User::whereMonth('created_at', '04')->where('type', '=', 'client')->count(), 
                        User::whereMonth('created_at', '05')->where('type', '=', 'client')->count(), 
                        User::whereMonth('created_at', '06')->where('type', '=', 'client')->count(), 
                        User::whereMonth('created_at', '07')->where('type', '=', 'client')->count(),  
                        User::whereMonth('created_at', '08')->where('type', '=', 'client')->count(),
                        User::whereMonth('created_at', '09')->where('type', '=', 'client')->count(), 
                        User::whereMonth('created_at', '10')->where('type', '=', 'client')->count(), 
                        User::whereMonth('created_at', '11')->where('type', '=', 'client')->count(), 
                        User::whereMonth('created_at', '12')->where('type', '=', 'client')->count()
                    ]
                ]
            ]);

        //$subscriptionsCompletes = DB::table("subscriptions")->join("plans", "plans.slug", "=", "subscriptions.stripe_plan")
        //    ->select("subscriptions.stripe_status", "plans.amount")
        //    ->where('subscriptions.stripe_status', '=', 'complete')
        //    ->get();

        //TOTAL AMOUNT SUBSCRIPTIONS
        $totalAmountSubscriptions = DB::table("subscriptions")->join("plans", "plans.slug", "=", "subscriptions.stripe_plan")
                                    ->select("subscriptions.stripe_status", "plans.amount")
                                    ->where('subscriptions.stripe_status', '=', 'complete')
                                    ->sum('plans.amount');

        //$totalAmountSuscriptions = 0;
        //foreach($subscriptionsCompletes as $subscription){
        //    $totalAmountSuscriptions = $subscription->amount + $totalAmountSuscriptions;
        //}

        //LINE - TOTAL AMOUNT SUBSCRIPTIONS PER MONTH
        $amountPerMonthSubscriptions = (new LarapexChart)->setType('line')
            ->setXAxis([
                'Jan', 'Feb', 'Mar', 'Apr', 'Marc', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
            ])
            ->setColors(['#7367F0'])
            ->setDataset([
                [
                    'name'  =>  'Amount $',
                    'data'  =>  [
                        DB::table("subscriptions")->join("plans", "plans.slug", "=", "subscriptions.stripe_plan")
                            ->select("subscriptions.stripe_status", "plans.amount")
                            ->where('subscriptions.stripe_status', '=', 'complete')
                            ->whereMonth('subscriptions.created_at', '01')
                            ->sum('plans.amount'),
                        DB::table("subscriptions")->join("plans", "plans.slug", "=", "subscriptions.stripe_plan")
                            ->select("subscriptions.stripe_status", "plans.amount")
                            ->where('subscriptions.stripe_status', '=', 'complete')
                            ->whereMonth('subscriptions.created_at', '02')
                            ->sum('plans.amount'),
                        DB::table("subscriptions")->join("plans", "plans.slug", "=", "subscriptions.stripe_plan")
                            ->select("subscriptions.stripe_status", "plans.amount")
                            ->where('subscriptions.stripe_status', '=', 'complete')
                            ->whereMonth('subscriptions.created_at', '03')
                            ->sum('plans.amount'),
                        DB::table("subscriptions")->join("plans", "plans.slug", "=", "subscriptions.stripe_plan")
                            ->select("subscriptions.stripe_status", "plans.amount")
                            ->where('subscriptions.stripe_status', '=', 'complete')
                            ->whereMonth('subscriptions.created_at', '04')
                            ->sum('plans.amount'),
                        DB::table("subscriptions")->join("plans", "plans.slug", "=", "subscriptions.stripe_plan")
                            ->select("subscriptions.stripe_status", "plans.amount")
                            ->where('subscriptions.stripe_status', '=', 'complete')
                            ->whereMonth('subscriptions.created_at', '05')
                            ->sum('plans.amount'),
                        DB::table("subscriptions")->join("plans", "plans.slug", "=", "subscriptions.stripe_plan")
                            ->select("subscriptions.stripe_status", "plans.amount")
                            ->where('subscriptions.stripe_status', '=', 'complete')
                            ->whereMonth('subscriptions.created_at', '06')
                            ->sum('plans.amount'),
                        DB::table("subscriptions")->join("plans", "plans.slug", "=", "subscriptions.stripe_plan")
                            ->select("subscriptions.stripe_status", "plans.amount")
                            ->where('subscriptions.stripe_status', '=', 'complete')
                            ->whereMonth('subscriptions.created_at', '07')
                            ->sum('plans.amount'),
                        DB::table("subscriptions")->join("plans", "plans.slug", "=", "subscriptions.stripe_plan")
                            ->select("subscriptions.stripe_status", "plans.amount")
                            ->where('subscriptions.stripe_status', '=', 'complete')
                            ->whereMonth('subscriptions.created_at', '08')
                            ->sum('plans.amount'),
                        DB::table("subscriptions")->join("plans", "plans.slug", "=", "subscriptions.stripe_plan")
                            ->select("subscriptions.stripe_status", "plans.amount")
                            ->where('subscriptions.stripe_status', '=', 'complete')
                            ->whereMonth('subscriptions.created_at', '09')
                            ->sum('plans.amount'),
                        DB::table("subscriptions")->join("plans", "plans.slug", "=", "subscriptions.stripe_plan")
                            ->select("subscriptions.stripe_status", "plans.amount")
                            ->where('subscriptions.stripe_status', '=', 'complete')
                            ->whereMonth('subscriptions.created_at', '10')
                            ->sum('plans.amount'),
                        DB::table("subscriptions")->join("plans", "plans.slug", "=", "subscriptions.stripe_plan")
                            ->select("subscriptions.stripe_status", "plans.amount")
                            ->where('subscriptions.stripe_status', '=', 'complete')
                            ->whereMonth('subscriptions.created_at', '11')
                            ->sum('plans.amount'),
                        DB::table("subscriptions")->join("plans", "plans.slug", "=", "subscriptions.stripe_plan")
                            ->select("subscriptions.stripe_status", "plans.amount")
                            ->where('subscriptions.stripe_status', '=', 'complete')
                            ->whereMonth('subscriptions.created_at', '12')
                            ->sum('plans.amount')
                    ]
                ]
            ]);

        //TOTAL AMOUNT PRODUCTS
        $totalAmountProducts = Order::sum('total_amount');

        //TOTAL ORDERS
        $totalOrders = Order::count();

        $amountPerMonthProducts = (new LarapexChart)->setType('line')
        ->setXAxis([
            'Jan', 'Feb', 'Mar', 'Apr', 'Marc', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
        ])
        ->setColors(['#ffc63b'])
        ->setDataset([
            [
                'name'  =>  'Amount $',
                'data'  =>  [
                    Order::whereMonth('created_at', '01')->sum('total_amount'),
                    Order::whereMonth('created_at', '02')->sum('total_amount'),
                    Order::whereMonth('created_at', '03')->sum('total_amount'),
                    Order::whereMonth('created_at', '04')->sum('total_amount'),
                    Order::whereMonth('created_at', '05')->sum('total_amount'),
                    Order::whereMonth('created_at', '06')->sum('total_amount'),
                    Order::whereMonth('created_at', '07')->sum('total_amount'),
                    Order::whereMonth('created_at', '08')->sum('total_amount'),
                    Order::whereMonth('created_at', '09')->sum('total_amount'),
                    Order::whereMonth('created_at', '10')->sum('total_amount'),
                    Order::whereMonth('created_at', '11')->sum('total_amount'),
                    Order::whereMonth('created_at', '12')->sum('total_amount'),
                ]
            ]
        ]);

        //TOTAL Activation Services Request ACTIVE
        $activationsRequestActive = Activation::where('status', '=', 'active')->count();
        //TOTAL Activation Services Request INACTIVE
        $activationsRequestInactive = Activation::where('status', '=', 'inactive')->count();
        //TOTAL Activation Services Request PROCESS
        $activationsRequestProcess = Activation::where('status', '=', 'process')->count();
        //TOTAL Activation Services Request WAIT
        $activationsRequestWait = Activation::where('status', '=', 'wait')->count();

        //TOTAL Payment Services Request ACTIVE
        $productsRequestActive = OrderLine::where('status', '=', 'active')->count();
        //TOTAL Payment Services Request INACTIVE
        $productsRequestInactive = OrderLine::where('status', '=', 'inactive')->count();
        //TOTAL Payment Services Request PROCESS
        $productsRequestProcess = OrderLine::where('status', '=', 'process')->count();
        //TOTAL Payment Services Request WAIT
        $productsRequestWait = OrderLine::where('status', '=', 'wait')->count();

        //TOTAL SUBSCRIPTIONS REQUEST ACTIVE
        $subscriptionsRequestActive = Subscription::where('status', '=', 'active')->where('stripe_status', '=', 'complete')->count();
        //TOTAL SUBSCRIPTIONS REQUEST ACTIVE
        $subscriptionsRequestInactive = Subscription::where('status', '=', 'inactive')->where('stripe_status', '=', 'complete')->count();
        //TOTAL SUBSCRIPTIONS REQUEST PROCESS
        $subscriptionsRequestProcess = Subscription::where('status', '=', 'process')->where('stripe_status', '=', 'complete')->count();
        //TOTAL SUBSCRIPTIONS REQUEST WAIT
        $subscriptionsRequestWait = Subscription::where('status', '=', 'wait')->where('stripe_status', '=', 'complete')->count();


        $nuevo = (new LarapexChart)->setTitle('Net Profit')
        ->setSubtitle('From January To March')
        ->setType('bar')
        ->setXAxis(['Jan', 'Feb', 'Mar'])
        ->setGrid(true)
        ->setDataset([
            [
                'name'  => 'Company A',
                'data'  =>  [500, 1000, 1900]
            ],
            [
                'name'  => 'Company B',
                'data'  => [300, 900, 1400]
            ],
            [
                'name'  => 'Company C',
                'data'  => [430, 245, 500]
            ]
        ])
        ->setStroke(1);

        $userProductsRequest = ProductRequest::where('user_id', '=', auth()->id())->get();

        $userActivationsRequest = Activation::where('user_id', '=', auth()->id())->get();

        $userSubscriptionsRequest = SubscriptionRequest::where('user_id', '=', auth()->id())->get();

        $requestPerMonthProducts = (new LarapexChart)->setType('line')
        ->setXAxis([
            'Jan', 'Feb', 'Mar', 'Apr', 'Marc', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
        ])
        ->setColors(['#ffc63b'])
        ->setDataset([
            [
                'name'  =>  'Request',
                'data'  =>  [
                    ProductRequest::whereMonth('created_at', '01')->count(), 
                    ProductRequest::whereMonth('created_at', '02')->count(), 
                    ProductRequest::whereMonth('created_at', '03')->count(), 
                    ProductRequest::whereMonth('created_at', '04')->count(), 
                    ProductRequest::whereMonth('created_at', '05')->count(), 
                    ProductRequest::whereMonth('created_at', '06')->count(), 
                    ProductRequest::whereMonth('created_at', '07')->count(), 
                    ProductRequest::whereMonth('created_at', '08')->count(), 
                    ProductRequest::whereMonth('created_at', '09')->count(), 
                    ProductRequest::whereMonth('created_at', '10')->count(), 
                    ProductRequest::whereMonth('created_at', '11')->count(), 
                    ProductRequest::whereMonth('created_at', '12')->count(), 
                ]
            ]
        ]);

        //dd($requestPerMonthProducts);

        return view('home', compact('usersStatus', 'usersActives', 'usersInactives', 'clientsTotal', 
                                                'usersPerMonth', 'totalAmountSubscriptions', 'amountPerMonthSubscriptions',
                                                'totalAmountProducts', 'totalOrders', 'amountPerMonthProducts', 'activationsRequestActive', 'productsRequestActive',
                                                'activationsRequestInactive', 'productsRequestInactive', 'activationsRequestProcess','productsRequestProcess', 
                                                'activationsRequestWait', 'productsRequestWait', 'subscriptionsRequestActive', 'subscriptionsRequestInactive',
                                                'subscriptionsRequestProcess', 'subscriptionsRequestWait', 'nuevo', 'userActivationsRequest', 'userProductsRequest', 
                                                'userSubscriptionsRequest', 'requestPerMonthProducts'));
    }
}
