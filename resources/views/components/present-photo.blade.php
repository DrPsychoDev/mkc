<div class="text-center">
    <img src="{{ asset('storage/' . $participant->photo) }}"
         alt="Foto de {{ $participant->name }}"
         class="w-32 h-32 rounded-full mx-auto">
    <p class="mt-2 text-lg font-semibold">{{ $participant->name }}</p>
</div>
