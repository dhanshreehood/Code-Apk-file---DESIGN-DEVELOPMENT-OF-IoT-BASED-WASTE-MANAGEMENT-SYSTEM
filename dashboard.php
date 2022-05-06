<?php
session_start();
if (!isset($_SESSION['email'])) {
    // echo $_SESSION['email'];
    session_destroy();
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Design & Development of IoT Based Waste Management System</title>
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        #map {
            height: 900px;
            width: 100%;
        }
    </style>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.12.0/build/ol.js"></script>
    <script language="javascript" type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/0.6.1/p5.js"></script>
    <script language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/0.6.1/addons/p5.dom.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/firebasejs/3.6.3/firebase.js"></script>
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.3.1/mapbox-gl.js"></script>
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.3.1/mapbox-gl.css" rel="stylesheet" />
</head>

<body>
    <div class="sidebar">
        <div class="sidebar-brand">
            <h2><span class="lab la-admin"></span><?= $_SESSION['name'] ?></h2>
        </div>
        <div class="sidebar-menu">
            <ul>
                <li>
                    <a href="" class="active"><i class="las la-map"></i>
                        <span>Map</span></a>
                </li>

                <li>
                    <a href="php/logout.php"><i class="las la-sign-out-alt"></i>
                        <span>Log out</span></a>
                </li>
            </ul>
        </div>
    </div>
    <div id="map" class="map-container">
        <script src="js/binlds.js"></script>
        <script>
            var alldatalog = [];
            mapboxgl.accessToken =
                "pk.eyJ1IjoicmFqYXQyMjMiLCJhIjoiY2t6c24xNzU3MGNhNDJvcGtiNmNrNGV3YyJ9.qBE05XHtRC15Y4lVNe6vuQ";

            var map = new mapboxgl.Map({
                container: "map",
                center: [79.08, 21.14],
                zoom: 10,
                style: "mapbox://styles/mapbox/streets-v11",
            });


            let dataLocal = JSON.parse(localStorage.getItem("data"));
            dataLocal.forEach(element => {
                const markerSun = new mapboxgl.Marker().setLngLat([element.logi, element.lati]).addTo(map);
                let ms = markerSun.getElement();
                ms.addEventListener('click', () => {
                    Swal.fire({
                        icon: 'info',
                        html: `
                <table class="table table-striped">
                    <tr>
                        <th>Wet</th>
                        <th>Dry</th>
                    </tr>
                    <tr>
                        <td>` + element.wet + `</td>
                        <td>` + element.dry + `</td>
                    </tr>
                </table>
              `,
                        showCancelButton: false,
                        showCloseButton: false,
                    });
                });
            });
            const markerSun = new mapboxgl.Marker().setLngLat([79.112, 21.099]).addTo(map);
            let ms = markerSun.getElement();
            ms.addEventListener('click', () => {
                Swal.fire({
                    icon: 'info',
                    html: `
                <table class="table table-striped">
                    <tr>
                        <th>Wet</th>
                        <th>Dry</th>
                    </tr>
                    <tr>
                        <td>25</td>
                        <td>5</td>
                    </tr>
                </table>
              `,
                    showCancelButton: false,
                    showCloseButton: false,
                });
            });

            const markerDim = new mapboxgl.Marker().setLngLat([79.236, 21.228]).addTo(map);
            let md = markerDim.getElement();
            md.addEventListener('click', () => {
                Swal.fire({
                    icon: 'info',
                    html: `
                <table class="table table-striped">
                    <tr>
                        <th>Wet</th>
                        <th>Dry</th>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>0</td>
                    </tr>
                </table>
              `,
                    showCancelButton: false,
                    showCloseButton: false,
                });
            });

            const markerDh = new mapboxgl.Marker().setLngLat([79.063, 21.195]).addTo(map);
            let mdh = markerDh.getElement();
            mdh.addEventListener('click', () => {
                Swal.fire({
                    icon: 'info',
                    html: `
                <table class="table table-striped">
                    <tr>
                        <th>Wet</th>
                        <th>Dry</th>
                    </tr>
                    <tr>
                        <td>0</td>
                        <td>15</td>
                    </tr>
                </table>
              `,
                    showCancelButton: false,
                    showCloseButton: false,
                });
            });
        </script>

        
</body>

</html>