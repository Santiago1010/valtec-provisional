<template>
	<div>
		<div class="fondoNegro">
			<vue-particles style="position: absolute; z-index: 0; width: 100%; height: 100%; top: 0; left: 0; max-height: 100%;" color="#D3D3D3"></vue-particles>
			<div class="contenedor">
				<br>
				<v-divider dark></v-divider>
				<h2 style="color: #FFFFFF;">DATOS DEL RESULTADO DE INVESTIGACIÓN</h2>
				<v-divider dark></v-divider>

				<v-form ref="formUpdateResults" v-model="formUpdateResults" lazy-validation>
					<v-row>
						<v-col cols="12" md="6">
							<v-text-field dark v-model="result.projectName" :rules="[rules.validationVoid]" label="Nombre del proyecto" autocomplete="off" required></v-text-field>
						</v-col>
						<v-col cols="12" md="6">
							<v-text-field dark v-model="result.resultName" :rules="[rules.validationVoid]" label="Nombre del resultado de investigación" autocomplete="off" required></v-text-field>
						</v-col>
					</v-row>

					<v-row>
						<v-col cols="12" md="3">
							<v-select v-model="result.typologyResult" :rules="[rules.validationVoid]" dark :items="typologies" label="Tipología del resultado de investigación según Colciencias" @change="setGroupsResults" autocomplete="off" required></v-select>
						</v-col>
						<v-col cols="12" md="3">
							<v-select v-model="result.resultGroup" :rules="[rules.validationVoid]" dark :items="groupsResults" label="Grupo del resultado de investigación según la tipografía" autocomplete="off" required></v-select>
						</v-col>
						<v-col cols="12" md="3">
							<v-radio-group dark v-model="result.prioritizationType" :rules="[rules.validationVoid]" @change="setAreasKnowledge" column>
								<v-radio label="COVID" value="covid"></v-radio>
								<v-radio label="ÁREAS DE CONOCIMIENTO" value="area"></v-radio>
							</v-radio-group>
						</v-col>

						<v-col cols="12" md="3">
							<v-select v-model="result.resultArea" :rules="[rules.validationVoid]" dark :items="resultArea" label="Categoría del resultado de investigación" @change="setSubAreas" autocomplete="off" required></v-select>
						</v-col>
					</v-row>

					<v-row>
						<v-col cols="12" md="6">
							<v-select v-model="result.subArea" :rules="[rules.validationVoid]" dark :items="subArea" label="Sub-área de conocimiento" autocomplete="off" required></v-select>
						</v-col>
						<v-col cols="12" md="6">
							<v-select v-model="result.knowledgeNetwork" :rules="[rules.validationVoid]" dark :items="knowledgesNetworks" item-value="id_red" item-text="nombre_red" label="Redes de conocimiento" autocomplete="off" required></v-select>
						</v-col>
					</v-row>

					<v-row>
						<v-col cols="12" md="6">
							<v-radio-group dark v-model="result.codeType" :rules="[rules.validationVoid]" @change="setCodeExample" row>
								<v-radio label="Código SGPS" value="SGPS"></v-radio>
								<v-radio label="Código SIGP" value="SIGP"></v-radio>
								<v-radio label="Iniciativa de centro" value="Iniciativa de centro"></v-radio>
							</v-radio-group>
						</v-col>
						<v-col cols="12" md="6">
							<v-text-field dark v-model="result.idCode" :rules="[rules.validationVoid]" :hint="exampleCodeType" @keyup="validCode" label="Código de identificación" autocomplete="off" required></v-text-field>
						</v-col>
					</v-row>
					<v-row>
						<v-col cols="12" md="4">
							<v-select dark v-model="result.regionalResult" :rules="[rules.validationVoid]" :items="regionals" item-value="id_regional" item-text="nombre_regional" label="Regional del resultado de investigación" @change="setCenters" required></v-select>
						</v-col>
						<v-col cols="12" md="4">
							<v-select dark v-model="result.centerResult" :rules="[rules.validationVoid]" :items="centers" item-value="id_centro" item-text="nombre_centro" label="Centro de formación del resultado de investigación" @change="setInvestigationGroup" required></v-select>
						</v-col>
						<v-col cols="12" md="4">
							<v-select dark v-model="result.investigationGroupResult" :rules="[rules.validationVoid]" :items="investigationGroups" item-value="id_grupo" item-text="nombre_grupo" label="Grupo de investigación del resultado de investigación" required></v-select>
						</v-col>
					</v-row>

					<v-row>
						<v-col cols="12">
							<v-select v-model="result.yearResult" :rules="[rules.validationVoid]" dark :items="rangePublicationYears" label="Año publicación resultado de investigación" required></v-select>
						</v-col>
					</v-row>

					<div v-for="(investigator, index) in newInvestigator" :key="investigator.id_relacion" id="muestraInvestigadores">
						<div v-if="investigator.documento_usuario != null">
							<!--{{ index }}: {{ investigator.id_relacion }} {{ investigator.documento_usuario }} {{ investigator.nombres_usuarios }} {{ investigator.apellidos_usuarios }} {{ investigator.tipo_investigador }}-->
							{{ setDataInvestigators(index, investigator.documento_usuario, investigator.nombres_usuarios + ' ' + investigator.apellidos_usuarios, investigator.tipo_investigador) }}
							<v-row>
								<v-col cols="12" md="3">
									<v-text-field v-model="result.documentInvestigator[index]" :rules="[rules.validationVoid]" dark label="Documento del investigador" autocomplete="off" required></v-text-field>
								</v-col>
								<v-col cols="12" md="3">
									<v-text-field v-model="result.nameInvestigator[index]" :rules="[rules.validationVoid]" dark label="Nombre y apellido del investigador" autocomplete="off" required></v-text-field>
								</v-col>
								<v-col cols="12" md="3">
									<v-select v-model="result.roleInvestigator[index]" :rules="[rules.validationVoid]" dark :items="rolesInvestigator" label="Rol del investigador en este resultado" required></v-select>
								</v-col>
								<v-col cols="12" md="3">
									<v-btn color="warning" style="width: 90%; margin-left: 5%;" @click="removeInvestigator(investigator.id_relacion)">Quitar</v-btn>
								</v-col>
							</v-row>
						</div>
						<div v-else>
							{{ setDataInvestigators(index, investigator.id_temporal, investigator.nombre_temporal, investigator.tipo_investigador) }}
							<v-row>
								<v-col cols="12" md="3">
									<v-text-field v-model="result.documentInvestigator[index]" :rules="[rules.validationVoid]" dark label="Documento del investigador" autocomplete="off" required></v-text-field>
								</v-col>
								<v-col cols="12" md="3">
									<v-text-field v-model="result.nameInvestigator[index]" :rules="[rules.validationVoid]" dark label="Nombre y apellido del investigador" autocomplete="off" required></v-text-field>
								</v-col>
								<v-col cols="12" md="3">
									<v-select v-model="result.roleInvestigator[index]" :rules="[rules.validationVoid]" dark :items="rolesInvestigator" label="Rol del investigador en este resultado" required></v-select>
								</v-col>
								<v-col cols="12" md="3">
									<v-btn color="warning" style="width: 90%; margin-left: 5%;" @click="removeInvestigator(investigator.id_relacion)">Quitar</v-btn>
								</v-col>
							</v-row>
						</div>
					</div>

					<v-row>
						<v-col cols="12">
							<v-textarea dark v-model="result.reviewResult" :rules="[rules.validationVoid]" label="Reseña del resultado de investigación" @keyup="countWords"></v-textarea>
							<small style="color: #FFFFFF;">Palabras escritas: {{ words }}. Palabras disponibles: <span>{{ limitWords }}</span></small>
						</v-col>
					</v-row>

					<v-row>
						<v-col cols="12" md="8">
							<v-switch v-model="result.acceptResult" :rules="[rules.validationVoid]" dark label="He leído y acepto la Política de Propiedad Intelectual SENA" color="institucional" value="sí"></v-switch>
						</v-col>
						<v-col cols="12" md="4">
							<a href="http://compromiso.sena.edu.co/documentos/vista/descarga.php?id=2358" target="_BLANK" style="text-decoration: none;"><v-icon dark x-large>open_in_new</v-icon></a>
						</v-col>
					</v-row>

					<v-row>
						<v-col cols="12">
							<v-text-field v-model="result.registrationDate" :rules="[rules.validationVoid]" dark label="Fecha registro" autocomplete="off" required readonly></v-text-field>
						</v-col>
					</v-row>

					<v-row>
						<v-col cols="12" md="5">
							<v-btn color="error" to='/inicio/resultados' large text style="width: 90%; margin-left: 5%;" @click="reset">Cancelar</v-btn>
						</v-col>
						<v-col cols="12" md="7">
							<v-btn type="submit" color="primary" style="width: 90%; margin-left: 5%;" @click="validate">Registrar</v-btn>
						</v-col>
					</v-row>
				</v-form>
			</div>
		</div>
		<v-snackbar v-model="snackbar">{{ textSnackbar }}
			<template v-slot:action="{ attrs }">
	        	<v-btn color="error" text v-bind="attrs" @click="snackbar = false">Cerrar</v-btn>
	      	</template>
	    </v-snackbar>
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
			menuLateral: false,
			formUpdateResults: true,
			snackbar: false,
			textSnackbar: '',
			result: {
				id: '',
				projectName: '',
				resultName: '',
				typologyResult: '',
				resultGroup: '',
				prioritizationType: '',
				resultArea: '',
				subArea: '',
				knowledgeNetwork: '',
				codeType: '',
				idCode: '',
				regionalResult: '',
				centerResult: '',
				investigationGroupResult: '',
				yearResult: '',
				documentInvestigator: [],
				nameInvestigator: [],
				roleInvestigator: [],
				reviewResult: '',
				acceptResult: true,
				registrationDate: '',
			},
			rules: {
				validationVoid: v => !!v || 'Este campo es obligatorio.',
				validationText: v => /^[a-zA-ZÀ-ÿ\u00f1\u00d1]+(\s*[a-zA-ZÀ-ÿ\u00f1\u00d1]*)*[a-zA-ZÀ-ÿ\u00f1\u00d1]+$/g.test(v) || 'Este campo debe contener solamente caracteres alfabéticos',
			},
			typologies: ['Productos resultados de actividades de generación de nuevo conocimiento', 'Productos resultados de actividades de desarrollo tecnológico e innovación'],
			groupsResults: ['No se ha especificado'],
			resultArea: ['No se ha especificado'],
			subArea: ['No se ha especificado'],
			knowledgesNetworks: ['No se ha especificado'],
			regionals: ['No se ha especificado'],
			centers: ['No se ha especificado'],
			investigationGroups: ['No se ha especificado'],
			rolesInvestigator: ['Ingreso de información', 'Investigador principal', 'Coinvestigador'],
			newInvestigator: [0],
			words: 0,
			limitWords: 150,
			fechaRegisto: '',
			aceptar: true,
			readValidCode: false,
			rangePublicationYears: [2021, 2020, 2019, 2018, 2017, 2015],
			exampleCodeType: 'Seleccione un tipo de código.',
		}),
		mounted() {
			this.readDataResearchResult();
			this.setPriorization();
			this.registrationDate();
			this.setKnowledesNetworks();
			this.setRegionals();
			this.setGroupsResults();
			this.setAreasKnowledge();
			this.setSubAreas();
			this.setInvestigationGroup();
			this.readInvestigatorsResult();
		},
		computed: {
			...mapGetters(['route']),
		},
		methods: {
			setGroupsResults() {
				if (this.result.typologyResult == 'Productos resultados de actividades de generación de nuevo conocimiento') {
					this.groupsResults = ['Productos teconológicos patentados o en proceso de concesión de patente', 'Variedades vegetales, nuevas razas de animales y poblaciones mejoradas de razas pecuarias', 'Obras o productos de investigación-creación en Artes, Arquitectura y Diseño'];
				}else if (this.typologyResult == 'Productos resultados de actividades de desarrollo tecnológico e innovación') {
					this.groupsResults = ['Productos teconológicos certificados o validados', 'Productos empresariales', 'Regulaciones, normas, reglamentos o legislaciones', 'Conceptos técnicos e informes técnicos', 'Registro de Acuerdos de licencia para la explotación de obras protegidas por derecho de autor'];
				}else {
					this.groupsResults = [];
				}
			},
			setAreasKnowledge() {
				if (this.result.prioritizationType == "covid") {
					this.resultArea = ['Seguridad alimentaria', 'Energías renovables', 'Gestión en salud', 'Biodiversidad y consumo responsable', 'Desarrollo de software, trabajo y formación infantil', 'Agricultura y agroindustria', 'Salud mental', 'Recursos no renovables'];
				}else if (this.result.prioritizationType == "area") {
					this.resultArea = ['Agronomía, veterinaria y afines', 'Bellas Artes', 'Ciencias de la educación', 'Ciencias de la salud', 'Ciencias sociales y humanas', 'Economía, administración, contaduría y afines', 'Ingeniería, arquitectura, urbanismo y afines', 'Matemáticas y ciencias naturales'];
				}else {
					this.resultArea = [];
				}
			},
			setSubAreas() {
				if (this.result.resultArea == "Agronomía, veterinaria y afines") {
					this.subArea = ['Agronomía', 'Medicina veterinaria', 'Zootecnia'];
				}else if (this.result.resultArea == "Bellas Artes") {
					this.subArea = ['Artes plásticas, visuales y afines', 'Artes representativas', 'Diseño', 'Música', 'Otros programas asociados a bellas artes', 'Publicidad y afines'];
				}else if (this.result.resultArea == "Ciencias de la educación") {
					this.subArea = ['Educación'];
				}else if (this.result.resultArea == "Ciencias de la salud") {
					this.subArea = ['Bateriología', 'Enfermería', 'Instrumentación quirúrjica', 'Medicina', 'Nutrición y detética', 'Odontología', 'Optometría', 'Salud pública', 'Terapias', 'Otros programas de ciencias de la salud'];
				}else if (this.result.resultArea == "Ciencias sociales y humanas") {
					this.subArea = ['Antropología, artes liberales', 'Bibliotecología', 'Ciencia política, relaciones internacionales', 'Comunicación social, periodismo y afines', 'Deportes, educación física y recreación', 'Derecho y afines', 'Filosofía, teología y afines', 'Formación relacionada con el campo militar o policial', 'Geografía, historia', 'Lenguas modernas, literatura, lingüisticay afines', 'Psicología', 'Sociología, trabajo social y afines'];
				}else if (this.result.resultArea == "Economía, administración, contaduría y afines") {
					this.subArea = ['Administración', 'Contaduría pública', 'Economía'];
				}else if (this.result.resultArea == "Ingeniería, arquitectura, urbanismo y afines") {
					this.subArea = ['Arquitectura', 'Ingeniería administrativa y afines', 'Ingeniería agrícola, forestal y afines', 'Ingeniería agroindustrial, alimentos y afines', 'Ingeniería agronómica, pecuaria y afines', 'Ingeniaría ambiental, sanitaria y afines', 'Ingeniería biomédica y afines', 'Ingeniería civil y afines', 'Ingeniería de minas, metaluergia y afines', 'Ingeniería de sistemas, telemática y afines', 'Ingeniería eléctrica y afines', 'Ingeniería electrónica, telecomunicaciones y afines', 'Ingeniería industrial y afines', 'Ingeniería mecánica y afines', 'Ingeniería química y afines', 'Otras ingenierías'];
				}else if (this.result.resultArea == "Matemáticas y ciencias naturales") {
					this.subArea = ['Biología, microbiología y afines', 'Física', 'Geología, otros programas de ciencia naturales', 'Matemáticas, estadísticas y afines', 'Química y afines'];
				}else {
					this.subArea = ['No aplica'];
				}
			},
			setKnowledesNetworks() {
				axios.post(this.route + 'receivers/receptionLocation.php', { typeFunction:'readKnowledgeNetworks' }).then(response => {
					this.knowledgesNetworks = response.data;
				});
			},
			setCodeExample() {
				if (this.result.codeType == "SGPS") {
					this.exampleCodeType = "Código SGPS. Ejemplo: 4560";
				}else if (this.result.codeType == "SIGP") {
					this.exampleCodeType = "Código SIGP. Ejemplo: 5B2C23A67E97 AB02B0664E87 61114878";
				}else if (this.result.codeType == "Iniciativa de centro") {
					this.exampleCodeType = "Iniciativa de centro. Ejemplo: PRO21456";
				}else {
					this.exampleCodeType = "Seleccione un tipo de código.";
				}
			},
			setRegionals() {
				axios.post(this.route + 'receivers/receptionLocation.php', { typeFunction:'readRegionals' }).then(response => {
					this.regionals = response.data;
					this.setCenters();
				});
			},
			setCenters() {
				axios.post(this.route + 'receivers/receptionLocation.php', { typeFunction:'readCenters', idRegional:this.result.regionalResult }).then(response => {
					this.centers = response.data;
					this.setInvestigationGroup();
				});
			},
			setInvestigationGroup() {
				axios.post(this.route + 'receivers/receptionLocation.php', { typeFunction:'readInvestigationGroups', idCenter:this.result.centerResult }).then(response => {
					this.investigationGroups = response.data;
				});
			},
			addInvestigator() {
				var position = this.newInvestigator[this.newInvestigator.length - 1];
				this.newInvestigator.push(position + 1);
			},
			removeInvestigator(position) {
				if (confirm('¿Desea eliminar la participación de este investigador?')) {
					axios.post(this.route + 'receivers/receptionResults.php', { typeFunction:'deleteInvestigatorsResult', idRelation:position }).then(response => {
						if (response.data == 1) {
							this.snackbar = true;
							this.textSnackbar = 'Se ha eliminado la participación del investigador.';
							this.readInvestigatorsResult();
						}
					});
				}
			},
			countWords() {
				var words = this.result.reviewResult.match(/\S+/g).length;
				if (words > 150) {
					var trimmed = this.result.reviewResult.split(/\s+/, 150).join(" ");
					this.result.reviewResult = trimmed + " ";
				}else {
					this.words = words;
					this.limitWords = 150 - words;
				}
			},
			registrationDate() {
				var f = new Date();
				this.result.registrationDate = f.getFullYear() + "-" + (f.getMonth() +1) + "-" + f.getDate();
			},
			validCode() {
				axios.post(this.route + 'receivers/receptionResults.php', { typeFunction:'readResultCode', code:this.result.idCode }).then(response => {
					if (response.data >= 1) {
						this.exampleCodeType+= ' Este código ya ha sido registrado con anterioridad.';
						this.readValidCode = false;
					}else {
						this.setCodeExample();
						this.readValidCode = true;
					}
				});
			},
			updateResearchResult() {
				axios.post(this.route + 'receivers/receptionResults.php', { typeFunction:'updateResult', result:this.result }).then(response => {
					if (response.data == 1) {
						this.snackbar = true;
						this.textSnackbar = 'Se ha modificado el resultado de investigación.';
					}else {
						this.snackbar = true;
						this.textSnackbar = 'Ha habido un error al modificar el resultado de investigación.';
					}
				});
			},
			setFirstInvestigator() {
				this.result.documentInvestigator[0] = localStorage.document;
				this.result.nameInvestigator[0] = localStorage.name + " " + localStorage.lastName;
			},
			validate () {
				event.preventDefault();
		    	if (this.$refs.formUpdateResults.validate()) {
					this.readValidCode ? this.updateResearchResult() : this.result.idCode = '';
				}
		    },
		    reset () {
		        this.$refs.formUpdateResults.reset()
		    },
		    resetValidation () {
		        this.$refs.formUpdateResults.resetValidation()
		    },
		    setPriorization() {
		    	if (this.result.resultArea == 'Seguridad alimentaria' || this.result.resultArea == 'Energías renovables' || this.result.resultArea == 'Gestión en salud' || this.result.resultArea == 'Biodiversidad y consumo responsable' || this.result.resultArea == 'Desarrollo de software, trabajo y formación infantil' || this.result.resultArea == 'Agricultura y agroindustria' || this.result.resultArea == 'Salud mental' || this.result.resultArea == 'Recursos no renovables') {
		    		this.result.prioritizationType = "covid";
				}else if (this.result.resultArea == 'Agronomía, veterinaria y afines' || this.result.resultArea == 'Bellas Artes' || this.result.resultArea == 'Ciencias de la educación' || this.result.resultArea == 'Ciencias de la salud' || this.result.resultArea == 'Ciencias sociales y humanas' || this.result.resultArea == 'Economía, administración, contaduría y afines' || this.result.resultArea == 'Ingeniería, arquitectura, urbanismo y afines' || this.result.resultArea == 'Matemáticas y ciencias naturales') {
					this.result.prioritizationType = "area";
				}else {
					this.result.resultArea = [];
				}
		    },
		    readDataResearchResult() {
		    	axios.post(this.route + 'receivers/receptionResults.php', { typeFunction:'readResultOnly', idRi:this.$route.params.id }).then(response => {
		    		this.result.id = this.$route.params.id;
					this.result.projectName = response.data.nombre_proyecto;
					this.result.resultName = response.data.nombre_tecnologia;
					this.result.typologyResult = response.data.tipo_resultado;
					this.result.resultGroup = response.data.grupo_resultado;
					//this.result.prioritizationType = response.data.;
					this.result.resultArea = response.data.especifico_resultado;
					this.result.subArea = response.data.subarea_proyecto;
					this.result.knowledgeNetwork = response.data.id_area;
					this.result.codeType = response.data.tipoCodigo_proyecto;
					this.result.idCode = response.data.sgps_proyecto;
					this.result.regionalResult = response.data.id_regional;
					this.result.centerResult =  response.data.id_centro;
					this.result.investigationGroupResult = response.data.id_grupo;
					this.result.yearResult = parseInt(response.data.ano_proyecto);
					this.result.reviewResult = response.data.resumen_proyecto;
					this.result.acceptResult = response.data.cede_derechos == 'Sí' ? 'checked' : 'unchecked';
					this.setPriorization();
					this.registrationDate();
					this.setKnowledesNetworks();
					this.setRegionals();
					this.setGroupsResults();
					this.setAreasKnowledge();
					this.setSubAreas();
					this.setInvestigationGroup();
					this.setCenters();
					this.setInvestigationGroup();
		    	});
		    },
		    readInvestigatorsResult() {
		    	axios.post(this.route + 'receivers/receptionResults.php', { typeFunction:'readInvestigatorsResult', idResult:this.$route.params.id }).then(response => {
		    		this.newInvestigator = response.data;
		    	});
		    },
		    setDataInvestigators(position, documentInvestigator, name, role) {
		    	this.result.documentInvestigator[position] = documentInvestigator;
		    	this.result.nameInvestigator[position] = name;
		    	this.result.roleInvestigator[position] = role;
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
</style>