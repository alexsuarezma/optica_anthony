<?php

namespace App\Http\Livewire\Activity;

use Livewire\Component;
use App\Models\Activity;
use App\Models\DetailActivity;
use App\Models\User;

use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search;
    public $searchSalesman;
    public $fecha_inicio;
    public $fecha_fin;
    public $detail_activity_id;
    public $state_activity;
    public $salesman_id;
    public $salesman_description;
    protected $queryString = ['search' => ['except'=>'']];

    public function mount(){
        $this->fecha_inicio = date('Y-m-', strtotime(\Carbon\Carbon::now()))."01";
        $this->fecha_fin = date('Y-m-d', strtotime(\Carbon\Carbon::now()));
    }

    public function render()
    {
 
        return view('livewire.activity.index',
        [
            'activities' => Activity::where( function($query) {
                                $query->where('description', 'LIKE', "%{$this->search}%")
                                ->orWhere('id', 'LIKE', "%{$this->search}%");
                            })
                            ->whereBetween('aperture_date', [date('Y-m-d 00:00:00', strtotime($this->fecha_inicio)),date('Y-m-d 23:59:59',strtotime($this->fecha_fin))])
                            ->where( function($query) {
                                if(\Auth::user()->salesman == 1){
                                    $query->where('user_id', \Auth::user()->id);
                                }elseif(\Auth::user()->admin == 1){
                                    if($this->salesman_id != ''){
                                        $query->where('user_id', $this->salesman_id);
                                    }
                                }
                            })
                            ->where( function($query) {
                                if($this->detail_activity_id != 0){
                                    $query->where('detail_activity_id', $this->detail_activity_id);
                                }
                            })
                            ->where( function($query) {
                                if($this->state_activity == 'A'){
                                    $query->where('departure_date', null);
                                }elseif($this->state_activity == 'F'){
                                    $query->where('departure_date', '<>', null);
                                }
                            })
                            // ->where( function($query) {
                            //     if(!\Auth::user()->can('grupo.*')){
                            //         $sql = "CONCAT('grupo.',id) in (select name from permissions a inner join model_has_permissions b on a.id = b.permission_id ";
                            //         $sql = $sql."where (name like '%*%' or SUBSTRING(name,length(name),length(name)) REGEXP '^[0-9]+$') and model_id = ".\Auth::user()->id.")";
                                    
                            //         $query->whereRaw($sql);
                            //     }
                            // })
                            ->orderBy('created_at','desc')
                            ->paginate(10),
             'detail_activities' => DetailActivity::where('active', 1)->orderBy('created_at','desc')->get(),
             'users' => User::where( function($query) {
                                $query->where('name', 'LIKE', "%{$this->searchSalesman}%")
                                ->where('lastname', 'LIKE', "%{$this->searchSalesman}%")
                                ->orWhere('id', 'LIKE', "%{$this->searchSalesman}%");
                            })->where('salesman', 1)->orderBy('created_at','desc')->paginate(10)
        ]);
    }

    public function selectSalesman(User $user){
        $this->salesman_id = $user->id;
        $this->salesman_description = "{$user->name} {$user->lastname}";
    }

    public function updated($name, $value)
    {
        if($name == 'salesman_id')
        {
            $user = User::where('id', $value)->first();

            if($user)
            {
                $this->salesman_id = $user->id;
                $this->salesman_description = "{$user->name} {$user->lastname}";
            }else
            {
                $this->salesman_id = '';
                $this->salesman_description = '';
            }
        }
    }
}
