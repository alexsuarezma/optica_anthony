<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\Activity;
use App\Models\OrderHasActivity;
use App\Models\Order;

class ActivityController extends Controller
{
    public function create(Request $request){

        $validatedData = $request->validate([
            'description' => 'string|max:255',
            'detail_activity_id' => 'required|numeric',
            'aperture_date' => 'required|date|after_or_equal:'. Carbon::now()->format('Y-m-d'),
            'aperture_hour' => 'required|hour',
            'departure_date' => 'required|date|after:aperture_date',
            'departure_hour' => 'required|hour',
            'delivery_date' => 'required|date|after:aperture_date',
            'delivery_hour' => 'required|hour',
            'order_id' => 'required|array|min:1',
            'order_id.*' => 'required|numeric',
        ]);
        
        try {

            DB::beginTransaction();
            
            $activity = new Activity();

            $activity->description = $request->input('description');
            $activity->aperture_date = date("Y/m/d", strtotime($request->input('aperture_date')).$request->input('aperture_hour'));
            $activity->departure_hour = date("Y/m/d", strtotime($request->input('departure_date')).$request->input('departure_hour'));
            $activity->delivery_date = date("Y/m/d", strtotime($request->input('delivery_date')).$request->input('delivery_hour'));
            $activity->detail_activity_id = $request->input('detail_activity_id');
            $activity->user_id = \Auth::user()->id;

            $activity->save();
            
            for ($i=0; $i < count($request->input('order_id')); $i++) { 
                $order_activity = new OrderHasActivity();
                $order_activity->order_id = $request->input('order_id')[$i];
                $order_activity->activity_id = $activity->id;
                
                $order_activity->save();
                
                $order = Order::where('id', $order_activity->order_id)->where('closed', 0)->first();

                if(!$order){
                    throw new \Exception("No se encontro la orden ${$request->input('order_id')[$i]} que deseas actualizar o posiblemente esta cerrada, porfavor confirma la informacion", 1);
                }

                $order->state_id = $order_activity->activity->detailActivity->state_id;
                $order->state_acronyms = $order_activity->activity->detailActivity->state->acronyms;
                
                $order->update();
            }

            
            DB::commit();
        } catch(Illuminate\Database\QueryException $error){
            DB::rollback();
            return redirect()->back()->withInput()->with('error', "Hubo un error: {$error->getMessage()}");
        }
        catch(\Exception $error){
            DB::rollback();
            return redirect()->back()->withInput()->with('error', "Hubo un error: {$error->getMessage()}");
        }

        return redirect()->back()->with('success', "Información creada satisfactoriamente"); 
    }

    public function update(Request $request){

        $validatedData = $request->validate([
            'id' => 'required|numeric',
            'description' => 'string|max:255',
            'detail_activity_id' => 'required|numeric',
            'aperture_date' => 'required|date|after_or_equal:'. Carbon::now()->format('Y-m-d'),
            'aperture_hour' => 'required|hour',
            'departure_date' => 'required|date|after:aperture_date',
            'departure_hour' => 'required|hour',
            'delivery_date' => 'required|date|after:aperture_date',
            'delivery_hour' => 'required|hour',
            'order_id' => 'required|array|min:1',
            'order_id.*' => 'required|numeric',
        ]);
        
        try {

            DB::beginTransaction();
            
            $activity = Activity::where('id', $request->input('id'))->where('user_id', \Auth::user()->id)->first();
        
            if(!$activity){
                throw new \Exception("'No se encontro la actividad que deseas actualizar, porfavor vuelve a intentarlo más tarde'", 1);
            }

            $activity->description = $request->input('description');
            $activity->aperture_date = date("Y/m/d", strtotime($request->input('aperture_date')).$request->input('aperture_hour'));
            $activity->departure_hour = date("Y/m/d", strtotime($request->input('departure_date')).$request->input('departure_hour'));
            $activity->delivery_date = date("Y/m/d", strtotime($request->input('delivery_date')).$request->input('delivery_hour'));
            $activity->detail_activity_id = $request->input('detail_activity_id');
            $activity->user_id = \Auth::user()->id;

            $activity->update();
            
            OrderHasActivity::where('activity_id', $activity->id)->delete();

            for ($i=0; $i < count($request->input('order_id')); $i++) { 
                $order_activity = new OrderHasActivity();
                $order_activity->order_id = $request->input('order_id')[$i];
                $order_activity->activity_id = $activity->id;
                
                $order_activity->save();

                $order = Order::where('id', $order_activity->order_id)->where('closed', 0)->first();

                if(!$order){
                    throw new \Exception("No se encontro la orden ${$request->input('order_id')[$i]} que deseas actualizar, porfavor confirma la informacion", 1);
                }

                $order->state_id = $order_activity->activity->detailActivity->state_id;
                $order->state_acronyms = $order_activity->activity->detailActivity->state->acronyms;
                
                $order->update();
            }
            
            DB::commit();
        } catch(\Illuminate\Database\QueryException $error){
            DB::rollback();
            return redirect()->back()->withInput()->with('error', "Hubo un error: {$error->getMessage()}");
        }
        catch(\Exception $error){
            DB::rollback();
            return redirect()->back()->withInput()->with('error', "Hubo un error: {$error->getMessage()}");
        }

        return redirect()->back()->with('success', "Información creada satisfactoriamente"); 
    }

    public function departureActivity(Request $request){

        $validatedData = $request->validate([
            'id' => 'required|numeric',
            'description' => 'string|max:255',
            'departure_date' => 'required|date|after:aperture_date',
            'departure_hour' => 'required|hour',
        ]);
        
        try {

            DB::beginTransaction();

            $activity = Activity::where('id', $request->input('id'))->where('user_id', \Auth::user()->id)->first();
        
            if(!$activity){
                throw new \Exception("'No se encontro la actividad que deseas actualizar, porfavor vuelve a intentarlo más tarde'", 1);
            }

            $activity->description = $request->input('description');
            $activity->aperture_date = date("Y/m/d", strtotime($request->input('aperture_date')).$request->input('aperture_hour'));

            $activity->update();
            
            DB::commit();
        } catch(Illuminate\Database\QueryException $error){
            DB::rollback();
            return redirect()->back()->withInput()->with('error', "Hubo un error: {$error->getMessage()}");
        }
        catch(\Exception $error){
            DB::rollback();
            return redirect()->back()->withInput()->with('error', "Hubo un error: {$error->getMessage()}");
        }

        return redirect()->back()->with('success', "Información actualizada satisfactoriamente"); 
    }

    // VIEWS
    public function index(){
        return view('activity.index');
    }

    public function createView(){
        $order_has_activity = OrderHasActivity::where('active', 1)->orderBy('created_at','desc')->get();
        $orders = Order::where('closed', 0)->orderBy('created_at','desc')->get();

        return view('activity.create', [
            'order_has_activity' => $order_has_activity,
            'orders' => $orders
        ]);
    }

    public function updateView($id){
        $activity = Activity::where('id', $id)->first();
        $order_has_activity = OrderHasActivity::where('active', 1)->orderBy('created_at','desc')->get();
        $orders = Order::where('closed', 0)->orderBy('created_at','desc')->get();

        return view('activity.update', [
            'activity' => $activity,
            'order_has_activity' => $order_has_activity,
            'orders' => $orders,
        ]);
    }
}
