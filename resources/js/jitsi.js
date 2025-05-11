// resources/js/jitsi.js
import JitsiMeetExternalAPI from './jitsi_meet_external_api.js'; // Adjust the path if needed

Livewire.on('open-jitsi-modal', (data) => {
    const { roomName, jwt } = data;
    // ... (Your Jitsi Meet initialization code)
});


import './bootstrap'; // Laravel's default bootstrapping
import.meta.glob([
    '../sass/**',
    '../img/**',
]);
import './jitsi.js'; // Import your Jitsi Meet code