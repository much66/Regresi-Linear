<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perhitungan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="icon" href="icon.png" type="image/png">
    <style>
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
    </style>
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="col">
            <div class="row">
                <div class="text-center">
                    <h3>Masukkan Nilai X dan Y</h3>
                    <hr>
                    <?php
                    // Mengecek apakah file CSV berhasil diupload
                    if (isset($_FILES["csv_file"]) && $_FILES["csv_file"]["error"] == UPLOAD_ERR_OK) : ?>

                        <?php
                        $allowedExtensions = array("csv");
                        $fileExtension = strtolower(pathinfo($_FILES["csv_file"]["name"], PATHINFO_EXTENSION));
                        if (in_array($fileExtension, $allowedExtensions)) {

                            $file = $_FILES["csv_file"]["tmp_name"];
                            $col = [$_POST['X'], $_POST['Y']]; // Mengambil kolom pertama dan kedua
                            $handle = fopen($file, "r");
                            $handle1 = fopen($file, "r");
                            $label = fgetcsv($handle, 1000, ",");
                            $i = 1;
                            $j  = 1;
                            $jumlah = -1;
                            while (($data1 = fgetcsv($handle1)) !== false) {
                                $jumlah++; // Increment the row count
                            } ?>

                            <form id="myForm" method="post" action="proses.php?jumlah=<?= $jumlah; ?>&nilai=<?= $_POST['duga']; ?>">
                                <div class="input-group">
                                    <input class="form-control" type="text" name="labelx" value="<?= $label[$col[0]]; ?>" placeholder="Masukkan Label untuk x" required>
                                    <span>&nbsp</span>
                                    <span class="text-secondary mx-2">Label</span>
                                    <span>&nbsp</span>
                                    <input class="form-control" type="text" name="labely" value="<?= $label[$col[1]]; ?>" placeholder="Masukkan Label untuk y" required>
                                </div>
                                <div class="input-group">
                                    <input class="form-control" type="text" name="satuanx" placeholder="Masukkan satuan untuk x" required>
                                    <span>&nbsp</span>
                                    <span class=" text-secondary m-2">Satuan</span>
                                    <span>&nbsp</span>
                                    <input class="form-control" type="text" name="satuany" placeholder="Masukkan satuan untuk y" required>
                                </div>

                                <?php
                                while (($data = fgetcsv($handle)) !== false) {
                                    echo '<div class="input-group">
                                    <input class="form-control" type="text" name="x[' . $i++ . ']" value="' . $data[$col[0]] . '" required readonly>
                                    <span>&nbsp</span>
                                    <span class="mx-2 text-secondary">' . $j . '</span>
                                    <span>&nbsp</span>
                                    <input class="form-control" type="text" name="y[' . $j++ . ']" value="' . $data[$col[1]] . '" required readonly>
                                </div>';
                                }
                                ?>
                                <center>
                                    <?php for ($j = 1; $j <= $_POST['duga']; $j++) : ?>
                                        <div class="form-floating my-2 col-md-3">
                                            <input class="form-control" id="floatingduga" type="text" name="duga[<?= $j; ?>]" placeholder="duga" pattern="[^,]*" title="Tidak boleh mengandung koma (,) gunakan titik (.)" required>
                                            <label for="floatingduga"><?= $_POST['duga'] > 1 ? "Masukkan nilai X untuk prediksi - " . $j : "Masukkan nilai X untuk prediksi"  ?></label>
                                        </div>
                                    <?php endfor; ?>
                                    <select class="form-select bg-outline-dark" style="width: 210px;" name="cara" aria-label="Default select example" id="mySelect" required>
                                        <option value="" title="Pilih cara yang akan digunakan" disabled selected hidden>Pilih Cara Penyelesaian</option>
                                        <option value="1">Cara 1</option>
                                        <option value="2">Cara 2</option>
                                        <option value="3">Cara 3</option>
                                    </select>
                                </center>
                                <input type="submit" value="Hitung" class="btn btn-outline-secondary mt-4"><br>
                                <a href="/regresilinear" class="btn btn-outline-danger mt-2 mb-3">Kembali</a>
                            </form>
                        <?php } else {
                            $errorMsg = "Hanya bisa menggunakan file yang berekstensi .csv!!!";
                            setcookie("error", $errorMsg, time() + 3600, "/");
                            $msg = "Gunakan file yang berekstensi .csv!!!";
                            setcookie("msg", $msg, time() + 3600, "/");
                            return header("Location:index.php");
                        } ?>
                    <?php else : ?>
                        <form id="myForm" method="post" action="proses.php?jumlah=<?= $_POST['jumlah']; ?>&nilai=<?= $_POST['duga']; ?>">
                            <div class="input-group">
                                <input class="form-control" type="text" name="labelx" placeholder="Masukkan Label untuk x" required>
                                <span>&nbsp</span>
                                <span>&nbsp</span>
                                <input class="form-control" type="text" name="labely" placeholder="Masukkan Label untuk y" required>
                            </div>
                            <div class="input-group">
                                <input class="form-control" type="text" name="satuanx" placeholder="Masukkan satuan untuk x" required>
                                <span>&nbsp</span>
                                <span>&nbsp</span>
                                <input class="form-control" type="text" name="satuany" placeholder="Masukkan satuan untuk y" required>
                            </div>
                            <?php for ($i = 1; $i <= $_POST['jumlah']; $i++) : ?>
                                <div class="input-group">
                                    <input class="form-control" type="text" name="x[<?= $i; ?>]" placeholder="x<?= $i; ?>" required>
                                    <span>&nbsp</span>
                                    <span>&nbsp</span>
                                    <input class="form-control" type="text" name="y[<?= $i; ?>]" placeholder="y<?= $i; ?>" required>
                                </div>
                            <?php endfor; ?>
                            <center>
                                <?php for ($j = 1; $j <= $_POST['duga']; $j++) : ?>
                                    <div class="form-floating my-2 col-md-3">
                                        <input class="form-control" id="floatingduga" type="text" name="duga[<?= $j; ?>]" placeholder="duga" pattern="[^,]*" title="Tidak boleh mengandung koma (,) gunakan titik (.)" required>
                                        <label for="floatingduga"><?= $_POST['duga'] > 1 ? "Masukkan nilai X untuk prediksi ke - " . $j : "Masukkan nilai X untuk prediksi"  ?></label>
                                    </div>
                                <?php endfor; ?>
                                <select class="form-select bg-outline-dark" style="width: 210px;" name="cara" aria-label="Default select example" id="mySelect" required>
                                    <option value="" title="Pilih cara yang akan digunakan" disabled selected hidden>Pilih Cara Penyelesaian</option>
                                    <option value="1">Cara 1</option>
                                    <option value="2">Cara 2</option>
                                    <option value="3">Cara 3</option>
                                </select>
                            </center>
                            <input type="submit" value="Hitung" class="btn btn-outline-secondary mt-4"><br>
                            <a href="/regresilinear" class="btn btn-outline-danger mt-2 mb-3">Kembali</a>
                        </form>
                    <?php endif; ?>
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
    <script>
        document.getElementById("mySelect").oninvalid = function(event) {
            event.target.setCustomValidity("Pilih Cara Terlebih Dahulu!!!");
        }
        document.getElementById("mySelect").oninput = function(event) {
            event.target.setCustomValidity("");
        }
    </script>
</body>

</html>