<style>

input[type=number]::-webkit-inner-spin-button,
input[type=number]::-webkit-outer-spin-button {

	-webkit-appearance: none;
	margin: 0;

}

input[type=number] {

	-moz-appearance: textfield;

}

</style>

<template>

	<div>
		
		<v-stepper v-model="e6" style="max-height: 90%;" vertical>

			<v-stepper-step @click="e6 = 1" :complete="e6 > 1" step="1">Revisión del desarrollo actual de la tecnología<small>Estado de desarrollo: <strong>{{ trlActual }}</strong></small></v-stepper-step>

			<v-stepper-content step="1">

				<div class="mt-6 mb-8">
					
					<h3 style="color: #333333;" class="mb-6">Recursos utilizados en el desarrollo actual de la tecnología</h3>

					<v-text-field v-model="datos[0]" color="institucional" label="Presente el valor en pesos para el Recurso Humano (servicios personales indirectos) utilizado en el desarrollo actual de la tecnología" :rules="numeros" @keyup="enviarTodo" autocomplete="off"></v-text-field>

					<v-text-field v-model="datos[1]" color="institucional" label="Presente el valor en pesos para los materiales de formación utilizado en el desarrollo actual de la tecnología" :rules="numeros" @keyup="enviarTodo" autocomplete="off"></v-text-field>

					<v-text-field v-model="datos[2]" color="institucional" label="Presente el valor en pesos para maquinaria y equipo utilizado en el desarrollo actual de la tecnología" @blur="sumarTotal" autocomplete="off"></v-text-field>

					<v-text-field v-model="datos[3]" color="institucional" label="Valor total utilizado en el desarrollo actual" @focus="sumarTotal" readonly autocomplete="off"></v-text-field>

					<v-select v-model="datos[4]" color="institucional" :items="productosObtenidos" label="Productos obtenidos del desarrollo actual de la tecnología (de acuerdo a la tipología definida por Minciencias)" @change="mostrarProductoObtenido"></v-select>

					<v-select v-model="datos[5]" color="institucional" :items="productoObtenido" @change="enviarTodo" label="Producto obtenido"></v-select>

					<v-textarea v-model="datos[6]" color="institucional" label="Descripción de los productos obtenidos (describa los productos que se han desarrollado durante el desarrollo actual de la tecnología)" autocomplete="off" @keyup="enviarTodo"></v-textarea>

					<v-radio-group v-model="datos[29]" @change="enviarTodo" row>

						<template v-slot:label>

							<div>El grupo de investigación cuenta con la capacidad instalada (talento humano, infraestructura y materiales de formación) para continuar con el desarrollo de la tecnología.</div>

						</template>

						<v-radio label="Sí" value="Sí"></v-radio>
						<v-radio label="No" value="No"></v-radio>

					</v-radio-group>

					<div v-if="datos[29] == 'No'">

						<v-textarea v-model="datos[30]" color="institucional" label="Si respondió NO en la pregunta anterior, escriba qué hace falta: infraestructura, talento humano o materiales de formación para continuar." @keyup="enviarTodo"></v-textarea>

					</div>

				</div>

				<v-btn color="primary" @click="e6 = 2">Continuar / Actualizar</v-btn>

				<v-btn to="/inicio/resultados" text>Cancelar</v-btn>

			</v-stepper-content>

			<v-stepper-step @click="e6 = 2" :complete="e6 > 2" step="2">Desarrollo de la tecnología</v-stepper-step>

			<v-stepper-content step="2">

				<div class="mt-6 mb-8">
					
					<h3 style="color: #333333;" class="mb-6">Esfuerzo para avanzar en el desarrollo tecnológico de acuerdo al nivel inventivo (TRL) definido</h3>

					<v-select v-model="datos[7]" color="institucional" :items="nivelInventivo" label="Seleccione el nivel inventivo esperado para la tecnología, el cual describe el alcance del desarrollo tecnológico" @change="enviarTodo"></v-select>

					<v-select v-model="datos[8]" color="institucional" :items="nivelInventivo" label="TRL al que se espera llegar, si su tecnología es financiada durante la vigencia 2021" @change="enviarTodo"></v-select>

					<v-select v-model="datos[9]" color="institucional" :items="requerimientoInfraestructura" label="Requerimiento de infraestructura para desarrollo de la tecnología" @change="enviarTodo"></v-select>

					<v-text-field v-model="datos[10]" color="institucional" label="Costo en pesos Recurso Humano (servicios personales indirectos) para avanzar en el desarrollo del resultado de investigación" :rules="numeros" autocomplete="off" @keyup="enviarTodo"></v-text-field>

					<v-text-field v-model="datos[11]" color="institucional" label="Costo en pesos  del o los Materiales de formación para avanzar en el desarrollo del resultado de investigación" autocomplete="off" @keyup="enviarTodo"></v-text-field>

					<v-text-field v-model="datos[12]" color="institucional" label="Costo en pesos de los equipos para avanzar en el desarrollo del resultado de investigación" autocomplete="off" @keyup="enviarTodo"></v-text-field>

					<v-text-field v-model="datos[13]" color="institucional" label="Costo en pesos para otros rubros necesarios para avanzar en el desarrollo del resultado de investigación" autocomplete="off" @keyup="enviarTodo"></v-text-field>

					<v-text-field v-model="datos[14]" color="institucional" label="Valor total solicitado en los rubros definidos" autocomplete="off" readonly @keyup="enviarTodo"></v-text-field>

					<v-textarea v-model="datos[15]" color="institucional" label="Justifique y describa el uso de los rubros solicitados especificando al detalle lo que se va a adquirir" @keyup="enviarTodo"></v-textarea>

					<v-radio-group v-model="datos[16]" @change="quitarReadOnlyEnviar1" row>

						<template v-slot:label>

							<div>Para avanzar en el desarrollo del resultado de investigación, ¿Requiere articularse con un ambiente de formación de otro centro a nivel nacional?</div>

						</template>

						<v-radio label="Sí" value="Sí"></v-radio>
						<v-radio label="No" value="No"></v-radio>

					</v-radio-group>

					<v-text-field v-model="datos[17]" color="institucional" label="Si su respuesta anterior fue afirmativa; escriba el nombre del centro de formación con el cual puede articularse" autocomplete="off" :readonly="esLectura" @keyup="enviarTodo"></v-text-field>

					<v-text-field v-model="datos[18]" color="institucional" label="Si su respuesta anterior fue afirmativa; seleccione el ID del ambiente de formación del cual va a hacer uso de acuerdo a la información presentada en la base de datos de los ambientes (ver PowerBI)" autocomplete="off" :readonly="esLectura" @keyup="enviarTodo"></v-text-field>

				</div>

				<v-btn color="primary" @click="e6 = 3">Continuar / Actualizar</v-btn>

				<v-btn color="institucional" dark class="ml-2" @click="e6 = 1">Atrás</v-btn>

				<v-btn to="/inicio/resultados" class="ml-2" text>Cancelar</v-btn>

			</v-stepper-content>

			<v-stepper-step @click="e6 = 3" :complete="e6 > 3" step="3">Mercado y aplicación</v-stepper-step>

			<v-stepper-content step="3">

				<div class="mt-6 mb-8">
					
					<h3 style="color: #333333;" class="mb-6">Aplicaciones de la tecnología</h3>

					<v-select v-model="datos[19]" color="institucional" :items="aplicacionesDeLaTecnologia" label="Seleccione las aplicaciones de la tecnología del listado presentado según corresponda" @change="enviarTodo"></v-select>
					
					<h3 style="color: #333333;" class="mb-6">Aproximación al mercado</h3>

					<v-select v-model="datos[20]" color="institucional" :items="criterioAproximacionMercado" label="Seleccione el criterio de aproximación al mercado del listado presentado según corresponda" @change="enviarTodo"></v-select>

					<v-radio-group v-model="datos[21]" @change="quitarReadOnlyEnviar2" row>

						<template v-slot:label>

							<div>Si la tecnologia ha sido desarrollada por el grupo de investigación en alianza con una empresa que está activa en el mercado, indique si se ha realizado algún acuerdo con la empresa o aliado sobre los derechos en propiedad intelectual</div>

						</template>

						<v-radio label="Sí" value="Sí"></v-radio>
						<v-radio label="No" value="No"></v-radio>

					</v-radio-group>

					<v-radio-group v-model="datos[22]" :readonly="esLecturaSiNo3" @change="enviarTodo" row>

						<template v-slot:label>

							<div>Si la respuesta anterior es 'Sí', indique si la alianza continua vigente</div>

						</template>

						<v-radio label="Sí" value="Sí"></v-radio>
						<v-radio label="No" value="No"></v-radio>

					</v-radio-group>
					
					<h3 style="color: #333333;" class="mb-6">Alcance de aplicación para la tecnología</h3>

					<v-select v-model="datos[23]" color="institucional" :items="criterioAproximacionMercado2" label="Seleccione el criterio correspondiente a la expansión de la tecnología del listado presentado según corresponda" @change="enviarTodo"></v-select>
					
					<h3 style="color: #333333;" class="mb-6">Regulaciones y Barreras del Mercado</h3>

					<v-select v-model="datos[24]" color="institucional" :items="criterioBarreras" label="Seleccione el criterio correspondiente a regulaciones y barreras del mercado del listado presentado según corresponda" @change="enviarTodo"></v-select>

				</div>

				<v-btn color="primary" @click="e6 = 4">Continuar / Actualizar</v-btn>

				<v-btn text>Cancelar</v-btn>

			</v-stepper-content>

			<v-stepper-step @click="e6 = 4" step="4">Diferencial de la tecnología</v-stepper-step>

			<v-stepper-content step="4">

				<div class="mt-6 mb-8">
					
					<h3 style="color: #333333;" class="mb-6">Afectaciones por Artículos o Patentes</h3>

					<v-select v-model="datos[25]" color="institucional" :items="afectacionesArtiuclosPatentes" label="Seleccione el criterio correspondiente a afectaciones por artículos o patentes del listado presentado según corresponda" @change="enviarTodo"></v-select>
					
					<h3 style="color: #333333;" class="mb-6">Afectaciones por Productos Comerciales</h3>

					<v-select v-model="datos[26]" color="institucional" :items="afectacionesComerciales" label="Seleccione el criterio correspondiente a afectaciones por artículos o patentes del listado presentado según corresponda" @change="enviarTodo"></v-select>

					<v-radio-group v-model="datos[27]" @change="quitarReadOnlyEnviar3" row>

						<template v-slot:label>

							<div>¿Considera que el resultado del desarrollo de la tecnología puede llevar a algún proceso de propiedad intelectual?</div>

						</template>

						<v-radio label="Sí" value="Sí"></v-radio>
						<v-radio label="No" value="No"></v-radio>

					</v-radio-group>

					<v-select v-model="datos[28]" color="institucional" :items="propiedadIntelectual" label="Si la respuesta anterior es afirmativa, ¿Qué tipo de protección de la propiedad intelectual puede llegar a obtenerse? Eje: patente de invención, patente modelo de utilidad, derechos de autor" :readonly="esLecturaPropiedad" @change="enviarTodo"></v-select>

				</div>

				<v-btn color="primary" @click="enviarTodo">Finalizar</v-btn>

				<v-btn text>Cancelar</v-btn>

			</v-stepper-content>

		</v-stepper>

	</div>

</template>

<script>

	import { mapGetters } from 'vuex'

	export default {

		name: 'StepperValidacion',
		data: () => ({

			e6: 1,
			menuLateral: false,
			obligatorio: [],
			numeros: [

			v => /^([0-9$.])*$/.test(v) || 'Este campo sólo debe contener caracteres numéricos.',

			],
			datos: [/*0*/'$', /*1*/'$', /*2*/'$', /*3*/'$', /*4*/'', /*5*/'', /*6*/'', /*7*/'', /*8*/'', /*9*/'', /*10*/'$', /*11*/'$', /*12*/'$', /*13*/'$', /*14*/'$', /*15*/'', /*16*/'',
			/*17*/'', /*18*/'', /*19*/'', /*20*/'', /*21*/'', /*22*/'', /*23*/'', /*24*/'', /*25*/'', /*26*/'', /*27*/'', /*28*/'', /*29*/'', /*30*/null],

			productosObtenidos: ['Productos resultado de actividades de generación de nuevo conocimiento', 'Productos resultado de actividades de desarrollo tecnológico e innovación - productos tecnologicos certificados o validados', 'Productos resultado de actividades de desarrollo tecnológico e innovación - productos empresariales', 'Productos resultado de actividades de desarrollo tecnológico e innovación - Regulaciones, normas, reglamentos o legislaciones', 'Productos resultado de actividades de desarrollo tecnológico e innovación - Conceptos técnicos e informes técnicos', 'Productos resultado de actividades de desarrollo tecnológico e innovación - Registros de Acuerdos de licencia para la explotación de obras protegidas por derecho de autor', 'Productos resultado de actividades de apropiación social del conocimiento - Participación ciudadana en CTeI y creación', 'Productos resultado de actividades de apropiación social del conocimiento - Estrategias pedagógicas para el fomento de la CTeI', 'Productos resultado de actividades de apropiación social del conocimiento - Comunicación social del conocimiento', 'Productos resultado de actividades de apropiación social del conocimiento - Circulación de conocimiento especializado', 'Productos de actividades relacionadas con la formación de recurso humano para la CTel-dirección de tesis de doctorado', 'Productos de actividades relacionadas con la formación de recurso humano para la CTel-Dirección de trabajo de grado de maestría', 'Dirección/Tutoría de Trabajo de grado de maestría', 'Codirección/Cotutoría de Trabajo de grado de maestría', 'Productos de actividades relacionadas con la formación de recurso humano para la CTeI-Proyectos de investigación y desarrollo', 'Productos de actividades relacionadas con la formación de recurso humano para la CTeI-Proyectos de investigación-creación', 'Productos de actividades relacionadas con la formación de recurso humano para la CTeI-Proyectos de investigación, desarrollo e innovación (ID+I)', 'Productos de actividades relacionadas con la formación de recurso humano para la CTeI-Apoyo a creación de programas o cursos de formación de investigadores'],

			productoObtenido: [],

			nivelInventivo: ['TRL 1 - Investigación básica: Idea básica. Terminó su idea en forma de estudios, observación de los principios básicos y propiedades básicas de una tecnología', 'TRL 2 - Investigación aplicada: Formulación del concepto, su aplicación y puesta en práctica de la tecnología. Identificación de formulaciones preliminares de aplicaciones prácticas, estudios analíticos para la simulación o análisis', 'TRL 3 - Pruebas de concepto: Desarrollo de actividades de investigación y desarrollo (I+D), pruebas analíticas, pruebas de concepto o a escala de laboratorio orientadas a demostrar la factibilidad técnica de los conceptos', 'TRL 4 - Validación de componentes/modelo/susbsistemas a nivel de laboratorio y/o trabajo de campo: Prueba que puede funcionar de manera integrada en un sistema. Diseño, desarrollo y análisis de laboratorio de los componentes tecnológicos ya sea producto, muestra, estudio', 'TRL 5 - Validación de los componentes/sistemas en un entorno relevante: Los componentes tecnológicos básicos son integrados conjuntamente con elementos reales para ser analizados en un entorno simulado', 'TRL 6 - Validacion de los modelos/prototipos/sistemas en condiciones cercanas a las reales. La demostración del sistema o proceso se lleva a cabo en un entorno operacional real con pruebas de factibilidad superadas en ese entorno', 'TRL 7 - La tecnología/El modelo está proximo a operar en escala pre-comercial. En la ejecución del proyecto se tiene un prototipo escalable con un proceso de manufactura claro y operacional a baja escala', 'TRL 8 - La tecnología/El modelo está proximo se encuentra en su fase final de entrada al mercado, se tiene un producto final listo para comercializar. Todas las cuestiones operativas y de fabricación han sido resueltas. La tecnología ha sido probada en su forma final y bajo condiciones supuestas, por lo que se ha demostrado su potencial a nivel comercial', 'TRL 9 - La tecnología/El modelo está probado y disponible para su comercialización y/o producción'],

			requerimientoInfraestructura: ['La infraestructura tecnológica no se desarrolla en el país, se requiere talento humano no disponible y altas inversiones =  Valor 1', 'La infraestructura tecnológica no se desarrolla en el país y aunque hay talento humano disponible se requieren altas inversiones = Valor 2', 'La infraestructura tecnológica se desarrolla en el pais y se precisan altas inversiones = Valor 3', 'La infraestructura tecnológica es similar a la actual, aunque implica realizar inversiones para ajustarla = Valor 4', 'La infraestructura tecnológica es similar a la actual y no se requiere de inversiones = Valor 5'],

			esLectura: 'readonly',

			aplicacionesDeLaTecnologia: ['No se identifican aplicaciones conocidas para la tecnología; Valor = 1', 'No se identifican aplicaciones conocidas para la tecnología; Valor = 1', 'Se identifican aplicaciones que se han probado pero no se han validado; Valor = 3', 'Se ha probado y validado al menos 1 aplicación de la tecnología; Valor = 4', 'Se han probado y validado 2 o más aplicaciones de la tecnología; Valor =5'],

			criterioAproximacionMercado: ['La tecnología ha sido desarrollada por iniciativa de un instructor sin proyecto de investigación; Valor = 1', 'La tecnología ha sido desarrollada por iniciativa del grupo de investigación partiendo de una necesidad del sector productivo; Valor = 2', 'La tecnología ha sido desarrollada por instructores del grupo de investigación que han tenido experiencia en el sector productivo; Valor = 3', 'La tecnología ha sido desarrollada con proyección de alianza o convenio con alguna empresa o entidad; Valor = 4', 'La tecnología ha sido desarrollada por el grupo de investigación en alianza con una empresa que está activa en el mercado; Valor=5'],

			esLecturaSiNo3: 'readonly',

			criterioAproximacionMercado2: ['La aplicación de la tecnología puede darse únicamente en el centro de formación donde se desarrollo; Valor = 1', 'La aplicación de la tecnología puede darse únicamente en el contexto de una empresa o problemática local; Valor = 2', 'La tecnología puede aplicarse a un problema de un conjunto de empresas y/ o Centros de formación a nivel local; Valor =3', 'La tecnología puede aplicarse a un problema de un conjunto de empresas y/o Centros de formación en diferentes departamentos del país; Valor = 4', 'La tecnología puede aplicarse a un problema de varias empresas o Centros de Formación a nivel nacional; Valor = 5'],

			criterioBarreras: ['Existen regulaciones y restricciones que limitan la comercialización o aplicación de la tecnología; Valor = 1', 'Existen regulaciones y restricciones que limitan la comercialización o aplicación de la tecnología que pueden ser gestionadas; Valor = 2', 'Existen regulaciones y restricciones que limitan la comercialización o aplicación de la tecnología aunque ya se ha iniciado la gestión para cumplirlas; Valor = 3', 'Ya se han cumplido los requerimientos regulatorios que podrían limitar la comercialización o aplicación de la tecnología; Valor = 4', 'Existen regulaciones que tienden a impulsar el uso y aplicación de la tecnología; Valor = 5'],

			afectacionesArtiuclosPatentes: ['Se identifican tecnologías similares en la literatura. No hay pruebas del diferencial de la tecnología respecto a las identificadas; Valor = 1', 'Se identifican tecnologías similares en la literatura y se han hecho pruebas de la tecnología que evidencian un bajo diferencial; Valor = 2', 'Se identifican tecnologías similares en la literatura y se han hecho pruebas de la tecnología que evidencian un diferencial relevante; Valor = 3', 'Se identifican tecnologías en la literatura con funcionalidad similar. Las pruebas realizadas muestran un alto diferencial de la tecnología; Valor = 4', 'No se evidencian tecnologías con funcionalidad similar y las pruebas realizadas muestran que se encuentra en la frontera del conocimiento; Valor = 5'],

			afectacionesComerciales: ['Se identifican productos similares. No hay pruebas del diferencial de la tecnología respecto a estos productos. Valor = 1', 'Se identifican productos similares y se han hecho pruebas de la tecnología que evidencian un bajo diferencial; Valor = 2', 'Se identifican productos similares y se han hecho pruebas de la tecnología que evidencian un diferencial relevante; Valor = 3', 'Se identifican productos con funcionalidad similar. Las pruebas realizadas muestran un alto diferencial de la tecnología; Valor = 4', 'No se evidencian productos con funcionalidad similar y las pruebas realizadas muestran que podria ser una tecnología disruptiva; Valor = 5'],

			esLecturaPropiedad: 'readonly',

			propiedadIntelectual: ['Patente de invención', 'Patente de modelo de utilidad', 'Derechos de autor (software)', 'Otro', 'Ninguno'],

			trlActual: 'TRL 1',

		}),

		mounted() {

			this.consultarAnterior();

		},
		computed: {

			...mapGetters(['ruta']),

		},

		methods: {

			sumarTotal: function() {

				this.datos[3] = '$';

				var suma = parseFloat(this.adquirirNumeros(this.datos[0])) + parseFloat(this.adquirirNumeros(this.datos[1])) + parseFloat(this.adquirirNumeros(this.datos[2]));

				console.log(parseFloat(this.adquirirNumeros(this.datos[2])));

				this.datos[3] = this.formatoMoneda(suma);

				this.datos[0] = this.formatoMoneda(this.adquirirNumeros(this.datos[0]));
				this.datos[1] = this.formatoMoneda(this.adquirirNumeros(this.datos[1]));
				this.datos[2] = this.formatoMoneda(this.adquirirNumeros(this.datos[2]));

				this.enviarTodo();

			},

			adquirirNumeros: function(numero) {

				var num = numero.replace('.', '');

				var n = num.replace('$', '');

				return n;

			},

			mostrarProductoObtenido: function() {

				if (this.datos[4] == 'Productos resultado de actividades de generación de nuevo conocimiento'){

					this.productoObtenido = ['Artículos de investigación A1, A2, B y C', 'Artículos de investigación D', 'Notas científicas', 'Libros resultado de investigación', 'Capítulos en libro resultado de investigación', 'Productos tecnológicos patentados o en proceso de concesión de la patente', 'Variedades vegetales, nuevas razas animales y poblaciones mejoradas de razas pecuarias', 'Obras o productos de investigacióncreación en Artes, Arquitectura y Diseño'];

				}else if (this.datos[4] == 'Productos resultado de actividades de desarrollo tecnológico e innovación - productos tecnologicos certificados o validados'){

					this.productoObtenido = ['Diseño industrial', 'Esquema de circuito integrado', 'Software', 'Planta piloto', 'Prototipo industrial', 'Signos distintivos', 'Producto nutracéutico', 'Colección científica', 'Nuevo registro científico'];

				}else if (this.datos[4] == 'Productos resultado de actividades de desarrollo tecnológico e innovación - productos empresariales'){

					this.productoObtenido = ['Secreto empresarial', 'Empresas de base tecnológica (spin-off y start-up)', 'Empresas creativas y culturales', 'Innovaciones generadas en la gestión empresarial', 'Innovaciones en procesos', 'Procedimientos y servicios'];

				}else if (this.datos[4] == 'Productos resultado de actividades de desarrollo tecnológico e innovación - Regulaciones, normas, reglamentos o legislaciones'){

					this.productoObtenido = ['Regulaciones', 'Regulaciones', 'Reglamentos', 'Legislaciones', 'Guías (práctica clínica y manejo clínico forense)', 'Protocolos (vigilancia epidemiológica y atención a pacientes)', 'Protocolos (vigilancia epidemiológica y atención a pacientes)'];

				}else if (this.datos[4] == 'Productos resultado de actividades de desarrollo tecnológico e innovación - Conceptos técnicos e informes técnicos'){

					this.productoObtenido = ['Conceptos técnicos e informes técnicos'];

				}else if (this.datos[4] == 'Productos resultado de actividades de desarrollo tecnológico e innovación - Registros de Acuerdos de licencia para la explotación de obras protegidas por derecho de autor'){

					this.productoObtenido = ['Acuerdos de licencia para la explotación de obras protegidas por derecho de autor'];

				}else if (this.datos[4] == 'Productos resultado de actividades de apropiación social del conocimiento - Participación ciudadana en CTeI y creación'){

					this.productoObtenido = ['Participación ciudadana o comunidad(es) en proyectos de investigación', 'Espacio/evento de participación ciudadana o de comunidad(es) en relación con la CTeI'];

				}else if (this.datos[4] == 'Productos resultado de actividades de apropiación social del conocimiento - Estrategias pedagógicas para el fomento de la CTeI'){

					this.productoObtenido = ['Programa/Estrategia pedagógica de fomento a la CTeI', 'Incluye la formación de redes de fomento de la apropiación social del conocimiento'];

				}else if (this.datos[4] == 'Productos resultado de actividades de apropiación social del conocimiento - Comunicación social del conocimiento') {

					this.productoObtenido = ['Estrategias de comunicación del conocimiento', 'Generación de contenido impreso', 'Generación de contenido multimedia', 'Generación de contenidos virtuales', 'Generación de contenido de audio'];

				}else if (this.datos[4] == 'Productos resultado de actividades de apropiación social del conocimiento - Circulación de conocimiento especializado') {

					this.productoObtenido = ['Eventos científicos', 'Participación en redes de conocimiento', 'Talleres de creación', 'Eventos culturales y artísticos', 'Documentos de trabajo (working papers)', 'Nueva secuencia genética', 'Boletines divulgativos de resultado de investigación', 'Ediciones de revista científica o de libros resultado de investigación', 'Informes finales de investigación', 'Consultorías (científicotecnológicas y arte, arquitectura y diseño)'];

				}else if (this.datos[4] == 'Productos de actividades relacionadas con la formación de recurso humano para la CTel-dirección de tesis de doctorado') {

					this.productoObtenido = ['Dirección/Tutoría  de Tesis de Doctorado', 'Codirección/Cotutoría de Tesis de Doctorado'];

				}else if (this.datos[4] == 'Productos de actividades relacionadas con la formación de recurso humano para la CTel-Dirección de trabajo de grado de maestría') {

					this.productoObtenido = ['Dirección/Tutoría de Trabajo de grado de maestría', 'Codirección/Cotutoría de Trabajo de grado de maestría'];

				}else if (this.datos[4] == 'Productos de actividades relacionadas con la formación de recurso humano para la CTel-Dirección de trabajo de grado de pregrado') {

					this.productoObtenido = ['Dirección/Tutoría de Trabajo de grado de pregrado', 'Codirección/Cotutoría de Trabajo de grado de pregrado'];

				}else if (this.datos[4] == 'Productos de actividades relacionadas con la formación de recurso humano para la CTeI-Proyectos de investigación y desarrollo') {

					this.productoObtenido = ['Proyectos ejecutados por los Grupos de Investigación en calidad de Investigador principal'];

				}else if (this.datos[4] == 'Productos de actividades relacionadas con la formación de recurso humano para la CTeI-Proyectos de investigación-creación') {

					this.productoObtenido = ['Proyectos ejecutados por los Grupos de Investigación en calidad de Investigador principal'];

				}else if (this.datos[4] == 'Productos de actividades relacionadas con la formación de recurso humano para la CTeI-Proyectos de investigación, desarrollo e innovación (ID+I)') {

					this.productoObtenido = ['Proyectos ejecutados por investigadores en empresas', 'Proyectos ejecutados por jovenes investigadores en empresas'];

				}else if (this.datos[4] == 'Productos de actividades relacionadas con la formación de recurso humano para la CTeI-Apoyo a creación de programas o cursos de formación de investigadores') {

					this.productoObtenido = ['Apoyo a la creación de programas de maestria o doctorado', 'Apoyo a la creación de cursos de maestria o doctorado'];

				}else if (this.datos[4] == 'Productos de actividades relacionadas con la formación de recurso humano para la CTeI-Acompañamientos y asesorías de línea temática del programa ondas') {

					this.productoObtenido = ['Productos de actividades relacionadas con la formación de recurso humano para la CTeI-Acompañamientos y asesorías de línea temática del programa ondas', 'Productos de actividades relacionadas con la formación de recurso humano para la CTeI-Acompañamientos y asesorías de línea temática del programa ondas'];

				}else {

					this.productoObtenido = [];

				}

				//this.enviarTodo();

			},

			enviarTodo: function() {

				axios.post(this.ruta + 'recepcionFormularioValidacion.php', {datos: this.datos, id_proyecto: this.$route.params.id}).then(response => {

					console.log(response.data);

				});

			},

			consultarAnterior: function() {

				axios.post(this.ruta + 'recepcionFormularioValidacion.php', {consultar: this.datos, id_proyecto: this.$route.params.id}).then(response => {

					this.trlActual = response.data.trl_proyecto;

					this.datos[0] = this.formatoMoneda(response.data.pregunta0);
					this.datos[1] = this.formatoMoneda(response.data.pregunta1);
					this.datos[2] = this.formatoMoneda(response.data.pregunta2);
					this.datos[3] = this.formatoMoneda(response.data.pregunta3);
					this.datos[4] = response.data.pregunta4;

					this.mostrarProductoObtenido();

					this.datos[5] = response.data.pregunta5;
					this.datos[6] = response.data.pregunta6;
					this.datos[7] = response.data.pregunta7;
					this.datos[8] = response.data.pregunta8;
					this.datos[9] = response.data.pregunta9;
					this.datos[10] = this.formatoMoneda(response.data.pregunta10);
					this.datos[11] = this.formatoMoneda(response.data.pregunta11);
					this.datos[12] = this.formatoMoneda(response.data.pregunta12);
					this.datos[13] = this.formatoMoneda(response.data.pregunta13);
					this.datos[14] = this.formatoMoneda(response.data.pregunta14);
					this.datos[15] = response.data.pregunta15;
					this.datos[16] = response.data.pregunta16;
					this.datos[17] = response.data.pregunta17;
					this.datos[18] = response.data.pregunta18;
					this.datos[19] = response.data.pregunta19;
					this.datos[20] = response.data.pregunta20;
					this.datos[21] = response.data.pregunta21;
					this.datos[22] = response.data.pregunta22;
					this.datos[23] = response.data.pregunta23;
					this.datos[24] = response.data.pregunta24;
					this.datos[25] = response.data.pregunta25;
					this.datos[26] = response.data.pregunta26;
					this.datos[27] = response.data.pregunta27;
					this.datos[28] = response.data.pregunta28;
					this.datos[29] = response.data.pregunta29;

				});

			},

			formatoMoneda: function(numero) {

				if (numero != "undefined" && numero != null && numero != "") {

					let inputNum = numero

					inputNum = inputNum.toString()

					inputNum = inputNum.split('.')

					if (!inputNum[1]) {

						inputNum[1] = '00'

					}

					let separados

					if (inputNum[0].length > 3) {
						let uno = inputNum[0].length % 3
						if (uno === 0) {
							separados = []
						} else {
							separados = [inputNum[0].substring(0, uno)]
						}
						let posiciones = parseInt(inputNum[0].length / 3)
						for (let i = 0; i < posiciones; i++) {
							let pos = ((i * 3) + uno)
							separados.push(inputNum[0].substring(pos, (pos + 3)))
						}
					} else {
						separados = [inputNum[0]]
					}

					return '$' + separados.join('.')

				}else {

					return '$';

				}

			},

			quitarReadOnlyEnviar1: function() {

				this.esLectura = (this.datos[16] == 'Sí') ? false : 'readonly';

				this.enviarTodo();

			},

			quitarReadOnlyEnviar2: function() {

				this.esLecturaSiNo3=(thisdatos[21] == 'Sí') ? false : 'readonly'

				this.enviarTodo();

			},

			quitarReadOnlyEnviar3: function() {

				this.esLecturaPropiedad = (this.datos[27] == 'Sí') ? false : 'readonly'

				this.enviarTodo();

			}

		}

	}

</script>