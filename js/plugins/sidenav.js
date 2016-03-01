jQuery(function ($) {

  var menuLeft = document.getElementById( 'toolbar' ),
      showLeftPush = document.getElementById( 'showLeftPush' ),
      sideNavOverlay = document.getElementById( 'sideNavOverlay' ),
  		body = document.body;

      if (showLeftPush == null || sideNavOverlay == null) {
        return;
      }

  showLeftPush.onclick = function() {
  	classie.toggle( this, 'active' );
  	classie.toggle( body, 'sidenav-push-toright' );
  	classie.toggle( menuLeft, 'sidenav-open' );
    $('#sideNavOverlay').velocity({ opacity: .85 }, { display: "block" });
  };

  sideNavOverlay.onclick = function() {
    classie.toggle( body, 'sidenav-push-toright' );
    $('#sideNavOverlay').velocity("reverse", { display: "none" });
  }

});
