<div>
    @if ($errors->any())
        <div x-data="{ cardOpen: true }" 
            x-show="cardOpen" 
            x-transition:enter="transition ease-out duration-100" 
            x-transition:enter-start="transform opacity-0 scale-95" 
            x-transition:enter-end="transform opacity-100 scale-100" 
            x-transition:leave="transition ease-in duration-75" 
            x-transition:leave-start="transform opacity-100 scale-100" 
            x-transition:leave-end="transform opacity-0 scale-95" 
            style="display: none;"
            class="flex justify-center items-center my-2 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative origin-top-left" role="alert">
            <div class="text-base font-normal max-w-full flex-initial ml-8">        
                <span class="font-bold">Vaya, parece que algo ha ido mal</span>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li type="circle">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="flex flex-auto flex-row-reverse">
                <div @click="cardOpen = !cardOpen">
                    <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x cursor-pointer hover:text-red-400 rounded-full w-5 h-5 ml-2">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </div>
            </div>
        </div> 
    @endif

    @if (session('success') || session('error'))    
        <div x-data="{ cardOpen: true }" 
            x-show="cardOpen" 
            x-transition:enter="transition ease-out duration-100" 
            x-transition:enter-start="transform opacity-0 scale-95" 
            x-transition:enter-end="transform opacity-100 scale-100" 
            x-transition:leave="transition ease-in duration-75" 
            x-transition:leave-start="transform opacity-100 scale-100" 
            x-transition:leave-end="transform opacity-0 scale-95" 
            style="display: none;"
            class="flex justify-center items-center my-2 font-medium py-1 px-2 bg-white rounded-md text-red'}}-700 bg-{{session('success') ? 'green' : 'red'}}-100 border-b border-{{session('success') ? 'green' : 'red'}}-300 origin-top-left">
            <div slot="avatar">
                <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle w-5 h-5 mx-2">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
            </div>
            <div class="text-base {{session('error') ? 'text-gray-800' : ''}} font-normal  max-w-full flex-initial">        
                @if (session('success'))
                    {!! session('success') !!}
                @else
                    {!! session('error') !!}
                @endif
            </div>
            <div class="flex flex-auto flex-row-reverse">
                <div @click="cardOpen = !cardOpen">
                    <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x cursor-pointer hover:text-{{session('success') ? 'green' : 'red'}}-400 rounded-full w-5 h-5 ml-2">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </div>
            </div>
        </div>   
    @endif
</div>