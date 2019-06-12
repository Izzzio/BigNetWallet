<?php
/**
 * @var \App\Model\Entity\Card $card
 */
?>
<script src="/assets/js/webcamjs/webcam.min.js" type="application/javascript"></script>
<input id="photo" type="hidden" name="photo">
<div class="panel panel-white">
    <div class="panel-body">
        <?php
        $fileName = \App\Lib\Cards::getCardPhotoPath($card);
        if ($fileName) {
            ?>
            <b>Текущее фото:</b><br>
            <img src="<?=$fileName?>"
                 style="width: auto; max-height: 250px; border-radius: 5px"/>
            <br><br>
            <?php
        }
        ?>
        <div id="photoBooth" class=" col-md-12">
            <div class="col-md-6">
                <b>Фотография:</b><br>
                <div id="camera"></div>
                <button type="button" class="btn btn-info" id="takePhoto" style="width: 320px">
                    <i
                        class="glyphicon glyphicon-camera"></i> Сфотографировать
                </button>
            </div>
            <div class="col-md-6">
                <div id="result"></div>
            </div>
            <br><br>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        Webcam.set({
            width: 320,
            height: 230,
            dest_width: 640,
            dest_height: 480,
            image_format: 'jpeg',
            jpeg_quality: 90
        });
        Webcam.on('error', function () {
            $('#photoBooth').html('<b>Ошибка захвата изображения с камеры. Функция фотографирования недоступна.</b><br><br>');
        });
        Webcam.attach('#camera');

        $('#takePhoto').click(function () {
            Webcam.snap(function (dataUri) {
                $('#photo').val(dataUri);
                document.getElementById('result').innerHTML =
                    '<b>Результат фото:</b><br>' +
                    '<img style="max-width: 320px; height: auto; border-radius: 5px"  src="' + dataUri + '"/>';
            });
        });
    });
</script>