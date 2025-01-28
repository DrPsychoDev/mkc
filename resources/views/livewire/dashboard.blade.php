<div class="mx-auto p-2 h-screen" wire:poll.1s="loadDivisions">
    <div class="grid grid-cols-4 grid-rows-2 gap-2 h-full">
        @foreach($divisions as $division)
            <div class="flex flex-col justify-between bg-white/10 shadow-lg rounded-lg border-2 border-gray-600 p-2 h-full">
                <h3 class="text-2xl font-bold text-gray-300 text-left px-4 mb-2 border-b-2 border-gray-400 pb-2">
                    {{ $division->name }}
                </h3>

                <div class="grid grid-cols-1 gap-2 w-full">
                    @foreach($division->participants->where('total_evaluation','>',0)->sortByDesc('total_evaluation')->take(9) as $participant)
                        <div class="bg-white/20 flex items-center space-x-4 p-1 rounded-lg border border-gray-400">
                            <div class="flex ms-0 me-2">
                                <img src="{{ $participant->school->photo}}" alt="Foto" class="w-10 h-10 rounded-full border border-gray-500">
                                <img src="{{ $participant->photo}}" alt="Foto" class="w-10 h-10 rounded-full border border-gray-500">
                            </div>
                            <div   class="flex justify-between w-full">
                                <div class="">
                                    <p class="text-md font-semibold text-gray-200">{{ $participant->short_name }}</p>
                                    <p class="text-xs font-semibold text-gray-300">{{$participant->school->name}}</p>
                                </div>
                                <div class="flex items-center me-2">
                                    <div class="flex gap-2 items-center text-white">
                                        <div class="{{$participant->status>1?'text-amber-400':'text-gray-400'}} ">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 0 1 3 3h-15a3 3 0 0 1 3-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 0 1-.982-3.172M9.497 14.25a7.454 7.454 0 0 0 .981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 0 0 7.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M7.73 9.728a6.726 6.726 0 0 0 2.748 1.35m8.272-6.842V4.5c0 2.108-.966 3.99-2.48 5.228m2.48-5.492a46.32 46.32 0 0 1 2.916.52 6.003 6.003 0 0 1-5.395 4.972m0 0a6.726 6.726 0 0 1-2.749 1.35m0 0a6.772 6.772 0 0 1-3.044 0" />
                                    </svg>
                                        </div>
                                        <span class="text-2xl">{{$participant->total_evaluation}}</span>
                                        <span class="text-sm font-bold text-gray-800">pts</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
            <div class="flex flex-col justify-between bg-white/5 shadow-lg rounded-lg p-2 h-full">

                <div class="w-full h-full flex items-center justify-center flex-col ">
                    <img src="{{ asset('images/logo.png') }}" alt="MKC Logo" class="max-w-full max-h-full object-contain p-4">
                </div>
                <h3 class="text-4xl font-bold text-gray-400 text-center mb-1 border-t-2 border-white pt-2">
                    TOP 8
                </h3>
                <video class="fixed top-0 left-0 w-full h-full object-fill z-[-1]" autoplay loop muted playsinline>
                    <source src="{{asset('assets/video/smoke.mp4')}}" type="video/mp4">
                    ESTE NAVEGADOR NÃO SUPORTA O ELEMENTO DE VIDEO
                </video>
                </div>
            </div>
    </div>
</div>
