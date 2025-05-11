<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ActivityUpload;

class StudentActivityUpload extends Component
{
    public function render()
    {
        $activityuploads = ActivityUpload::all();
        return view('livewire.student-activity-upload', compact('activityuploads'));
    }
}
