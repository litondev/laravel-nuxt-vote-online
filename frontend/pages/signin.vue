<template>
	<div class="login-box">
    	<div class="login-logo">
          <b>Admin</b>LTE
        </div>

        <div class="card">
          <div class="card-body login-card-body">

            <p class="login-box-msg">
              Sign in to start your session
            </p>

            <ValidationObserver
                v-slot="{invalid,validate}">  

              <form 
               @submit.prevent="validate().then(onSubmit(invalid))">
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
                  rules="required|min:8"> 
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

                <div class="row">               
                  <div class="col-4">                               
                   <button class="btn btn-primary btn-block"  type="submit">                    
                      <span v-if="isLoadingForm">
                        ...
                      </span>
                      <span v-else>
                        Signin
                      </span>
                    </button>                 
                  </div>
                  <div class="col-6 text-right">
                    <nuxt-link to="/signup">Daftar</nuxt-link>       
                  </div>
                </div>
              </form>  

            </ValidationObserver>      
          </div>
        </div>
    </div>
</template>

<script>
import {ValidationProvider,ValidationObserver} from 'vee-validate';

export default{
  middleware : "isNotLogin", 

  head(){
    return {
      title : "Signin"
    }
  },
  
  components: {
    ValidationProvider,
    ValidationObserver
  },

	layout : 'empty',

	mounted(){  
   window.$("body").removeClass("sidebar-collapse");
   window.$("body").attr({"style" : ""});
	 window.$("body").addClass("hold-transition login-page");  
	},
	
	// destroyed(){
    // setTimeout(() => {
	   //  window.$("body").removeClass("hold-transition login-page");
    // },25);
	// },

	data(){
		return {
      isLoadingForm : false,
			form : {
				email : null,
				password : null
			}
		}
	},

	methods:{
		onSubmit(isInvalid){	
      if(isInvalid){
        return false;
      }

      if(this.isLoadingForm){
        return false;
      }

      this.isLoadingForm = true;

			this.$auth.login({
    		data: this.form,
  		}).then(res => {    
        this.$router.push("/");
  		}).catch(err => {
        this.isLoadingForm = false;

        if(err.response && err.response.status === 422){
          this.$toaster.error(err.response.data.error);
        }else if(err.response && err.response.status === 500){
          this.$toaster.error(err.response.data.message);
        }else{
          this.$toaster.error('Terjadi Kesalahan');
        }
      })
		}
	}
}
</script>