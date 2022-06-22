<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Illuminate\Support\Facades\Storage;

use App\Models\Order;


class OrderController extends ApiController
{
    public function create(Request $request){
        try {
            
            DB::beginTransaction();

            $validator = Validator::make(
                $request->all(),[
                    'Reference' => 'required|string|max:16|unique:orders',
                    'Description' => 'required|string|max:200',
                    'Client_id' => 'required|string|max:16',
                ]
            );
    
            if($validator->fails()){
                $errorMessage = json_encode($validator->errors());
                return $this->sendError("Error de validación: {$errorMessage}", $errorMessage, 422);            
            }
    
            // Storage::disk('local')->put('example.txt', json_encode($request->input()));
            
            $order = new Order();

            //Se debe de tomar los campos de la orden y hacerlos json para guardarlos en el campo "data"
            $order->reference = $request->input('Reference');
            $order->data = $request->input('Description'); //json_encode($request->input('data'));
            $order->client_id = $request->input('Client_id');
            
            
            $order->save();
            

            $data = [];        

            $data['order'] = $order;
            
            DB::commit();
        } catch(\Illuminate\Database\QueryException $error){
            DB::rollback();
            return $this->sendError("Error en los datos", ["Hubo un error: {$error->getMessage()}"], 422);            
        }
        catch(\Exception $error){
            DB::rollback();
            return $this->sendError("Error en los datos", ["Hubo un error: {$error->getMessage()}"], 422);            
        }

        return $this->sendResponse($data, "Información creada satisfactoriamente");
    }

    public function update(Request $request){

        try {

            DB::beginTransaction();

            $validator = Validator::make(
                $request->all(),[
                    'Reference' => 'required|string|max:16',
                    'Description' => 'required|string|max:200',
                    'Client_id' => 'required|string|max:16',
                ]
            );

            if($validator->fails()){
                $errorMessage = json_encode($validator->errors());
                return $this->sendError("Error de validación: {$errorMessage}", $errorMessage, 422);            
            }

            $order = Order::where('reference', $request->input('Reference'))->where('client_id', $request->input('Client_id'))->where('closed', 0)->first();
        
            if(!$order){
                throw new \Exception("'No se encontro la Orden a la que intentas acceder o esta cerrada, porfavor vuelve a intentarlo más tarde'", 1);
            }

            $order->reference = $request->input('Reference');
            $order->data = $request->input('Description'); //json_encode($request->input('data'));

            $order->update();

            $data = [];        

            $data['order'] = $order;
            
            DB::commit();
        } catch(\Illuminate\Database\QueryException $error){
            DB::rollback();
            return $this->sendError("Error en los datos", ["Hubo un error: {$error->getMessage()}"], 422);            
        }
        catch(\Exception $error){
            DB::rollback();
            return $this->sendError("Error en los datos", ["Hubo un error: {$error->getMessage()}"], 422);            
        }

        return $this->sendResponse($data, "Información actualizada satisfactoriamente");
    }

}
