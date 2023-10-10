<div>  
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @livewire('livewire-ui-modal')
    <x-livewire-alert::scripts />
   <script>
        Pusher.logToConsole = true;        
            var pusher = new Pusher('34c5d9a9c46a96a5b6e6', {
                cluster: 'ap1'
            });
            
            var channel = pusher.subscribe('channel-' + {{str(auth()->user()->id)}});
            channel.bind('my-event', function(data) {
                Livewire.emit('realtimeNotifyDisplay', data);
            });
    </script>
</div>

