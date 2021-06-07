<template>
	<div>
		<div class="fondoNegro">
			<vue-particles style="position: absolute; z-index: 0; width: 100%; height: 100%; top: 0; left: 0; max-height: 100%;" color="#D3D3D3"></vue-particles>
			<div class="contenedor">
				<h1 class="mt-4 mb-4" style="text-align: center; color: #FFFFFF;">{{ resultName }} (<span style="color: #FF6B00;">{{ resultYear }}</span>)</h1>
				<h2 style="text-align: center; color: #FFFFFF;">{{ codeTypeResult }}: {{ resultCode }}</h2>
				<v-stepper v-model="e1">
					<v-stepper-header>
						<v-stepper-step :complete="e1 > 1" step="1" color="institucional">TRL 1</v-stepper-step>
						<v-divider></v-divider>
						<v-stepper-step :complete="e1 > 2" step="2" color="institucional">TRL 2</v-stepper-step>
						<v-divider></v-divider>
						<v-stepper-step :complete="e1 > 3" step="3" color="institucional">TRL 3</v-stepper-step>
						<v-divider></v-divider>
						<v-stepper-step :complete="e1 > 4" step="4" color="institucional">TRL 4</v-stepper-step>
						<v-divider></v-divider>
						<v-stepper-step :complete="e1 > 5" step="5" color="institucional">TRL 5</v-stepper-step>
						<v-divider></v-divider>
						<v-stepper-step :complete="e1 > 6" step="6" color="institucional">TRL 6</v-stepper-step>
						<v-divider></v-divider>
						<v-stepper-step :complete="e1 > 7" step="7" color="institucional">TRL 7</v-stepper-step>
						<v-divider></v-divider>
						<v-stepper-step :complete="e1 > 8" step="8" color="institucional">TRL 8</v-stepper-step>
						<v-divider></v-divider>
						<v-stepper-step :complete="e1 > 9" step="9" color="institucional">TRL 9</v-stepper-step>
					</v-stepper-header>

					<v-stepper-items>
						<v-stepper-content step="1">
							<h1 style="text-align: center; color: #000000;">INVESTIGACIÓN BÁSICA</h1>
							<h4 style="text-align: center; color: #000000;">Principios básicos observados y reportados. Artículos científicos publicados sobre los principios de la nueva tecnología.</h4>
							<v-divider color="institucional"></v-divider>
							<div class="mt-4 mb-8">
								<v-switch color="institucional" @change="setChecks(1)" v-model="check[0]" value="checked" label="1. ¿Finalizó con la investigación básica de su idea?"></v-switch>
								<v-switch color="institucional" @change="setChecks(1)" v-model="check[1]" value="checked" label="2. ¿Identificó principios de investigación básica que pudieran trasladarse en principios nuevos que pueden ser utilizados en nuevas tecnologías?"></v-switch>
							</div>
							<v-btn class="mr-2" color="error" to='/inicio'>Cancelar</v-btn>
							<v-btn class="mr-2" color="accent" @click="updateTrl('TRL 1')">Actualizar</v-btn>
							<v-btn class="mr-2" color="institucional" :disabled="progress[1] == 100 ? false : true" @click="transitionTRL12">Siguiente</v-btn>

							<br><br>
							<v-progress-linear :value="progress[1]" striped rounded color="primary" height="25">
								<strong>{{ Math.ceil(progress[1]) }}%</strong>
							</v-progress-linear>
							<br>
						</v-stepper-content>

						<v-stepper-content step="2">
							<h1 style="text-align: center; color: #000000;">Investigación de Laboratorio. Concepto tecnológico y/o aplicación tecnológica formulada. Investigación aplicada</h1>
							<h4 style="text-align: center; color: #000000;">Publicaciones o referencias que subrayan las aplicaciones de la nueva tecnología. Inicio de la invención.</h4>
							<v-divider color="institucional"></v-divider>
							<div class="mt-4 mb-8">
								<v-switch color="institucional" @change="setChecks(2)" v-model="check[2]" value="checked" label="1. ¿Realizó un análisis de los artículos científicos, modelos o teorías científicas que respaldan la aplicación de la idea en algún área tecnológica?"></v-switch>
								<v-switch color="institucional" @change="setChecks(2)" v-model="check[3]" value="checked" label="2. ¿Realizó estudios de búsqueda y análisis de patentes a nivel nacional e internacional, y los resultados indicaron que no existe un desarrollo igual a su idea? (benchmark tecnológico)"></v-switch>
								<v-switch color="institucional" @change="setChecks(2)" v-model="check[4]" value="checked" label="3. ¿Ha explorado principios básicos de manufacturabilidad?"></v-switch>
								<v-switch color="institucional" @change="setChecks(2)" v-model="check[5]" value="checked" label="4. ¿Ha explorado posibles usuarios de la invención?"></v-switch>
								<v-switch color="institucional" @change="setChecks(2)" v-model="check[6]" value="checked" label="5. ¿Cuenta con un grupo de investigación que pueda facilitar la evaluación inicial de factibilidad de la tecnología?"></v-switch>
								<v-switch color="institucional" @change="setChecks(2)" v-model="check[7]" value="checked" label="6. ¿Tiene contemplado un plan de licenciamiento de tecnología a terceros?"></v-switch>
							</div>
							<v-btn class="mr-2" color="error" to='/inicio'>Cancelar</v-btn>
							<v-btn class="mr-2" color="warning" @click="e1 = 1">Atrás</v-btn>
							<v-btn class="mr-2" color="accent" @click="updateTrl('TRL 2')">Actualizar</v-btn>
							<v-btn class="mr-2" color="institucional" :disabled="progress[2] == 100 ? false : true" @click="transitionTRL23()">Siguiente</v-btn>

							<br><br>
							<v-progress-linear :value="progress[2]" striped rounded color="primary" height="25">
								<strong>{{ Math.ceil(progress[2]) }}%</strong>
							</v-progress-linear>
							<br>
						</v-stepper-content>

						<v-stepper-content step="3">
							<h1 style="text-align: center; color: #000000;">Investigación de Laboratorio. Prueba experimental de concepto</h1>
							<h4 style="text-align: center; color: #000000;">Primera evaluación de la factibilidad de un concepto y su tecnología</h4>
							<v-divider color="institucional"></v-divider>
							<div class="mt-4 mb-8">
								<v-switch color="institucional" @change="setChecks(3)" v-model="check[8]" value="checked" label="1. ¿Tiene identificados los componentes de su invención tecnológica?"></v-switch>
								<v-switch color="institucional" @change="setChecks(3)" v-model="check[9]" value="checked" label="2. ¿Ha llevado a cabo algún proceso de validación de mercado sobre su invención? (I+D en laboratorio mús primeras pláticas con posibles usuarios)"></v-switch>
								<v-switch color="institucional" @change="setChecks(3)" v-model="check[10]" value="checked" label="3. ¿Realizó/actualizó estudios de búsqueda y análisis de patentes a nivel nacional e internacional, y los resultados indicaron que no existe un desarrollo igual a su idea? (benchmark tecnológico)"></v-switch>
								<v-switch color="institucional" @change="setChecks(3)" v-model="check[11]" value="checked" label="4. ¿Los resultados de la búsqueda y análisis de patentes indicaron que la invención puede ser protegida mediante algún mecanismo de protección?"></v-switch>
								<v-switch color="institucional" @change="setChecks(3)" v-model="check[12]" value="checked" label="5. ¿Ha realizado un estudio sobre los aspectos regulatorios (comités de ética, normas, ISO´s, y certificaciones) que son requeridos para su invención tecnológica?"></v-switch>
								<v-switch color="institucional" @change="setChecks(3)" v-model="check[13]" value="checked" label="6. ¿Tiene contemplado un plan de licenciamiento de tecnología a terceros?"></v-switch>
							</div>
							<v-btn class="mr-2" color="error" to='/inicio'>Cancelar</v-btn>
							<v-btn class="mr-2" color="warning" @click="e1 = 2">Atrás</v-btn>
							<v-btn class="mr-2" color="accent" @click="updateTrl('TRL 3')">Actualizar</v-btn>
							<v-btn class="mr-2" color="institucional" :disabled="progress[3] == 100 ? false : true" @click="transitionTRL34">Siguiente</v-btn>

							<br><br>
							<v-progress-linear :value="progress[3]" striped rounded color="primary" height="25">
								<strong>{{ Math.ceil(progress[3]) }}%</strong>
							</v-progress-linear>
							<br>
						</v-stepper-content>

						<v-stepper-content step="4">
							<h1 style="text-align: center; color: #000000;">Desarrollo Tecnológico. Validación tecnológica a nivel laboratorio</h1>
							<h4 style="text-align: center; color: #000000;">Validación de un prototipo inicial con componentes integrados en laboratorio con baja confiabilidad de comportamiento.</h4>
							<v-divider color="institucional"></v-divider>
							<div class="mt-4 mb-8">
								<v-switch color="institucional" @change="setChecks(4)" v-model="check[14]" value="checked" label="1. ¿Ha integrado los componentes principales de su invención tecnológica?"></v-switch>
								<v-switch color="institucional" @change="setChecks(4)" v-model="check[15]" value="checked" label="2. ¿Ha realizado pruebas de validación de efectividad de dicha invención en laboratorio?"></v-switch>
								<v-switch color="institucional" @change="setChecks(4)" v-model="check[16]" value="checked" label="3. ¿Ha explorado con mayor profundidad aspectos/certificaciones de manufacturabilidad relacionados con el desarrollo de su invención tecnológica?"></v-switch>
								<v-switch color="institucional" @change="setChecks(4)" v-model="check[17]" value="checked" label="4. ¿Ha continuado la validación de mercado de su invención con más entrevistas con usuarios potenciales y estudios de mercado?"></v-switch>
								<v-switch color="institucional" @change="setChecks(4)" v-model="check[18]" value="checked" label="5. ¿Su invención tecnológica funciona a nivel laboratorio?"></v-switch>
								<v-switch color="institucional" @change="setChecks(4)" v-model="check[19]" value="checked" label="6. ¿Identificó los riesgos tecnológicos de mercado y financieros con un plan de mitigación de los mismos?"></v-switch>
								<v-switch color="institucional" @change="setChecks(4)" v-model="check[20]" value="checked" label="7. ¿Actualizó el estudio de patentes nacionales e internacionales, y tiene definida una estrategia de gestión de la propiedad intelectual? (benchmark tecnológico)"></v-switch>
								<v-switch color="institucional" @change="setChecks(4)" v-model="check[21]" value="checked" label="8. ¿Tiene contemplado un plan de licenciamiento de tecnología a terceros?"></v-switch>
							</div>
							<v-btn class="mr-2" color="error" to='/inicio'>Cancelar</v-btn>
							<v-btn class="mr-2" color="warning" @click="e1 = 3">Atrás</v-btn>
							<v-btn class="mr-2" color="accent" @click="updateTrl('TRL 4')">Actualizar</v-btn>
							<v-btn class="mr-2" color="institucional" :disabled="progress[4] == 100 ? false : true" @click="transitionTRL45">Siguiente</v-btn>

							<br><br>
							<v-progress-linear :value="progress[4]" striped rounded color="primary" height="25">
								<strong>{{ Math.ceil(progress[4]) }}%</strong>
							</v-progress-linear>
							<br>
						</v-stepper-content>

						<v-stepper-content step="5">
							<h1 style="text-align: center; color: #000000;">Desarrollo Tecnológico. Tecnología validada en laboratorio pero en condiciones de un entorno relevante (condiciones que simulan condiciones existentes en un entorno real)</h1>
							<h4 style="text-align: center; color: #000000;">La integración de los componentes empieza a ser de alta confiabilidad. Para el caso de plataformas tecnológicas, el ambiente relevante debe considerar condiciones industriales, no de laboratorio experimental académico. Proceso de planeación del negocio.</h4>
							<v-divider color="institucional"></v-divider>
							<div class="mt-4 mb-8">
								<v-switch color="institucional" @change="setChecks(5)" v-model="check[22]" value="checked" label="1. ¿Ha probado su prototipo en laboratorio en condiciones de un ambiente real?"></v-switch>
								<v-switch color="institucional" @change="setChecks(5)" v-model="check[23]" value="checked" label="2. ¿Tiene plenamente identificadas y considerados aspectos de manufacturabilidad del futuro producto?"></v-switch>
								<v-switch color="institucional" @change="setChecks(5)" v-model="check[24]" value="checked" label="3. ¿El prototipo a escala real cumple con las normas y/o previsiones legales o del medio ambiente del sector?"></v-switch>
								<v-switch color="institucional" @change="setChecks(5)" v-model="check[25]" value="checked" label="4. ¿Actualizó el estudio de patentes nacionales e internacional, y tiene definida una estrategia de gestión de la propiedad intelectual? (benchmark tecnológico)?"></v-switch>
							</div>
							<v-btn class="mr-2" color="error" to='/inicio'>Cancelar</v-btn>
							<v-btn class="mr-2" color="warning" @click="e1 = 4">Atrás</v-btn>
							<v-btn class="mr-2" color="accent" @click="updateTrl('TRL 5')">Actualizar</v-btn>
							<v-btn class="mr-2" color="institucional" :disabled="progress[5] == 100 ? false : true" @click="transitionTRL56">Siguiente</v-btn>

							<br><br>
							<v-progress-linear :value="progress[5]" striped rounded color="primary" height="25">
								<strong>{{ Math.ceil(progress[5]) }}%</strong>
							</v-progress-linear>
							<br>
						</v-stepper-content>

						<v-stepper-content step="6">
							<h1 style="text-align: center; color: #000000;">Demostración tecnológica.Tecnología demostrada en un ambiente relevante (Para el caso de plataformas tecnológicas, el ambiente relevante debe considerar condiciones industriales, no de laboratorio experimental académico)</h1>
							<h4 style="text-align: center; color: #000000;">Pre-producción de un producto, incluyendo pruebas en un ambiente real.</h4>
							<v-divider color="institucional"></v-divider>
							<div class="mt-4 mb-8">
								<v-switch color="institucional" @change="setChecks(6)" v-model="check[26]" value="checked" label="1. ¿Tiene integradas las tecnologías de producto y manufactura en una planta piloto? (considerando todos los aspectos de manufacturabilidad)"></v-switch>
								<v-switch color="institucional" @change="setChecks(6)" v-model="check[27]" value="checked" label="2. ¿Tiene alineado el nuevo producto con las tecnologías de producción?"></v-switch>
								<v-switch color="institucional" @change="setChecks(6)" v-model="check[28]" value="checked" label="3. ¿Cuenta con usuarios potenciales que pruebe la producción a baja escala?"></v-switch>
								<v-switch color="institucional" @change="setChecks(6)" v-model="check[29]" value="checked" label="4. ¿Cuenta con una organización operativa acorde a las necesidades de operación de la producción? (mercadotecnia, logística, producción y otros)"></v-switch>
								<v-switch color="institucional" @change="setChecks(6)" v-model="check[30]" value="checked" label="5. ¿Inició el proceso sobre el registro de las certificaciones requeridas por instancias gubernamentales para la producción y despliegue del prototipo?"></v-switch>
							</div>
							<v-btn class="mr-2" color="error" to='/inicio'>Cancelar</v-btn>
							<v-btn class="mr-2" color="warning" @click="e1 = 5">Atrás</v-btn>
							<v-btn class="mr-2" color="accent" @click="updateTrl('TRL 6')">Actualizar</v-btn>
							<v-btn class="mr-2" color="institucional" :disabled="progress[6] == 100 ? false : true" @click="transitionTRL67">Siguiente</v-btn>

							<br><br>
							<v-progress-linear :value="progress[6]" striped rounded color="primary" height="25">
								<strong>{{ Math.ceil(progress[6]) }}%</strong>
							</v-progress-linear>
							<br>
						</v-stepper-content>

						<v-stepper-content step="7">
							<h1 style="text-align: center; color: #000000;">Desarrollo de Producto. Demostración de prototipo a nivel sistema en un ambiente operativo real (sistema real)</h1>
							<h4 style="text-align: center; color: #000000;">Producción a baja escala para demostración en ambiente operativo real.</h4>
							<v-divider color="institucional"></v-divider>
							<div class="mt-4 mb-8">
								<v-switch color="institucional" @change="setChecks(7)" v-model="check[31]" value="checked" label="1. ¿Cuenta con una proceso de manufactura operacional en baja escala? (produciendo productos comerciales)"></v-switch>
								<v-switch color="institucional" @change="setChecks(7)" v-model="check[32]" value="checked" label="2. ¿Cuenta con usuarios potenciales que prueben la versión final del producto?"></v-switch>
								<v-switch color="institucional" @change="setChecks(7)" v-model="check[33]" value="checked" label="3. ¿Cuenta con una estructura organizacional adecuada para la implementación?"></v-switch>
								<v-switch color="institucional" @change="setChecks(7)" v-model="check[34]" value="checked" label="4. ¿Cuenta con un producto terminado para prueba de primeros clientes?"></v-switch>
							</div>
							<v-btn class="mr-2" color="error" to='/inicio'>Cancelar</v-btn>
							<v-btn class="mr-2" color="warning" @click="e1 = 6">Atrás</v-btn>
							<v-btn class="mr-2" color="accent" @click="updateTrl('TRL 7')">Actualizar</v-btn>
							<v-btn class="mr-2" color="institucional" :disabled="progress[7] == 100 ? false : true" @click="transitionTRL78">Siguiente</v-btn>

							<br><br>
							<v-progress-linear :value="progress[7]" striped rounded color="primary" height="25">
								<strong>{{ Math.ceil(progress[7]) }}%</strong>
							</v-progress-linear>
							<br>
						</v-stepper-content>

						<v-stepper-content step="8">
							<h1 style="text-align: center; color: #000000;">Desarrollo de Producto. Sistema completo y evaluado. Manufacturabilidad probada y validada para ambiente real.</h1>
							<h4 style="text-align: center; color: #000000;">Sistema completo y certificado. Producto o servicio comercializable. Resultados de las pruebas del sistema en su configuración final.</h4>
							<v-divider color="institucional"></v-divider>
							<div class="mt-4 mb-8">
								<v-switch color="institucional" @change="setChecks(8)" v-model="check[35]" value="checked" label="1. ¿Se encuentra manufacturando el producto en su versión final?"></v-switch>
								<v-switch color="institucional" @change="setChecks(8)" v-model="check[36]" value="checked" label="2. ¿Tiene un producto comercializable?"></v-switch>
								<v-switch color="institucional" @change="setChecks(8)" v-model="check[37]" value="checked" label="3. ¿Su organización es operativa al 100%?"></v-switch>
								<v-switch color="institucional" @change="setChecks(8)" v-model="check[38]" value="checked" label="4. ¿Su prototipo cumple con estándares de la industria en cuestión?"></v-switch>
								<v-switch color="institucional" @change="setChecks(8)" v-model="check[39]" value="checked" label="5. ¿Elaboró los documentos para la utilización y mantenimiento del producto (manual del usuario, soporte técnico)?"></v-switch>
							</div>
							<v-btn class="mr-2" color="error" to='/inicio'>Cancelar</v-btn>
							<v-btn class="mr-2" color="warning" @click="e1 = 7">Atrás</v-btn>
							<v-btn class="mr-2" color="accent" @click="updateTrl('TRL 8')">Actualizar</v-btn>
							<v-btn class="mr-2" color="institucional" :disabled="progress[8] == 100 ? false : true" @click="transitionTRL89">Siguiente</v-btn>

							<br><br>
							<v-progress-linear :value="progress[8]" striped rounded color="primary" height="25">
								<strong>{{ Math.ceil(progress[8]) }}%</strong>
							</v-progress-linear>
							<br>
						</v-stepper-content>

						<v-stepper-content step="9">
							<h1 style="text-align: center; color: #000000;">Desarrollo de Producto. Sistema completo y evaluado. Manufacturabilidad probada y validada para ambiente real.</h1>
							<h4 style="text-align: center; color: #000000;">Sistema completo y certificado. Producto o servicio comercializable. Resultados de las pruebas del sistema en su configuración final.</h4>
							<v-divider color="institucional"></v-divider>
							<div class="mt-4 mb-8">
								<v-switch color="institucional" @change="setChecks(9)" v-model="check[40]" value="checked" label="1. ¿Cuenta con producción sostenida?"></v-switch>
								<v-switch color="institucional" @change="setChecks(9)" v-model="check[41]" value="checked" label="2. ¿Cuenta con un producto que cuenta con un crecimiento de mercado?"></v-switch>
								<v-switch color="institucional" @change="setChecks(9)" v-model="check[42]" value="checked" label="3. ¿Cuenta con cambios incrementales de producto que le lleven a crear nuevas versiones?"></v-switch>
								<v-switch color="institucional" @change="setChecks(9)" v-model="check[43]" value="checked" label="4. ¿Los procesos de manufactura y producción son optimizados a través de innovaciones incrementales?"></v-switch>
							</div>
							<v-btn class="mr-2" color="error" to='/inicio'>Cancelar</v-btn>
							<v-btn class="mr-2" color="warning" @click="e1 = 8">Atrás</v-btn>
							<v-btn class="mr-2" color="accent" @click="updateTrl('TRL 9')">Actualizar</v-btn>
							<v-btn class="mr-2" color="primary" :disabled="progress[0] == 100 ? false : true" @click="finalizarTRL9">Finalizar</v-btn>

							<br><br>
							<v-progress-linear :value="progress[9]" striped rounded color="primary" height="25">
								<strong>{{ Math.ceil(progress[9]) }}%</strong>
							</v-progress-linear>
							<br>
						</v-stepper-content>
					</v-stepper-items>
				</v-stepper-items>
			</v-stepper>

			<br>

			<v-progress-linear :value="progress[0]" striped rounded color="institucional" height="25">
				<strong>{{ Math.ceil(progress[0]) }}%</strong>
			</v-progress-linear>

			<v-snackbar v-model="snackbar">{{ snackbarText }}
				<template v-slot:action="{ attrs }">
					<v-btn color="institucional" text v-bind="attrs" @click="snackbar = false">Cerrar</v-btn>
				</template>
			</v-snackbar>
		</div>
	</div>
</div>
</template>

<script>
	import { mapActions, mapGetters } from 'vuex'
	export default {
		name: 'RegistrarResultados',
		data: () => ({
			snackbar: false,
			snackbarText: '',
			progress: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
			e1: '1',
			check: ['unchecked', 'unchecked', 'unchecked', 'unchecked', 'unchecked', 'unchecked', 'unchecked', 'unchecked', 'unchecked', 'unchecked', 'unchecked', 'unchecked', 'unchecked', 'unchecked', 'unchecked', 'unchecked', 'unchecked', 'unchecked', 'unchecked', 'unchecked', 'unchecked', 'unchecked', 'unchecked', 'unchecked', 'unchecked', 'unchecked', 'unchecked', 'unchecked', 'unchecked', 'unchecked', 'unchecked', 'unchecked', 'unchecked', 'unchecked', 'unchecked', 'unchecked', 'unchecked', 'unchecked', 'unchecked', 'unchecked', 'unchecked', 'unchecked', 'unchecked', 'unchecked'],
			resultName: 'NOMBRE RESULTADO',
			resultYear: 2021,
			codeTypeResult: '',
			resultCode: '',
		}),
		mounted() {
			this.readResearchResult();
		},
		computed: {
			...mapGetters(['route']),
		},
		methods: {
			readResearchResult() {
				axios.post(this.route + 'receivers/receptionTrl.php', { typeFunction:'readRIData', idRi:this.$route.params.id }).then(response => {
					this.resultName = response.data.nombre_tecnologia;
					this.resultYear = response.data.ano_proyecto;
					this.codeTypeResult = response.data.tipoCodigo_proyecto;
					this.resultCode = response.data.sgps_proyecto;
					this.serTrl(response.data.trl_proyecto);
				});
				axios.post(this.route + 'receivers/receptionTrl.php', { typeFunction:'readChecks', idRi:this.$route.params.id }).then(response => {
					for (var i = 0; i < this.check.length; i++) {
						this.check[i] = response.data[i].pregunta_seleccion;
					}
				});
			},
			serTrl(trl) {
				switch (trl) {
					case 'TRL 1':
						this.e1 = 1;
						break;

					case 'TRL 2':
						this.e1 = 2;
						break;

					case 'TRL 3':
						this.e1 = 3;
						break;

					case 'TRL 4':
						this.e1 = 4;
						break;

					case 'TRL 5':
						this.e1 = 5;
						break;

					case 'TRL 6':
						this.e1 = 6;
						break;

					case 'TRL 7':
						this.e1 = 7;
						break;

					case 'TRL 8':
						this.e1 = 8;
						break;

					case 'TRL 9':
						this.e1 = 9;
						break;
				}
			},
			updateTrl(trl) {
				axios.post(this.route + 'receivers/receptionTrl.php', { typeFunction:'updateTrl', idRi:this.$route.params.id, newTrl:trl }).then(response => {
					this.snackbar = true;
					this.snackbarText = 'Se ha actualizado el resultado de investigación a ' + trl;
				});
			},
			setProgressTrl(arrayCheck, position) {
				let counter = 0;
				arrayCheck.forEach(elements => {
					if (elements == 'checked') {
						counter++;
					}
				});
				this.progress[position] = counter * 100 / arrayCheck.length;
			},
			setProgressGeneral(arrayCheck) {
				let counter = 0;
				arrayCheck.forEach(elements => {
					if (elements == 'checked') {
						counter++;
					}
				});
				this.progress[0] = counter * 100 / arrayCheck.length;
			},
			setChecks(trl) {
				axios.post(this.route + 'receivers/receptionTrl.php', { typeFunction:'updateChecks', idRi:this.$route.params.id, checks:this.check }).then(response => {
					console.log(response.data);
				});
				if (trl == 1) {
					this.setProgressTrl([this.check[0], this.check[1]], trl);
				}else if (trl == 2) {
					this.setProgressTrl([this.check[2], this.check[3], this.check[4], this.check[5], this.check[6], this.check[7]], trl);
				}else if (trl == 3) {
					this.setProgressTrl([this.check[8], this.check[9], this.check[10], this.check[11], this.check[12], this.check[13]], trl);
				}else if (trl == 4) {
					this.setProgressTrl([this.check[14], this.check[15], this.check[16], this.check[17], this.check[18], this.check[19], this.check[20], this.check[21]], trl);
				}else if (trl == 5) {
					this.setProgressTrl([this.check[22], this.check[23], this.check[24], this.check[25]], trl);
				}else if (trl == 6) {
					this.setProgressTrl([this.check[26], this.check[27], this.check[28], this.check[29], this.check[30]], trl);
				}else if (trl == 7) {
					this.setProgressTrl([this.check[31], this.check[32], this.check[33], this.check[34]], trl);
				}else if (trl == 8) {
					this.setProgressTrl([this.check[35], this.check[36], this.check[37], this.check[38], this.check[39]], trl);
				}else if (trl == 9) {
					this.setProgressTrl([this.check[40], this.check[41], this.check[42], this.check[43]], trl);
				}
				this.setProgressGeneral(this.check);
			},
			transitionTRL12() {
				if (this.check[0] == 'checked' && this.check[1] == 'checked') {
					this.e1 = 2;
					this.updateTrl('TRL 1');
				}else {
					this.snackbar = true;
					this.snackbarText = 'Debe completar toda la sección para poder seguir.';
				}
			},
			transitionTRL23() {
				if (this.check[2] == 'checked' && this.check[3] == 'checked' && this.check[4] == 'checked' && this.check[5] == 'checked' && this.check[6] == 'checked' && this.check[7] == 'checked') {
					this.updateTrl('TRL 2');
					this.e1 = 3;
				}else {
					this.snackbar = true;
					this.snackbarText = 'Debe completar toda la sección para poder seguir.';
				}
			},
			transitionTRL34() {
				if (this.check[8] == 'checked' && this.check[9] == 'checked' && this.check[10] == 'checked' && this.check[11] == 'checked' && this.check[12] == 'checked' && this.check[13] == 'checked') {
					this.updateTrl('TRL 3');
					this.e1 = 4;
				}else {
					this.snackbar = true;
					this.snackbarText = 'Debe completar toda la sección para poder seguir.';
				}
			},
			transitionTRL45() {
				if (this.check[14] == 'checked' && this.check[15] == 'checked' && this.check[16] == 'checked' && this.check[17] == 'checked' && this.check[18] == 'checked' && this.check[19] == 'checked' && this.check[20] == 'checked' && this.check[21] == 'checked') {
					this.updateTrl('TRL 4');
					this.e1 = 5;
				}else {
					this.snackbar = true;
					this.snackbarText = 'Debe completar toda la sección para poder seguir.';
				}
			},
			transitionTRL56() {
				if (this.check[22] == 'checked' && this.check[23] == 'checked' && this.check[24] == 'checked' && this.check[25] == 'checked') {
					this.updateTrl('TRL 5');
					this.e1 = 6;
				}else {
					this.snackbar = true;
					this.snackbarText = 'Debe completar toda la sección para poder seguir.';
				}
			},
			transitionTRL67() {
				if (this.check[26] == 'checked' &&  this.check[27] == 'checked' &&  this.check[28] == 'checked' &&  this.check[29] == 'checked' &&  this.check[30] == 'checked') {
					this.updateTrl('TRL 6');
					this.e1 = 7;
				}else {
					this.snackbar = true;
					this.snackbarText = 'Debe completar toda la sección para poder seguir.';
				}
			},
			transitionTRL78() {
				if (this.check[31] == 'checked' &&  this.check[32] == 'checked' &&  this.check[33] == 'checked' &&  this.check[34] == 'checked') {
					this.updateTrl('TRL 7');
					this.e1 = 8;
				}else {
					this.snackbar = true;
					this.snackbarText = 'Debe completar toda la sección para poder seguir.';
				}
			},
			transitionTRL89() {
				if (this.check[35] == 'checked' && this.check[36] == 'checked' && this.check[37] == 'checked' && this.check[38] == 'checked' && this.check[39] == 'checked') {
					this.updateTrl('TRL 8');
					this.e1 = 9;
				}else {
					this.snackbar = true;
					this.snackbarText = 'Debe completar toda la sección para poder seguir.';
				}
			},

			finalizarTRL9() {
				if (this.check[40] == 'checked' && this.check[41] == 'checked' && this.check[42] == 'checked' && this.check[43] == 'checked') {
					this.updateTrl('TRL 9');
					this.e1 = 9;
				}else {
					this.snackbar = true;
					this.snackbarText = 'Debe completar toda la sección para poder seguir.';
				}
			},
		}
	}
</script>

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
p {
	color: #000000;
}
</style>