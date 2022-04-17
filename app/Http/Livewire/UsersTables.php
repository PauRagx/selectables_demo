<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use App\Exports\UserExport;
use Maatwebsite\Excel\Facades\Excel;

class UsersTables extends Component
{
    use WithPagination;
    public $search = '';
    public $perPage = 10;
    public $sortField = 'id';
    public $sortAsc = true;
    public $selected = [];

    public function deleteUsers()
    {
        User::destroy($this->selected);
    }

    public function export()
    {
        // dd($this->selected);
        return (new UserExport($this->selected))->download('users.xls');
        // return Excel::download(new UserExport, 'users.xlsx');
        // return (new UserExport($this->selected))->download('appoinment.xls');
    }


    public function render()
    {
        return view('livewire.users-tables', [
            'users' => User::search($this->search)
                ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                ->simplePaginate($this->perPage),
        ]);
    }
}
