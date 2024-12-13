<div >
    <x-app-layout class="flex justify-center">
        @foreach ($so as $causer => $items)
        <table class="table table-striped mx-auto text-center flex bg-white">
                <thead>
                    <tr>
                        <th class="m-3">Nome</th>
                        <th class="m-3">Tipo</th>
                        <th class="m-3">Quantidade</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $items->first()->collectedCauser->name }}</td>
                        @if ($items->first()->collectedCauser->is_city_agent)
                            <td>Defesa civil</td>
                        @elseif($items->first()->collectedCauser->is_bussines)
                            <td>Empresa privada</td>
                        @endif
                        <td>{{ count($items) }}</td>
                    </tr>
                </tbody>
            </table>
        @endforeach
    </x-app-layout>
</div>
