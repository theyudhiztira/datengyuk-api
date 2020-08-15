<?php

function sendResponse($data, int $errorCode = 200)
{
    return response()->json($data, $errorCode);
}

function randomGenerator($length = 1)
{
    if ($length < 1) {
        return "";
    }

    $characters = '0k#lmno12@38+9abcde*fghijp@q45&67*rst#uvwxyzA-BCDEFGHIJKL@MNOPQR*STUVWXY#Z_';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }

    return $randomString;
}

function generateUniqueCode()
{
    $length = 11;
    if ($length < 1) {
        return "";
    }

    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }

    return $randomString;
}

function getOperatorId()
{
    return session()->get('user_data')['id'];
}

function getOperatorGroup()
{
    return session()->get('user_data')['user_group'];
}

function getOperator($id)
{
    $uc = \App\Http\Controllers\User\UserController::get($id);

    return $uc;
}

function cacheKey()
{
    $param = [];
    $url = parse_str(\Request::getQueryString(), $param);
    $cacheKey = $param;
    unset($cacheKey['_']);

    return request()->url().'?'.json_encode($cacheKey);
}

function clientTimezone()
{
    return \geoip(\request()->ip())->timezone;
}

function nowUserTime()
{
    return \Carbon\Carbon::now(\geoip(\request()->ip())->timezone);
}

function getCurrency()
{
    return "IDR";
}

function uploadFile($file, $folder, $fileName)
{
    $fileExploded   = explode(',', $file);
    // $fileType       = str_replace('data:image/', '', str_replace(';base64', '', $fileExploded[0]));
    $base64_replaced    = str_replace(';base64', '', $fileExploded[0]);
    $base64_exploded    = explode('/', $base64_replaced);
    $fileType           = $base64_exploded[1];
    $newFilename    = $fileName.'.'. $fileType;
    // $checkSize      = (strlen(($fileExploded[1])) / 4 * 3);
    // $typePool       = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];
    $fileData       = base64_decode($fileExploded[1]);

    if ($folder == null or $fileName == null or $fileData == null) {
        return false;
    }

    $storeFile = \Storage::put($folder."/".$newFilename, $fileData);

    $arr['file_name'] = $newFilename;

    if ($storeFile) {
        $arr['status'] = true;
    } else {
        $arr['status'] = false;
    }

    return $arr;
}

function uploadFileMailBlast($file, $folder, $fileName)
{
    $fileExploded   = explode(',', $file);
    // return $fileExploded;
    // $fileType       = str_replace('data:image/', '', str_replace(';base64', '', $fileExploded[0]));
    $base64_replaced    = str_replace(';base64', '', $fileExploded[0]);
    $base64_exploded    = explode('/', $base64_replaced);
    $fileType           = $base64_exploded[1];
    $newFilename    = $fileName.'.blade.php';
    // $checkSize      = (strlen(($fileExploded[1])) / 4 * 3);
    // $typePool       = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];
    $fileData       = base64_decode($fileExploded[1]);

    if ($folder == null or $fileName == null or $fileData == null) {
        return false;
    }

    // return $folder;
    // $fileData->move($folder);
    $storeFile = file_put_contents($folder.'/'.$newFilename, $fileData);

    // $storeFile = \Storage::put($folder."/".$newFilename, $fileData);

    $arr['file_name'] = $newFilename;

    if ($storeFile) {
        $arr['status'] = true;
    } else {
        $arr['status'] = false;
    }

    return $arr;
}

function logError($exception)
{
    \Log::error('Error : '.$exception->getMessage().' File : '.$exception->getFile().' ('.$exception->getLine().') Happened on : '.nowUserTime()->toDateTimeString());

    $wa = new \App\Whatsapp\Courier(env('WABLAS_TOKEN'));
    $wa->addRecipient('085155001616');
    $wa->sendMessage('<b>Error : </b>'.$exception->getMessage().'\n File : '.$exception->getFile().' ('.$exception->getLine().')\n Happened on : '.nowUserTime()->toDateTimeString());
}
