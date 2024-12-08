<div>
    @if ($errors->any())
    <div class="w-full">
        <div class="flex p-5 border border-red-200 rounded-lg bg-red-50">
            <div>
                <x-icon
                    name="exclamation-circle"
                    class="w-6 h-6 stroke-red-500" />
            </div>
            <div class="ml-3">
                <h2 class="font-semibold text-red-500">Erros de validação!</h2>
                <ul class="text-sm text-red-500 list-disc list-inside">

                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif
</div>