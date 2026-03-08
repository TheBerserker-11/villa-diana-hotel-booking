@extends('layouts.app')

@section('content')

<section class="event-show-hero">
    <div class="overlay"></div>
    <div class="container text-center text-white position-relative">
        <h1 class="display-4 fw-bold">{{ $event->title }}</h1>
        <p class="lead">
            {{ $event->event_date }} • {{ $event->location }}
        </p>
    </div>
</section>

<div class="container py-5">

    <div class="row g-4 mb-5">
        @foreach($event->images as $img)
            <div class="col-md-4">
                <img
                    src="{{ asset('storage/events/' . $img->image) }}"
                    class="event-gallery-img"
                    onclick="openModal(this.src)"
                    alt="Event image">
            </div>
        @endforeach
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="event-info-card">
                <h2 class="mb-3">About this Event</h2>
                <p class="text-muted">{{ $event->description }}</p>

                <div class="text-center mt-4">
                    <a href="{{ route('contact') }}" class="btn btn-warning btn-lg px-5">
                        Inquire About This Event
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center mt-5">
        <a href="{{ route('events.index') }}" class="btn btn-outline-dark">
            ← Back to Events
        </a>
    </div>

</div>

<div id="imgModal" class="img-modal">
    <span class="close-modal">&times;</span>
    <img id="modalImg" alt="Modal image">
</div>

@endsection

@push('scripts')
<style>
.event-show-hero{
    height: 45vh;
    background: linear-gradient(rgba(0,0,0,.6),rgba(0,0,0,.6)),
        url('{{ asset('events/weddings/1.jpg') }}') center/cover no-repeat;
    display:flex;
    align-items:center;
}

.event-gallery-img{
    width:100%;
    height:260px;
    object-fit:cover;
    border-radius:15px;
    cursor:pointer;
    transition:.3s;
}
.event-gallery-img:hover{ transform:scale(1.04); }

.event-info-card{
    background:#fff;
    padding:40px;
    border-radius:20px;
    box-shadow:0 10px 30px rgba(0,0,0,.08);
}

.img-modal{
    display:none;
    position:fixed;
    inset:0;
    background:rgba(0,0,0,.9);
    justify-content:center;
    align-items:center;
    z-index:9999;
}
.img-modal img{
    max-width:90%;
    max-height:90%;
    border-radius:10px;
}
.close-modal{
    position:absolute;
    top:20px;
    right:30px;
    color:white;
    font-size:35px;
    cursor:pointer;
}
</style>

<script>
function openModal(src){
    const modal = document.getElementById('imgModal');
    const img = document.getElementById('modalImg');
    modal.style.display='flex';
    img.src = src;
}
document.addEventListener('DOMContentLoaded', () => {
    const close = document.querySelector('.close-modal');
    if(close){
        close.onclick = () => document.getElementById('imgModal').style.display='none';
    }
});
</script>
@endpush