<?php

namespace App\Http\Livewire\User;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

use App\Models\User;

class Invoice extends Component
{
    private $URI = 'http://181.39.128.194:8092/';
    public $invoices = array();
    public $fechaInicio;
    public $fechaFin;
    
    protected $listeners = ['updateGrid', 'renderGrid'];


    public function mount()
    {
        $this->fechaInicio = date('Y-m-', strtotime(\Carbon\Carbon::now()))."01";
        $this->fechaFin = date('Y-m-d', strtotime(\Carbon\Carbon::now()));
    }

    public function render()
    {
        return view('livewire.user.invoice');
    }

    public function updateGrid()
    {
        $user = User::select('cedula')->where('id', \Auth::user()->id)->first();

        $invoices = Http::acceptJson()->post("{$this->URI}SAN32.WS.Rest.Bitacora/api/ConsultarFactura/ConsultarFactura", [
            'cedula' => $user->cedula,
            'empresa' => 'All Padel',
            'fechaInicio' => date('m/d/Y', strtotime($this->fechaInicio)),
            'fechaFin' => date('m/d/Y', strtotime($this->fechaFin))
        ]);

        $invoices = $invoices->json()['Response'];
        
        if(empty($invoices))
        {
            $invoices = array();
        }

        // $this->invoices = compact('invoices');

        $this->emit('renderGrid', compact('invoices'));
    }

    public function renderGrid($data){ return; }

    // public function SearchListener($data)
    // {
    //     return;
    // }
}
