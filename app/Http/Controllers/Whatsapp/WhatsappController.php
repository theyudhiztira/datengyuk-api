<?php

namespace App\Http\Controllers\Whatsapp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WhatsappChats;

class WhatsappController extends Controller
{
    //
    public function store(Request $req)
    {
        try{
            $waChats = new WhatsappChats;
            $waChats->message = $req->message;
            $waChats->save();
        }catch(\Exception $e){
            return sendResponse([
                'message' => $e->getMessage()
            ], 500);
        }

        return sendResponse(true, 200);
    }
}
