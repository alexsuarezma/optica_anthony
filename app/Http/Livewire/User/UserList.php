<?php

namespace App\Http\Livewire\User;

use Livewire\Component;
use App\Models\User;

use Livewire\WithPagination;

class UserList extends Component
{
    use WithPagination;

    protected $queryString = ['search' => ['except'=>'']];

    public $search = '';
    public $filter = '';
    public $status = 1;
    public $usersSelected = array();

    protected $listeners = ['removeUserInArray','checkOrUncheckAll'];

    public function render()
    {
        return view('livewire.user.user-list',
        [
            'users' => User::where('active', $this->status)
                            // ->where('id', '<>', \Auth::user()->id)
                            ->where( function($query) {
                                $query->where('name', 'LIKE', "%{$this->search}%")->orWhere('email', 'LIKE', "%{$this->search}%")
                                ->orWhere('lastname', 'LIKE', "%{$this->search}%");
                            })
                            ->paginate(10)
        ]);
    }

    public function filterOne(){
        $this->status = 1;
        $this->usersSelected = array();
    }

    public function filterTwo(){
        $this->status = 0;
        $this->usersSelected = array();
    }

    public function addUserInArray($id,$status,$name,$email,$role,$photo){
        $flag = $this->removeUserInArray($id);

        if(!$flag){
            array_push($this->usersSelected,
                            array(
                                    'id' => $id,
                                    'name' => $name,
                                    'email' => $email,
                                    'role' => $role,
                                    'photo' => $photo,
                                    'active' => $status
                                )
                    );
        }

    }

    public function removeUserInArray($id){
        foreach($this->usersSelected as $index => $user){
            if($user['id'] == $id){
                unset($this->usersSelected[$index]);
                $this->emit('removeUserInArray', $id);
                return true;
            }
        }
        return false;
    }

    public function checkOrUncheckAll(){
        return true;
    }
}
