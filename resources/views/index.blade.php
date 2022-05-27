<!DOCTYPE html>
<html>
  <!--
    WARNING! Make sure that you match all Quasar related
    tags to the same version! (Below it's "@2.7.1")
  -->

  <head>
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900|Material+Icons" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/eva-icons@^1.0.0/style/eva-icons.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/quasar@2.7.1/dist/quasar.css" rel="stylesheet" type="text/css">
  </head>

  <body>
    <!-- example of injection point where you write your app template -->
    <div id="q-app"></div>

    <!-- Add the following at the end of your body tag -->
    <script src="https://cdn.jsdelivr.net/npm/vue@3/dist/vue.global.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/quasar@2.7.1/dist/quasar.umd.js"></script>
    
    {{-- <script>
      /*
        Example kicking off the UI. Obviously, adapt this to your specific needs.
        Assumes you have a <div id="q-app"></div> in your <body> above
       */
      const app = Vue.createApp({
        setup () {
          return {}
        }
      })

      app.use(Quasar)
      app.mount('#q-app')
    </script> --}}
  </body>
</html>
