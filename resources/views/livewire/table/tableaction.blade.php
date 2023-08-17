<ul
    {{dd($filterForm)}}
    class="w-fit absolute top-14 right-14 bg-white min-w-[180px] p-3 border border-blue-gray-50 rounded-md shadow-lg shadow-blue-gray-500/10 font-sans text-sm font-normal text-blue-gray-500 overflow-auto focus:outline-none z-[999]">
    <li 
        class="hover:bg-slate-100 block w-full pt-[9px] pb-2 px-3 rounded-md text-start leading-tight cursor-pointer select-none transition-all hover:bg-blue-gray-50 hover:bg-opacity-80 focus:bg-blue-gray-50 focus:bg-opacity-80 active:bg-blue-gray-50 active:bg-opacity-80 hover:text-blue-gray-900 focus:text-blue-gray-900 active:text-blue-gray-900">
        <i class="fa-solid fa-square-check pr-2"></i>Seclect all</li>
    <li 
        class="hover:bg-slate-100 block w-full pt-[9px] pb-2 px-3 rounded-md text-start leading-tight cursor-pointer select-none transition-all hover:bg-blue-gray-50 hover:bg-opacity-80 focus:bg-blue-gray-50 focus:bg-opacity-80 active:bg-blue-gray-50 active:bg-opacity-80 hover:text-blue-gray-900 focus:text-blue-gray-900 active:text-blue-gray-900">
        <i class="fa-solid fa-trash pr-2"></i>Detele ()</li>
    <li 
        class="flex-col justify-between w-full pt-[9px] px-2 rounded-md text-start leading-tight transition-all bg-slate-100">
        <p class='text-center antialiased pb-1'>Filter form</p>
        <ul class='flex-col'>
            <li class='py-1'>
                <p>Sort _ by _ </p>
            </li>
            <li class='py-1'>
                <p>Row per Page: </p>
            </li>
            <li>
                <ul>
                    <li class='py-1'>
                        <p class='text-bold pb-1 text-center'>Constant1</p>
                        <ul class="grid grid-cols-2 gap-2">
                            <li class='flex items-center'>
                                <input type="checkbox" checked="checked" class="checkbox checkbox-info" />
                                <p class='pl-1'>element1111</p>
                            </li>
                            <li class='flex items-center'>
                                <input type="checkbox" checked="checked" class="checkbox checkbox-info" />
                                <p class='pl-1'>element1111</p>
                            </li>
                            <li class='flex items-center'>
                                <input type="checkbox" checked="checked" class="checkbox checkbox-info" />
                                <p class='pl-1'>element1111</p>
                            </li>
                        </ul>        
                    </li>
                    <li class='py-1'>
                        <p class='text-bold pb-1 text-center'>Constant2</p>
                        <ul class="grid grid-cols-2 gap-2">
                            <li class='flex items-center'>
                                <input type="checkbox" checked="checked" class="checkbox checkbox-info" />
                                <p class='pl-1'>element1111</p>
                            </li>
                            <li class='flex items-center'>
                                <input type="checkbox" checked="checked" class="checkbox checkbox-info" />
                                <p class='pl-1'>element1111</p>
                            </li>
                            <li class='flex items-center'>
                                <input type="checkbox" checked="checked" class="checkbox checkbox-info" />
                                <p class='pl-1'>element1111</p>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
        </ul>
    </li>
</ul>
