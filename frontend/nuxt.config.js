import colors from 'vuetify/es5/util/colors'
const environment = process.env.NODE_ENV || 'development'
const envSettings = require(`./env.${environment}.js`)

export default {
  env: envSettings,
  // Target: https://go.nuxtjs.dev/config-target
  target: 'static',

  // Global page headers: https://go.nuxtjs.dev/config-head
  head: {
    titleTemplate: '%s - munin',
    title: 'munin',
    htmlAttrs: {
      lang: 'ja'
    },
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { hid: 'description', name: 'description', content: '' },
      { name: 'format-detection', content: 'telephone=no' }
    ],
    link: [
      { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' }
    ]
  },

  // Global CSS: https://go.nuxtjs.dev/config-css
  css: [
  ],

  // Plugins to run before rendering page: https://go.nuxtjs.dev/config-plugins
  plugins: [
  ],

  // Auto import components: https://go.nuxtjs.dev/config-components
  components: true,

  // Modules for dev and build (recommended): https://go.nuxtjs.dev/config-modules
  buildModules: [
    // https://go.nuxtjs.dev/vuetify
    '@nuxtjs/vuetify',
  ],

  // Modules: https://go.nuxtjs.dev/config-modules
  modules: [
    // https://go.nuxtjs.dev/axios
    '@nuxtjs/axios',
    '@nuxtjs/auth-next',
    '@nuxtjs/markdownit',
  ],

  // Axios module configuration: https://go.nuxtjs.dev/config-axios
  axios: {
    // Workaround to avoid enforcing hard-coded localhost:3000: https://github.com/nuxt-community/axios-module/issues/308
    credentials: true,
  },

  // Vuetify module configuration: https://go.nuxtjs.dev/config-vuetify
  vuetify: {
    customVariables: ['~/assets/variables.scss'],
    theme: {
      dark: true,
      themes: {
        dark: {
          primary: colors.blue.darken2,
          accent: colors.grey.darken3,
          secondary: colors.amber.darken3,
          info: colors.teal.lighten1,
          warning: colors.amber.base,
          error: colors.deepOrange.accent4,
          success: colors.green.accent3
        }
      }
    }
  },

  // Build Configuration: https://go.nuxtjs.dev/config-build
  build: {
  },
  publicRuntimeConfig: {
    axios: {
      baseURL: envSettings.API_URL,
    },
  },
  auth: {
    redirect: {
      callback: '/',
      home: '/timeline',
    },
    strategies: {
      local: {
        token: {
          property: "token",
          global: true,
          maxAge: 60 * 60 * 24,
        },
        user: {
          property: "user",
        },
        endpoints: {
          login: {url: "/api/login", method: "post", propertyName: "token" },
          logout: {url: "/api/logout", method: "post" },
          user: {url: "/api/user", method: "get", propertyName: "user" },
          timeline: {url: "/api/note/post", method: "post" },
        },
      },
    },
  },
  router: {
    base: envSettings.BASE_URL
  },
  markdownit: {
    injected: true,
    use: [
      [
        'markdown-it-link-attributes',
        {
          attrs:{
            target: '_blank',
            rel: 'noopener',
          }
        }
      ]
    ]
  },
}
