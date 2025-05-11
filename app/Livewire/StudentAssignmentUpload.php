<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\AssignmentUpload;

class StudentAssignmentUpload extends Component
{
    
    public function render()
    {
        $assignmentuploads = AssignmentUpload::all();
        return view('livewire.student-assignment-upload', compact('assignmentuploads'));
    }
}
