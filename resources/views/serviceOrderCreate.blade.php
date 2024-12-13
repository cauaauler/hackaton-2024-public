<div>
    <x-app-layout>
        <!DOCTYPE html>
        <html lang="pt-br">

        <head>
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
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Criar ordem</title>
        </head>

        <body>
            @if (session('message'))
                <div class="alert alert-success">
                    <h1 class="text-center text-gray-700 dark:text-gray-300 mb-10"> {{ session('message') }}</h1>
                </div>
            @endif

            <div class="section">
                <div>
                    <h1 class="title">Criar ordem de coleta</h1>
                    <form class="form" action="{{ route('serviceOrder.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="box-input">
                            <x-input-label for="descricao" :value="__('Descrição')" />
                            <input type="text" id="descricao" name="descricao" class="form-control" required>
                        </div>

                        <!-- Campos ocultos para latitude e longitude -->
                        <input type="hidden" id="latitude" name="latitude">
                        <input type="hidden" id="longitude" name="longitude">

                        <!-- Checkboxes com campos ocultos -->
                        <div class="form-check">
                            <input type="hidden" name="has_carcaca_animais" value="0">
                            <input type="checkbox" id="has_carcaca_animais" name="has_carcaca_animais" value="1"
                                class="form-check-input">
                            <label for="has_carcaca_animais" class="form-check-label">Carcaças de Animais</label>
                        </div>

                        <div class="form-check">
                            <input type="hidden" name="has_agua_parada" value="0">
                            <input type="checkbox" id="has_agua_parada" name="has_agua_parada" value="1"
                                class="form-check-input">
                            <label for="has_agua_parada" class="form-check-label">Água Parada</label>
                        </div>

                        <div class="form-check">
                            <input type="hidden" name="has_lixo_organico" value="0">
                            <input type="checkbox" id="has_lixo_organico" name="has_lixo_organico" value="1"
                                class="form-check-input">
                            <label for="has_lixo_organico" class="form-check-label">Lixo Orgânico</label>
                        </div>

                        <div class="form-check">
                            <input type="hidden" name="has_produtos_quimicos" value="0">
                            <input type="checkbox" id="has_produtos_quimicos" name="has_produtos_quimicos"
                                value="1" class="form-check-input">
                            <label for="has_produtos_quimicos" class="form-check-label">Produtos Químicos</label>
                        </div>

                        <div class="form-check">
                            <input type="hidden" name="has_vidros" value="0">
                            <input type="checkbox" id="has_vidros" name="has_vidros" value="1"
                                class="form-check-input">
                            <label for="has_vidros" class="form-check-label">Vidros</label>
                        </div>

                        <div class="form-check">
                            <input type="hidden" name="has_materias_reciclaveis" value="0">
                            <input type="checkbox" id="has_materias_reciclaveis" name="has_materias_reciclaveis"
                                value="1" class="form-check-input">
                            <label for="has_materias_reciclaveis" class="form-check-label">Materiais Recicláveis</label>
                        </div>

                        <div class="form-check">
                            <input type="hidden" name="has_residuos_construcao" value="0">
                            <input type="checkbox" id="has_residuos_construcao" name="has_residuos_construcao"
                                value="1" class="form-check-input">
                            <label for="has_residuos_construcao" class="form-check-label">Resíduos de
                                Construção</label>
                        </div>

                        <button type="submit" class="button-confirm">Cadastrar</button>
                    </form>
                </div>
                <div class="map-container">
                    <div id="map"></div>
                </div>
            </div>
        </body>

        </html>
    </x-app-layout>
</div>
<script>
    // Inicializar o mapa
    var map = L.map('map').setView([-29.455988423201006, -51.29417896270753],
        16); // Define a posição inicial e o nível de zoom

    // Adicionar a camada de tiles do OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Adicionar um ouvinte de eventos para cliques no mapa
    map.on('click', function(e) {
        var lat = e.latlng.lat;
        var lng = e.latlng.lng;

        // Preencher os campos ocultos com latitude e longitude
        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;

        // Opcional: Adicionar um marcador no mapa
        L.marker([lat, lng]).addTo(map)
            .bindPopup('Latitude: ' + lat + '<br>Longitude: ' + lng)
            .openPopup();
    });
</script>
