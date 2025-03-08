<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage Fundraisers') }}
            </h2>
        </div>
    </x-slot>

    @role('owner')
    <div class="list-fundraisers py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-10 flex flex-col gap-y-5">
                @forelse($fundraisers as $fundraiser)
                    <div class="item-card flex flex-row justify-between items-center">
                        <div class="flex flex-row items-center gap-x-3">
                            @if($fundraiser->user)
                                <img src="{{ Storage::url($fundraiser->user->avatar) }}" 
                                     alt="" 
                                     class="rounded-2xl object-cover w-[90px] h-[90px]">
                            @endif
                            <div class="flex flex-col">
                                <h3 class="text-indigo-950 text-xl font-bold">{{ $fundraiser->user->name ?? 'Unknown' }}</h3>
                            </div>
                        </div> 
                        <div class="hidden md:flex flex-col">
                            <p class="text-slate-500 text-sm">Date</p>
                            <h3 class="text-indigo-950 text-xl font-bold">{{ $fundraiser->created_at->format('d M Y') }}</h3>
                        </div>

                     
                        <span class="w-fit text-sm font-bold py-2 px-3 rounded-full 
                                    {{ $fundraiser->is_active ? 'bg-green-500' : 'bg-orange-500' }} text-white">
                            {{ $fundraiser->is_active ? 'ACTIVE' : 'PENDING' }}
                        </span>           
                
                        @if(!$fundraiser->is_active)
                        <div class="hidden md:flex flex-row items-center gap-x-3">
                            <form action="{{route('admin.fundraisers.update',$fundraiser)}}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="font-bold py-4 px-6 bg-indigo-700 text-white rounded-full">
                                    Approve
                                </button>
                            </form>
                        </div>
                    @endif
                    
                        <div class="hidden md:flex flex-row items-center gap-x-3">
                            <form action="" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="font-bold py-4 px-6 bg-red-700 text-white rounded-full">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                @empty 
                    <p>Belum ada Apply Terbaru</p>
                @endforelse
            </div>
        </div>
    </div>
    @endrole

    <div class="list-fundraisers py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-10 flex flex-col text-center">
                <div class="flex flex-col justify-center items-center gap-y-5">
                    <svg width="80" height="80" viewBox="0 0 24 24" fill="none">
                        <path opacity="0.4" d="M19 9C19 10.45 18.57 11.78 17.83 12.89C16.75 14.49 15.04 15.62 13.05 15.91C12.71 15.97 12.36 16 12 16C11.64 16 11.29 15.97 10.95 15.91C8.96 15.62 7.25 14.49 6.17 12.89C5.43 11.78 5 10.45 5 9C5 5.13 8.13 2 12 2C15.87 2 19 5.13 19 9Z" fill="#292D32"/>
                        <path d="M21.2491 18.4699L19.5991 18.8599C19.2291 18.9499 18.9391 19.2299 18.8591 19.5999L18.5091 21.0699C18.3191 21.8699 17.2991 22.1099 16.7691 21.4799L11.9991 15.9999L7.2291 21.4899C6.6991 22.1199 5.6791 21.8799 5.4891 21.0799L5.1391 19.6099C5.0491 19.2399 4.7591 18.9499 4.3991 18.8699L2.7491 18.4799C1.9891 18.2999 1.7191 17.3499 2.2691 16.7999L6.1691 12.8999C7.2491 14.4999 8.9591 15.6299 10.9491 15.9199C11.2891 15.9799 11.6391 16.0099 11.9991 16.0099C12.3591 16.0099 12.7091 15.9799 13.0491 15.9199C15.0391 15.6299 16.7491 14.4999 17.8291 12.8999L21.7291 16.7999C22.2791 17.3399 22.0091 18.2899 21.2491 18.4699Z" fill="#292D32"/>
                    </svg>
                    <h3 class="text-indigo-950 text-xl font-bold">Tebarkan Kebaikan</h3>
                    <p class="text-slate-500 text-base">Jadilah bagian dari kami untuk membantu mereka yang membutuhkan dana tambahan</p>

                    @if ($fundraiserStatus == 'Pending')
                        <span class="w-fit text-sm font-bold py-2 px-3 rounded-full bg-orange-500 text-white">PENDING</span> 
                    @elseif ($fundraiserStatus == 'Active')
                        <a href="{{route('admin.fundraisings.create')}}" class="font-bold py-4 px-6 bg-indigo-700 text-white rounded-full">
                            Create a fundraising
                        </a>
                    @else 
                        <form action="{{ route('admin.fundraiser.apply') }}" method="POST">
                            @csrf
                            <button type="submit" class="font-bold py-4 px-6 bg-indigo-700 text-white rounded-full">
                                Become Fundraiser
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
