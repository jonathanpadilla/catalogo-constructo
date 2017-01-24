var btn_agregar_producto 	= $(".btn_agregar_producto");
var form_agregar_producto 	= $(".form_agregar_producto");
var btn_editar_producto 	= $(".btn_editar_producto");
var btn_eliminar_producto   = $(".btn_eliminar_producto");
var btn_imprimir            = $("#btn_imprimir");
var btn_eliminar_tabla      = $(".btn_eliminar_tabla");
var btn_editar_cabecera     = $(".btn_editar_cabecera");

$(function(){

    btn_eliminar_tabla.on('click', function(e){

        if(confirm('¿Realmente desea eliminar la tabla?'))
        {
            return true;
        }else{
            e.preventDefault();
        }
    });

    btn_editar_cabecera.on('click', function(e){
        e.preventDefault();
        var btn = $(this);
        var id = btn.data('id');

        var th_codigo      = $("#th_codigo_"+id);
        var th_producto    = $("#th_producto_"+id);
        var th_cantidad    = $("#th_cantidad_"+id);
        var th_precio      = $("#th_precio_"+id);

        th_codigo.parent().find('th').css('padding', 0);

        addInput(th_codigo, 'codigo', id);
        addInput(th_producto, 'producto', id);
        addInput(th_cantidad, 'cantidad', id);
        addInput(th_precio, 'precio', id);

    });

    btn_imprimir.on('click', function(e){
        e.preventDefault();
        $('#print_area').printThis({
            // debug: false,               //* show the iframe for debugging
            // importCSS: true,            //* import page CSS
            // importStyle: false,         //* import style tags
            // printContainer: true,       //* grab outer container as well as the contents of the selector
            // //loadCSS: "path/to/my.css",  //* path to additional css file - use an array [] for multiple
            // pageTitle: "",              //* add title to print page
            // removeInline: false,        //* remove all inline styles from print elements
            // printDelay: 333,            //* variable print delay; depending on complexity a higher value may be necessary
            // header: null,               //* prefix to html
            // footer: null,               //* postfix to html
            // base: false,                //* preserve the BASE tag, or accept a string for the URL
            // formValues: true,           //* preserve input/form values
            // canvas: false,              //* copy canvas elements (experimental)
            // //doctypeString: "..."        //* enter a different doctype for older markup
        });
    });

	form_agregar_producto.on('submit', function(e){

		var form = $(this);

		form.validate({
            rules: {

                codigo: {
                    required: true
                },
                producto: {
                    required: true
                },
                cantidad: {
                    required: true
                },
                precio: {
                    required: true
                }
            },
            messages: {

                codigo: {
                    required: 'Campo requerido'
                },
                producto: {
                    required: 'Campo requerido'
                },
                cantidad: {
                    required: 'Campo requerido'
                },
                precio: {
                    required: 'Campo requerido'
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

		if(form.valid(true))
        {
            return true;
        }else{
            e.preventDefault();
        }
	});

	btn_editar_producto.on('click', function(){
		var btn       = $(this);
		var id 	      = btn.data('id');
        var estado    = btn.data('estado');

		var td_codigo 		= $("#td_codigo_"+id);
		var td_producto 	= $("#td_producto_"+id);
		var td_cantidad 	= $("#td_cantidad_"+id);
		var td_precioreal 	= $("#td_precioreal_"+id);

        if(estado == 'td')
        {
            btn.data('estado', 'input');

            addInput(td_codigo, 'codigo', id);
            addInput(td_producto, 'producto', id);
            addInput(td_cantidad, 'cantidad', id);
            addInput(td_precioreal, 'precioreal', id);

            btn.removeClass('btn-default');
            btn.addClass('btn-warning');
            btn.html('<i class="fa fa-save"></i>');

        }else if(estado == 'input')
        {
            btn.data('estado', 'td');

            btn.html('<i class="fa fa-spinner fa-pulse"></i>');
            $("#input_codigo_"+id).attr('disabled', 'disabled');
            $("#input_producto_"+id).attr('disabled', 'disabled');
            $("#input_cantidad_"+id).attr('disabled', 'disabled');
            $("#input_precioreal_"+id).attr('disabled', 'disabled');

            var datos = {
                'id':           id,
                'codigo':       $("#input_codigo_"+id).val(),
                'producto':     $("#input_producto_"+id).val(),
                'cantidad':     $("#input_cantidad_"+id).val(),
                'precioreal':   $("#input_precioreal_"+id).val(),
            };

            $.ajax({
                url: Routing.generate('admin_catalogo_producto_editar'),
                data: datos,
                dataType: 'json',
                method: 'post'
            }).done(function(json){
                if(json.result)
                {
                    td_codigo.html($("#input_codigo_"+id).val());
                    td_producto.html($("#input_producto_"+id).val());
                    td_cantidad.html($("#input_cantidad_"+id).val());
                    var n_precioreal = $("#input_precioreal_"+id).val();
                    td_precioreal.html('$'+formatMoney(n_precioreal, 0, ',', '.'));

                    btn.removeClass('btn-warning');
                    btn.addClass('btn-default');
                    btn.html('<i class="fa fa-edit"></i>');
                }
            });

        }

	});

    // btn_eliminar_producto.on('click', function(e){

    //     if(confirm('¿Realmente desea deshabilitar el producto?'))
    //     {
    //         return true;
    //     }else{
    //         e.preventDefault();
    //     }

    // });

	function addInput(td, name, id)
	{
		var texto = td.text();
        var type = 'text';
        if(name == 'precioreal')
        {
            texto = texto.replace('$', '');
            texto = texto.replace('.', '');

            type = 'number';
        }

        td.html('<input type="'+type+'" class="form-control" style="width:100%;" name="input['+name+']['+id+']" id="input_'+name+'_'+id+'" value="'+texto+'" >');
	}

    function formatMoney(n, c, d, t){
        c = isNaN(c = Math.abs(c)) ? 2 : c, 
        d = d == undefined ? "." : d, 
        t = t == undefined ? "," : t, 
        s = n < 0 ? "-" : "", 
        i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))), 
        j = (j = i.length) > 3 ? j % 3 : 0;
        return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
    };

});