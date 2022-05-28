<?php

namespace App\Http\Livewire\Activity;

use Livewire\Component;
use App\Models\Activity;

use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search;
    protected $queryString = ['search' => ['except'=>'']];

    public function render()
    {
 
        return view('livewire.activity.index',
        [
            'activities' => Activity::where( function($query) {
                                $query->where('description', 'LIKE', "%{$this->search}%")
                                ->orWhere('id', 'LIKE', "%{$this->search}%");
                            })
                            ->where( function($query) {
                                if(\Auth::user()->salesman == 1){
                                    $query->where('user_id', \Auth::user()->id);
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
                            ->paginate(10)
        ]);
    }
}
