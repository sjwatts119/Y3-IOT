import Echo from 'laravel-echo';
 
import Pusher from 'pusher-js';
window.Pusher = Pusher;
 
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true
});

//add event listener
var channel = window.Echo.channel('realtime_data');
channel.listen('.update', function(data) {

  //fire an event we can listen for
  window.dispatchEvent(new CustomEvent('realtime-data', {detail: data}));
});
