<?php
include 'configvoid.php';
if (isset($_POST['method'])) {
    $method = $_POST['method'];
    switch ($method) {
        case "showaudio":
            $res = array();
            $text = isset($_POST["text"]) ? $_POST["text"] : "";
            $namevoid = isset($_POST["namevoid"]) ? $_POST["namevoid"] : "";
            $languageCode = isset($_POST["languageCode"]) ? $_POST["languageCode"] : "";
            $rs = $texttospeech->showaudio($text, $languageCode, $namevoid);
            $date = date_create();
            $id = date_timestamp_get($date);
            $filename = "sound_{$id}.mp3";
            $url = "audio/sound_{$id}.mp3";
            $status = file_put_contents($url, $rs);
            chmod($url, 0775);
            if ($status != '') {
                $res['isaudio'] = true;
                $res['filename'] = $filename;
            } else {
                $res['isaudio'] = false;
            }
            echo json_encode($res);
            break;
        case "viewnamevoid":
            $rs = $texttospeech->viewnamevoid();
            foreach ($rs as $key => $value) {
                ?>
            <option value="<?=$value;?>"><?=$value;?></option>
            <?php
}
            break;
    }
}