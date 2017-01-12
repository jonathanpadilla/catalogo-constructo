$(function(){

	$("#submit_agregar_categoria").on('click', function(e){

		var form = $("#form_agregar_categoria");

		form.validate({
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

        if(form.valid(true))
        {
        	form.submit();
        }else{
        	e.preventDefault();
        }
	});
});