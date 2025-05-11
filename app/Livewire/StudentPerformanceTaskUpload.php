<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\PerformanceTaskUpload;

class StudentPerformanceTaskUpload extends Component
{
    public function render()
    {
        $performanceTaskuploads = PerformanceTaskUpload::all();
        return view('livewire.student-performance-task-upload', compact('performanceTaskuploads'));
    }
}
