<div class="flex justify-center">
    <img class="rounded-full " src="{{ asset($getRecord()->participant->photo) }}" alt="Foto do Participante" style="max-height: 200px;">
</div>
<div class="p-2 text-xs text-center">
    {{$getRecord()->participant->name}}
</div>
<div class="p-2 text-justify">
    {{$getRecord()->question->question}}
</div>
<div class="p-2 text-justify text-xs">
    Memória Descritiva: {{$getRecord()->question->memory}}
</div>
