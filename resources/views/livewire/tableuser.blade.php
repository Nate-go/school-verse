<div
    class="relative flex flex-col bg-clip-border rounded-xl bg-white text-gray-700 shadow-md overflow-hidden xl:col-span-2">
    @if ($actionIsOpen)
        <livewire:useractions/>
    @endif
    <div
        class="relative bg-clip-border rounded-xl overflow-hidden bg-transparent text-gray-700 shadow-none m-0 flex items-center justify-between p-6">
        <div>
            <h6
                class="block antialiased tracking-normal font-sans text-base font-semibold leading-relaxed text-blue-gray-900 mb-1">
                Users</h6>
            <p
                class="antialiased font-sans text-sm leading-normal flex items-center gap-1 font-normal text-blue-gray-600">
                <i class="fa-solid fa-magnifying-glass"></i><strong>{{ $users->lastPage() }}</strong> pages found</p>
        </div>
        <button
            class="hover:bg-slate-100 relative middle none font-sans font-medium text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none w-8 max-w-[32px] h-8 max-h-[32px] rounded-lg text-xs text-blue-gray-500 hover:bg-blue-gray-500/10 active:bg-blue-gray-500/30"
            wire:click='openAction'><i class="fa-solid fa-ellipsis-vertical text-xl"></i>
        </button>
    </div>
    <div class="p-6 overflow-x-scroll px-0 pt-0 pb-2 z-10 flex-col">
        <table class="w-full min-w-[640px] table-auto">
            <thead>
                <tr>
                    <th class="border-b border-blue-gray-50 py-3 px-6 text-left">
                        <p class="block antialiased font-sans text-[11px] font-medium uppercase text-blue-gray-400">
                            companies</p>
                    </th>
                    <th class="border-b border-blue-gray-50 py-3 px-6 text-left">
                        <p class="block antialiased font-sans text-[11px] font-medium uppercase text-blue-gray-400">
                            members</p>
                    </th>
                    <th class="border-b border-blue-gray-50 py-3 px-6 text-left">
                        <p class="block antialiased font-sans text-[11px] font-medium uppercase text-blue-gray-400">
                            budget</p>
                    </th>
                    <th class="border-b border-blue-gray-50 py-3 px-6 text-left">
                        <p class="block antialiased font-sans text-[11px] font-medium uppercase text-blue-gray-400">
                            completion</p>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    @livewire('rowuser', ['user' => $user], key($user->id))
                @endforeach
            </tbody>
        </table>
        {{ $users->links('livewire.pagination') }}
    </div>
</div>