<?php

namespace App\Http\Controllers;

use App\Models\DeliveryAddress;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    public function addDelivery(Request $request)
    {
        $data = $request->validate([
            'address' => 'required',
            'apartment' => 'nullable',
            'intercom_code' => 'nullable',
            'entrance' => 'nullable',
            'floor' => 'nullable',
            'comments' => 'nullable',
        ]);

        $data['user_id'] = auth()->id();

        DeliveryAddress::create($data);

        return redirect()->route('cart');
    }

    public function updateActiveAddress(Request $request)
    {
        $user = auth()->user();

        $selectedAddressId = $request->input('address');
        $user->addresses()->update(['status' => 'unselected']);

        $selectedAddress = DeliveryAddress::findOrFail($selectedAddressId);
        $selectedAddress->status = 'selected';
        $selectedAddress->save();

        return redirect()->back();
    }

    public function editDelivery(Request $request, $id){

    }

    public function seeOneDelivery($id){

    }

    public function deleteDelivery($id){

    }
}
