<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Notifications\CategoryAdded;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;


class CategoryComponent extends Component
{
    use WithPagination, WithFileUploads;
    protected $paginationTheme = 'bootstrap';

    //inputs
    public $category_id, $name, $photo, $photo_name;
    //search
    public $search_name, $search_from_date, $search_to_date;


    
    public function rules()
    {
        return [
            'name'  => 'required|string|unique:categories,name,'.$this->category_id,
            'photo' => 'nullable|file|image|max:1024|mimes:png,jpg,jpeg',
        ];
    }

    public function updated($inputs)
    {
        $this->validateOnly($inputs);
    }

    public function resetInputs()
    {
        $this->name             = '';
        $this->photo            = '';
        $this->category_id      = '';
        $this->photo_name       = '';
        $this->search_name      = '';
        $this->search_from_date = '';
        $this->search_to_date   = '';
    }

    public function closeModal()
    {
        $this->resetInputs();
    }



    public function render(Request $request)
    {
        $data = Category::orderBy('id', 'DESC')
        ->when($this->search_name != null,function ($q) use($request){
            return $q->where('name','like','%'.$this->search_name.'%');
        })
        ->when($this->search_from_date != null,function ($q) use($request){
            return $q->whereDate('created_at','>=',$this->search_from_date);
        })
        ->when($this->search_to_date != null,function ($q) use($request){
            return $q->whereDate('created_at','<=',$this->search_to_date);
        })
        ->paginate(10);
        return view('livewire.category.index', ['data' => $data]);
    }



    public function storeData()
    {
        $validator = $this->validate();
        //upload image
        if ($this->photo) {
            $this->photo_name = md5($this->photo.microtime()). '.' .$this->photo->extension();
            $this->photo->storeAs('/category',$this->photo_name,'attachments');
        }
        //save data
        $date = Category::create([
            'name'  => $this->name,
            'photo' => $this->photo ? $this->photo_name : null,
        ]);
        //send notification
        $users = User::where('id', '!=', Auth::user()->id)->select('id','name')->get();
        Notification::send($users, new CategoryAdded($date->id));
        $this->resetInputs();
        $this->dispatchBrowserEvent('closeModal');
        session()->flash('success');
    }



    public function editData(int $category_id)
    {
        $data = Category::find($category_id);
        if($data) {
            $this->category_id = $data->id;
            $this->name        = $data->name;
            $this->photo       = $data->photo;
            $this->photo_name  = $data->photo;
        } else {
            return redirect()->back();
        }
    }



    public function updateData()
    {
        $validator = $this->validate();
        $category = Category::find($this->category_id);
        //upload photo
        if ($this->photo) {
            //remove old photo
            Storage::disk('attachments')->delete('category/' . $category->photo);
            $this->photo_name = md5($this->photo.microtime()). '.' .$this->photo->extension();
            $this->photo->storeAs('/category',$this->photo_name,'attachments');
        }
        $data = $category->update([
            'name'  => $this->name,
            'photo' => $this->photo ? $this->photo_name : $category->photo,
        ]);
        $this->resetInputs();
        $this->dispatchBrowserEvent('closeModal');
        session()->flash('message','تم التعديل بنجاح');
    }



    public function deleteData(int $category_id)
    {
        $this->category_id = $category_id;
    }



    public function destroyData()
    {
        // $related_table = RelatedTable::where('category_id', $this->category_id)->pluck('category_id');
        // if($related_table->count() == 0) { 
            $category = Category::find($this->category_id);
            //remove old photo
            Storage::disk('attachments')->delete('category/' . $category->photo);
            $data = $category->delete();
            $this->resetInputs();
            $this->dispatchBrowserEvent('closeModal');
            session()->flash('success');
        // } else {
        //     session()->flash('canNotDeleted');
        //     return redirect()->back();
        // }
    }
}
