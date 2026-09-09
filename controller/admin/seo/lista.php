<?php
use Seo\model\SeoModel;
use Seo\entity\SeoEntity;
use Base\entity\OrganosEntity;
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
 
    $sortInput  = (!empty($MyRequest->getRequest('sidx',"nombre")) ? : "nombre");

    $idioma_base = getCoreConfig('base/theme/baselang');
    $lang_b = (empty($request['lang']) ? $idioma_base: $request['lang']);

    $MySeo = new SeoModel();
    $OrganosEntity = new OrganosEntity($request);
    $SeoEntity = new SeoEntity($request);
    $Tokenizer = new Tokenizer();
    $SeoEntity->lang($lang_b);



    $MySeo->setPage($MyRequest->getRequest('page',1));
    $MySeo->setTampag($MyRequest->getRequest('rows',12));
    $MySeo->setOrdensql($sortInput." ".$MyRequest->getRequest('sord',"ASC"));
    $OrganosEntity->status(1);
    $result	= $MySeo->getData($SeoEntity->getArrayCopy(),$OrganosEntity->getArrayCopy());
    $dataRows = ["rows" => [], "total" => ceil($MySeo->getTotal() / $MyRequest->getRequest('rows',12)), "page" => (int)$MyRequest->getRequest('page',1),"records" => $MySeo->getTotal()];
    if($MySeo->getTotal() > 0)
    {

        while($registro = $MySeo->getRows())
        {
            $registro = array_filter($registro, function($llave) {
                    return !is_numeric($llave);
            }, ARRAY_FILTER_USE_KEY);

            $dataRows['rows'][] = array_merge($registro,array(
                    "status"  => ($registro["status"] == 1 ? "desactivar" : "activar"),
                    "callback" => $Tokenizer->token('seo',$MyRequest->getURI()),
                    "id" => $Tokenizer->token('seo',$registro["id"])
                    ));
                    $iRow++;
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
