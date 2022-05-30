<?php

namespace App\Http\Livewire\Order;

use Livewire\Component;
use App\Models\Order;
use App\Models\DetailActivity;

use Livewire\WithPagination;


class Index extends Component
{
    use WithPagination;

    public $search;
    public $fecha_inicio;
    public $fecha_fin;
    public $detail_activity_id;
    public $state_order;
    protected $queryString = ['search' => ['except'=>'']];

    public function mount(){
        $this->fecha_inicio = date('Y-m-', strtotime(\Carbon\Carbon::now()))."01";
        $this->fecha_fin = date('Y-m-d', strtotime(\Carbon\Carbon::now()));
    }

    public function render()
    {
        return view('livewire.order.index',[
            'orders' => Order::where( function($query) {
                                $query->where('reference', 'LIKE', "%{$this->search}%")
                                ->orWhere('id', 'LIKE', "%{$this->search}%")
                                ->orWhere('client_id', 'LIKE', "%{$this->search}%");
                            })
                            ->whereBetween('created_at', [date('Y-m-d 00:00:00', strtotime($this->fecha_inicio)),date('Y-m-d 23:59:59',strtotime($this->fecha_fin))])
                            ->where( function($query) {
                                if(\Auth::user()->client == 1){
                                    $query->where('client_id', \Auth::user()->id);
                                }
                            })
                            ->where( function($query) {
                                if($this->detail_activity_id != 0){
                                    $query->where('state_id', $this->detail_activity_id);
                                }
                            })
                            ->where( function($query) {
                                if($this->state_order == 'C'){
                                    $query->where('closed', 1);
                                }elseif($this->state_order == 'P'){
                                    $query->where('closed', 0);
                                }
                            })
                            ->orderBy('created_at','desc')
                            ->paginate(10),
             'detail_activities' => DetailActivity::where('active', 1)->orderBy('created_at','desc')->get(),
        ]);
    }
}
