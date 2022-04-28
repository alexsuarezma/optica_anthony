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
            // 'cedula' => ['required', 'numeric', 'unique:users', 'between:0000000000,9999999999999',
            //     function ($attribute, $value, $fail){
            //         if(!$this->validateCedula($value)){
            //             $fail("Lo lamentamos, el cliente que intenta crear no se encuentra dentro de los registros de clientes actualmente");
            //         }
            //     },
            // ],
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

    private function validateCedula($cedula){
        $identity = Http::acceptJson()->post("http://181.39.128.194:8092/SAN32.WS.Rest.Bitacora/api/ValidarIdentificacion/ValidarIdentificacion", [
            'cedula' => $cedula,
            'empresa' => 'All Padel',
        ]);
        
        $exist = $identity->json()['Response'];

        // var_dump($identity->json()); die;

        if(empty($exist) || $identity->json()['CodigoError'] == '2000'){
            return false;
        }

        if($exist[0]['EXISTE_CLIENTE'] == 0) //&& ($identity->json()['CodigoError'] != "200" && $identity->json()['CodigoError'] != "00"))
        {
            return false;
        }
        
        return true;
    }

    public function invoiceView(){

        $invoices = $this->fetchInvoices('','');

        return view('user.invoice',[
            'invoices' => compact('invoices')
        ]);
    }

    public function getInvoices(Request $request){
        return $this->fetchInvoices($request->input('fechaInicio'), $request->input('fechaFin'));
    }

    public function fetchInvoices($fechaInicio, $fechaFin){
        $user = User::select('cedula')->where('id', \Auth::user()->id)->first();
        
        $invoices = Http::acceptJson()->post("{$this->URI}SAN32.WS.Rest.Bitacora/api/ConsultarFactura/ConsultarFactura", [
            'cedula' => $user->cedula,
            'empresa' => 'All Padel',
            'fechaInicio' => $fechaInicio != '' ? date('m/d/Y', strtotime($fechaInicio)) : '',
            'fechaFin' => $fechaFin != '' ? date('m/d/Y', strtotime($fechaFin)) : ''
        ]);

        $invoices = $invoices->json()['Response'];

        return $invoices;
    }

    public function accountStatusView(){
        $documents = $this->fetchAccountStatus('','');

        return view('user.account-status',[
            'documents' => compact('documents')
        ]);
    }

    public function getAccountStatus(Request $request){
        return $this->fetchAccountStatus($request->input('fechaInicio'), $request->input('fechaFin'));
    }

    public function fetchAccountStatus($fechaInicio, $fechaFin){
        $user = User::select('cedula')->where('id', \Auth::user()->id)->first();
        
        $documents = Http::acceptJson()->post("{$this->URI}SAN32.WS.Rest.Bitacora/api/ConsultarEstadoCuentaCliente/ConsultarEstadoCuentaCliente", [
            'cedula' => $user->cedula,
            'empresa' => 'All Padel',
            'fechaInicio' => $fechaInicio != '' ? date('m/d/Y', strtotime($fechaInicio)) : '',
            'fechaFin' => $fechaFin != '' ? date('m/d/Y', strtotime($fechaFin)) : ''
        ]);

        $documents = $documents->json()['Response'];

        return $documents;
    }

    public function printInvoice(Request $request){
        $user = User::select('cedula')->where('id', \Auth::user()->id)->first();
        $query = '';

        $query .= "SELECT VW_DOCUMENTO_FACTURA.nombreComercial, VW_DOCUMENTO_FACTURA.dirMatriz, VW_DOCUMENTO_FACTURA.dirEstablecimiento, VW_DOCUMENTO_FACTURA.contribuyenteEspecial";
        $query .= ",VW_DOCUMENTO_FACTURA.obligadoContabilidad, VW_DOCUMENTO_FACTURA.razonSocialComprador, VW_DOCUMENTO_FACTURA.RUC, VW_DOCUMENTO_FACTURA.fechaEmision";
        $query .= ",VW_DOCUMENTO_FACTURA.guiaRemision, VW_DOCUMENTO_FACTURA.descuento, VW_DOCUMENTO_FACTURA.identificacionComprador, VW_DOCUMENTO_FACTURA.MAIL, VW_DOCUMENTO_FACTURA.baseImponible";
        $query .= ",VW_DOCUMENTO_FACTURA.fecha_autorizacionElectronica, VW_DOCUMENTO_FACTURA.ESTAB, VW_DOCUMENTO_FACTURA.ptoEmi, VW_DOCUMENTO_FACTURA.secuencial, VW_DOCUMENTO_FACTURA.ambiente, VW_DOCUMENTO_FACTURA.CLAVE_ACCESO";
        $query .= ",VW_DOCUMENTO_FACTURA.telefonos_CLI, VW_DOCUMENTO_FACTURA.AUTORIZACION, VW_DOCUMENTO_FACTURA.DOMICILIO, VW_DOCUMENTO_FACTURA.NOMBRE_UBICACION, VW_DOCUMENTO_FACTURA.NOMBRE_FPAGO";
        $query .= ",VW_DOCUMENTO_FACTURA.NOMBRE_VENDEDOR, VW_DOCUMENTO_FACTURA.OBSERVACION, VW_DOCUMENTO_FACTURA.VALOR_IVA, VW_DOCUMENTO_FACTURA.VEN_TOTAL, VW_DOCUMENTO_FACTURA.cantidad, VW_DOCUMENTO_FACTURA.codigoPrincipal";
        $query .= ",VW_DOCUMENTO_FACTURA.descripcion, VW_DOCUMENTO_FACTURA.precioUnitario, VW_DOCUMENTO_FACTURA.TASA_ICE, VW_DOCUMENTO_FACTURA.DCTONORMAL, VW_DOCUMENTO_FACTURA.secuencial_mov, VW_DOCUMENTO_FACTURA.BODEGA";
        $query .= ",VW_DOCUMENTO_FACTURA.factorx, VW_DOCUMENTO_FACTURA.SUBTOTALIVA, VW_DOCUMENTO_FACTURA.IVA FROM VW_DOCUMENTO_FACTURA VW_DOCUMENTO_FACTURA WHERE SEQ_COMPTE = '{$request->input('id')}' ORDER BY VW_DOCUMENTO_FACTURA.secuencial_mov";

        $invoices = Http::post("{$this->URI}/SAN32.WS.Rest.Reportes/api/EjecutarReporte", [
           'ParametrosSession' => array(
                'CodigoBodega' => '001',
                'CodigoEmpresa' => '1',
                'CodigoSucursal' => '001',
                'CodigoUsuario' => 'OPTIMUS',
                'FechaProceso' => '13/11/2020',
                'IdEmpresa' => '823',
                'Imei' => 'c1f20795cd373dbc',
                'Latitud' => '37.421998333333335',
                'Longitud' => '-122.08400000000002',
                'NivelPrecio' => '',
                'NombreBodega' => 'BODEGA PRINCIPAL',
                'NombreEmpresa' => 'ALL PADEL',
                'NombreSucursal' => 'MATRIZ',
                'NombreUsuario' => 'INDETERMINADO'
            ),
            'parametrosReporte' => array(
                "Bodega" => "001",
                "NombreReporte" => "RIDE",
                "RutaReporte" => "reportes_darmacio",
                "SQLQuery" => $query,
                "SelectionFormula" => "",
                "SqlSubquery" => "SELECT CLIENTE, SEQ_COMPTE, DIAS, FP, VALOR FROM VW_FORMA_PAGO WHERE   SEQ_COMPTE = '{$request->input('id')}'",
                "TipoExportacion" => "",
                "Usuario" => "OPTIMUS"
            )
        ]);

        // var_dump($invoices->json());

        $invoices = $invoices->json()['PathReporte'];

        return view("user.invoice-pdf", [
            'url' => "{$this->URI}{$invoices}"
        ]);
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
