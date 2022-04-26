<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Models\User;

class UserController extends Controller
{
    private $URI = 'http://181.39.128.194:8092/';

    public function invoiceView(){
        $user = User::select('cedula')->where('id', \Auth::user()->id)->first();
        
        $invoices = Http::acceptJson()->post("{$this->URI}SAN32.WS.Rest.Bitacora/api/ConsultarFactura/ConsultarFactura", [
            'cedula' => $user->cedula,
            'empresa' => 'All Padel',
        ]);

        $invoices = $invoices->json()['Response'];

        return view('user.invoice',[
            'invoices' => compact('invoices')
        ]);
    }

    public function accountStatusView(){
        $user = User::select('cedula')->where('id', \Auth::user()->id)->first();
        
        $documents = Http::acceptJson()->post("{$this->URI}SAN32.WS.Rest.Bitacora/api/ConsultarEstadoCuentaCliente/ConsultarEstadoCuentaCliente", [
            'cedula' => $user->cedula,
            'empresa' => 'All Padel',
        ]);

        $documents = $documents->json()['Response'];

        return view('user.account-status',[
            'documents' => compact('documents')
        ]);
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
}
