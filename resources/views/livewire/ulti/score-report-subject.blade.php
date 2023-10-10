<div>
    <h1>Score report for subject</h1>
    <div class='items-center'>
        <img src={{ asset('img/logo-school-verse.png') }} class="w-1/2">
    </div>
    <p>- Date: {{ $data['data'] }}</p>
    <p>- Subject: {{ $data['subjectName'] }}</p>
    <p>- Class: {{ $data['roomName'] }}</p>
    <p>- Teacher: {{ $data['teacherName'] }}</p>
    
    <table class="w-full min-w-[640px] table-autos">
        <thead class="sticky top-0 z-20">
            <tr class='bg-slate-100'>
                <th class="pl-2 border-b border-blue-gray-50 py-3 px-2 text-left">
                    <p class="block antialiased font-sans text-[11px] font-medium uppercase text-blue-gray-400">
                        Student</p>
                </th>
    
                @foreach ($header as $column)
                <th class="border-b border-blue-gray-50 py-3 px-2 text-left -z-50">
                    <p class="block antialiased font-sans text-[11px] font-medium uppercase text-blue-gray-400">
                        {{$column['name']}}</p>
                </th>
                @endforeach
    
                <th class="border-b border-blue-gray-50 py-3 px-2 text-center">
                    <p class="block antialiased font-sans text-[11px] font-medium uppercase text-blue-gray-400 text-center">
                        Final score</p>
                </th>
            </tr>
        </thead>
        <tbody class="overflow-y-auto">
            @php
                $count = 0;
            @endphp
            @foreach ($body as $item)
            <tr class='{{ $count%2 === 1 ? ' bg-slate-100' : '' }} hover:bg-blue-100'>
                <td class="cursor-pointer pl-2 py-3 px-5 border-b border-blue-gray-50">
                    <div class="flex gap-2 items-center">
                        <img class="w-6 h-6 rounded-full"
                            src="{{$item['student']['studentImage'] ?? asset('storage/images/default-image.png')}}">
                        <p class="block antialiased font-sans text-xs font-medium text-blue-gray-600">
                            {{ $item['student']['studentName'] ?? 'null'}}
                        </p>
                    </div>
                </td>
    
                @foreach ($header as $column)
                <td class="py-3 px-5 border-b border-blue-gray-50">
                    @if (empty($item['scores']))
                    <p class="block antialiased font-sans text-xs font-medium text-blue-gray-600">
    
                    </p>
                    @else
                    <div class="flex gap-1">
                        @foreach ($item['scores'] as $score)
                        @if ($score['type'] == $column['value'])
                        <div class="py-1 px-1.5 rounded-md cursor-pointer hover:bg-blue-700 hover:text-white"
                            wire:click='getModal("detail.examdetail", {{json_encode(["examStudentId" => $score["id"], "roomTeacherId" => $itemId])}})'>
                            <p class="block antialiased font-sans text-xs font-medium text-blue-gray-600">
                                {{ $score['score'] }}
                            </p>
                        </div>
                        @endif
                        @endforeach
                    </div>
                    @endif
    
                </td>
                @endforeach
    
                <td class="py-3 px-5 border-b border-blue-gray-50">
                    <p class="block antialiased font-sans text-xs font-medium text-blue-gray-600">
                        {{ $item['totalScore'] }}
                    </p>
                </td>
            </tr>
            @php
                $count += 1;
            @endphp
            @endforeach
        </tbody>
    </table>
</div>
