<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ShowModal extends Component
{
    public $content;
    public $modal_id;
    protected $listeners = ['changeContent' => 'changeContent'];
    public function mount($content,$modal_id){
        $this->content=$content;
        $this->modal_id=$modal_id;
    }
    public function render()
    {
        return view('livewire.show-modal',['content'=>$this->content,'modal_id'=>$this->modal_id]);
    }
    public function changeContent(){
        $this->content='This content is changed';
    }
}
