<div class="flex flex-col h-full">
    <div
        class="-m-1.5 overflow-x-auto  overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-track]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:rounded-full  [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-slate-700 dark:[&::-webkit-scrollbar-thumb]:bg-slate-500">
        <div class="p-1.5 min-w-full inline-block align-middle">
            <div class="overflow-hidden border border-gray-300 rounded-lg dark:border-gray-700">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50 dark:bg-gray-700 ">
                        <tr class="uppercase">
                            {{ $headerColumns }}
                        </tr>
                    </thead>

                    <tbody
                        class="bg-white divide-y divide-gray-200  dark:bg-gray-900 dark:divide-gray-700">
                        {{ $dataRows }}
                    </tbody>

                    @if ($footer)
                    {{ $footer }}
                    @endif
                </table>
            </div>
        </div>
    </div>
</div>