<?php
namespace Seo\Form;

class SEOForm extends \Franky\Form\Form
{
    public function __construct($name)
    {
        parent::__construct();


       $this->setAtributos(array(
            'name' => $name,
            'action' => "/admin/seo/submit.php",
            'method' => 'post'
        ));


       $this->add(array(
                'name' => 'callback',
                'type'  => 'hidden',

            )
        );

       $this->add(array(
                'name' => 'id_franky',
                'label' => _seo('Página'),
                'type'  => 'select',
                'required'  => true,
                'atributos' => array(
                    'class'       => 'required',
                 ),
                'options' => array(

                ),
                'label_atributos' => array(
                    'class'       => 'desc_form_obligatorio'
                 )
        ));

        $this->add(array(
                'name' => 'titulo',
                'label' => _seo('Metatag Titulo'),
                'type'  => 'text',
                'required'  => true,
                'atributos' => array(
                    'class'       => 'required',
                    'maxlength' => 70
                 ),
                'label_atributos' => array(
                    'class'       => 'desc_form_obligatorio'
                 )
            )
        );


          $this->add(array(
                'name' => 'descripcion',
                'label' => _seo('Metatag descripcion'),
                'type'  => 'textarea',
                'required'  => true,
                'atributos' => array(
                    'class' => 'required',
                    'rows'  => 5,
                    'placeholder' => _seo('Recuerda que el optimo son 160 caracteres.')
                 ),
                'label_atributos' => array(
                    'class'       => 'desc_form_obligatorio'
                 )
            )
        );


        $this->add(array(
            'name' => 'extra_name[]',
            'label' => _seo('Nombre metatag'),
            'type'  => 'text',
            'required'  => true,
            'atributos' => array(
                'class'       => 'required',
                'maxlength' => 70,
                'placeholder' => _seo('Nombre de la mataetiqueta')
             ),
            'label_atributos' => array(
                'class'       => 'desc_form_obligatorio'
             )
            )
        );

        $this->add(array(
            'name' => 'extra_scheme[]',
            'label' => _seo('Scheme metatag'),
            'type'  => 'text',
            'required'  => false,
            'atributos' => array(
                'class'       => '',
                'maxlength' => 70,
                'placeholder' => _seo('Tipo de scheme de la mataetiqueta')
             ),
            'label_atributos' => array(
                'class'       => 'desc_form_no_obligatorio'
             )
            )
        );

        $this->add(array(
            'name' => 'extra_type[]',
            'label' => _seo('tipo propiedad'),
            'type'  => 'select',
            'required'  => true,
                
                'atributos' => array(
                    'class'       => 'required',
                   
                 ),
                'options' => array(
                    'name' => 'name',
                    'property' => 'property'
                ),
                'label_atributos' => array(
                     'class'       => 'desc_form_obligatorio'
                 )
        ));


        $this->add(array(
            'name' => 'extra_value[]',
            'label' => _seo('Valor'),
            'type'  => 'textarea',
            'required'  => true,
            'atributos' => array(
                'class' => 'required',
                'rows'  => 5,
                'placeholder' => 'Contenido de la mataetiqueta'
             ),
            'label_atributos' => array(
                'class'       => 'desc_form_obligatorio'
             )
        )
    );

          $this->add(array(
                'name' => 'keywords',
                'label' => _seo('Metatag keywords'),
                'type'  => 'textarea',
                'required'  => false,
                'atributos' => array(
                    'class' => '',
                    'rows'  => 5,
                    'id'    => 'keywords'
                 ),
                'label_atributos' => array(
                    'class'       => 'desc_form_obligatorio'
                 )
            )
        );


        $this->add(array(
                'name' => "lang",
                'type'  => 'select',
                'label' => _seo('Idioma'),
                'required'  => true,
                'atributos' => array(
                    'class'       => 'required',
                 ),
                'options' => array(

                ),
                'label_atributos' => array(
                     'class'       => 'desc_form_obligatorio'
                 )
        ));

         $this->add(array(
                'name' => 'guardar',
                'type'  => 'submit',
                'atributos' => array(
                    'class'       => 'btn btn-primary btn-big float_right',
                    'value' => _seo("Guardar")
                 )

            )
        );

    }

    public function addId()
    {
         $this->add(array(
                'name' => 'id',
                'type'  => 'hidden',

            )
        );
    }

}
?>
