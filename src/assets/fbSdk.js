window.fbAsyncInit = function () {
  /* eslint-disable no-undef */
  FB.init({
    appId: '1659136830972887',
    cookie: true,
    xfbml: true,
    version: 'v2.8'
  })
};

(function (d, s, id) {
  var js
  var fjs = d.getElementsByTagName(s)[0]
  if (d.getElementById(id)) return
  js = d.createElement(s); js.id = id
  js.src = '//connect.facebook.net/en_US/sdk.js'
  fjs.parentNode.insertBefore(js, fjs)
}(document, 'script', 'facebook-jssdk'))
