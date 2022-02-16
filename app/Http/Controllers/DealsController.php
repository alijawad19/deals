<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Deal;
use App\Models\UserDeal;
use Validator;
use Carbon\Carbon;

class DealsController extends Controller
{
    function createDeal(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'deal_name' => 'required|string',
            'quantity' => 'required|integer',
            'expiry_date' => 'required|date_format:Y-m-d H:i:s|after_or_equal:now'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data = [
            'deal_name' => $request['deal_name'],
            'quantity' => $request['quantity'],
            'expiry_date' => $request['expiry_date']
        ];

        Deal::create($data);
        echo response()->json(['message' => 'Deal created.']);
        return $data;
    }

    function showDeals()
    {
        $data = Deal::select(['deal_name','quantity','expiry_date'])->where('expiry_date', '>=', Carbon::now())->get();
        echo response()->json(['message' => 'List of all deals']);
        return $data;
    }

    public function claimDeal(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'deal_id' => 'required|exists:deals,id', //exists
            'user_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
                
        $deal = Deal::where('id', $request['deal_id'])->where('claimed' , '<', Deal::raw('quantity')) ->where('expiry_date', '>=', Carbon::now()) ->first();
        if($deal)
        {

            $check = UserDeal::where(['user_id' => $request->user_id, 'deal_id' => $request->deal_id])->first();
            $data = [
                'user_id' => $request['user_id'],
                'deal_id' => $request['deal_id']
            ];
            
            if(!$check)
            {
                UserDeal::create($data);
                Deal::where('id', $request['deal_id'])->increment('claimed');
                echo response()->json(['message' => 'Deal claimed.']);
                return $data;
            }
            else
            {
                return response()->json(['message' => 'Deal already claimed!']);
            }
        }
        else
        {
            return response()->json(['message' => 'Deal expired!']);
        }
    }
    
    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|integer',
            'expiry_date' => 'required|date_format:Y-m-d H:i:s|after_or_equal:now'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $check = Deal::find($id);
        if($check)
        {
            $data = Deal::find($request->id);
            $data->quantity = $request->quantity;
            $data->expiry_date = $request->expiry_date;
            $data->update();
            echo response()->json(['message' => 'Deal updated.']);
            return $data;
        }

        return response()->json(['message' => 'Deal does not exist!']);
    }

}
