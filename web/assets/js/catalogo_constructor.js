'use strict';

var btn_eliminar_categoria      = $('.btn_eliminar_categoria');
var btn_editar_categoria        = $('.btn_editar_categoria');
var btn_crear_categoria         = $("#btn_crear_categoria");
var btn_agregar_tabla           = $("#btn_agregar_tabla");
var modal_nueva_categoria       = $("#modal_nueva_categoria");
var modal_nueva_tabla           = $("#modal_nueva_tabla");
var form_agregar_categoria      = $("#form_agregar_categoria");
var form_agregar_tabla          = $("#form_agregar_tabla");
var submit_agregar_tabla        = $("#submit_agregar_tabla");
var submit_agregar_categoria    = $("#submit_agregar_categoria");

$(function(){

    // categorias
    submit_agregar_categoria.on('click', function(e){

        form_agregar_categoria.validate({
            rules: {

                nombre: {
                    required: true
                }
            },
            messages: {

                nombre: {
                    required: 'Campo requerido',
                }
            },
            errorPlacement: function(error, element) {
                if (element.is(":radio") || element.is(":checkbox")) {
                    element.closest('.option-group').after(error);
                }
                else {
                    error.insertAfter(element);
                }
            }
        });

        if(form_agregar_categoria.valid(true))
        {
            form_agregar_categoria.submit();
        }else{
            e.preventDefault();
        }
    });

    btn_crear_categoria.on('click', function(e){
        e.preventDefault();
        form_agregar_categoria[0].reset();
        modal_nueva_categoria.modal('show');
    });

    btn_editar_categoria.on('click', function(e){
        e.preventDefault();
        var btn     = $(this);
        var id      = btn.data('id');
        var nombre  = btn.data('nombre');
        var padre   = btn.data('padre');
        var desc    = btn.data('descripcion');

        form_agregar_categoria.find('#id_update').val(id);
        form_agregar_categoria.find('#nombre').val(nombre);
        form_agregar_categoria.find('#comentario').val(desc);
        form_agregar_categoria.find('#padre option[value='+padre+']').attr('selected', 'selected');
        
        modal_nueva_categoria.modal('show');
    });

    btn_eliminar_categoria.on('click', function(e){
        var btn = $(this);
        var id = btn.data('id');

        e.preventDefault();

        if(confirm('¿Eliminar categoria?'))
        {
            $.ajax({
                url: Routing.generate('admin_catalogo_categoria_eliminar'),
                data: {id:id},
                dataType: 'json',
                method: 'post'
            }).done(function(json){
                if(json)
                {
                    location.reload(true);
                }
            });
        }
    });
    // productos
    btn_agregar_tabla.on('click', function(e){
        e.preventDefault();

        var btn         = $(this);
        var categoria   = btn.data('categoria');
        form_agregar_tabla[0].reset();
        modal_nueva_tabla.find('#id_categoria').val(categoria);
        modal_nueva_tabla.modal('show');
    });

    submit_agregar_tabla.on('click', function(e){
        form_agregar_tabla.validate({
            rules: {

                nombre: {
                    required: true
                }
            },
            messages: {

                nombre: {
                    required: 'Campo requerido',
                }
            },
            errorPlacement: function(error, element) {
                if (element.is(":radio") || element.is(":checkbox")) {
                    element.closest('.option-group').after(error);
                }
                else {
                    error.insertAfter(element);
                }
            }
        });

        if(form_agregar_tabla.valid(true))
        {
            form_agregar_tabla.submit();
        }else{
            e.preventDefault();
        }
    });
});