<style>

.contenedorResultado {

	padding: 1em;
	cursor: pointer;
	border-top: 2px solid #FFFFFF;

}

.contenedorResultado h1, .contenedorResultado h2, .contenedorResultado h3 {

	text-align: center;
	border-bottom: 1px solid #59B548;

}

.contenedorResultado h1 span, .contenedorResultado h2 span, .contenedorResultado h3 span {

	color: #FF6B00;

}

</style>

<template>
	
	<div>

		<v-form>

			<v-container>

				<v-row>

					<v-col cols="12" md="4">

						<v-text-field dark v-model="nombreResultado" @keyup="filtrarResultados" label="Filtrar por nombre del resultado de investigación" required></v-text-field>

					</v-col>

					<v-col cols="12" md="4">

						<v-text-field dark v-model="nombreInvestigador" @keyup="filtrarResultados" label="Filtrar por nombre de investigador" required></v-text-field>

					</v-col>

					<v-col cols="12" md="4">

						<v-text-field dark v-model="codigoResultado" @keyup="filtrarResultados" label="Filtrar por código (SGPS, SIGP, Iniciativa de centro)" required></v-text-field>

					</v-col>

				</v-row>

				<v-row>

					<v-col cols="12" md="3">

						<v-select dark v-model="trlResultado" :items="listaTrl" @change="filtrarResultados" label="Filtrar por TRL del resultado de investigación" required></v-select>

					</v-col>

					<v-col cols="12" md="3">

						<v-select dark v-model="regionalResultado" :items="regionales" item-value="id_regional" item-text="nombre_regional" label="Filtrar por regional del resultado de investigación" @change="filtrarResultados"></v-select>

					</v-col>

					<v-col cols="12" md="3" v-if="$store.state.rol != 11" @click="filtrarResultados">

						<v-checkbox dark v-model="checkbox" label="Filtrar resultados propios" :value="$store.state.documento"></v-checkbox>

					</v-col>

					<div v-else>

						<v-text-field dark v-model="checkbox" @keyup="filtrarResultados" style="display: none;"></v-text-field>

					</div>

					<v-col cols="12" md="3">

						<v-btn color="info" style="width: 100%; margin-top: 10px;" @click="reporteGeneral">Descargar reporte</v-btn>

					</v-col>

				</v-row>

			</v-container>

		</v-form>

		<v-divider dark></v-divider>

		<div v-if="listaResultados[0] == null">
			
			<iframe src="https://app.powerbi.com/view?r=eyJrIjoiNTIzZTJlNGUtNzViMC00OGU4LThmZmUtMDQ1ZDc5MGEzNDg3IiwidCI6ImNiYzJjMzgxLTJmMmUtNGQ5My05MWQxLTUwNmM5MzE2YWNlNyIsImMiOjR9" frameborder="0" style="width: 100%; height: calc(100vh - 60px);"></iframe>

		</div>

		<div v-else>

			<div class="contenedorResultado" v-for="(dato, indice) in listaResultados">

				<div @click="modificarResultado(dato.id_proyecto)">

					<h2 style="color: #FFFFFF;">{{ dato.nombre_proyecto }} <span>({{ dato.ano_proyecto }})</span></h2>

					<h2 style="color: #FFFFFF;">{{ dato.nombre_tecnologia }} - <span v-if="dato.tipoCodigo_proyecto == null">Código sin actualizar</span><span v-else>Código {{ dato.tipoCodigo_proyecto }}</span>: {{ dato.sgps_proyecto }}</h2>

					<h2 style="color: #FFFFFF;"><span>{{ dato.trl_proyecto }}</span> - {{ dato.ctei_proyecto }}</h2>

					<h2 style="color: #FFFFFF;">Categoría de priorización SENNOVA: <span>{{ dato.especifico_resultado }}</span></h2>

					<h2 style="color: #FFFFFF;">{{ dato.nombre_regional }}</h2>

					<h3 style="color: #FFFFFF;">Fecha de registro en ValTec: <span>{{ dato.fecha_inicio }}</span></h3>

					<h3 style="color: #FFFFFF;">Fecha de última modificación: <span v-if="dato.ultima_modificacion == null">No se han registrado cambios</span><span v-else>{{ dato.ultima_modificacion }}</span></h3>

				</div>

				<v-row>

					<v-col cols="12" md="3">

						<v-btn style="min-width: 90%; max-width: 90%; margin-left: 5%;" color="primary" large @click="reporteEspecifico(dato.id_proyecto)">Descargar reporte</v-btn>

					</v-col>

					<v-col cols="12" md="3">

						<v-btn style="min-width: 90%; max-width: 90%; margin-left: 5%;" color="warning" large @click="modificarResultado(dato.id_proyecto)">Modificar</v-btn>

					</v-col>

					<v-col cols="12" md="3">

						<v-btn style="min-width: 90%; max-width: 90%; margin-left: 5%;" color="secondary" large @click="mostrarTRL(dato.id_proyecto)">Valoración TRL</v-btn>

					</v-col>

					<v-col cols="12" md="3">

						<v-btn style="min-width: 90%; max-width: 90%; margin-left: 5%;" dark color="institucional" large @click="abrirValidacion(dato.id_proyecto)">Validación</v-btn>

					</v-col>

				</v-row>

			</div>

		</div>

	</div>

</div>

</template>

<script>

	import { mapGetters } from 'vuex'

	export default {

		name: 'ListaResultados',
		data: () => ({

			listaResultados: [null],
			listaTrl: ['', 'TRL 1', 'TRL 2', 'TRL 3', 'TRL 4', 'TRL 5', 'TRL 6', 'TRL 7', 'TRL 8', 'TRL 9'],
			regionales: [''],
			nombreResultado: '',
			nombreInvestigador: '',
			codigoResultado: '',
			trlResultado: null,
			regionalResultado: '',
			checkbox: '',

		}),
		mounted () {

			//this.consultarResultados();
			this.llenarRegionales();
			this.llenarCheck();

		},
		computed: {

			...mapGetters(['documento', 'rol', 'ruta']),

		},
		methods: {

			consultarResultados: function() {

				axios.post(this.ruta + 'recepcionFiltrosLista.php', {consultarLista:true, rolUsuario:this.$store.state.rol}).then(response => {

					this.listaResultados = response.data;

				});

			},

			alertarId: function(id) {

				alert(id);

			},

			mostrarTRL: function(id) {

				this.$router.push('/inicio/valoracion/' + id);

			},

			modificarResultado(id) {

				this.$router.push('/inicio/modificarResultado/' + id);

			},

			abrirValidacion(id) {

				this.$router.push('/inicio/validacion/' + id);

			},

			filtrarResultados() {

				if (this.nombreResultado == "" && this.nombreInvestigador == "" && this.codigoResultado == "" && this.trlResultado == null && this.regionalResultado == "") {

					this.listaResultados = this.listaResultados.splice(1);

					this.listaResultados[0] = null;

				}else {

					axios.post(this.ruta + 'recepcionFiltrosLista.php', {filtrarResultados:true, nombreTecnologia:this.nombreResultado, nombreInvestigador:this.nombreInvestigador, filtrarCodigo:this.codigoResultado, trlProyecto:this.trlResultado, regionalProyecto:this.regionalResultado, proyectosPropios:this.checkbox}).then(response => {

						this.listaResultados = response.data;

						console.log(response.data)

					});

				}

			},

			reporteGeneral() {

				axios.post(this.ruta + 'recepcionReportes.php', {reporteGeneral:true, nombreTecnologia:this.nombreResultado, nombreInvestigador:this.nombreInvestigador, filtrarCodigo:this.codigoResultado, trlProyecto:this.trlResultado, regionalProyecto:this.regionalResultado, proyectosPropios:this.checkbox}).then(response => {

					window.open('http://sistema.valtec.systems/' + response.data);

				});

			},

			reporteEspecifico(id) {

				axios.post(this.ruta + 'recepcionReportes.php', {reporteEspecifico:id}).then(response => {

					window.open('https://sistema.valtec.systems/' + response.data);

				});

			},

			llenarRegionales: function() {

				axios.post(this.ruta + 'recepcionResultadosInvestigacion.php', {consultarRegional:true}).then(response => {

					this.regionales = response.data;

				});

			},

			llenarCheck: function() {

				if (this.$store.state.rol == 11) {

					this.checkbox = this.documento;

				}

			}

		}

	}

</script>