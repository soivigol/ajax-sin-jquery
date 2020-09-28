window.addEventListener( 'load', function() {
	const formulario = document.getElementById( 'formulario-semanawp' );
	formulario.addEventListener( 'submit', envioForm );
} );

//Envio formulario
function envioForm( e ) {
	e.preventDefault();
	const contAvisos = document.getElementById( 'avisos' );
	const nombre     = document.getElementById( 'nombre' ).value;
	const profesion  = document.getElementById( 'profesion' ).value;
	//Objeto para envío de datos por http
	const request = new XMLHttpRequest();
	request.open( 'POST', var_ajax.url, true );
	request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8;');
	request.onload = function () {
		//Tratamiento de datos de retorno de la parte del servidor
		if (this.status >= 200 && this.status < 400) {
			const result = JSON.parse(this.response);
			if ( 'ERROR' === result.response ) {
				contAvisos.innerHTML = '<p>' + result.error + '</p>';
				contAvisos.style.color = 'red';
			} else if ( 'SUCCESS' === result.response ) {
				const htmlSalida = '<p>Hola!! Mi nombre es ' + result.nombre + ' y trabajo como ' + result.profesion + '</p>';
				contAvisos.innerHTML = htmlSalida;
				contAvisos.style.color = 'green';
			}
		} else {
			contAvisos.innerHTML =  '<p>Hay algún problema de comunicación con el servidor</p>';
			contAvisos.style.color = 'red';
		}
	}
	request.onerror = function() {
		contAvisos.innerHTML =  '<p>Error: ' + this.error + '</p>';
	};
	//Función para envío por ajax
	request.send( 'action=ajax_semana_wp&nonce=' + var_ajax.nonce + '&nombre=' + nombre + '&profesion=' + profesion );
}
