<?php

namespace App\Livewire;

use App\Models\Table;
use Livewire\Component;
use Livewire\WithPagination;
use LaravelQRCode\Facades\QRCode;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Storage;

class TablePage extends Component
{
    use WithPagination;

    public $search = '';
    public $modalCreate = false;
    public $modalEdit = false;

    public $editId = '';

    public $number = 0;

    public $qr_code = '';

    public function generateQR(Table $table)
    {
        $code = $table->code;
        // dd($code);
        try {
            QRCode::url(route('welcome', ['code' => $code]))
                ->setOutfile(Storage::disk("public")->path("$code.png"))
                ->setSize(8)
                ->png();
                $table->qr_code = "$code.png";
                $table->save();
            return redirect()->route('table')->with('status', 'QR code generated successfully');
        } catch (\Throwable $th) {
            session()->flash('status', $th->getMessage());
        }
    }
    public function openModalCreate()
    {
        $this->modalCreate = true;
    }

    public function openModalEdit()
    {
        $this->modalEdit = true;
    }

    public function setEdit(Table $table)
    {
        $this->editId = $table->id;
        $this->number = $table->number;
        $this->openModalEdit();
    }

    public function update()
    {
        $this->validate([
            'number' => 'required|numeric',
        ]);
        Table::find($this->editId)->update([
            'number' => $this->number,
        ]);
        $this->closeModal();
        session()->flash('status', 'Table updated successfully');
    }

    public function closeModal()
    {
        $this->reset();
    }

    public function store()
    {
        $this->validate([
            'number' => 'required|numeric',
        ]);
        Table::create([
            'code' => 'T' . random_int(1000, 9999) . rand(1000, 9999) . $this->number,
            'number' => $this->number,
        ]);
        $this->closeModal();
        session()->flash('status', 'Table created successfully');
    }

    public function delete(Table $table)
    {

        $table->delete();
        session()->flash('status', 'Table deleted successfully');
    }
    public function render()
    {
        $tables = Table::query()->where('number', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(5);
        return view('livewire.table-page', compact('tables'));
    }
}
