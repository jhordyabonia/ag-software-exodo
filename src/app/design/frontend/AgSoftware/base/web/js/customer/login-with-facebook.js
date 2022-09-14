
window.fbAsyncInit = function() {
  FB.init({
    appId      : '1137136550231962',
    cookie     : true,
    xfbml      : true,
    version    : 'v14.0'
  });
    
  FB.AppEvents.logPageView();   
    
};

(function(d, s, id){
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) {return;}
  js = d.createElement(s); js.id = id;
  js.src = "https://connect.facebook.net/en_US/sdk.js";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

function onLogin() {
  FB.login((response) => {
    if(response.authResponse) {
      FB.api('/me?fields=email,name,picture', (response) => {
        console.log(response)
      })
    }
  })
}

//Estado de inicio sesion

FB.getLoginStatus(function(response) {
  statusChangeCallback(response);
});