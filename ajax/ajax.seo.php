<?php


function EliminarRedireccion(string $id,int $status)
{
	global $MyRedireccion;
        global $MyAccessList;
        global $MyMessageAlert;
        $Tokenizer = new \Franky\Haxor\Tokenizer;
        $redireccionEntity = new Base\entity\redireccionesEntity();
        $redireccionEntity->setId(addslashes($Tokenizer->decode($id)));
        $redireccionEntity->setStatus($status);
        $respuesta = null;
        if($MyAccessList->MeDasChancePasar("administrar_redirecciones_301"))
        {
            if($MyRedireccion->save($redireccionEntity->getArrayCopy()) == REGISTRO_SUCCESS)
            {
		
            }
            else
            {
		 $respuesta[] = array("message" => $MyMessageAlert->Message("eliminar_generico_error"));
            }
        }
        else
        {
             $respuesta[] = array("message" => $MyMessageAlert->Message("sin_privilegios"));
        }
	
	return $respuesta;
}

function EliminarSeo(string $id, int $status)
{
        global $MyAccessList;
        global $MyMessageAlert;

        $Tokenizer = new \Franky\Haxor\Tokenizer;
        $MySeo              = new \Seo\model\SeoModel();
        $SeoEntity              = new \Seo\entity\SeoEntity();
        $respuesta = null;
        if($MyAccessList->MeDasChancePasar("administrar_seo"))
        {
            $SeoEntity->id(addslashes($Tokenizer->decode($id)));
            $SeoEntity->status(addslashes($status));
            if($MySeo->save($SeoEntity->getArrayCopy()) == REGISTRO_SUCCESS)
            {
	
            }
            else
            {
		 $respuesta[] = array("message" => $MyMessageAlert->Message("eliminar_generico_error"));
            }
        }
        else
        {
             $respuesta[] = array("message" => $MyMessageAlert->Message("sin_privilegios"));
        }
	
	return $respuesta;
}

$MyAjax->register("EliminarRedireccion");
$MyAjax->register("EliminarSeo");
?>