<template>
	<div id="loading" v-if="loading" class="text-center">
		<div class="mt-4 mb-4">
			<i class="fas fa-spinner fa-spin fa-3x"></i>
			<br/>
			<div class="d-inline-block mt-3 mb-3">
				Loading . . .
			</div>
		</div>
	</div>
</template>

<script>
export default {
	data(){
		return {
			loading :  true
		}
	},

	mounted(){
		setTimeout(() => {
			this.loading = false
		},2000);
	}
}
</script>

<style scoped>
#loading{
	position: fixed;
	left: 0;
	right: 0;
	top: 0;
	bottom: 0;
	background: white;
	z-index: 1000001;
}
</style>