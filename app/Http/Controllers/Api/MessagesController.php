<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Notifications\OrderNotification;
use Illuminate\Support\Facades\Notification;

use Validator;

class MessagesController extends ApiController
{
    public function sendToOneClient(Request $request){
        try {
            $validator = Validator::make(
                $request->all(),[
                        // 'data' => 'required|string',
                        // 'factor' => 'required|array|min:1',
                        // 'factor.*' => 'required|numeric',
                        'client_dni' => 'required|string|min:10',
                        'close_order' => 'required|bool',
                        'client_name' => 'required|string|min:7',
                        'reference_order' => 'required',
                        'phone' => 'required|array|min:1',
                        'phone.*' => 'required|string|min:7',
                        'mail' => 'required|array|min:1',
                        'mail.*' => 'required|string|min:6',
                    ]
            );
    
            if($validator->fails()){
                return $this->sendError("Error de validación", $validator->errors(), 422);            
            }

            for($i = 0; $i < count($request->input('phone')); $i++)
            {
                Notification::route('mail', $request->input('mail')[$i])
                            ->notify(new OrderNotification($request->input('close_order'), $request->input('client_name'), $request->input('client_dni'), $request->input('mail')[$i], $request->input('phone')[$i], $request->input('reference_order'))); 
            }

            $data = [
                'data' => array(
                    'phone' => $request->input('phone'),
                    'mail' => $request->input('mail'),
                )
            ];

        } catch(\Exception $error){
            return $this->sendError("Error en los datos", ["El trabajo no pudo ser agregado a las queue {$error->getMessage()}"], 422);    
        }

        return $this->sendResponse($data, "Mensajes guardados, se procesaran en los proximos minutos");
    }
}
