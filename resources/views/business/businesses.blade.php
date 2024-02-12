<div>

    @if($addBusiness)
    @include('livewire.business.business-setup')
    @elseif($updateBusiness)
    @include('livewire.business.update')
    @else
    @include('livewire.business.all-businesses')
    @endif

</div>