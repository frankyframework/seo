<?php
use Seo\Form\redireccion301Form;
use \Base\entity\redireccionesEntity;
use Franky\Haxor\Tokenizer;

$Tokenizer = new Tokenizer();
$id         = $Tokenizer->decode($MyRequest->getRequest('id'));
$callback	= $MyRequest->getRequest('callback');
$data           = $MyFlashMessage->getResponse();

$adminForm = new redireccion301Form("frmredireccion");
$redireccionesEntity      = new redireccionesEntity();

if(!empty($id))
{
        $redireccionesEntity->setId($id);
        $result	 = $MyRedireccion->getData($redireccionesEntity->getArrayCopy());
	$data = $MyRedireccion->getRows();
        $data["id"] = $Tokenizer->token('seo-redirect',$data["id"]);
        $adminForm->addId();
}


$adminForm->setData($data);
$adminForm->setAtributoInput("callback","value", urldecode($callback));



$title_form = "Redirecciones 301";
$MyFrankyMonster->setPHPFile(getVista("admin/template/form.phtml"));