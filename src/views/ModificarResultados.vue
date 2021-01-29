<style>

.fondoNegro {

	background-color: #5A5A5A;
	min-height: calc(100vh - 60px);
	max-height: 100%;
	min-width: 100%;
	max-width: 100%;
	text-align: justify;

}

.fondoNegro .contenedor {

	position: relative;
	color: #FFFFFF;
	min-height: calc(100vh - 60px);
	min-width: 100%;
	max-width: 100%;
	padding: 1em;
	overflow-x: hidden;
	text-align: justify;

}

.fondoNegro .contenedor .tituloFranjaNaranja {

	font-size: 4em;
	text-align: center;
	border-bottom: 4px solid #FF6B00;
	border-radius: 5px;
	margin-bottom: 20px;

}

.fondoNegro .contenedor h2 {

	text-align: center;
	padding: 1em;

}

</style>

<template>

	<div>

		<app-menu></app-menu>
		
		<div class="fondoNegro">

			<vue-particles style="position: fixed; z-index: 0; width: 100%; height: 100%; top: 0; left: 0; max-height: 100%;" color="#D3D3D3"></vue-particles>

			<div class="contenedor">

				<br>

				<v-divider dark></v-divider>

				<h2>DATOS DEL RESULTADO DE INVESTIGACIÓN</h2>

				<v-divider dark></v-divider>

				<v-form>

					<v-row>

						<v-col cols="12" md="6">

							<v-text-field dark v-model="nombreProyecto" :rules="validacionVacios" label="Nombre del proyecto" autocomplete="off" required></v-text-field>

						</v-col>

						<v-col cols="12" md="6">

							<v-text-field dark v-model="nombreResultado" :rules="validacionVacios" label="Nombre del resultado de investigación" autocomplete="off" required></v-text-field>

						</v-col>

					</v-row>

					<v-row>

						<v-col cols="12" md="3">

							<v-select v-model="tipologiaResultado" dark :items="tipologias" :rules="validacionVacios" label="Tipología del resultado de investigación según Colciencias" @change="llenarGrupo" autocomplete="off" required></v-select>

						</v-col>

						<v-col cols="12" md="3">

							<v-select v-model="grupoResultado" dark :items="gruposResultados" :rules="validacionVacios" label="Grupo del resultado de investigación según la tipografía" autocomplete="off" required></v-select>

						</v-col>

						<v-col cols="12" md="3">

							<v-radio-group dark v-model="tipoPriorizacion" @change="llenarAreas" column>

								<v-radio label="COVID" value="covid"></v-radio>
								<v-radio label="ÁREAS DE CONOCIMIENTO" value="area"></v-radio>

							</v-radio-group>

						</v-col>

						<v-col cols="12" md="3">

							<v-select v-model="areaResultado" dark :items="areasConocimiento" :rules="validacionVacios" label="Categoría del resultado de investigación" @change="llenarSubAreas" autocomplete="off" required></v-select>

						</v-col>

					</v-row>

					<v-row>

						<v-col cols="12" md="6">

							<v-select v-model="subArea" dark :items="subAreasConocimiento" :rules="validacionVacios" label="Sub-área de conocimiento" autocomplete="off" required></v-select>

						</v-col>

						<v-col cols="12" md="6">

							<v-select v-model="redConocimiento" dark :items="redesConocimiento" item-value="id_red" item-text="nombre_red" :rules="validacionVacios" label="Redes de conocimiento" autocomplete="off" required></v-select>

						</v-col>

					</v-row>

					<v-row>

						<v-col cols="12" md="6">

							<v-radio-group dark v-model="tipoCodigo" @change="mostrarEjemploCodigo" row>

								<v-radio label="Código SGPS" value="SGPS"></v-radio>
								<v-radio label="Código SIGP" value="SIGP"></v-radio>
								<v-radio label="Iniciativa de centro" value="Iniciativa de centro"></v-radio>

							</v-radio-group>

						</v-col>

						<v-col cols="12" md="6">

							<v-text-field dark v-model="cofigoIdentificacion" :rules="validacionVacios" :hint="hintCodigo" label="Código de identificación" autocomplete="off" required></v-text-field>

						</v-col>

					</v-row>

					<v-row>

						<v-col cols="12" md="4">

							<v-select dark v-model="regionalResultado" :items="regionales" item-value="id_regional" item-text="nombre_regional" :rules="validacionVacios" label="Regional del resultado de investigación" @change="llenarCentros" required></v-select>

						</v-col>

						<v-col cols="12" md="4">

							<v-select dark v-model="centroResultado" :items="centros" item-value="id_centro" item-text="nombre_centro" :rules="validacionVacios" label="Centro de formación del resultado de investigación" @change="llenarGruposInvestigacion" required></v-select>

						</v-col>

						<v-col cols="12" md="4">

							<v-select dark v-model="grupoInvestigacionResultado" :items="gruposInvestigacion" item-value="id_grupo" item-text="nombre_grupo" :rules="validacionVacios" label="Grupo de investigación del resultado de investigación" required></v-select>

						</v-col>

					</v-row>

					<v-row>

						<v-col cols="12">

							<v-select v-model="anoResultado" dark :items="añosPublicacion" :rules="validacionVacios" label="Año publicación resultado de investigación" required></v-select>

						</v-col>

					</v-row>

					<div v-for="investigador in nuevoInvestigador" id="muestraInvestigadores">

						<v-row>

							<v-col cols="12" md="3">

								<v-text-field v-model="documentoInvestigador[investigador]" dark :rules="validacionVacios" label="Documento del investigador" autocomplete="off" required></v-text-field>

							</v-col>

							<v-col cols="12" md="3">

								<v-text-field v-model="nombreInvestigador[investigador]" dark :rules="validacionVacios" label="Nombre y apellido del investigador" autocomplete="off" required></v-text-field>

							</v-col>

							<v-col cols="12" md="3">

								<v-select v-model="rolInvestigador[investigador]" dark :items="rolesInvestigadores" :rules="validacionVacios" label="Rol del investigador en este resultado" required></v-select>

							</v-col>

							<v-col v-if="investigador == 0" cols="12" md="3">

								<v-btn color="info" style="width: 90%; margin-left: 5%;" @click="agregarInvestigador">Agregar</v-btn>

							</v-col>

						</v-row>

					</div>

					<v-row>

						<v-col cols="12">

							<v-textarea dark v-model="resenaResultado" label="Reseña del resultado de investigación" @keyup="contarPalabaras"></v-textarea>
							<small>Palabras escritas: {{ palabras }}. Palabras disponibles: <span>{{ limitePalabras }}</span></small>

						</v-col>

					</v-row>

					<v-row>

						<v-col cols="12">

							<v-switch v-model="aceptar" label="He leído y acepto la Política de privacidad del SENA." dark color="institucional"></v-switch>

						</v-col>

					</v-row>

					<v-row>

						<v-col cols="12" md="6">

							<v-text-field v-model="fechaRegisto" dark :rules="validacionVacios" label="Fecha registro" autocomplete="off" required readonly></v-text-field>

						</v-col>

						<v-col cols="12" md="6">

							<v-text-field v-model="fechaModificacion" dark :rules="validacionVacios" label="Fecha modificación" autocomplete="off" required readonly></v-text-field>

						</v-col>

					</v-row>

					<v-row>

						<v-col cols="12" md="5">

							<v-btn color="error" to='/inicio/resultados' large text style="width: 90%; margin-left: 5%;">Cancelar</v-btn>

						</v-col>

						<v-col cols="12" md="7">

							<v-btn color="primary" style="width: 90%; margin-left: 5%;" @click="actualizarDatos">Actualizar</v-btn>

						</v-col>

					</v-row>

				</v-form>

				<v-snackbar v-model="snackbar">

					{{ textoSnackbar }}

					<template v-slot:action="{ attrs }">

						<v-btn color="institucional" text v-bind="attrs" @click="snackbar = false">

							Cerrar

						</v-btn>

					</template>

				</v-snackbar>

			</div>

		</div>

	</div>

</template>

<script>

	import MenuSesion from '../components/MenuSesion.vue';
	import { mapGetters, mapActions } from 'vuex';

	export default {

		name: 'RegistrarResultados',
		components: {

			'app-menu': MenuSesion,

		},
		data: () => ({

			snackbar: false,
			textoSnackbar: '',
			menuLateral: false,
			nombreProyecto: '',
			nombreResultado: '',
			tipologiaResultado: '',
			grupoResultado: '',
			tipoPriorizacion: '',
			areaResultado: '',
			subArea: '',
			redConocimiento: '',
			tipoCodigo: '',
			cofigoIdentificacion: '',
			regionalResultado: '',
			centroResultado: '',
			grupoInvestigacionResultado: '',
			hintCodigo: 'Seleccione un tipo de código.',
			tipologias: ['Productos resultados de actividades de generación de nuevo conocimiento', 'Productos resultados de actividades de desarrollo tecnológico e innovación'],
			gruposResultados: [],
			areasConocimiento: [],
			subAreasConocimiento: [],
			redesConocimiento: [],
			regionales: [],
			centros: [],
			gruposInvestigacion: [],
			validacionTextos: [

			v => /^[a-zA-ZÀ-ÿ\u00f1\u00d1]+(\s*[a-zA-ZÀ-ÿ\u00f1\u00d1]*)*[a-zA-ZÀ-ÿ\u00f1\u00d1]+$/g.test(v) || 'Este campo debe contener solamente caracteres alfabéticos',

			],
			validacionVacios: [

			v => !!v || 'Este campo es obligatorio.',

			],
			rolesInvestigadores: ['Ingreso de información', 'Investigador principal', 'Coinvestigador'],
			documentoInvestigador: [],
			nombreInvestigador: [],
			rolInvestigador: [],
			nuevoInvestigador: [],
			resenaResultado: '',
			palabras: 0,
			limitePalabras: 150,
			fechaRegisto: '',
			fechaModificacion: '',
			aceptar: true,
			añosPublicacion: [2020, 2019, 2018, 2017, 2015],
			anoResultado: 2015,

		}),
		mounted() {

			this.consultarResultados();

			this.fechaActual();

			this.consultarInvestigadores();

			this.verificarInicio();

		},
		computed: {

			...mapGetters(['ruta']),

		},
		methods: {

			...mapActions(['verificarInicio']),

			llenarGrupo: function() {

				if (this.tipologiaResultado == 'Productos resultados de actividades de generación de nuevo conocimiento') {

					this.gruposResultados = ['Productos teconológicos patentados o en proceso de concesión de patente', 'Variedades vegetales, nuevas razas de animales y poblaciones mejoradas de razas pecuarias', 'Obras o productos de investigación-creación en Artes, Arquitectura y Diseño'];

				}else if (this.tipologiaResultado == 'Productos resultados de actividades de desarrollo tecnológico e innovación') {

					this.gruposResultados = ['Productos teconológicos certificados o validados', 'Productos empresariales', 'Regulaciones, normas, reglamentos o legislaciones', 'Conceptos técnicos e informes técnicos', 'Registro de Acuerdos de licencia para la explotación de obras protegidas por derecho de autor'];

				}else {

					this.gruposResultados = [];

				}

			},

			llenarAreas: function() {

				if (this.tipoPriorizacion == "covid") {

					this.areasConocimiento = ['Seguridad alimentaria', 'Energías renovables', 'Gestión en salud', 'Biodiversidad y consumo responsable', 'Desarrollo de software, trabajo y formación infantil', 'Agricultura y agroindustria', 'Salud mental', 'Recursos no renovables'];

				}else if (this.tipoPriorizacion == "area") {

					this.areasConocimiento = ['Agronomía, veterinaria y afines', 'Bellas Artes', 'Ciencias de la educación', 'Ciencias de la salud', 'Ciencias sociales y humanas', 'Economía, administración, contaduría y afines', 'Ingeniería, arquitectura, urbanismo y afines', 'Matemáticas y ciencias naturales'];

				}else {

					this.areasConocimiento = [];

				}

			},

			llenarSubAreas: function() {

				if (this.areaResultado == "Agronomía, veterinaria y afines") {

					this.subAreasConocimiento = ['Agronomía', 'Medicina veterinaria', 'Zootecnia'];

				}else if (this.areaResultado == "Bellas Artes") {

					this.subAreasConocimiento = ['Artes plásticas, visuales y afines', 'Artes representativas', 'Diseño', 'Música', 'Otros programas asociados a bellas artes', 'Publicidad y afines'];

				}else if (this.areaResultado == "Ciencias de la educación") {

					this.subAreasConocimiento = ['Educación'];

				}else if (this.areaResultado == "Ciencias de la salud") {

					this.subAreasConocimiento = ['Bateriología', 'Enfermería', 'Instrumentación quirúrjica', 'Medicina', 'Nutrición y detética', 'Odontología', 'Optometría', 'Salud pública', 'Terapias', 'Otros programas de ciencias de la salud'];

				}else if (this.areaResultado == "Ciencias sociales y humanas") {

					this.subAreasConocimiento = ['Antropología, artes liberales', 'Bibliotecología', 'Ciencia política, relaciones internacionales', 'Comunicación social, periodismo y afines', 'Deportes, educación física y recreación', 'Derecho y afines', 'Filosofía, teología y afines', 'Formación relacionada con el campo militar o policial', 'Geografía, historia', 'Lenguas modernas, literatura, lingüisticay afines', 'Psicología', 'Sociología, trabajo social y afines'];

				}else if (this.areaResultado == "Economía, administración, contaduría y afines") {

					this.subAreasConocimiento = ['Administración', 'Contaduría pública', 'Economía'];

				}else if (this.areaResultado == "Ingeniería, arquitectura, urbanismo y afines") {

					this.subAreasConocimiento = ['Arquitectura', 'Ingeniería administrativa y afines', 'Ingeniería agrícola, forestal y afines', 'Ingeniería agroindustrial, alimentos y afines', 'Ingeniería agronómica, pecuaria y afines', 'Ingeniaría ambiental, sanitaria y afines', 'Ingeniería biomédica y afines', 'Ingeniería civil y afines', 'Ingeniería de minas, metaluergia y afines', 'Ingeniería de sistemas, telemática y afines', 'Ingeniería eléctrica y afines', 'Ingeniería electrónica, telecomunicaciones y afines', 'Ingeniería industrial y afines', 'Ingeniería mecánica y afines', 'Ingeniería química y afines', 'Otras ingenierías'];

				}else if (this.areaResultado == "Matemáticas y ciencias naturales") {

					this.subAreasConocimiento = ['Biología, microbiología y afines', 'Física', 'Geología, otros programas de ciencia naturales', 'Matemáticas, estadísticas y afines', 'Química y afines'];

				}else {

					this.subAreasConocimiento = ['No aplica'];

				}

			},

			llenarRedesConocimiento: function() {

				axios.post(this.ruta + 'recepcionResultadosInvestigacion.php', {consultarRedes:true}).then(response => {

					this.redesConocimiento = response.data;

				});

			},

			mostrarEjemploCodigo: function() {

				if (this.tipoCodigo == "SGPS") {

					this.hintCodigo = "Código SGPS. Ejemplo: 4560";

				}else if (this.tipoCodigo == "SIGP") {

					this.hintCodigo = "Código SIGP. Ejemplo: 5B2C23A67E97 AB02B0664E87 61114878";

				}else if (this.tipoCodigo == "Iniciativa de centro") {

					this.hintCodigo = "Iniciativa de centro. Ejemplo: PRO21456";

				}else {

					this.hintCodigo = "Seleccione un tipo de código.";

				}

			},

			llenarRegionales: function() {

				axios.post(this.ruta + 'recepcionResultadosInvestigacion.php', {consultarRegional:true}).then(response => {

					this.regionales = response.data;

				});

			},

			llenarCentros: function() {

				axios.post(this.ruta + 'recepcionResultadosInvestigacion.php', {consultarCentro:this.regionalResultado}).then(response => {

					this.centros = response.data;

				});

			},

			llenarGruposInvestigacion: function() {

				axios.post(this.ruta + 'recepcionResultadosInvestigacion.php', {consultarGrupos:this.centroResultado}).then(response => {

					this.gruposInvestigacion = response.data;

				});

			},

			consultarResultados: function() {

				axios.post(this.ruta + 'recepcionResultadosInvestigacion.php', {consultarResultado:this.$route.params.id}).then(response => {

					this.nombreProyecto = response.data[0].nombre_proyecto;
					this.nombreResultado = response.data[0].nombre_tecnologia;
					this.tipologiaResultado = response.data[0].tipo_resultado;
					this.grupoResultado = response.data[0].grupo_resultado;
					this.areaResultado = response.data[0].especifico_resultado;
					this.subArea = response.data[0].subarea_proyecto;
					this.tipoCodigo = response.data[0].tipoCodigo_proyecto;
					this.cofigoIdentificacion = response.data[0].sgps_proyecto;
					this.regionalResultado = response.data[0].id_regional;
					this.centroResultado = response.data[0].id_centro;

					this.anoResultado = response.data[0].ano_proyecto;

					this.llenarCentros();

					this.llenarRedesConocimiento();

					this.redConocimiento = response.data[0].id_area;

					this.llenarRegionales();
					this.llenarGrupo();
					this.llenarSubAreas();

					this.llenarGruposInvestigacion();

					this.grupoInvestigacionResultado = response.data[0].id_grupo;

					var covid = ['Seguridad alimentaria', 'Energías renovables', 'Gestión en salud', 'Biodiversidad y consumo responsable', 'Desarrollo de software, trabajo y formación infantil', 'Agricultura y agroindustria', 'Salud mental', 'Recursos no renovables'];

					var normales = ['Agronomía, veterinaria y afines', 'Bellas Artes', 'Ciencias de la educación', 'Ciencias de la salud', 'Ciencias sociales y humanas', 'Economía, administración, contaduría y afines', 'Ingeniería, arquitectura, urbanismo y afines', 'Matemáticas y ciencias naturales'];

					for (var i = 0; i < 8; i++) {

						if (this.areaResultado == covid[i]) {

							this.tipoPriorizacion = 'covid';

							this.llenarAreas();

							this.areaResultado = response.data[0].especifico_resultado;

						}

					}

					for (var i = 0; i < 8; i++) {

						if (this.areaResultado == normales[i]) {

							this.tipoPriorizacion = 'area';

							this.llenarAreas();

							this.areaResultado = response.data[0].especifico_resultado;

						}

					}

					this.fechaRegisto = response.data[0].fecha_inicio;

					this.resenaResultado = response.data[0].resumen_proyecto;

					this.contarPalabaras();

				});

			},

			agregarInvestigador: function() {

				var posicion = this.nuevoInvestigador[this.nuevoInvestigador.length - 1];

				this.nuevoInvestigador.push(posicion + 1);

			},

			quitarInvestigador: function(posicion) {

				if (this.nuevoInvestigador.indexOf(posicion) != 0) {

					this.documentoInvestigador.splice(this.nuevoInvestigador.indexOf(posicion), 1);
					this.nombreInvestigador.splice(this.nuevoInvestigador.indexOf(posicion), 1);
					this.rolInvestigador.splice(this.nuevoInvestigador.indexOf(posicion), 1);

					this.nuevoInvestigador.splice(this.nuevoInvestigador.indexOf(posicion), 1);

				}

			},

			contarPalabaras: function() {

				var words = this.resenaResultado.match(/\S+/g).length;

				if (words > 150) {

					var trimmed = this.resenaResultado.split(/\s+/, 150).join(" ");

					this.resenaResultado = trimmed + " ";

				}else {

					this.palabras = words;

					this.limitePalabras = 150 - words;

				}

			},

			fechaActual: function() {

				var f = new Date();
				this.fechaModificacion = f.getFullYear() + "-" + (f.getMonth() +1) + "-" + f.getDate();

			},

			consultarInvestigadores: function() {

				axios.post(this.ruta + 'recepcionResultadosInvestigacion.php', {consultarInvestigadoresCantidad:this.$route.params.id}).then(response => {

					this.nuevoInvestigador = response.data;

				});

				axios.post(this.ruta + 'recepcionResultadosInvestigacion.php', {consultarInvestigadores:this.$route.params.id}).then(response => {

					for (var i = 0; i < response.data.length; i++) {

						this.documentoInvestigador[i] = response.data[i].documento_usuario;

						this.nombreInvestigador[i] = response.data[i].nombres_usuarios + " " + response.data[i].apellidos_usuarios;

						this.rolInvestigador[i] = response.data[i].tipo_investigador;

					}

				});

				axios.post(this.ruta + 'recepcionResultadosInvestigacion.php', {consultarTemporales:this.$route.params.id}).then(response => {

					var contador = 0;

					var posicionNueva = this.documentoInvestigador.length;

					for (var i = 0; i < response.data.length; i++) {

						this.documentoInvestigador[posicionNueva] = response.data[contador].id_temporal;

						this.nombreInvestigador[posicionNueva] = response.data[contador].nombre_temporal;

						this.rolInvestigador[posicionNueva] = response.data[contador].tipo_investigador;

						this.nuevoInvestigador.push(posicionNueva);

						contador++;

						posicionNueva++;

					}

				});

			},

			actualizarDatos: function() {

				axios.post(this.ruta + 'recepcionResultadosInvestigacion.php', {nombreProyecto: this.nombreProyecto, nombreResultado: this.nombreResultado, tipologiaResultado: this.tipologiaResultado, grupoResultado: this.grupoResultado, tipoPriorizacion: this.tipoPriorizacion, areaResultado: this.areaResultado, subArea: this.subArea, redConocimiento: this.redConocimiento, tipoCodigo: this.tipoCodigo, cofigoIdentificacion: this.cofigoIdentificacion, regionalResultado: this.regionalResultado, centroResultado: this.centroResultado, grupoInvestigacionResultado: this.grupoInvestigacionResultado, documentoInvestigador: this.documentoInvestigador, nombreInvestigador: this.nombreInvestigador, rolInvestigador: this.rolInvestigador, resenaResultado: this.resenaResultado, aceptar: this.aceptar, fechaRegisto: this.fechaRegisto, fechaModificacion: this.fechaModificacion, anoResultado:this.anoResultado, id_proyecto:this.$route.params.id, actualizarResultado:true, documento:this.documentoInvestigador, nombre:this.nombreInvestigador, rol:this.rolInvestigador}).then(response => {

					this.snackbar = true;

					this.textoSnackbar = response.data;

				});

			}

		}

	}

</script>