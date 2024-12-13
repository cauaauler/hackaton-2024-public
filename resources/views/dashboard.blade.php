<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <style>
        main {
            width: 100%;
            color: #ffff;
        }

        .section {}

        .title {
            height: 4em;
            padding: 1em 1em;
            text-align: center;
        }

        .form {
            height: 24em;
            display: flex;
            justify-content: space-between;
            flex-direction: column;
        }

        #map {
            height: 25em;
            width: 100%;
        }

        .map-container {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .button-confirm {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
        }

        .box-input {
            padding: 0.5em 0.5em;

            input {
                width: 100%;
                color: #000;
            }
        }

        @media only screen and (min-width: 1200px) {
            main {
                width: 50%;
                margin: 0 auto;
                height: initial;
            }
        }
    </style>
    @if (session('message'))
        <div class="text-center">
            {{ session('message') }}
        </div>
    @endif
    <div class="map-container">
        <div id="map"></div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                var map = L.map('map').setView([-29.455988423201006, -51.29417896270753], 12);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);

                var serviceOrders = @json($serviceOrders);
                serviceOrders.forEach(function(order) {
                    L.marker([order.latitude, order.longitude])
                        .addTo(map)
                        .bindPopup('<b>Score:</b> ' + order.score + '<br>' +
                            '<b>Descrição:</b> ' + order.description + '<br>'
                        );
                });

                map.invalidateSize();
            }, 2000);
        });
    </script>
    @if (Auth::user()->is_city_agent)
        @if (!$hasOrderPending)
            <h1 class="text-center">Tudo certo por aqui! Sem ordens pendentes</h1>
        @elseif(isset($serviceOrders))
            <h2 class="text-center">Ordens de Serviço</h2>
            <table class="table table-striped table-bordered mx-auto text-center w-100 justify-center b-white">
            <thead>
                    <tr>
                        <th> Score </th>
                        <th> Cidadão </th>
                        <th> Verificado </th>
                        <th> Descrição </th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($serviceOrders as $order)
                        <tr>
                            <td>{{ $order->score }} </td>
                            <td>{{ $order->causer->name }}</td>
                            <td>{{ $order->checked ? 'Sim' : 'Não' }}</td>
                            <td>{{ $order->description }}</td>
                            @if (!$order->checked)
                                <td class="bg-white text-black"><a href="{{ route('serviceOrder.verificar', ['id' => $order->id]) }}">Validar</a>
                                </td>
                            @else
                                <td class="bg-white text-black"><a href="{{ route('serviceOrder.coletar', ['id' => $order->id]) }}">Coletar</a></td>
                            @endif

                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    @elseif(Auth::user()->is_bussines)
        <h2>Ordens de Serviço</h2>
        <div class="container my-4">
    <table class="table table-striped table-bordered mx-auto text-center w-100 justify-center">
        <thead class="table-light">
            <tr>
                <th>Score</th>
                <th>Cidadão</th>
                <th>Descrição</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($serviceOrders as $order)
                <tr>
                    <td>{{ $order->score }}</td>
                    <td>{{ $order->causer->name }}</td>
                    <td>{{ $order->description }}</td>
                    @if ($order->checked && !$order->collected)
                        <td><a href="{{ route('serviceOrder.coletar', ['id' => $order->id]) }}" class="btn btn-primary">Coletar</a></td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

    @else
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white bg-[#4CAF50] overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <a href="{{ route('serviceOrder.create') }}">
                            <h1 class="text-center">Solicitar recolhimento de resíduo</h1>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</x-app-layout>
