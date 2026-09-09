<?php
use Base\entity\redireccionesEntity;
use Base\model\redireccionesModel;
use Franky\Haxor\Tokenizer;

if ($MyRequest->isAjax()) {
        $callback	= $MyRequest->getRequest('callback');
        $filters = $MyRequest->getRequest('filters');
        $dataPost = json_decode(stripslashes($filters),true);
        $dataPost = $dataPost['rules'];
        $requestFranky = [];
        $request = [];
        foreach($dataPost as $data) {
                $request[$data['field']] = $MyRequest->Sanitizacion($data['data']);
        }        
        $sortInput  = (!empty($MyRequest->getRequest('sidx',"fecha")) ? : "fecha");

        $redireccionesModel = new redireccionesModel();
        $redireccionesEntity = new redireccionesEntity($request);
        $Tokenizer = new Tokenizer();

        $redireccionesModel->setPage($MyRequest->getRequest('page',1));
        $redireccionesModel->setTampag($MyRequest->getRequest('rows',12));
        $redireccionesModel->setOrdensql($sortInput." ".$MyRequest->getRequest('sord',"ASC"));

        $result	 = $redireccionesModel->getData($redireccionesEntity->getArrayCopy());
        $dataRows = ["rows" => [], "total" => ceil($redireccionesModel->getTotal() / $MyRequest->getRequest('rows',12)), "page" => (int)$MyRequest->getRequest('page',1),"records" => $redireccionesModel->getTotal()];
    
        if($redireccionesModel->getTotal() > 0)
        {

                while($registro = $redireccionesModel->getRows())
                {
                        $registro = array_filter($registro, function($llave) {
                                return !is_numeric($llave);
                        }, ARRAY_FILTER_USE_KEY);
                        

                        $dataRows['rows'][]= array_merge($registro,array(
                        "id" => $Tokenizer->token('seo-redirec',$registro["id"]),
                        "fecha"         => getFechaUI($registro['fecha']),
                        "status"  => ($registro["status"] == 1 ? "desactivar" : "activar"),
                        "callback" => $Tokenizer->token('seo-redirec',$MyRequest->getURI()),
                        ));

                }
        }

        header('Content-Type: application/json; charset=utf-8');
        echo $callback . '(' . json_encode($dataRows). ');';
        die;
} else {
        $MyMetatag->setJs("/public/plugins/jqGrid/js/jquery.jqGrid.js");
        $MyMetatag->setJs("/public/plugins/jqGrid/js/i18n/grid.locale-$lang_root.js");
        $MyMetatag->setCSS("/public/plugins/jqGrid/css/ui.jqgrid.css");
}
?>
