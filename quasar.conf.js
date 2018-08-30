// Configuration for your app
const webpack = require('webpack')
const path = require('path')

const envparser = require('./src/config/envparser')

module.exports = function (ctx) {
  return {
    // app plugins (/src/plugins)
    plugins: [
      'axios',
      'vuelidate',
      'fbSdk'
    ],
    css: [
      'app.styl'
    ],
    extras: [
      ctx.theme.mat ? 'roboto-font' : null,
      'material-icons'
      // 'ionicons',
      // 'mdi',
      // 'fontawesome'
    ],
    supportIE: false,
    build: {
      scopeHoisting: true,
      vueRouterMode: 'history',
      env: envparser(),
      // gzip: true,
      // analyze: true,
      // extractCSS: false,
      // useNotifier: false,
      extendWebpack (cfg) {
        cfg.module.rules.push({
          enforce: 'pre',
          test: /\.(js|vue)$/,
          loader: 'eslint-loader',
          exclude: /(node_modules|quasar)/
        })
      }
    },
    devServer: {
      // https: true,
      port: 8002,
      open: false, // opens browser window automatically
      proxy: {
        '/api': {
            target: 'http://localhost:8001',
            changeOrigin: true,
            pathRewrite: {
                '^/api': ''
            }
        }
      },
      historyApiFallback: true
    },
    // framework: 'all' --- includes everything; for dev only!
    framework: {
      components: [
          'QLayout',
          'QLayoutHeader',
          'QLayoutDrawer',
          'QPageContainer',
          'QPage',
          'QToolbar',
          'QToolbarTitle',
          'QBtn',
          'QIcon',
          'QList',
          'QListHeader',
          'QItem',
          'QItemMain',
          'QItemSide',
          'QItemTile',
          'QItemSeparator',
          'QScrollArea',
          'QPageSticky',
          'QTooltip',
          'QStepper',
          'QStep',
          'QStepperNavigation',
          'QCard',
          'QCardTitle',
          'QCardSeparator',
          'QCardMain',
          'QChip',
          'QInput',
          'QField',
          'QSelect',
          'QTable',
          'QTr',
          'QTd',
          'QSearch',
          'QInnerLoading',
          'QCarousel',
          'QCarouselSlide'
      ],
      directives: [
        'Ripple'
      ],
      // Quasar plugins
      plugins: [
        'Notify',
        'Screen'
      ]
    },
    // animations: 'all' --- includes all animations
    animations: [],
    ssr: {
        pwa: false
    },
    pwa: {
      // workboxPluginMode: 'InjectManifest',
      // workboxOptions: {},
      manifest: {
        // name: 'Quasar App',
        // short_name: 'Quasar-PWA',
        // description: 'Best PWA App in town!',
        // start_url: "/",
        display: 'standalone',
        orientation: 'portrait',
        background_color: '#ffffff',
        theme_color: '#027be3',
        icons: [
          {
            'src': 'statics/icons/icon-128x128.png',
            'sizes': '128x128',
            'type': 'image/png'
          },
          {
            'src': 'statics/icons/icon-192x192.png',
            'sizes': '192x192',
            'type': 'image/png'
          },
          {
            'src': 'statics/icons/icon-256x256.png',
            'sizes': '256x256',
            'type': 'image/png'
          },
          {
            'src': 'statics/icons/icon-384x384.png',
            'sizes': '384x384',
            'type': 'image/png'
          },
          {
            'src': 'statics/icons/icon-512x512.png',
            'sizes': '512x512',
            'type': 'image/png'
          }
        ]
      }
    },
    cordova: {
      // id: 'org.cordova.quasar.app'
    },
    electron: {
      extendWebpack (cfg) {
        // do something with cfg
      },
      packager: {
        // OS X / Mac App Store
        // appBundleId: '',
        // appCategoryType: '',
        // osxSign: '',
        // protocol: 'myapp://path',

        // Window only
        // win32metadata: { ... }
      }
    }
  }
}
