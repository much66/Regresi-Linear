<?php
// Mengecek apakah cookie error ada
if (isset($_COOKIE["error"])) {
  $errorMsg = $_COOKIE["error"];
  // Hapus cookie error setelah mengambil nilai
  setcookie("error", "", time() - 3600, "/");
  $msg = $_COOKIE["msg"];
  // Hapus cookie error setelah mengambil nilai
  setcookie("msg", "", time() - 3600, "/");
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Regresi Linear</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="icon" href="icon.png" type="image/png">
  <style>
    .popup {
      position: relative;
      display: inline-block;
      cursor: pointer;
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
    }

    /* The actual popup */
    .popup .popuptext {
      visibility: hidden;
      width: 160px;
      background-color: #555;
      color: #fff;
      text-align: center;
      border-radius: 6px;
      padding: 8px 0;
      position: absolute;
      z-index: 1;
      bottom: 125%;
      left: 50%;
      margin-left: -80px;
    }

    /* Popup arrow */
    .popup .popuptext::after {
      content: "";
      position: absolute;
      top: 100%;
      left: 50%;
      margin-left: -5px;
      border-width: 5px;
      border-style: solid;
      border-color: #555 transparent transparent transparent;
    }

    /* Toggle this class - hide and show the popup */
    .popup .show {
      visibility: visible;
      -webkit-animation: fadeIn 1s;
      animation: fadeIn 1s;
    }

    /* Add animation (fade in the popup) */
    @-webkit-keyframes fadeIn {
      from {
        opacity: 0;
      }

      to {
        opacity: 1;
      }
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
      }

      to {
        opacity: 1;
      }
    }

    /* Define the loading animation */
    .loading {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      /* semi-transparent background */
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 9999;
      /* make sure it's on top of other elements */
    }

    /* Add animation to the loading spinner */
    .loading::after {
      content: '';
      display: block;
      width: 40px;
      height: 40px;
      border-radius: 50%;
      border: 4px solid #fff;
      border-top-color: grey;
      border-bottom-color: grey;
      animation: spin 0.7s infinite linear;
      /* 1 second rotation animation */
    }

    /* Animation keyframes for the spinner */
    @keyframes spin {
      from {
        transform: rotate(0deg);
      }

      to {
        transform: rotate(360deg);
      }
    }

    .chart-container {
      padding: 10px;
      max-width: 100vh;
      display: none;
      margin: 0px auto;
      transition: opacity 1s ease-in-out;
    }

    .chart-container.show {
      visibility: visible;
      opacity: 1;
      transform: scale(1.1);
    }
  </style>
</head>

<body class="bg-light">
  <div class="container mx-auto position-relative mt-5 justify-content-center" style="padding: 10em 0.5em;">
    <?php
    if (isset($errorMsg)) :
    ?>
      <div style="margin-top: -100px;" class=" mx-auto alert alert-danger fade show col-md-5 text-center" role="alert">
        <?= $errorMsg; ?>
        <button type="button" class="btn-close me-auto" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php            // Menghapus pesan error dari session setelah ditampilkan
    endif;
    ?>
    <div class="col">
      <div class="row">
        <div class="text-center">
          <h1>Regresi Linear</h1>
          <form method="post" action="input.php" id="myForm">
            <!-- <div class="input-group"> -->
            <center>
              <div class="input-group justify-content-center">
                <div class="form-floating mb-3 col-sm-5">
                  <input class="form-control" type="number" id="floatingjumlah" name="jumlah" placeholder="MasukkanJumlah X dan Y" required>
                  <label for="floatingjumlah">Masukkan Jumlah x dan y yang dibutuhkan</label>
                </div>
                <span class="popup ms-2 mt-3 bi bi-question-circle-fill" onclick="myFunction()">
                  <span class="popuptext p-2" id="myPopup">Angka yang diinputkan disini merupakan jumlah dari masing - masing x dan y yang akan diinputkan pada inputan selanjutnya</span>
              </div>
              <div class="input-group justify-content-center">
                <div class="form-floating col-sm-5">
                  <input class="form-control" type="number" id="floatingduga" name="duga" placeholder="Jumlah Nilai Duga" required>
                  <label for="floatingduga">Masukkan Jumlah Prediksi yang dibutuhkan</label>
                </div>
                <span class="popup ms-2 mt-3 bi bi-question-circle-fill" onclick="myFunction2()">
                  <span class="popuptext p-2" id="myPopup2">Angka yang diinputkan disini merupakan jumlah dari nilai prediksi yang akan diinputkan selanjutnya</span>
              </div>
            </center>

            <!-- Bootstrap JS -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-yEV3KWXmY8xEW61RnZ9+QZbb/ckYZ6FQ13Ekze+G6aDP48zyg1YvN8VfIuH9TvcT" crossorigin="anonymous"></script>

            <!-- </div> -->
            <input type="submit" value="Next" class="btn btn-outline-secondary mt-2">
          </form>
          <center><button id="toggleButton" class="btn btn-dark mt-3">Gunakan file CSV</button>
            <div class="mt-2 chart-container" id="chartDiv">
              <form action="input.php" method="post" enctype="multipart/form-data">
                <input class="form-control 
                <?php
                if (isset($errorMsg)) :
                ?>
                is-invalid
            <?php            // Menghapus pesan error dari session setelah ditampilkan
                endif;
            ?>" type="file" name="csv_file" accept=".csv">
                <div id="validationServer03Feedback" class="invalid-feedback text-left">
                  <?= $msg; ?>
                </div>
                <div class="form-floating mt-2 mb-3 col-sm-5">
                  <input class="form-control" type="number" id="floatingjumlah" name="X" placeholder="MasukkanJumlah X dan Y" required>
                  <label for="floatingjumlah">Index kolom untuk X</label>
                </div>
                <div class="form-floating mb-3 col-sm-5">
                  <input class="form-control" type="number" id="floatingjumlah" name="Y" placeholder="MasukkanJumlah X dan Y" required>
                  <label for="floatingjumlah">Index kolom untuk Y</label>
                </div>
                <div class="form-floating col-sm-5">
                  <input class="form-control" type="number" id="floatingduga" name="duga" placeholder="Jumlah Nilai Duga" required>
                  <label for="floatingduga">Masukkan Jumlah Prediksi</label>
                </div>
                <button type="submit" class="btn btn-secondary mt-2">Next</button>
              </form>
            </div>
          </center>
        </div>
      </div>
    </div>
  </div>

  <script>
    // Get the form element
    var formElement = document.getElementById('myForm');

    // Show loading animation during form submission
    function showLoading() {
      var loadingElement = document.createElement('div');
      loadingElement.className = 'loading';
      document.body.appendChild(loadingElement);
    }

    // Submit form with a delay of 1 second
    function submitFormWithDelay(event) {
      event.preventDefault();

      // Display the loading animation
      showLoading();

      setTimeout(function() {
        // Submit the form after 1 second
        formElement.submit();
      }, 950); // 1000 ms = 1 second
    }

    // Add event listener to the form's submit event
    formElement.addEventListener('submit', submitFormWithDelay);
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
  </script>

  <!-- Option 2: Separate Popper and Bootstrap JS -->

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
  </script>
  <script>
    // When the user clicks on div, open the popup
    function myFunction() {
      var popup = document.getElementById("myPopup");
      popup.classList.toggle("show");
    }

    function myFunction2() {
      var popup = document.getElementById("myPopup2");
      popup.classList.toggle("show");
    }
  </script>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      // Mengambil referensi elemen tombol dengan ID "toggleButton"
      var toggleButton = document.getElementById("toggleButton");

      // Mengambil referensi elemen dengan ID "chartDiv"
      var chartDiv = document.getElementById("chartDiv");

      // Mengatur event listener pada tombol
      toggleButton.addEventListener("click", function() {
        // Memeriksa status tampilan grafik saat ini
        if (chartDiv.style.display === "block") {
          // Jika sedang disembunyikan, tampilkan grafik
          chartDiv.style.display = "none";
        } else {
          // Jika sedang ditampilkan, sembunyikan grafik
          chartDiv.style.display = "block";
        }
      });
    });
  </script>

</body>

</html>