<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>LeafletJS GeoJSON Polyline</title>
    <link href="https://unsorry.net/assets-date/images/favicon.png" rel="shortcut icon" type="image/png" />
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.1/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet-draw@1.0.4/dist/leaflet.draw.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css" />
    <style>
        html,
        body,
        #map {
            height: 100%;
            width: 100%;
            margin: 0px;
            overflow: hidden;
        }
    </style>
</head>

<body>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.1/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/leaflet-draw@1.0.4/dist/leaflet.draw.min.js"></script>
    <!-- Terraformer -->
    <script src="https://cdn.jsdelivr.net/npm/terraformer@1.0.12/terraformer.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/terraformer-wkt-parser@1.2.1/terraformer-wkt-parser.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- MAP -->
    <div id="map"></div>
    <p hidden id="id_feature"></p>

    <p hidden id="id_feature"></p>
    <p hidden id="name_feature"></p>
    <p id="eventStatus">eventStatus</p>

    <!-- Modal Polyline -->
    <div class="modal fade" id="polylineModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel"> <i class="fas fa-info-circle"></i> Polyline </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url('leafletdraw/simpan_edit_polyline') ?>" method="POST">
                        <?= csrf_field() ?>
                        <label for="edit_polyline_name">Nama</label>
                        <input type="hidden" id="id_polyline" name="id_polyline">
                        <input type="text" class="form-control" id="edit_polyline_name" name="edit_polyline_name">
                        <label for="edit_polyline_geometry">Geometry</label>
                        <textarea class="form-control" name="edit_polyline_geometry" id="edit_polyline_geometry" rows="2"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="btn_save_polyline">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        /* Initial Map */
        var map = L.map("map").setView([0.5034539147170272, 101.445717093435], 10);
        /* Tile Basemap */
        var basemap = L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
            attribution: '<a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> | <a href="https://www.unsorry.net" target="_blank">unsorry@2022</a>',
        });
        basemap.addTo(map);


        /* GeoJSON Polyline */
        var polyline = L.geoJson(null, {
            onEachFeature: function(feature, layer) {
                var popupContent = "Nama: " + feature.properties.nama;
                layer.on({
                    mouseover: function(e) {
                        var idPolyline = feature.properties.id;
                        document.getElementById("id_feature").innerHTML = idPolyline;
                        polyline.bindTooltip(feature.properties.nama);
                    },
                });
            },
        });
        $.getJSON("<?= base_url('api/polyline') ?>", function(data) {
            polyline.addData(data);
            map.addLayer(polyline);
        });

        /* Draw Control */
        var drawControl = new L.Control.Draw({
            draw: false,
            edit: {
                featureGroup: polyline,
                edit: true,
                remove: true,
            }
        });
        map.addControl(drawControl);


        /* EDITED Event  */
        map.on(L.Draw.Event.EDITED, function(e) {
            var type = e.layerType;
            var layers = e.layers;

            layers.eachLayer(function(layer) {
                // Convert geometry to GeoJSON 
                var drawnItemJson = layer.toGeoJSON().geometry;
                // Convert GeoJSON to WKT 
                var drawnItemWKT = Terraformer.WKT.convert(drawnItemJson);

                // Set value to edit
                if (layer instanceof L.Polyline) {
                    var idPolyline = document.getElementById("id_feature").innerHTML;
                    var htmlIdPolyline = '<input type="hidden" id="id_polyline" name="id_polyline" value="' + idPolyline + '">';
                    $('#id_polyline').html(htmlIdPolyline);

                    var namaFeature = document.getElementById("name_feature").innerHTML;
                    $('#edit_polyline_name').val(namaFeature);

                    $('#edit_polyline_geometry').html(drawnItemWKT);
                    // Open Modal 
                    $('#polylineModal').modal('show');
                }
            });
        });

        /* DELETED Event  */
        map.on('draw:deletestart', function(e) {
            document.getElementById("eventStatus").innerHTML = "deletestart";
        });

        map.on(L.Draw.Event.DELETED, function(e) {
            var type = e.layerType;
            var layers = e.layers;

            layers.eachLayer(function(layer) {
                var id = layer.feature.properties.id;
                var nama = layer.feature.properties.nama;
                var confirm = window.confirm("Apakah anda yakin ingin menghapus garis: " + nama + "?");
                if (confirm) {
                    // redirect to delete  
                    window.location.href = "<?= base_url('/deletepolyline/') ?>" + "/" + id;
                } else {
                    window.location.href = "<?= base_url('/editpolyline') ?>";
                }
            });

        });
    </script>
</body>

</html>