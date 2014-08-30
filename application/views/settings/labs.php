<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title text-bold">Web Notifications</h3>
  </div>
  <div class="panel-body">
    <script>

  // Thanks to developer.mozilla for the example of this API! Regards, Serg :D

  function permissionAsk() {

    if (!("Notification" in window)) {
      console.log('Unfortunately, Notifications are not available for your browser. Aw shucks! We really wanted you to test it.');
    }

    if (Notification.permission == "granted") {
      // If it's okay let's create a notification
      var notification = new Notification("Notifications are already enabled for Alphasquare. No need to hit the button again. :D");
    } else {

      Notification.requestPermission(function (permission) {
      if (!('permission' in Notification)) {
        Notification.permission = permission;
      }

    }

  }

  </script>
  <button class="btn btn-success btn-block btn-lg" onclick="permissionAsk();">Turn on Notifications</button>
  <br>
  <em>Please keep in mind that these features are in beta and aren't fully implemented. </em>
  </div>

</div>

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title text-bold">Around the web</h3>
  </div>
  <div class="panel-body">
    Coming soon!
  </div>
</div>