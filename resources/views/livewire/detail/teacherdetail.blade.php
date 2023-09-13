<div>
    <div class="p-5 bg-white rounded-2xl flex-col">
        <div class="pb-10">
            <h6 class="block antialiased tracking-normal font-sans text-xl font-semibold leading-relaxed text-blue-gray-900 mb-2">
                Subjects</h6>
            <div class="mt-6 flex overflow-x-auto gap-8 scroll">
                @foreach ($subjects as $subject)
                <div
                    class="relative flex flex-col bg-clip-border rounded-xl bg-transparent text-gray-700 shadow-none min-w-[250px]">
                    <div
                        class="relative bg-clip-border rounded-xl overflow-hidden bg-gray-500 text-white shadow-gray-500/40 shadow-lg mx-0 mt-0 mb-2 h-64 xl:h-40">
                        <img src="{{$subject['imageUrl'] ?? asset('storage/images/default-image.png')}}"
                            class="h-full w-full object-cover">
                    </div>
                    <div class="pt-2 px-2">
                        <h5
                            class="block antialiased tracking-normal font-sans text-base font-semibold leading-snug text-blue-gray-900 mt-1 mb-2">
                            {{$subject['name']}}</h5>
                        {{-- <p class="block antialiased font-sans text-sm leading-normal font-normal text-blue-gray-500">
                            {{$homeroomTeacher}}
                        </p> --}}
                    </div>
                    <div class="p-6 flex items-center justify-between py-0 px-1"><a
                            href="{{ 'teachers/' . $itemId . '/subjects/'. $subject['id']}}">
                            <button
                                class="middle none font-sans font-bold center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none text-xs py-2 px-4 rounded-lg border border-blue-500 text-blue-500 hover:opacity-75 focus:ring focus:ring-blue-200 active:opacity-[0.85]"
                                type="button">view subject</button></a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="pb-10">
            <h6
                class="block antialiased tracking-normal font-sans text-xl font-semibold leading-relaxed text-blue-gray-900 mb-2">
                Homerooms</h6>
            <div class="mt-6 flex overflow-x-auto gap-8 scroll">
                @foreach ($homerooms as $homeroom)
                <div
                    class="relative flex flex-col bg-clip-border rounded-xl bg-transparent text-gray-700 shadow-none min-w-[250px]">
                    <div
                        class="relative bg-clip-border rounded-xl overflow-hidden bg-gray-500 text-white shadow-gray-500/40 shadow-lg mx-0 mt-0 mb-2 h-64 xl:h-40">
                        <img src="{{$homeroom['imageUrl'] ?? asset('storage/images/default-image.png')}}"
                            class="h-full w-full object-cover">
                    </div>
                    <div class="pt-2 px-2">
                        <h5
                            class="block antialiased tracking-normal font-sans text-base font-semibold leading-snug text-blue-gray-900 mt-1 mb-2">
                            {{$homeroom['name']}}</h5>
                    </div>
                    <div class="p-6 flex items-center justify-between py-0 px-1"><a
                            href="{{ 'teachers/' . $itemId . '/homerooms/'. $homeroom['id']}}">
                            <button
                                class="middle none font-sans font-bold center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none text-xs py-2 px-4 rounded-lg border border-blue-500 text-blue-500 hover:opacity-75 focus:ring focus:ring-blue-200 active:opacity-[0.85]"
                                type="button">view homeroom</button></a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
