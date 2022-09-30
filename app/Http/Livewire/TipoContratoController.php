<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\TipoContrato;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

use Illuminate\Support\Facades\DB;

use App\Http\Livewire\TipoContratoImport;

use Intervetion\Image\Facades\Image;
use Illuminate\Http\Request;

class TipoContratoController extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $name, $image, $selected_id;
    public $pageTitle, $componentName, $search;
    private $pagination = 5;

    public function mount(){
        $this -> pageTitle = 'Listado';
        $this -> componentName = 'Tipo de Contrato';
    }

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function render()
    {
        if(strlen($this->search) > 0)
            $data = TipoContrato::where('name','like','%' . $this->search . '%')->paginate($this->pagination);
        else
            $data = TipoContrato::orderBy('id','desc')->paginate($this->pagination);

        return view('livewire.tipoContrato.component', ['tipos' => $data]) // se envia tipos
        ->extends('layouts.theme.app')
        ->section('content');
    }

    // prueba de importacion de datos de excel a BD

    //https://codedrinks.com/importar-un-archivo-de-excel-a-base-de-datos-en-laravel/

    // https://coder-solution-es.com/solution-es-blog/1149981

    /*public function importForm(){
        return view('import');
    }
 
    public function import(Request $request)
    {
        $import = new TipoContratoImport();
        Excel::import($import, request()->file('tipo_contratos'));
        return view('import', ['numRows'=>$import->getRowCount()]);
    }*/


    public function Edit($id){
        $record = TipoContrato::find($id, ['id', 'name', 'image']);
        $this->name = $record->name;
        $this->selected_id = $record->id;
        $this->image = null;

        $this->emit('show-modal', 'show modal!');
    }

    public function Store(Request $request){
        $rules = [
            'name' => 'required|unique:tipo_contratos|min:3'
        ];
        $messages =  [
            'name.required' => 'Nombre requerido',
            'name.unique' => 'ya existe el nombre en el sistema',
            'name.min' => 'el nombre debe tener al menos  3 caracteres'
        ];

        $this->validate($rules, $messages);

        $category = TipoContrato::create([
            'name' => $this->name
        ]);

        //$customFileName;
        if($this->image)
        {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/tipoContrato', $customFileName);

            /*$image = Image::make(Storage::get($this->image));

            $image->resize(1280, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
              });*/


            $category->image = $customFileName;
            $category->save();

           
        }

        $this->resetUI();
        $this->emit('tipocont-added', 'Tipo de Contrato Registrado');
    }

    public function Update(){
        $rules = [
            'name' => "required|min:3|unique:tipo_contratos,name,{$this->selected_id}"
        ];

        $messages = [
            'name.required' => 'Nombre requerido',
            'name.unique' => 'ya existe el nombre en el sistema',
            'name.min' => 'el nombre debe tener al menos  3 caracteres'
        ];
        $this->validate($rules,$messages);

        $category = TipoContrato::find($this->selected_id);
        $category -> update([
            'name' => $this->name
        ]);

        if($this->image){
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/tipoContrato', $customFileName);
            $imageName = $category->image;

            $category->image = $customFileName;
            $category->save();

            if($imageName !=null){
                if(file_exists('storage/tipoContrato') . $imageName){
                    unlink('storage/tipoContrato' . $imageName);
                }
            }
        }

        $this->resetUI();
        $this->emit('tipocont-updated','Categoria Actualizar');
    }

    public function resetUI(){
        $this->name='';
        $this->image=null;
        $this->search='';
        $this->selected_id=0;
    }

    protected $listeners = [
        'deleteRow' => 'Destroy'
    ];

    public function Delete($id){
        $category = TipoContrato::find($id);
        $imageName = $category->image; //imagen temporal
        $category->delete();
        
        if($imageName !=null){
            unlink('storage/tipoContrato/' . $imageName);
        }

        $this->resetUI();
        $this->emit('tipocont-deleted','Categoria Eliminada');
    }
}
