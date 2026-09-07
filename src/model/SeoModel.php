<?php
namespace Seo\model;

class SeoModel  extends \Franky\Database\Mysql\objectOperations
{
       public function __construct()
    {
        parent::__construct();
        $this->from()->addTable('seo');
    }
    
    function getData($seo = array(),$franky = array())
    {
        $seo = $this->optimizeEntity($seo);
        $franky = $this->optimizeEntity($franky);
        $campos = ["seo.id","id_franky","titulo","descripcion","keywords","seo.status","fecha","lang","nombre","extra"];

        foreach($seo as $k => $v)
        {
              if(!empty($v) || is_numeric($v))
            {
                if(is_array($v))
                {
                    $this->where()->concat('AND (');
                    foreach ($v as $_v)
                    {
                        $this->where()->addOr('seo.'.$k,$_v,'=');

                    }
                    $this->where()->concat(')');
                }
                else
                {
                    if(in_array($k,['id','id_franky','status','fecha'])) {
                        $this->where()->addAnd('seo.'.$k,$v,'=');
                    } else {
                        $this->where()->addAnd('seo.'.$k,"%".$v."%",'like');
                    }
                } 
            }
        }
        foreach($franky as $k => $v)
        {
              if(!empty($v) || is_numeric($v))
            {
                if(is_array($v))
                {
                    $this->where()->concat('AND (');
                    foreach ($v as $_v)
                    {
                        $this->where()->addOr('franky.'.$k,$_v,'=');

                    }
                    $this->where()->concat(')');
                }
                else
                {
                    if(in_array($k,['id','status','fecha'])) {
                        $this->where()->addAnd('franky.'.$k,$v,'=');
                    } else {
                        $this->where()->addAnd('franky.'.$k,"%".$v."%",'like');
                    }
                } 
            }
        }

     

        $this->from()->addInner('franky','seo.id_franky','franky.id');

        return $this->getColeccion($campos);
    }

    private function optimizeEntity($array)
    {
        foreach ($array as $k => $v )
        {
            if (!isset($v)) {
                unset($array[$k]);
            }
        }
        return $array;
    }

    public function save($seo)
    {
        $seo = $this->optimizeEntity($seo);


    	if (isset($seo['id']))
    	{
              $this->where()->addAnd('id',$seo['id'],'=');
            return $this->editarRegistro($seo);
    	}
    	else {

            return $this->guardarRegistro($seo);
    	}

    }
}
?>
