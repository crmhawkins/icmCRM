<?php

namespace App\Http\Livewire;

use App\Models\Clients\Client;
use App\Models\Users\User;
use Livewire\Component;
use Livewire\WithPagination;

class ClientsTable extends Component
{
    use WithPagination;

    public $gestores;
    public $buscar;
    public $selectedGestor = '';
    public $isClient = 1;
    public $perPage = 10;
    public $sortColumn = 'created_at'; // Columna por defecto
    public $sortDirection = 'desc'; // Dirección por defecto
    protected $clients;

    public function mount(){
        $this->gestores = User::where('access_level_id', 4)->get();
    }

    public function render()
    {
        $this->actualizarClientes();
        return view('livewire.clients-table', [
            'clients' => $this->clients
        ]);
    }

    protected function actualizarClientes()
    {
        $query = Client::when($this->buscar, function ($query) {
                $query->where('name', 'like', '%' . $this->buscar . '%')
                      ->orWhere('email', 'like', '%' . $this->buscar . '%')
                      ->orWhere('cif', 'like', '%' . $this->buscar . '%')
                      ->orWhere('identifier', 'like', '%' . $this->buscar . '%')
                      ->orWhere('activity', 'like', '%' . $this->buscar . '%');
            })
            ->when($this->selectedGestor, function ($query) {
                $query->where('admin_user_id', $this->selectedGestor);
            })
            ->when(isset($this->isClient), function ($query) {
                $query->where('is_client', $this->isClient);
            });

            $query->orderBy($this->sortColumn, $this->sortDirection);

            // Verifica si se seleccionó 'all' para mostrar todos los registros
            $this->clients = $this->perPage === 'all' ? $query->get() : $query->paginate(is_numeric($this->perPage) ? $this->perPage : 10);
    }

    public function sortBy($column)
    {
        if ($this->sortColumn === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortColumn = $column;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    public function updating($propertyName)
    {
        if ($propertyName === 'buscar' || $propertyName === 'selectedGestor' || $propertyName === 'isClient') {
            $this->resetPage();
        }
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }
}
