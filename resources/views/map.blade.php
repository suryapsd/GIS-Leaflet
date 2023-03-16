<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('earth-grid.png') }}"/>
    <link rel="icon" type="image/png" href="{{ asset('earth-grid.png') }}" />

    <title>GIS | Leaflet</title>

    <!-- Boostrap CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
      crossorigin="anonymous"
    />

    <!-- Leaflet -->
    <link
      rel="stylesheet"
      href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
      integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI="
      crossorigin=""
    />
    <script
      src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
      integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM="
      crossorigin=""
    ></script>

    <!--JQuery -->
    <script
      src="https://code.jquery.com/jquery-3.6.4.min.js"
      integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8="
      crossorigin="anonymous"
    ></script>

    <!-- Boostrap Icon -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css"
      integrity="sha384-b6lVK+yci+bfDmaY1u0zE8YYJt0TZxLEAFyYSLHId4xoVvsrQu3INevFKo+Xir8e"
      crossorigin="anonymous"
    />

    <style>
      /* Style untuk crop image */
      .cropped-image {
        width: 100%;
        height: 150px;
        object-fit: cover;
      }
    </style>
  </head>
  <body>
    <h3 class="py-2 text-xl font-medium mx-auto container"><i class="bi bi-geo-alt"></i>&nbsp;GIS | Leaflet</h3>
    @if (\Session::has('success'))
      <div class="container">
        <div class="alert alert-primary" role="alert">
          {!! \Session::get('success') !!}
        </div>
      </div>
    @endif @if (\Session::has('error'))
      <div class="container">
        <div class="alert alert-danger" role="alert">
          {!! \Session::get('error') !!}
        </div>
      </div>
    @endif
    <div class="container mx-auto">
      <div
        class="w-full border border-2 border-primary"
        style="border-radius: 1rem"
      >
        <div
          class="m-2 rounded-2xl"
          id="map"
          style="height: 500px; border-radius: 1rem"
        ></div>
      </div>
    </div>

    <!-- Modal create -->
    <div
      class="modal fade"
      id="modalCreate"
      data-bs-backdrop="static"
      data-bs-keyboard="false"
      tabindex="-1"
      aria-labelledby="staticBackdropLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">
              Add Data to Maps
            </h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <form action="/map" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
              <div class="mb-1">
                <label for="image" class="form-label">Image</label>
                <input
                  class="form-control form-control-sm @error('image') is-invalid @enderror"
                  id="image"
                  name="image"
                  type="file"
                />
                @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="mb-1">
                <label for="name" class="col-form-label">Name</label>
                <input
                  type="text"
                  class="form-control form-control-sm @error('name') is-invalid @enderror"
                  id="name"
                  name="name"
                  placeholder="Jhon Doe"
                  required
                  autofocus
                />
                @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="mb-1">
                <label for="telepon" class="col-form-label">Telepon</label>
                <input
                  type="text"
                  class="form-control form-control-sm @error('telepon') is-invalid @enderror"
                  id="telepon"
                  name="telepon"
                  placeholder="08xxxxxxxxxx"
                  required
                />
                @error('telepon')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="mb-1">
                <label for="address" class="col-form-label">Address</label>
                <textarea
                  class="form-control form-control-sm @error('address') is-invalid @enderror"
                  id="address"
                  name="address"
                  placeholder="Input your address"
                  required
                ></textarea>
                @error('address')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="row">
                <div class="col mb-1">
                  <label for="latitude" class="col-form-label">Latitude</label>
                  <input
                    type="text"
                    class="form-control form-control-sm"
                    id="latitude"
                    name="latitude"
                    readonly
                  />
                </div>
                <div class="col mb-1">
                  <label for="longtitude" class="col-form-label"
                    >Longtitude</label
                  >
                  <input
                    type="text"
                    class="form-control form-control-sm"
                    id="longitude"
                    name="longitude"
                    readonly
                  />
                </div>
              </div>
            </div>
            <div class="modal-footer mt-3">
              <button
                type="button"
                class="btn btn-secondary"
                data-bs-dismiss="modal"
              >
                Close
              </button>
              <button type="submit" class="btn btn-primary">Save</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Modal update -->
    <div
      class="modal fade"
      id="modalUpdate"
      data-bs-backdrop="static"
      data-bs-keyboard="false"
      tabindex="-1"
      aria-labelledby="staticBackdropLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">
              Update Data Maps
            </h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <form
            id="formUpdate"
            action="/map/"
            method="post"
            enctype="multipart/form-data"
          >
            @method('put') @csrf
            <div class="modal-body">
              <div class="mb-1">
                <label for="image" class="form-label">Image</label>
                <input
                  class="form-control form-control-sm @error('image') is-invalid @enderror"
                  id="files"
                  name="mimage"
                  type="file"
                />
                @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="mb-1">
                <label for="name" class="col-form-label">Name</label>
                <input
                  type="text"
                  class="form-control form-control-sm @error('name') is-invalid @enderror"
                  id="mname"
                  name="mname"
                  placeholder="Jhon Doe"
                  required
                  autofocus
                />
                @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="mb-1">
                <label for="telepon" class="col-form-label">Telepon</label>
                <input
                  type="text"
                  class="form-control form-control-sm @error('telepon') is-invalid @enderror"
                  id="mtelepon"
                  name="mtelepon"
                  placeholder="08xxxxxxxxxx"
                  required
                />
                @error('telepon')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="mb-1">
                <label for="address" class="col-form-label">Address</label>
                <textarea
                  class="form-control form-control-sm @error('address') is-invalid @enderror"
                  id="maddress"
                  name="maddress"
                  placeholder="Input your address"
                  required
                ></textarea>
                @error('address')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="row">
                <div class="col mb-1">
                  <label for="latitude" class="col-form-label">Latitude</label>
                  <input
                    type="text"
                    class="form-control form-control-sm"
                    id="mlatitude"
                    name="mlatitude"
                    value=""
                    readonly
                  />
                </div>
                <div class="col mb-1">
                  <label for="longtitude" class="col-form-label"
                    >Longtitude</label
                  >
                  <input
                    type="text"
                    class="form-control form-control-sm"
                    id="mlongitude"
                    name="mlongitude"
                    readonly
                  />
                </div>
              </div>
            </div>
            <div class="modal-footer mt-3">
              <button
                type="button"
                class="btn btn-secondary"
                data-bs-dismiss="modal"
              >
                Close
              </button>
              <button type="submit" class="btn btn-primary">Save Update</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
      crossorigin="anonymous"
    ></script>

    <!-- Leaflet -->
    <script>

      var peta1 = L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
      	attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
      		'<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
      		'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
      	id: 'mapbox/streets-v11'
      });

      var peta2 = L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
          '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
          'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        id: 'mapbox/satellite-v9'
      });


      var peta3 = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
      });

      var peta4 = L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
          '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
          'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        id: 'mapbox/dark-v10'
      });

      //var map = L.map('map').setView([-8.537304773847266, 115.12583771558118], 13)
      var map = L.map('map', {
        center: [-8.537304773847266, 115.12583771558118],
        zoom: 13,
        layers: [peta1]
      });
      
      if (navigator.geolocation) {
      const location = navigator.geolocation.getCurrentPosition(
        (position) => {
          map.setView(
            [position.coords.latitude, position.coords.longitude],
            13
          )
        }
      )} else {
        alert('Geolocation is not supported by this browser.')
      }

      var baseMaps = {
        "Grayscale": peta1,
        "Satellite": peta2,
        "Streets": peta3,
        "Dark": peta4,
      };

      L.control.layers(baseMaps).addTo(map);
      map.attributionControl.setPrefix(false);

      var markerIcon = L.icon({
        iconUrl: "map-marker.png",
        iconSize: [30, 30], // size of the icon
        popupAnchor: [0, -30], // point from which the popup should open relative to the iconAnchor
      });

      function openModal(id, img, nm, tlp, ads, lt, ln) {
        document.getElementById("formUpdate").action += id;
        const fileInput = document.getElementById("files");
        const mname = document.getElementById("mname");
        const mtelepon = document.getElementById("mtelepon");
        const maddress = document.getElementById("maddress");
        const mlatitude = document.getElementById("mlatitude");
        const mlongitude = document.getElementById("mlongitude");

        console.log(fileInput.files instanceof FileList); // true even if empty

        for (const file of fileInput.files) {
          console.log(file.name); // prints file name
          let fileDate = new Date(file.lastModified);
          console.log(fileDate.toLocaleDateString()); // prints legible date
          console.log(
            file.size < 1000 ? file.size : Math.round(file.size / 1000) + "KB"
          );
          console.log(file.type); // prints MIME type
        }

        mname.value = nm;
        mtelepon.value = tlp;
        maddress.value = ads;
        mlatitude.value = lt;
        mlongitude.value = ln;
        $("#modalUpdate").modal("show");
        $(".navbar-collapse.in").collapse("hide");
      }

      @foreach ($spaces as $item)
        L.marker([{{ $item->latitude }},{{ $item->longitude }}], {icon: markerIcon,})
          .bindPopup(
          `
            <div class="" style="width: 18rem;">
              <img src="/uploads/imgCover/{{ $item->image }}" class="card-img-top mt-2 cropped-image" alt="...">
              <h6 class="pt-3 pb-1">{{$item->name}}</h6>
              <div class="border-top border-bottom">
                <table class="table table-borderless my-1">
                  <tbody>
                    <tr>
                      <th width="10px"><i class="bi bi-telephone" style="color: rgb(59 130 246);"></i></th>
                      <td>{{$item->telepon}}</td>
                    </tr>
                    <tr>
                      <th width="10px"><i class="bi bi-geo-alt"  style="color: rgb(59 130 246);"></i></th>
                      <td>{{$item->address}}, {{$item->latitude}}, {{$item->longitude}}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <button type="button" class="btn btn-outline-primary btn-sm mt-3 mb-2" onClick="openModal('{{$item->id}}', '{{$item->image}}', '{{$item->name}}', '{{$item->telepon}}', '{{$item->address}}', '{{$item->latitude}}', '{{$item->longitude}}')">
                Edit
              </button>
            </div>
          `
        ).addTo(map);
      @endforeach


      var marker;

      var latitude = document.getElementById("latitude");
      var longitude = document.getElementById("longitude");
      function onMapClick(e) {
        marker = new L.marker(e.latlng, {
          icon: markerIcon,
        }).addTo(map);
        var lat = e.latlng.lat;
        var lng = e.latlng.lng;

        if (!marker) {
          marker = L.marker(e.latlng).addTo(map);
        } else {
          marker.setLatLng(e.latlng);
        }

        latitude.value = lat;
        longitude.value = lng;

        $("#modalCreate").modal("show");
      }

      map.on("click", onMapClick);

      $('#modalCreate').on('hidden.bs.modal', function () {
        map.removeLayer(marker)
      })
    </script>
  </body>
</html>
