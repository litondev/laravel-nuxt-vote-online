<template>
 <div class="wrapper">
   
  <nav class="main-header navbar navbar-expand navbar-dark">
    <ul class="navbar-nav">
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Logo</a>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto">  
      <li class="nav-item">
        <a class="nav-link" href="#" @click="sidebar = !sidebar">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>

  <div class="default-sidebar" v-if="sidebar">
    <div class="row m-0">
      <div class="col-8 bg-dark h-100"></div>
      <div class="col-4 bg-white h-100 p-2">
        <div class="clearfix">
          <div class="float-left">
            Menu
          </div>
          <div class="float-right" @click="sidebar = !sidebar">
            <i class="fas fa-times"></i>
          </div>
        </div>

        <ul class="list-group">
          <li class="list-group-item border-0">
            <nuxt-link to="/">Home</nuxt-link>
          </li>
          <li class="list-group-item border-0" v-if="$auth.loggedIn">
            <nuxt-link to="/profil">Profil</nuxt-link>
          </li>
          <li class="list-group-item border-0" v-if="!$auth.loggedIn">
            <nuxt-link to="/signin">Masuk</nuxt-link>
          </li>
          <li class="list-group-item border-0" v-if="!$auth.loggedIn">
            <nuxt-link to="/signup">Daftar</nuxt-link>
          </li>
          <li class="list-group-item border-0" v-if="$auth.loggedIn">
            <a href="#" @click="logout()">Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </div>

  <nuxt />
 </div>
</template>

<script>
export default{
  data(){
    return {
      sidebar : false
    }
  },

  mounted(){    
      window.$("body").addClass("sidebar-collapse");
  },
  destroyed(){
      window.$("body").removeClass("sidebar-collapse");
  },
  methods: {
    logout(){
     this.$auth.logout()
     .then(res => {
       this.sidebar = false;
       this.$router.push("/");  
     })
    }
  }
}
</script>

<style scoped>
.default-sidebar{
  position: absolute;
  left: 0;
  top: 0;
  right: 0;
  bottom: 0;
  z-index: 2001;
}

.default-sidebar > .row {
  height: 100vh;
}

.default-sidebar > .row > .bg-dark{
  opacity: 0.3;
}
</style>