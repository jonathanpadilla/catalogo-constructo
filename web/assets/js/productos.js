var btn_agregar_producto = $(".btn_agregar_producto");
var form_agregar_producto = $(".form_agregar_producto");

$(function(){

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

});