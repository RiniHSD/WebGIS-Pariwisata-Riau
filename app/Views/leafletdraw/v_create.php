<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>LeafletJS GeoJSON Point</title>
    <link href="https://unsorry.net/assets-date/images/favicon.png" rel="shortcut icon" type="image/png" />
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.1/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet-draw@1.0.4/dist/leaflet.draw.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ font-awesome/5.9.0/css/all.min.css" />
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
    <!-- Modal Point -->
    <div class="modal fade" id="pointModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                        <i class="fas fa-info-circle"></i> Point
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url('leafletdraw/simpan_point') ?>" method="POST">
                        <?= csrf_field() ?>
                        <label for="input_point_name">Nama</label>
                        <input type="text" class="form-control" id="input_point_name" name="input_point_name">
                        <label for="input_point_geometry">Geometry</label>
                        <textarea class="form-control" name="input_point_geometry" id="input_point_geometry" rows="2"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="btn_save_point">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Polyline -->
    <div class="modal fade" id="polylineModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                        <i class="fas fa-info-circle"></i> Polyline
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url('leafletdraw/simpan_polyline') ?>" method="POST">
                        <?= csrf_field() ?>
                        <label for="input_polyline_name">Nama</label>
                        <input type="text" class="form-control" id="input_polyline_name" name="input_polyline_name">
                        <label for="input_polyline_geometry">Geometry</label>
                        <textarea class="form-control" name="input_polyline_geometry" id="input_polyline_geometry" rows="2"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="btn_save_polyline">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Polygon -->
    <div class="modal fade" id="polygonModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                        <i class="fas fa-info-circle"></i> Polygon
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url('leafletdraw/simpan_polygon') ?>" method="POST">
                        <?= csrf_field() ?>
                        <label for="input_polygon_name">Nama</label>
                        <input type="text" class="form-control" id="input_polygon_name" name="input_polygon_name">
                        <label for="input_polygon_geometry">Geometry</label>
                        <textarea class="form-control" name="input_polygon_geometry" id="input_polygon_geometry" rows="2"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="btn_save_polygon">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        /* Initial Map */
        var map = L.map("map").setView([-6.9235299, 107.6474762], 10);
        /* Tile Basemap */
        var basemap = L.tileLayer(
            "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
                attribution: '<a href = "https://www.openstreetmap.org/copyright" > OpenStreetMap < /a> | <a href = "https://www.unsorry.net" target = "_blank" > unsorry @2022 < /a>',
            }
        );
        basemap.addTo(map);
        // draw items
        var drawnItems = new L.FeatureGroup();
        map.addLayer(drawnItems);
        console.log(drawnItems);
        /* Draw Control */
        var drawControl = new L.Control.Draw({
            draw: {
                polygon: true,
                marker: true,
                polyline: true,
                circle: false,
                rectangle: false,
                circlemarker: false,
            },
        });
        map.addControl(drawControl);
        /* Draw Event */
        map.on(L.Draw.Event.CREATED, function(e) {
            var type = e.layerType,
                layer = e.layer;
            // Convert geometry to GeoJSON
            var drawnItemJson = layer.toGeoJSON().geometry;
            // Convert GeoJSON to WKT
            var drawnItemWKT = Terraformer.WKT.convert(drawnItemJson);
            if (type === 'marker') {
                // Set value to input
                $('#input_point_geometry').html(drawnItemWKT);
                // Open Modal
                $('#pointModal').modal('show');
            } else if (type === 'polyline') {
                // Set value to input
                $('#input_polyline_geometry').html(drawnItemWKT);
                // Open Modal
                $('#polylineModal').modal('show');
            } else if (type === 'polygon') {
                // Set value to input
                $('#input_polygon_geometry').html(drawnItemWKT);
                // Open Modal
                $('#polygonModal').modal('show');
            }
            map.addLayer(layer);
        });

        /* GeoJSON Point */
        var point = L.geoJson(null, {
            onEachFeature: function(feature, layer) {
                var popupContent = "Nama: " +
                    feature.properties.nama;
                layer.on({
                    click: function(e) {
                        point.bindPopup(popupContent);
                    },
                    mouseover: function(e) {
                        point.bindTooltip(feature.properties.nama);
                    },
                });
            },
        });
        $.getJSON("<?= base_url('api/point') ?>", function(data) {
            point.addData(data);
            map.addLayer(point);
        });

        /* GeoJSON Polyline */
        var polyline = L.geoJson(null, {
            // Style Line
            style: function(feature) {
                return {
                    color: "#3388ff",
                    weight: 3,
                    opacity: 1,
                };
            },
            onEachFeature: function(feature, layer) {
                var popupContent = "Nama: " + feature.properties.nama + "<br>" +
                    "Panjang:" + feature.properties.panjang + " m";
                layer.on({
                    click: function(e) {
                        polyline.bindPopup(popupContent);
                    },
                    mouseover: function(e) {
                        polyline.bindTooltip(feature.properties.nama);
                    },
                });
            },
        });
        $.getJSON("<?= base_url('api/polyline') ?>", function(data) {
            polyline.addData(data);
            map.addLayer(polyline);
        });

        /* GeoJSON Polygon */
        var polygon = L.geoJson(null, {
            // Style Area
            style: function(feature) {
                return {
                    color: "#3388ff",
                    weight: 3,
                    opacity: 1,
                };
            },
            onEachFeature: function(feature, layer) {
                var popupContent = "Nama: " + feature.properties.nama + "<br>" +
                    "Area :" + feature.properties.area + ' m2';
                layer.on({
                    click: function(e) {
                        polygon.bindPopup(popupContent);
                    },
                    mouseover: function(e) {
                        polygon.bindTooltip(feature.properties.nama);
                    },
                });
            },
        });
        $.getJSON("<?= base_url('api/polygon') ?>", function(data) {
            polygon.addData(data);
            map.addLayer(polygon);
        });
    </script>
</body>

</html>