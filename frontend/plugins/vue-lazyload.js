import Vue from 'vue'
import VueLazyLoad from "vue-lazyload";
Vue.use(VueLazyLoad,{
	preload: 1.3,
	error: '/images/not-found-image-full-screen.png',
	loading: '/images/not-found-image-full-screen.png',
	attempt: 1
});