<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderStore;
use App\Http\Requests\OrderStoreRequest;
use App\Http\Requests\OrderUpdateRequest;
use App\Jobs\ProcessOrderJob;
use App\Mail\OrderCreatedMail;
use App\Models\Event;
use App\Models\Order;
use App\Models\Torta;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class OrderController extends Controller
{

    public function clientIndex($name)
    {
        $event = Event::where("name", $name)->firstOrFail();
        $tortas = Torta::all();
        $order_code = session('order_code');
        return Inertia::render('Order/OrderPage', compact('event', "tortas", "order_code"));
    }

    public function clientRedirect()
    {
        $event = Event::first();
        return redirect()->route("client.order.index", $event->name);
    }

    public function clientStore(OrderStore $request)
    {
        $validatedData = $request->validated();
        DB::transaction(function () use ($validatedData) {
            $user_id = Auth::id();
            $order = Order::create([
                "user_id" => $user_id,
                "event_id" => $validatedData["event_id"],
                "shipping_address" => $validatedData["shipping_address"],
                "event_date" => $validatedData["event_date"],
                "details" => $validatedData["details"],
                "total" => $validatedData["total"],
            ]);

            $tortas = [];
            foreach ($validatedData["tortas"] as $torta) {
                $pivot = $torta["pivot"];
                $tortas[$torta['id']] = ['quantity' => $pivot['quantity']];
            }

            $order->tortas()->attach($tortas);
            ProcessOrderJob::dispatch($order);
            return back()->with('order_code', $order->order_code);
        });
    }

    public function clientRastreoIndex()
    {
        $orders = Order::where("user_id", Auth::id())->get();
        return Inertia::render('Order/RastreoPage', compact('orders'));
    }

    public function index()
    {
        $orders = Order::all();
        $customers = User::where("rol_user_id", 2)->get();
        $tortas = Torta::all();
        $events = Event::all();
        return Inertia::render("Admin/Orders", compact("orders", "customers", "tortas", "events"));
    }

    public function store(OrderStoreRequest $request)
    {
        $validatedData = $request->validated();
        DB::transaction(function () use ($validatedData) {
            $order = Order::create([
                "user_id" => $validatedData["user_id"],
                "event_id" => $validatedData["event_id"],
                "shipping_address" => $validatedData["shipping_address"],
                "event_date" => $validatedData["event_date"],
                "status" => $validatedData["status"],
                "details" => $validatedData["details"],
                "total" => $validatedData["total"],
            ]);

            $tortas = [];
            foreach ($validatedData["tortas"] as $torta) {
                $pivot = $torta["pivot"];
                $tortas[$torta['id']] = ['quantity' => $pivot['quantity']];
            }

            $order->tortas()->attach($tortas);
            ProcessOrderJob::dispatch($order);
        });
    }

    public function update(OrderUpdateRequest $request, $id)
    {
        $validatedData = $request->validated();
        $order = Order::findOrFail($id);
        DB::transaction(function () use ($order, $validatedData) {

            if (!$order->confirmed_at) {
                $order->update(["confirmed_at" => now(), "delivery_date" => $validatedData["delivery_date"], "status" => "confirmado"]);
            } else {
                $order->update([
                    "user_id" => $validatedData["user_id"],
                    "event_id" => $validatedData["event_id"],
                    "shipping_address" => $validatedData["shipping_address"],
                    "delivery_date" => $validatedData["delivery_date"],
                    "event_date" => $validatedData["event_date"],
                    "status" => $validatedData["status"],
                    "details" => $validatedData["details"],
                    "total" => $validatedData["total"],
                ]);

                $tortas = [];
                foreach ($validatedData["tortas"] as $torta) {
                    $pivot = $torta["pivot"];
                    $tortas[$torta['id']] = ['quantity' => $pivot['quantity']];
                }

                $order->tortas()->sync($tortas);
            }
        });
    }


    public function destroy(Request $request, $id)
    {
        DB::transaction(function () use ($request, $id) {
            $order = Order::findOrFail($id);
            $order->update(['status' => 'cancelado']);
        });
    }

}
