<?php

function dvd($arg){
    echo "<pre>";
    var_dump($arg);
    die;
}

function achou($str, $tipo){


    if ($tipo == 'ad'){
        $del = array(
            'Canais | Adultos',
            '[XXX] Adultos',
            'Adultos:',);
    }
    if ($tipo == 'sportv'){
        $del = array('Canais | SporTV');
    }

    foreach ($del as $d){
        if(strchr($str,$d)){
            return true;
        }
    }
}

echo "Vamos editar a playlist";

$file = 'lista_kYk9aZJr3m6.m3u';
$data = file($file);

foreach($data as $k => $line) {

    if(achou($line, 'ad')){
        unset($data[$k]);
        unset($data[$k + 1]);
    }

    if(achou($line, 'sportv')){
        $data[$k] = str_replace('Canais | SporTV','Canais | Esportes', $data[$k]);
    }

}

$fp = fopen("no_porn.m3u", "w+");
flock($fp, LOCK_EX);
foreach($data as $line) {
    fwrite($fp, $line);
}

flock($fp, LOCK_UN);
fclose($fp);
