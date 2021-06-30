<template>
	<div class="container pt-3">			
		<template v-if="successFetch">
			<div class="row m-0">
				<div class="col-md-3 text-center">
					<form name="form-upload" encType="multipart/form-data">
						<img v-lazy="$auth.user.photo" 
							name="photo"/>

						<input type="file" name="photo" class="d-none"
							@change="onUploadPhoto"/>

						<button class="btn btn-primary mt-2 mb-2 d-inline-block"
							@click="onUpload">
							Upload
						</button>
					</form>
				</div>
				<div class="col-md-9">
					<ValidationObserver
		                v-slot="{invalid,validate}">  

		              <form 
		               @submit.prevent="validate().then(onSubmit(invalid))">
		               	<ValidationProvider 
		               		name="username"
		               		rules="required">
		               		<div class="input-group mb-3"                
		                      slot-scope="{errors,valid}">
		                      <input class="form-control" 
		                        type="text"               
		                        placeholder="Username"
		                        name="username"
		                        v-model="form.username" 
		                        :class="errors[0] ? 'is-invalid' : ''"/>

		                      <div class="invalid-feedback" v-if="errors[0]">
		                        {{ errors[0] }}
		                      </div>                                 
		                  </div>
		               	</ValidationProvider>

		                <ValidationProvider 
		                    name="email"
		                    rules="required|email"> 
		                  <div class="input-group mb-3"                
		                      slot-scope="{errors,valid}">
		                      <input class="form-control" 
		                        type="email"               
		                        placeholder="Email"
		                        name="email"
		                        v-model="form.email" 
		                        :class="errors[0] ? 'is-invalid' : ''"/>

		                      <div class="invalid-feedback" v-if="errors[0]">
		                        {{ errors[0] }}
		                      </div>                                 
		                  </div>
		                </ValidationProvider>

		                <ValidationProvider 
		                  name="password"
		                  rules="min:8"> 
		                  <div class="input-group mb-3" slot-scope="{errors,valid}">

		                    <input class="form-control"
		                      type="password"                 
		                      placeholder="Password"
		                      name="password"
		                      v-model="form.password" 
		                      :class="errors[0] ? 'is-invalid' : ''"/>

		                    <div class="invalid-feedback" v-if="errors[0]">
		                      {{ errors[0] }}
		                    </div>                                   
		                  </div>
		                </ValidationProvider>

		                <ValidationProvider 
		                  name="password_confirm"
		                  rules="required|min:8"> 
		                  <div class="input-group mb-3" slot-scope="{errors,valid}">

		                    <input class="form-control"
		                      type="password"                 
		                      placeholder="Password Konfirmasi"
		                      name="password_confirm"
		                      v-model="form.password_confirm" 
		                      :class="errors[0] ? 'is-invalid' : ''"/>

		                    <div class="invalid-feedback" v-if="errors[0]">
		                      {{ errors[0] }}
		                    </div>                                   
		                  </div>
		                </ValidationProvider>

		                <div class="row">               
		                  <div class="col-4">                               
		                   <button class="btn btn-primary btn-block"  type="submit">                    
		                      <span v-if="isLoadingForm">
		                        ...
		                      </span>
		                      <span v-else>
		                        Update
		                      </span>
		                    </button>                 
		                  </div>		                 
		                </div>
		              </form>  

		            </ValidationObserver>  
				</div>
			</div>
		</template>
		<template v-else>
			Maaf data tidak dapat ditampilkan
		</template>
	</div>
</template>

<script>
import {ValidationProvider,ValidationObserver} from 'vee-validate';

export default{
	components: {
    	ValidationProvider,
    	ValidationObserver
  	},

    middleware : "isLogin",  

    async asyncData(ctx) {    	
    	let fetchData = {
    		data : {},
    		successFetch : false,
    		isLoadingUpload : false,
    		isLoadingForm : false,
			form : {
      			...ctx.$auth.user,
				password_confirm : null
			}
    	}

    	try{
    		let { data } = await ctx.$axios.get("/check");    		
    		fetchData.data = data;
    		fetchData.successFetch = true;
    	}catch(e){    	
    		console.log("Failed Fetch Data");
    	}
 
    	return fetchData;
    },

    methods: {
    	onUpload(evt){
    		evt.preventDefault();
    		window.$("input[name=photo]").trigger("click")
    	},

    	onUploadPhoto(evt){
    		if(!evt.target.files.length){
				return false;
			}

			if(!["image/jpg","image/png","image/jpeg"].includes(evt.target.files[0].type)){
				this.$toaster.error("Gambar tidak valid");
				return false;
			}	
		
			if(this.isLoadingUpload){
				return false;
			}

			this.isLoadingUpload = true;

			let formData = new FormData(document.querySelector("form[name=form-upload]"));

			window.$("img[name=photo]").attr("src",URL.createObjectURL(evt.target.files[0]))		

			this.$axios.post("/profil/upload",formData)
			.then(res => {
				this.$toaster.success("Berhasil Upload Foto");
				// this.$auth.setUser({
					// ...this.$auth.user,
					// photo : res.photo
				// })
			})
			.catch(err => {
				window.$("img[name=photo]").attr("src",this.$auth.user.photo);

	      		if(err.response && err.response.status === 422){
		         	this.$toaster.error(err.response.data.error);
      			}else if(err.response && err.response.status === 500){
         			this.$toaster.error(err.response.data.message);
      			}else{
	         		this.$toaster.error('Terjadi Kesalahan');
      			}
			})
			.finally(() => {				
        		this.isLoadingUpload = false      			
			});
    	},

    	onSubmit(isInvalid){	
	  	  	if(isInvalid){
		  	    return false;
	  	  	}

	  	  	if(this.isLoadingForm){
		  	    return false;
	  	  	}

		    this.isLoadingForm = true;

			this.$axios.post("/profil/update",this.form)
	      	.then(res => {  
	      		this.$toaster.success("Berhasil Update")  
			}).catch(err => {
		     if(err.response && err.response.status === 422){
		       this.$toaster.error(err.response.data.error);
		     }else if(err.response && err.response.status === 500){
		       this.$toaster.error(err.response.data.message);
		     }else{
		       this.$toaster.error('Terjadi Kesalahan');
		     }  
		   }).finally(() => {
		   	this.isLoadingForm = false;
		   })
		},
    }
}
</script>

<style scoped>
img[name=photo]{
	height:200px;
	width:200px;
	object-fit:cover;
}
</style>