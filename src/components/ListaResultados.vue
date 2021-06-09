<template>
	<div>
		<v-form>
			<v-container>
				<v-row>
					<v-col cols="12" md="4">
						<v-text-field dark v-model="filterListResults.resultName" label="Filtrar por nombre del resultado de investigación" required></v-text-field>
					</v-col>
					<v-col cols="12" md="4">
						<!--<v-text-field dark v-model="filterListResults.investigatorName" label="Filtrar por nombre de investigador" required></v-text-field>-->
						<v-select dark v-model="filterListResults.trlResult" :items="trlList" label="Filtrar por TRL del resultado de investigación" required></v-select>
					</v-col>
					<v-col cols="12" md="4">
						<v-text-field dark v-model="filterListResults.sgpsResult" label="Filtrar por código (SGPS, SIGP, Iniciativa de centro)" required></v-text-field>
					</v-col>
				</v-row>

				<v-row>
					<v-col cols="12" md="4">
						<v-select dark v-model="filterListResults.regionalResult" :items="regionals" item-value="id_regional" item-text="nombre_regional" label="Filtrar por regional del resultado de investigación"></v-select>
					</v-col>
					<v-col cols="12" md="4">
						<v-btn color="institucional" style="width: 100%; margin-top: 10px;" @click="applyFilter">Filtrar RI</v-btn>
					</v-col>
					<v-col cols="12" md="4">
						<v-btn color="info" style="width: 100%; margin-top: 10px;" @click="generalReport">Descargar reporte</v-btn>
					</v-col>
				</v-row>
			</v-container>
		</v-form>
		<v-divider dark></v-divider>
		<div v-if="resultList[0] == null">
			<br>
			<h1 style="text-align: center; color: #FF6B00;">Al aplicar un filtro, haciendo click al botón naranja, se enlistarán los resultados de investigación. Este filtro también se aplicará al reporte general. Si el filtro fue aplicado, pero aún ve este mensaje, es debido a que no se encontraron coincidencias con lo buscado.</h1>
		</div>

		<div v-else>
			<div class="contenedorResultado" v-for="(dato, indice) in resultList">
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
						<v-btn style="min-width: 90%; max-width: 90%; margin-left: 5%;" color="primary" large @click="specificReport(dato.id_proyecto)">Descargar reporte</v-btn>
					</v-col>
					<v-col cols="12" md="3">
						<v-btn style="min-width: 90%; max-width: 90%; margin-left: 5%;" color="warning" large :to="'/inicio/modificarResultado/' + dato.id_proyecto">Modificar</v-btn>
					</v-col>
					<v-col cols="12" md="3">
						<v-btn style="min-width: 90%; max-width: 90%; margin-left: 5%;" color="secondary" large :to="'/inicio/valoracion/' + dato.id_proyecto">Valoración TRL</v-btn>
					</v-col>
					<v-col cols="12" md="3">
						<v-btn style="min-width: 90%; max-width: 90%; margin-left: 5%;" dark color="institucional" large :to="'/inicio/validacion/' + dato.id_proyecto">Validación</v-btn>
					</v-col>
				</v-row>
			</div>
		</div>
	</div>
</template>

<script>
	import { mapGetters, mapActions } from 'vuex'

	export default {

		name: 'ListaResultados',
		data: () => ({
			resultList: [null],
			trlList: ['TRL 1', 'TRL 2', 'TRL 3', 'TRL 4', 'TRL 5', 'TRL 6', 'TRL 7', 'TRL 8', 'TRL 9'],
			regionals: [''],
			filterListResults: {
				resultName: '',
				investigatorName: '',
				sgpsResult: '',
				trlResult: null,
				regionalResult: 0,
			},
			checkbox: '',
			comeResult: [],
		}),
		mounted () {
			this.readResults();
			this.readRegionals();
			this.validateSession();
		},
		computed: {
			...mapGetters(['route'])
		},
		methods: {
			validateSession() {
				if (localStorage.document == undefined || localStorage.email == undefined || localStorage.name == undefined || localStorage.lastName == undefined || localStorage.role == undefined || localStorage.session == false) {
					window.location.href = '/';
				}
			},
			readRegionals() {
				axios.post(this.route + 'receivers/receptionLocation.php', { typeFunction:'readRegionals' }).then(response => {
					this.regionals = response.data;
				});
			},
			generalReport() {
				if (this.resultList[0] != null) {
					axios.post(this.route + 'receivers/receptionReports.php', { typeFunction:'createGeneralReport', resultList:this.resultList }).then(response => {
						window.open(this.route + response.data);
					});
				}else {
					axios.post(this.route + 'receivers/receptionReports.php', { typeFunction:'createGeneralReport', resultList:this.comeResult }).then(response => {
						window.open(this.route + response.data);
					});
				}
			},
			specificReport(id) {
				axios.post(this.route + 'receivers/receptionReports.php', { typeFunction:'createSpecificReport', idRi:id }).then(response => {
					window.open(this.route + response.data);
				});
			},
			readResults() {
				axios.post(this.route + 'receivers/receptionResults.php', { typeFunction:'readResultList', document:localStorage.document }).then(response => {
					this.comeResult = response.data;
				});
			},
			applyFilter() {
				this.resultList = this.comeResult;
				if (this.filterListResults.resultName != "") {
					this.resultList = this.resultList.filter(data => data.nombre_proyecto.toLowerCase().includes(this.filterListResults.resultName.toLowerCase()))
				}

				if (this.filterListResults.sgpsResult != "") {
					this.resultList = this.resultList.filter(data => data.sgps_proyecto == this.filterListResults.sgpsResult)
				}

				if (this.filterListResults.trlResult != "" && this.filterListResults.trlResult != undefined) {
					this.resultList = this.resultList.filter(data => data.trl_proyecto == this.filterListResults.trlResult)
				}

				if (this.filterListResults.regionalResult != "" && this.filterListResults.regionalResult != undefined) {
				 	this.resultList = this.resultList.filter(data => parseInt(data.id_regional) == parseInt(this.filterListResults.regionalResult))
				}

				if (this.filterListResults.resultName == "" && this.filterListResults.investigatorName == "" && this.filterListResults.sgpsResult == "" && this.filterListResults.trlResult == "" && this.filterListResults.regionalResult == "" && this.filterListResults.trlResult == undefined || this.filterListResults.regionalResult == undefined) {
					this.resultList = this.resultList.splice(1);
					this.resultList[0] = null;
				}
			}
		}
	}
</script>

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