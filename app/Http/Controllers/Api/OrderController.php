<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

use App\Models\Order;


class OrderController extends ApiController
{
    public function create(Request $request){

        // $validatedData = $request->validate([
        //     'reference' => 'required|string|max:16|unique:orders',
        //     'data' => 'required|string',
        // ]);
        
        
        try {
            
            DB::beginTransaction();
    
            $validator = Validator::make(
                $request->all(),[
                        'reference' => 'required|string|max:16|unique:orders',
                        'data' => 'required|string',
                    ]
            );
       
            if($validator->fails()){
                throw new \Exception("Error de validación ".$validator->errors(), 1);
            }
            
            $order = new Order();

            $order->reference = $request->input('reference');
            $order->data = json_encode($request->input('data'));

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

        // $validatedData = $request->validate([
        //     'reference' => 'required|string|max:16',
        //     'data' => 'required|string',
        // ]);
        
        try {

            DB::beginTransaction();
    
            $validator = Validator::make(
                $request->all(),[
                        'reference' => 'required|string|max:16|unique:orders',
                        'data' => 'required|string',
                    ]
            );
       
            if($validator->fails()){
                throw new \Exception("Error de validación ".$validator->errors(), 1);
            }

            $order = Order::where('id', $request->input('reference'))->where('closed', 0)->first();
        
            if(!$order){
                throw new \Exception("'No se encontro la Orden a la que intentas acceder o esta cerrada, porfavor vuelve a intentarlo más tarde'", 1);
            }

            $order->reference = $request->input('reference');
            $order->data = json_encode($request->input('data'));

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

        return $this->sendResponse($data, "Información creada satisfactoriamente");
    }

}