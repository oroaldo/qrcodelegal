<?php
require 'vendor/autoload.php';

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Encoding\Encoding;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $url = $_POST['url'];
    $size = $_POST['size'] ?? 300;
    $foreground = $_POST['foreground'];
    $background = $_POST['background'];
    $image = __DIR__ .'/image/logo.png';

    $result = Builder::create()
        ->data($url)
        ->size($size)
        ->encoding(new Encoding('UTF-8'))
        ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
        ->foregroundColor(new Color(hexdec(substr($foreground, 1, 2)), hexdec(substr($foreground, 3, 2)), hexdec(substr($foreground, 5, 2))))
        ->backgroundColor(new Color(hexdec(substr($background, 1, 2)), hexdec(substr($background, 3, 2)), hexdec(substr($background, 5, 2))))
        ->logoPath($image)
        ->logoResizeToWidth(80)
        ->build();

    $result->saveToFile(__DIR__ . '/qrcode.png');
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <!-- Meta tags Obrigatórias -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>QRCode Legal</title>
</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <!-- Coluna do formulário -->
            <div class="col-md-6">
                <h3>Gerar QR Code Legal</h3>
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="url" class="form-label">Digite a URL ou Texto:</label>
                        <input type="text" class="form-control" name="url" id="url" required>
                    </div>
                    <div class="mb-3">
                        <label for="size" class="form-label">Tamanho (px):</label>
                        <input type="number" class="form-control" name="size" id="size" value="300">
                    </div>
                    <div class="mb-3">
                        <label for="foreground" class="form-label">Cor do QR Code:</label>
                        <input type="color" class="form-control form-control-color" name="foreground" id="foreground"
                            value="#000000">
                    </div>
                    <div class="mb-3">
                        <label for="background" class="form-label">Cor de Fundo:</label>
                        <input type="color" class="form-control form-control-color" name="background" id="background"
                            value="#ffffff">
                    </div>
                    <button type="submit" class="btn btn-primary">Gerar QR Code</button>
                </form>
            </div>

            <!-- Coluna para exibição do QR Code -->
            <div class="col-md-6 d-flex justify-content-center align-items-center">
                <!-- Local onde o QR Code será exibido -->
                <?php if (isset($result)): ?>
                    <img src="qrcode.png" alt="QR Code gerado" class="img-fluid">
                <?php else: ?>
                    <p>Nenhum QR Code gerado ainda.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>