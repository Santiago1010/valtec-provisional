<template>
	<div>
		<v-snackbar v-model="snackbar">
			{{ snackbarText }}
			<template v-slot:action="{ attrs }">
				<v-btn color="error" text v-bind="attrs" @click="modifyStateSnackbar(false)">Cerrar</v-btn>
			</template>
		</v-snackbar>
	</div>
</template>

<script>
	import { mapGetters, mapActions } from 'vuex'

	export default {
		name: 'Snackbar',
		components: {},
		data: () => ({}),
		computed: {
			...mapGetters(['snackbar', 'snackbarText'])
		},
		methods: {
			...mapActions(['modifyStateSnackbar']),
		}
	}
</script>
</script>