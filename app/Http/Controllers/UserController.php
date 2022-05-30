<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class UserController extends Controller
{
    private $URI = 'http://181.39.128.194:8092/';

    public function create(Request $request){

        $validatedData = $request->validate([
            'name' => 'required|string|max:60',
            'lastname' => 'string|max:60',
            'cedula' => ['required', 'numeric', 'unique:users', 'between:0000000000,9999999999999',
                // function ($attribute, $value, $fail){
                //     if(!$this->validateCedula($value)){
                //         $fail("Lo lamentamos, el cliente que intenta crear no se encuentra dentro de los registros de clientes actualmente");
                //     }
                // },
            ],
            'email' => 'required|string|max:100|email|unique:users,email,',
            'address' => 'string',
            'phone' => 'numeric|min:7',
        ]);

        try {
            DB::beginTransaction();

            $user = new User();

            $user->name = $request->input('name'); 
            $user->lastname = $request->input('lastname'); 
            $user->cedula = $request->input('cedula'); 
            $user->admin = empty($request->input('admin')) ? 0 : 1; 
            $user->email = $request->input('email'); 
            $user->address = $request->input('address'); 
            $user->phone = $request->input('phone'); 

            $password = Hash::make(strtolower($request->input('name')).'123');
            $user->password = $password;

            $user->save();

            DB::commit();
        } catch(Illuminate\Database\QueryException $error){
            DB::rollback();
            return redirect()->back()->withInput()->with('error', "Oh, parece que hubo un error: {$error->getMessage()}");
        }
        catch(\Exception $error){
            DB::rollback();
            return redirect()->back()->withInput()->with('error', "Oh, parece que hubo un error: {$error->getMessage()}");
        }

        return redirect()->back()->with('success', "Información creada satisfactoriamente"); 
    }

    public function updateInformationProfile(Request $request){
        
        $validatedData = $request->validate([
            'name' => 'required|string|max:25',
            'lastname' => 'required|string|max:30',
            'email' => 'required|string|max:100|email|unique:users,email,'.\Auth::user()->id,
            'phone' => 'required|numeric|min:7',
        ]);

        try {
            $user = \Auth::user();
            
            $lastEmail = $user->email;

            $user->name = $request->input('name'); 
            $user->lastname = $request->input('lastname'); 
            $user->email = $request->input('email'); 
            $user->phone = $request->input('phone'); 
            $user->address = $request->input('address'); 
            
            $user->update();
            
            $this->verifyEmailForUpdateInformation($lastEmail, $user);
        } catch(Illuminate\Database\QueryException $error){
            return redirect()->back()->withInput()->with('error', "Oh, parece que hubo un error: {$error->getMessage()}");
        }
        catch(\Exception $error){
            return redirect()->back()->withInput()->with('error', "Oh, parece que hubo un error: {$error->getMessage()}");
        }

        return redirect()->back()->with('success', "Información actualizada satisfactoriamente");
    }

    private function verifyEmailForUpdateInformation($email,User $user){
        if($email != $user->email){
            $affected = DB::table('users')
              ->where('id', $user->id)
              ->update(['email_verified_at' => null]);
        }
        
        return true;
    }

    public function updatePasswordsUsers(Request $request){
        $validatedData = $request->validate([
            'passwordUsers' => 'required|string',
            'id' => 'required|array|min:1',
            'id.*' => 'required|numeric|distinct',
        ]);

        try {
            DB::beginTransaction();

            for($i=0;$i<count($request->input('id'));$i++){
               $user = User::where('id', $request->input('id')[$i])->first();

               if(!$user){
                    throw new Exception("El usuario al que intenta acceder no existe. ID = {$request->input('id')[$i]}", 1);
                }

               $password = Hash::make($request->input('passwordUsers'));
               $user->password = $password;

               $user->update();  
            }
            DB::commit();
        } catch(Illuminate\Database\QueryException $error){
            DB::rollback();
            return redirect()->back()->withInput()->with('error', "Oh, parece que hubo un error: {$error->getMessage()}");
        }
        catch(\Exception $error){
            DB::rollback();
            return redirect()->back()->withInput()->with('error', "Oh, parece que hubo un error: {$error->getMessage()}");
        }

        return redirect()->back()->with('success', "Información actualizada satisfactoriamente");
    }

    public function desactiveAccount(Request $request){
        $validatedData = $request->validate([
            'password' => 'required|string|current_password',
            'id' => 'required|array|min:1',
            'id.*' => 'required|numeric|distinct',
            'active' => 'required|array|min:1',
            'active.*' => 'required|numeric',
        ]);

        try {
            DB::beginTransaction();

            for($i=0;$i<count($request->input('id'));$i++){
               $user = User::where('id', $request->input('id')[$i])->first();
               
               if(!$user){
                    throw new Exception("El usuario al que intenta acceder no existe. ID = {$request->input('id')[$i]}", 1);
               }
               $user->active = $request->input('active')[$i];

               $user->update();  
               
               if($user->active == 0){
                   if (config('session.driver') !== 'database') {
                       return;
                    }
                    
                    DB::connection(config('session.connection'))->table(config('session.table', 'sessions'))
                    ->where('user_id', $request->input('id')[$i])
                    ->delete();
                }
            }
            DB::commit();
        } catch(Illuminate\Database\QueryException $error){
            DB::rollback();
            return redirect()->back()->withInput()->with('error', "Oh, parece que hubo un error: {$error->getMessage()}");
        }
        catch(\Exception $error){
            DB::rollback();
            return redirect()->back()->withInput()->with('error', "Oh, parece que hubo un error: {$error->getMessage()}");
        }

        return redirect()->back()->with('success', "Información actualizada satisfactoriamente");
    }

    public function index(){
        return view('user.index');
    }

    public function createView(){
        return view('user.create');
    }

}
