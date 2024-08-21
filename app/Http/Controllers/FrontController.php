<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\TransactionRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
use App\Models\Transaction;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use PDO;

class FrontController extends Controller
{
    //
    public function index()
    {
        $categories = Category::all();
        $latest_products = Product::latest()->take(4)->get();
        $random_products = Product::inRandomOrder()->take(6)->get();

        return view('front.index', compact('categories', 'latest_products', 'random_products'));
    }

    public function category(Category $category)
    {
        session()->put('category_id', $category->id);

        return view('front.brand', compact('category'));
    }

    public function brand(Brand $brand)
    {
        $category_id = session()->get('category_id');
        $products = Product::where('brand_id', $brand->id)
            ->where('category_id', $category_id)
            ->latest()
            ->get();

        return view('front.gadget', compact('brand', 'products'));
    }

    public function details(Product $product)
    {
        return view('front.details', compact('product'));
    }

    public function booking(Product $product)
    {
        $stores = Store::all();
        return view('front.booking', compact('product', 'stores'));
    }

    public function booking_save(StoreBookingRequest $request, Product $product)
    {
        session()->put('product_id', $product->id);

        $BookingData = $request->only(['duration', 'started_at', 'store_id', 'delivery_type', 'address']);

        session($BookingData);

        return redirect()->route('front.checkout', $product->slug);
    }

    public function checkout(Product $product)
    {
        $duration = session('duration');

        $insurance = 900000;
        $ppn = 0.11;
        $price = $product->price;

        $subTotal = $price * $duration;
        $totalPpn = $subTotal * $ppn;
        $grandTotal = $subTotal + $totalPpn + $insurance;


        return view('front.checkout', compact('insurance', 'product', 'subTotal', 'totalPpn', 'grandTotal'));
    }

    public function checkout_store(StorePaymentRequest $request)
    {
        $bookingData = session()->only(['duration', 'started_at', 'store_id', 'delivery_type', 'address', 'product_id']);

        $duration = (int) $bookingData['duration'];
        $startedDate = Carbon::parse($bookingData['started_at']);

        $productDetails = Product::find($bookingData['product_id']);
        if (!$productDetails) {
            return redirect()->back()->withErrors(['product_id' => 'Product not found.']);

        }

        $insurance = 900000;
        $ppn = 0.11;
        $price = $productDetails->price;

        $subTotal = $price * $duration;
        $totalPpn = $subTotal * $ppn;
        $grandTotal = $subTotal + $totalPpn + $insurance;

        $bookingTransactionId = null;

        //closure based database transaction
        DB::transaction(function() use ($request, &$bookingTransactionId, $duration, $bookingData, $grandTotal, $productDetails, $startedDate){

            $validated = $request->validated();

           if ($request->hasFile('proof')) {
            # code...
                $proofPath = $request->file('proof')->store('proofs', 'public');
                $validated['proof'] = $proofPath;
           }

           $endedDate = $startedDate->copy()->addDays($duration);

           $validated['started_at'] = $startedDate;
           $validated['ended_at'] = $endedDate;
           $validated['duration'] = $duration;
           $validated['total_amount'] = $grandTotal;
           $validated['store_id'] = $bookingData['store_id'];
           $validated['product_id'] = $productDetails->id;
           $validated['delivery_type'] = $bookingData['delivery_type'];
           $validated['address'] = $bookingData['address'];
           $validated['is_paid'] = false;
           $validated['trx_id'] = Transaction::generateUniqueTrxId();

           $newBooking = Transaction::create($validated);

           $bookingTransactionId = $newBooking->id;
        });

        return redirect()->route('front.success.booking', $bookingTransactionId);
    }

    public function success_booking(Transaction $transaction)
    {
        return view('front.success_booking', compact('transaction'));
    }

    public function transactions(){
        return view('front.transactions');
    }

    public function transactions_details (TransactionRequest $request){

        $trx_id = $request->input('trx_id');
        $phone_number = $request->input('phone_number');

        $details = Transaction::with(['store', 'product'])
        ->where('trx_id', $trx_id)
        ->where('phone_number', $phone_number)
        ->first();

        if(!$details){
            return redirect()->back()->withErrors(['error' => 'Transaction not found,']);
        }

        $ppn = 0.11;
        $insurance = 900000;
        $duration = $details->duration;
        $totalPpn = $details->product->price * $duration * $ppn;
        $subTotal = $details->product->price * $duration;

        return view('front.transaction_details', compact('details', 'totalPpn', 'subTotal', 'insurance'));

    }
}
