<?php
$x = $_POST['x'];
$y = $_POST['y'];
$duga = $_POST['duga'];
$jml = $_GET['jumlah'];
$cara = $_POST['cara'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Perhitungan <?= $_POST['cara'] == 1 ? "Cara 1" : ($_POST['cara'] == 2 ? "Cara 2" : "Cara 3") ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
    <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
    <link rel="icon" href="icon.png" type="image/png">
    <style>
        p {
            font-family: Arial, Helvetica, sans-serif;
            font-style: italic;
        }

        @media(max-width:1000px) {
            body {
                font-size: 12px;
            }
        }

        .chart-container {
            padding: 10px;
            padding-left: 20px;
            padding-right: 20px;
            display: none;
            max-width: 740px;
            height: 60vh;
            margin: 0px auto;
            border: 1px solid grey;
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
    <div class="container mt-3">
        <div class="col">
            <div class="row text-center">
                <h2 style="text-decoration: underline;"><?= $_POST['cara'] == 1 ? "Cara 1" : ($_POST['cara'] == 2 ? "Cara 2" : "Cara 3") ?></h2>
                <!-- <center>
                    <hr style="width:100px; ">
                </center> -->
                <table class="table table-hover table-responsive table-bordered caption-top table-dark table-striped text-center mx-2">
                    <caption>Tabel X dan Y :</caption>
                    <thead>
                        <tr>
                            <th scope="col" style="width: 250px;">\(X\) (<?= $_POST['labelx'], "(", $_POST['satuanx'], ")"; ?>)</th>
                            <th scope="col" style="width: 250px;">\(Y\) (<?= $_POST['labely'], "(", $_POST['satuany'], ")"; ?>)</th>
                            <th scope="col">\(X^2\)</th>
                            <th scope="col">\(Y^2\)</th>
                            <th scope="col">\(XY\)</th>
                        </tr>
                    </thead>
                    <tbody class="table-light">
                        <?php
                        $total_x = 0;
                        $total_y = 0;
                        $total_x2 = 0;
                        $total_y2 = 0;
                        $total_xy = 0;
                        for ($i = 1; $i <= $jml; $i++) : ?>
                            <tr>
                                <td><?= $x[$i]; ?></td>
                                <td><?= $y[$i]; ?></td>
                                <td><?= $x[$i] * $x[$i]; ?></td>
                                <td><?= $y[$i] * $y[$i]; ?></td>
                                <td><?= $x[$i] * $y[$i]; ?></td>
                            </tr>
                        <?php endfor; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <?php for ($i = 1; $i <= $jml; $i++) {
                                $total_x += $x[$i];
                                $total_y += $y[$i];
                                $total_x2 += $x[$i] * $x[$i];
                                $total_y2 += $y[$i] * $y[$i];
                                $total_xy += $x[$i] * $y[$i];
                            }
                            ?>
                            <td><?= $total_x; ?></td>
                            <td><?= $total_y; ?></td>
                            <td><?= $total_x2; ?></td>
                            <td><?= $total_y2; ?></td>
                            <td><?= $total_xy; ?></td>
                        </tr>
                    </tfoot>
                </table>
                <center><button id="toggleButton" class="btn btn-dark">Scatter Plot</button>
                    <div class="mt-2 chart-container" id="chartDiv"> <canvas style="margin-top: 13px;" id="myChart"></canvas>
                    </div>
                </center>
                <?php if ($cara == 1) :
                    $rata_y = $total_y / $jml;
                    $rata_y = number_format($rata_y, 2);
                    $rata_x = $total_x / $jml;
                    $rata_x = number_format($rata_x, 2);
                    $b1 = (($jml * $total_xy) - ($total_x * $total_y)) / (($jml * $total_x2) - ($total_x * $total_x));
                    $b = number_format($b1, 2);
                    $a1 = (($total_y * $total_x2) - ($total_x * $total_xy)) / (($jml * $total_x2) - ($total_x * $total_x));
                    $a = number_format($a1, 2);
                ?>
                    <caption>Penyelesaian :</caption>
                    <div class="text-start caption-top mt-1 mx-2 mb-2" style="border-width: 2px; border-style:solid;">
                        <p>
                            \[a = \frac{(\sum_{i=1}^{n} Y_i)(\sum_{i=1}^{n} X_i^2) - (\sum_{i=1}^{n} X_i)(\sum_{i=1}^{n} X_iY_i)}{(n)(\sum_{i=1}^{n} X_i^2) - (\sum_{i=1}^{n} X_i)^2} \]
                        </p>

                        <p>\begin{align*}
                            a= \frac{(<?= $total_y; ?>)(<?= $total_x2; ?>) - (<?= $total_x; ?>)(<?= $total_xy; ?>)}{(<?= $jml; ?>)(<?= $total_x2; ?>) - <?= $total_x; ?>^2} = <?= $a; ?>\\
                            \end{align*}
                        </p>
                        <p>
                            \[b = \frac{(n)(\sum_{i=1}^{n} X_iY_i) - (\sum_{i=1}^{n} X_i)(\sum_{i=1}^{n} Y_i)}{(n)(\sum_{i=1}^{n} X_i^2) - (\sum_{i=1}^{n} X_i)^2} \]
                        </p>
                        <p>\begin{align*}
                            b= \frac{(<?= $jml; ?>)(<?= $total_xy; ?>) - (<?= $total_x; ?>)(<?= $total_y; ?>)}{(<?= $jml; ?>)(<?= $total_x2; ?>) - <?= $total_x; ?>^2} = <?= $b; ?>\\
                            \end{align*}
                        </p>
                        <p>a. Jadi nilai \(a = <?= $a; ?>\). dan nilai \(b = <?= $b; ?>\)
                            <br>b. Persamaan regresi linearnya adalah \(<?= "Y = " . $a . "+ " . $b . "X"; ?>\).
                        </p>
                        <p>
                            c. Nilai duga \(Y\) (<?= $_POST['labely']; ?>) :
                        </p>
                        <?php for ($j = 1; $j <= $_GET['nilai']; $j++) : ?>
                            <p>Jika \(X\) (<?= $_POST['labelx']; ?>) \(=<?= $duga[$j]; ?>\) <br> \(\Rightarrow Y = <?= $a . "+" . $b . "(" . $duga[$j] . ")"; ?> = <?= number_format($a1 + ($b1 * $duga[$j]), 2); ?>\)
                            </p>
                        <?php endfor; ?>
                        <?php
                        for ($i = 1; $i <= $jml; $i++) :
                            $line[] = $a1 + ($b1 * $x[$i]);
                        endfor;
                        ?>
                    </div>
                <?php
                elseif ($cara == 2) :
                    $rata_y = $total_y / $jml;
                    $rata_y = number_format($rata_y, 2);
                    $rata_x = $total_x / $jml;
                    $rata_x = number_format($rata_x, 2);
                    $detA = $jml * $total_x2 - $total_x * $total_x;
                    $detA1 = $total_y * $total_x2 - $total_x * $total_xy;
                    $detA2 = $jml * $total_xy - $total_y * $total_x;
                    $b1 = $detA2 / $detA;
                    $b = number_format($b1, 2);
                    $a1 = $detA1 / $detA;
                    $a = number_format($a1, 2);
                ?>
                    <caption>Penyelesaian :</caption>
                    <div class="text-start caption-top mt-1 mb-2" style="border-width: 2px; border-style:solid;">
                        <p>\[\begin{pmatrix}
                            n & \sum_{n}^{i=1} X_i\\
                            \sum_{n}^{i=1} X_i & sum_{n}^{i=1} X_i^2
                            \end{pmatrix}
                            \begin{pmatrix}
                            a\\
                            b
                            \end{pmatrix} =
                            \begin{pmatrix}
                            \sum_{n}^{x=1} Y_i\\
                            \sum_{n}^{x=1} X_iY_i
                            \end{pmatrix} \]
                        </p>
                        <p>\[\begin{pmatrix}
                            <?= $jml; ?> & <?= $total_x; ?>\\
                            <?= $total_x; ?> & <?= $total_x2; ?>
                            \end{pmatrix}
                            \begin{pmatrix}
                            a\\
                            b
                            \end{pmatrix} =
                            \begin{pmatrix}
                            <?= $total_y; ?>\\
                            <?= $total_xy; ?>
                            \end{pmatrix} \]
                        </p>
                        <p>\[ A = \begin{pmatrix}
                            <?= $jml; ?> & <?= $total_x; ?>\\
                            <?= $total_x; ?> & <?= $total_x2; ?>
                            \end{pmatrix}, A_1 = \begin{pmatrix}
                            <?= $total_y; ?> & <?= $total_xy; ?>\\
                            <?= $total_x; ?> & <?= $total_x2; ?>
                            \end{pmatrix}, A_2 = \begin{pmatrix}
                            <?= $jml; ?> & <?= $total_x; ?>\\
                            <?= $total_x; ?> & <?= $total_x2; ?>
                            \end{pmatrix} \]
                        </p>
                        <p>
                            \[det A = (<?= $jml; ?>)(<?= $total_x2; ?>) - (<?= $total_x . ")(" . $total_x; ?>) = <?= $detA; ?>\]
                            \[det A_1 = (<?= $total_y; ?>)(<?= $total_x2; ?>) - (<?= $total_x . ")(" . $total_y; ?>) = <?= $detA1; ?>\]
                            \[det A_2 = (<?= $jml; ?>)(<?= $total_xy; ?>) - (<?= $total_y . ")(" . $total_x; ?>) = <?= $detA2; ?>\]
                            \[ a = \frac{detA_1}{detA}, b =\frac{detA2}{detA}\]
                            \[ a = \frac{<?= $detA1; ?>}{<?= $detA; ?>} = <?= $a; ?>, b =\frac{<?= $detA2; ?>}{<?= $detA; ?>} = <?= $b; ?> \]
                        </p>
                        <p>a. Jadi nilai \(a = <?= $a; ?>\). dan nilai \(b = <?= $b; ?>\)
                            <br>b. Persamaan regresi linearnya adalah \(<?= "Y = " . $a . "+ " . $b . "X"; ?>\).
                        </p>
                        <p>
                            c. Nilai duga \(Y\) (<?= $_POST['labely']; ?>) :
                        </p>
                        <?php for ($j = 1; $j <= $_GET['nilai']; $j++) : ?>
                            <p>Jika \(X\) (<?= $_POST['labelx']; ?>) \(=<?= $duga[$j]; ?>\) <br> \(\Rightarrow Y = <?= $a . "+" . $b . "(" . $duga[$j] . ")"; ?> = <?= number_format($a1 + ($b1 * $duga[$j]), 2); ?>\)
                            </p>
                        <?php endfor; ?>
                        <?php
                        for ($i = 1; $i <= $jml; $i++) :
                            $line[] = $a1 + ($b1 * $x[$i]);
                        endfor;
                        ?>
                    </div>
                <?php else :
                    $rata_y1 = $total_y / $jml;
                    $rata_y = number_format($rata_y1, 2);
                    $rata_x1 = $total_x / $jml;
                    $rata_x = number_format($rata_x1, 2);
                    $b1 = (($jml * $total_xy) - ($total_x * $total_y)) / (($jml * $total_x2) - ($total_x * $total_x));
                    $b = number_format($b1, 2);
                    $a1 = $rata_y1 - ($b1 * $rata_x1);
                    $a = number_format($a1, 2);
                ?>
                    <caption>Penyelesaian :</caption>
                    <div class="text-start caption-top mt-1 mb-2" style="border-width: 2px; border-style:solid;">
                        <p>
                            \[b = \frac{(n)(\sum_{i=1}^{n} X_iY_i) - (\sum_{i=1}^{n} X_i)(\sum_{i=1}^{n} Y_i)}{(n)(\sum_{i=1}^{n} X_i^2) - (\sum_{i=1}^{n} X_i)^2} \]
                        </p>
                        <p>\begin{align*}
                            b= \frac{(<?= $jml; ?>)(<?= $total_xy; ?>) - (<?= $total_x; ?>)(<?= $total_y; ?>)}{(<?= $jml; ?>)(<?= $total_x2; ?>) - <?= $total_x; ?>^2} = <?= $b; ?>\\
                            \end{align*}</p>
                        <p>
                            \[a = \bar{Y} + b\bar{X}\]
                        </p>
                        <p>\begin{align*}
                            a= <?= $rata_y; ?> - (<?= $b; ?>)(<?= $rata_x; ?>)
                            = <?= $a; ?>\\
                            \end{align*}
                        </p>
                        <p>a. Jadi nilai \(a = <?= $a; ?>\). dan nilai \(b = <?= $b; ?>\)
                            <br>b. Persamaan regresi linearnya adalah \(<?= "Y = " . $a . "+ " . $b . "X"; ?>\).
                        </p>
                        <p>
                            c. Nilai duga \(Y\) (<?= $_POST['labely']; ?>) :
                        </p>
                        <?php for ($j = 1; $j <= $_GET['nilai']; $j++) : ?>
                            <p>Jika \(X\) (<?= $_POST['labelx']; ?>) \(=<?= $duga[$j]; ?>\) <br> \(\Rightarrow Y = <?= $a . "+" . $b . "(" . number_format($duga[$j]) . ")"; ?> = <?= number_format($a1 + ($b1 * $duga[$j]), 2); ?>\)
                            </p>
                        <?php endfor; ?>
                        <?php
                        for ($i = 1; $i <= $jml; $i++) :
                            $line[] = $a1 + ($b1 * $x[$i]);
                        endfor;
                        ?>
                    </div>
                <?php endif; ?>
                <caption> Uji Kebaikan Model :</caption>
                <div class="text-start caption-top mt-1" style="border-width: 2px; border-style:solid;">
                    <?php
                    $p1 = $jml * $total_xy;
                    $p2 = $total_x * $total_y;
                    $p3 = $p1 - $p2;
                    $p4 = $p3 * $p3;
                    $t1 = $jml * $total_x2;
                    $t2 = $total_x * $total_x;
                    $t3 = $jml * $total_y2;
                    $t3 = $jml * $total_y2;
                    $t4 = $total_y * $total_y;
                    $t5 = $t1 - $t2;
                    $t6 = $t3 - $t4;
                    $t7 = $t5 * $t6;
                    $pt = $p4 / $t7;
                    $pt = number_format($pt, 4);
                    $percent_pt = number_format($pt * 100, 2) . '%';
                    $sisa_pt = number_format(100 - ($pt * 100), 2) . '%';
                    ?>
                    <p>\begin{align*}
                        R^2= \frac{((n)(\sum XY ) - (\sum X)(\sum Y))^2}{(n(\sum X^2) - (\sum X)^2) (n(\sum Y^2)-(\sum Y)^2)}\\
                        \end{align*}
                    </p>
                    <p>\begin{align*}
                        R^2= \frac{((<?= $jml; ?>)(<?= $total_xy; ?>) - (<?= $total_x; ?>)(<?= $total_y; ?>))^2}{(<?= $jml; ?>(<?= $total_x2; ?>) - (<?= $total_x; ?>)^2) (<?= $jml; ?>(<?= $total_y2; ?>)-(<?= $total_y; ?>)^2)}\\
                        \end{align*}
                    </p>
                    <p>\begin{align*}
                        R^2= \frac{(<?= $p1; ?> - <?= $p2; ?>)^2}{(<?= $t1; ?> - <?= $t2; ?>) (<?= $t3; ?>- <?= $t4; ?> )}\\
                        \end{align*}
                    </p>
                    <p>\begin{align*}
                        R^2= \frac{(<?= $p3; ?>)^2}{(<?= $t5; ?>) (<?= $t6; ?> )} = \frac{<?= $p4; ?>}{<?= $t7; ?>} = <?= $pt; ?> \\
                        \end{align*}
                    </p>
                    <p style="text-align: center;">
                        Nilai determinasi (R2) sebesar <?= $pt; ?>, artinya sumbangan atau pengaruh <?= $_POST['labelx']; ?> terhadap naik turunnya <?= $_POST['labely']; ?> adalah sebesar <?= $percent_pt; ?>. <br> Sisanya <?= $sisa_pt; ?> Disebabkan oleh faktor lain yang tidak dimasukkan dalam model.
                    </p>
                </div>
            </div>
            <div class="text-center">
                <a href="/regresi" class="my-4 btn btn-outline-secondary">Buat Perhitungan Lain</a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>

    <?php
    $xlabel = $_POST['labelx'];
    $ylabel = $_POST['labely'];
    $xsatuan = $_POST['satuanx'];
    $ysatuan = $_POST['satuany'];
    ?>
    <script type="text/javascript">
        const ctx = document.getElementById('myChart');
        const xlabel = "<?= $xlabel ?>";
        const ylabel = "<?= $ylabel ?>";
        const xsatuan = "<?= $xsatuan ?>";
        const ysatuan = "<?= $ysatuan ?>";
        const x = Object.values(<?= json_encode($x); ?>);
        const y = Object.values(<?= json_encode($y); ?>);
        const line = Object.values(<?= json_encode($line); ?>);
        const numbers = [1, 2, 3, 4, 5];
        const xy = [];
        const xline = [];

        for (let i = 0; i < x.length; i++) {
            xy.push({
                x: x[i],
                y: y[i]
            });
        }
        for (let j = 0; j < x.length; j++) {
            xline.push({
                x: x[j],
                y: line[j]
            });
        }

        const data = {
            datasets: [{
                    label: 'Scatter Dataset Korelasi antara ' + xlabel + ' dan ' + ylabel,
                    data: xy,
                    backgroundColor: '#606060',
                    pointStyle: 'circles',
                    radius: 5
                },
                {
                    label: 'Garis Prediksi',
                    data: xline,
                    type: 'line',
                    borderColor: '#660000',
                    backgroundColor: '#660000',
                    fill: false
                }
            ]
        };

        const config = {
            type: 'scatter',
            data: data,
            options: {
                responsive: true,
                scales: {
                    x: {
                        type: 'linear',
                        position: 'bottom',
                        title: {
                            display: true,
                            text: xlabel + " (" + xsatuan + ")"
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: ylabel + " (" + ysatuan + ")"
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: (context) => {
                                const dataPoint = context.parsed;
                                const xValue = dataPoint.x;
                                const yValue = dataPoint.y;
                                return (
                                    xlabel +
                                    " " +
                                    xValue +
                                    " " +
                                    xsatuan +
                                    ' dengan ' +
                                    ylabel +
                                    " " +
                                    yValue +
                                    " " +
                                    ysatuan
                                );
                            }
                        }
                    },
                    datalabels: {
                        align: 'end',
                        anchor: 'end',
                        offset: 8,
                        font: {
                            weight: 'bold'
                        },
                        formatter: () => 'Download',
                        color: 'blue',
                        listeners: {
                            click: (ctx, event) => {
                                // Perform the download action here
                                // For example, generate a download link or trigger a file download
                            }
                        }
                    }
                },
                elements: {
                    point: {
                        hoverBackgroundColor: 'rgba(211, 211, 211, 0.8)'
                    }
                }
            }
        };

        new Chart(ctx, config);
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