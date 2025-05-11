<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Meeting;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log; // Import the Log facade
use Illuminate\Database\Query\Builder; // Import Query Builder
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

class CurrentlyTakingMeetings extends Component
{
    public $meetings;
    public $roomName;
    public $config = [];
    public $jwt;
    public $courses;
    public $course;

    // For creating meetings
    public $meeting_name;
    public $meeting_description;
    public $meeting_start_time;
    public $selectedCourseId;

    public function mount()
    {
        $this->courses = Course::all();
        $this->config = [
            'openBridgeChannel' => true,
        ];
        $this->jwt = '';
    }

    public function loadMeetings()
    {
        Log::info('loadMeetings() called');

        $query = Meeting::with('course')
            ->where('status', 'scheduled')
            ->where('start_time', '>', now());

        if ($this->course) {
            Log::info('Filtering by course: ' . $this->course);
            $query->where('course_id', $this->course);
        }

        $query->orderBy('start_time');
        $this->meetings = $query->get();
        Log::info('Meetings retrieved:', ['meetings' => $this->meetings->toArray()]);
    }

    public function updatedCourse($value)
    {
        Log::info('updatedCourse() called with value: ' . $value);
        $this->loadMeetings();
    }

    public function joinMeeting($meetingId)
    {
        $meeting = Meeting::findOrFail($meetingId);

        if (!$this->isUserAllowedToJoin($meeting)) {
            session()->flash('error', 'You are not authorized to join this meeting.');
            return;
        }
        $this->roomName = $this->generateRoomName($meeting);

        if (config('jitsi.use_jwt')) {
            $this->jwt = $this->generateJWT(Auth::user(), $meeting);
        }

        $this->dispatch('open-jitsi-modal', [
            'roomName' => $this->roomName,
            'jwt' => $this->jwt,
        ]);
    }

    private function isUserAllowedToJoin(Meeting $meeting): bool
    {
        return true; // Adjust this
    }

    private function generateRoomName(Meeting $meeting): string
    {
        return Str::slug($meeting->title, '-');
    }

    private function generateJWT($user, Meeting $meeting = null): ?string
    {
        if (!config('jitsi.use_jwt')) {
            return null;
        }

        $header = [
            'typ' => 'JWT',
            'alg' => 'HS256',
        ];
        $payload = [
            'iss' => config('jitsi.jwt_issuer'),
            'aud' => 'jitsi',
            'sub' => '*',
            'room' => '*',
            'exp' => time() + config('jitsi.jwt_expiration'),
            'context' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'avatar' => '',
                    'email' => $user->email,
                ],
            ],
        ];
        if ($meeting) {
            $payload['context']['meeting'] = [
                'id' => $meeting->id,
            ];
        }

        $header_encoded = base64url_encode(json_encode($header));
        $payload_encoded = base64url_encode(json_encode($payload));

        $data = $header_encoded . '.' . $signature_encoded;

        $signature = hash_hmac('sha256', $data, config('jitsi.jwt_secret'), true);
        $signature_encoded = base64url_encode($signature);

        return $data . '.' . $signature_encoded;
    }

    public function submit()
    {
        $this->validate([
            'meeting_name' => 'required|string',
            'meeting_description' => 'required|string',
            'meeting_start_time' => 'required|date',
            'selectedCourseId' => 'required|exists:courses,id',
        ]);

        Meeting::create([
            'title' => $this->meeting_name,
            'description' => $this->meeting_description,
            'start_time' => $this->meeting_start_time,
            'user_id' => Auth::id(),
            'course_id' => $this->selectedCourseId,
            'room_name' => Str::slug($this->meeting_name, '-'),
        ]);

        session()->flash('message', 'Meeting created successfully!');
        $this->reset(['meeting_name', 'meeting_description', 'meeting_start_time', 'selectedCourseId']);
        $this->dispatch('close-modal', name: 'create-meeting');
        $this->loadMeetings();
    }

    public function render(): View
    {
        Log::info('render() called');

        try {
            // Attempt to fetch meetings directly
            $this->meetings = Meeting::all();

            // Check if the collection is valid.
            if (!$this->meetings instanceof Collection) {
                Log::error('Meetings is not a Collection.  It is: ' . get_class($this->meetings));
                $this->meetings = collect(); // Ensure $this->meetings is always a Collection
            }

             if ($this->meetings->isEmpty()) {
                Log::warning('No meetings found in the database.');
             }

             // Dump the meetings

            return view('livewire.currently-taking-meetings', [
                'meetings' => $this->meetings,
                'courses' => $this->courses,
            ]);
        } catch (\Exception $e) {
            // Catch any exceptions during the query
            Log::error('Error fetching meetings: ' . $e->getMessage());
            $this->meetings = collect(); // Set to empty Collection to avoid errors in view
            return view('livewire.currently-taking-meetings', [
                'meetings' => $this->meetings,
                'courses' => $this->courses,
            ]);
        }
    }

    function base64url_encode($data): string
    {
        return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($data));
    }
}
