<?php
//stabilisco i permessi di lettura del file (anyone)
header("Access-Control-Allow-Origin: *");
// definisco il formato della risposta (json)
header("Content-Type: application/json; charset=UTF-8");
// definisco il metodo consentito per la request
header("Access-Control-Allow-Methods: GET");

include_once "/opt/lampp/htdocs/YouTravel/Project_YouTravel/mngm/Database_Classe.php";
include_once "/opt/lampp/htdocs/YouTravel/Project_YouTravel/mngm/Provincia_Classe.php";


$database=new Database();
$conn=$database->getConnection();
$provincia = new Provincia($conn);

$provSigla = isset ($_GET["sigla"]) ? $_GET["sigla"] : die(); //IF compatto
$stmt = $provincia->leggiProvInfo($provSigla);
if ($provincia->idProv >0){
    $provInfo=array(
        "sigla"=>$provincia->sigla,
        "nome"=>$provincia->nomeProv,
        "regione"=>$provincia->nomeReg,
        "tipoViaggio"=> $provincia->tipologia,
        "descrizione"=>$provincia->desc,
        "link"=>$provincia->linkInfo,
        "foto"=>$provincia->foto
    );
    http_response_code(200);
    $provJson=json_encode($provInfo);
    echo $provJson;
} else{
    http_response_code(404);
     echo json_encode(array("mex"=>"Non esiste questa provincia"));
}
?>