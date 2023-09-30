<div>  
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Livewire.on('hideModal',(modalId)=>{
           $('#' + modalId).modal('hide');
        });
    </script>
    @livewire('livewire-ui-modal')
    <x-livewire-alert::scripts />
</div>
