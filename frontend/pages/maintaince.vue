<template>
  <div>
    Maintaince
    <a href="#" @click="onCheck">
    	Check Maintaince
    </a>
  </div>
</template>

<script>
export default {
	layout : 'empty',
	mounted(){
	  window.$("body").removeClass("hold-transition login-page");
	  window.$("body").removeClass("sidebar-collapse");
   	window.$("body").attr({"style" : ""});
	},
  methods:{
    onCheck(){
      this.$axios.get("/check")
      .then(res => {
        this.$cookiz.remove("maintaince");
        this.$router.push("/");
      }).catch(err => {
        if(err.response && err.response.status === 500){
          this.$toaster.error(err.response.data.message);
        }else if(err.response && err.response.status === 503){
          this.$toaster.error('Still Maintaince');
        }else{
          this.$toaster.error('Terjadi Kesalahan');
        }
      });
    }
  }
}
</script>