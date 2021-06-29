<template>
	<div>	
		My Profil
	</div>
</template>

<script>
export default{
    middleware : "isLogin",  
    // async asyncData(ctx) {
    	// await ctx.$axios.get("me")
    // }
}
</script>