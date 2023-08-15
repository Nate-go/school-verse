<tr>
    <td class="py-3 px-5 border-b border-blue-gray-50">
        <div class="flex items-center gap-4"><img src="/material-tailwind-dashboard-react/img/logo-xd.svg"
                 class="inline-block relative object-cover object-center w-9 h-9 rounded-md">
            <p class="block antialiased font-sans text-sm leading-normal text-blue-gray-900 font-bold">
                {{$user->username}}</p>
        </div>
    </td>
    <td class="py-3 px-5 border-b border-blue-gray-50">
        <p class="block antialiased font-sans text-xs font-medium text-blue-gray-600">{{$user->email}}</p>
    </td>
    <td class="py-3 px-5 border-b border-blue-gray-50">
        <p class="block antialiased font-sans text-xs font-medium text-blue-gray-600">{{$user->role}}</p>
    </td>
    <td class="py-3 px-5 border-b border-blue-gray-50">
        <p class="block antialiased font-sans text-xs font-medium text-blue-gray-600">{{$user->status}}</p>
    </td>
</tr>
