/* eslint-disable no-undef */
const vueFb = {}
vueFb.install = function install (Vue, options) {
  (function (d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0]
    if (d.getElementById(id)) { return }
    js = d.createElement(s)
    js.id = id
    js.src = '//connect.facebook.net/en_US/sdk.js'
    fjs.parentNode.insertBefore(js, fjs)
    console.log('setting fb sdk')
  }(document, 'script', 'facebook-jssdk'))

  window.fbAsyncInit = function onSDKInit () {
    FB.init(options)
    FB.AppEvents.logPageView()
    Vue.FB = FB
    Vue.prototype.$fb = FB
    console.log(options)
    window.dispatchEvent(new Event('fb-sdk-ready'))
  }
  Vue.FB = undefined
}

// leave the export, even if you don't use it
export default ({ Vue }) => {
  Vue.use(vueFb, {
    appId: '1659136830972887',
    cookie: true,
    xfbml: true,
    version: 'v2.8'
  })
}
