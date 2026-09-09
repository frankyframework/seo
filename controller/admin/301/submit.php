<?php

use Franky\Core\validaciones;
use Base\entity\redireccionesEntity;
use Franky\Haxor\Tokenizer;

$Tokenizer = new Tokenizer();

$id                 = $Tokenizer->decode($MyRequest->getRequest('id'));
$callback           = $Tokenizer->decode($MyRequest->getRequest('callback'));


$error = false;
$redireciconesEntity = new redireccionesEntity($MyRequest->getRequest());

$redireciconesEntity->setId($id);
$validaciones =  new validaciones();
$valid = $validaciones->validRules($redireciconesEntity->setValidation());
if(!$valid)
{
    $MyFlashMessage->setMsg("error",$validaciones->getMsg());
    $error = true;
}

if($MyRedireccion->existe($redireciconesEntity->getUrl(),$redireciconesEntity->getId()) == REGISTRO_SUCCESS)
{
    $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("url_duplicada"));
    $error = true;
}

if(!$MyAccessList->MeDasChancePasar("administrar_redirecciones_301"))
{
    $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("sin_privilegios"));
    $error = true;
}

if($error == false)
{
    $id = $redireciconesEntity->getId();
    $redireciconesEntity->setFecha(date('Y-m-d H:i:s'));
    if(empty($id))
    {
        $redireciconesEntity->setStatus(1);
        
    }


    $url = parse_url($redireciconesEntity->getUrl());
    $redireccion = parse_url($redireciconesEntity->getRedireccion());
    $redireciconesEntity->setUrl($url['path']);
    $redireciconesEntity->setRedireccion($redireccion['path']);


    $result = $MyRedireccion->save($redireciconesEntity->getArrayCopy());

    if($result == REGISTRO_SUCCESS)
    {
        if(empty($id))
        {
            $MyFlashMessage->setMsg("success",$MyMessageAlert->Message("guardar_generico_success"));
            $location =  $MyRequest->url(LISTA_REDIRECCIONES_301);
        }
        else
        {
            $MyFlashMessage->setMsg("success",$MyMessageAlert->Message("editar_generico_success"));
            $location = (!empty($callback) ? ($callback) : $MyRequest->url(LISTA_REDIRECCIONES_301));
        }
    }
    else
    {
        if(empty($id))
        {
            $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("guardar_generico_error"));
            $location = $MyRequest->getReferer();
        }
        else
        {
            $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("editar_generico_error"));
            $location = $MyRequest->getReferer();
        }

    }

}
else
{
    $location = $MyRequest->getReferer();
}

$MyRequest->redirect($location);
?>
