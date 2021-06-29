require('dotenv').config();

export default {
  target: 'server',

  router: {
    middleware: "checkBeforeMove"
  },

  server : {
    host: process.env.HOST
  },

  head: {
    title: 'Vote Online',
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { hid: 'description', name: 'description', content: '' }
    ],
    link: [
      { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' },
      { rel: 'stylesheet', type: 'text/css', href: '/plugins/fontawesome-free/css/all.min.css'},
      { rel: 'stylesheet', type: 'text/css', href: '/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css' },
      { rel: 'stylesheet', type: 'text/css', href: '/plugins/icheck-bootstrap/icheck-bootstrap.min.css' },
      { rel: 'stylesheet', type: 'text/css', href: '/dist/css/adminlte.min.css' },
      { rel: 'stylesheet', type: 'text/css', href: '/plugins/overlayScrollbars/css/OverlayScrollbars.min.css' },
      { rel: 'stylesheet', type: 'text/css', href: '/plugins/daterangepicker/daterangepicker.css' },
      { rel: 'stylesheet', type: 'text/css', href: '/plugins/summernote/summernote-bs4.min.css' }    
    ],
    script : [
      {src: '/plugins/jquery/jquery.min.js',defer: true},
      {src: '/plugins/jquery-ui/jquery-ui.min.js',defer: true},
      {src: '/plugins/bootstrap/js/bootstrap.bundle.min.js',defer: true},
      {src: '/plugins/sparklines/sparkline.js',defer: true},
      {src: '/plugins/moment/moment.min.js',defer: true},
      {src: '/plugins/daterangepicker/daterangepicker.js',defer: true},
      {src: '/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js',defer: true},
      {src: '/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js',defer: true},
      {src: '/dist/js/adminlte.js',defer: true}
    ],
  },

  loading: "~/components/loading",

  css: [],

  plugins: [
  { src:"~/plugins/vee-validate", ssr: false },
  '~/plugins/toaster',
   '~/plugins/axios',    
  ],

  modules: [ 
    [
      '@nuxtjs/dotenv',{ systemvars: true }
    ],
    [
      'cookie-universal-nuxt', { alias: 'cookiz' }
    ],
    '@nuxtjs/axios',
    '@nuxtjs/auth',
    '@nuxtjs/device',
    '@nuxtjs/moment'
  ],

  moment: {
    timezone: true,
    defaultTimezone: 'Asia/Jakarta',
    defaultLocale: 'id',
    locales: ['id']
  },

  axios: {
    baseURL: process.env.API_URL
  },

  auth: {   
    watchLoggedIn: true,
    redirect : false,
    strategies: {
      local: {
        endpoints: {
          login: {
            url: 'signin',
            method: 'post',
            propertyName: 'access_token'
          },
          logout: {
            url: 'logout',
            method: 'post'
          },
          user: {
            url: 'me',
            method: 'get',
            propertyName: false
          }
        },
        tokenRequired: true,
        tokenType: 'Bearer'
      }
    }    
  },

  build: {
      transpile : ['vee-validate/dist/rules']
  }
}
