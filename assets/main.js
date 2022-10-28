(function ($) {
  $("nav .dropdown").hover(
    function () {
      var $this = $(this);
      $this.addClass("show");
      $this.find("> a").attr("aria-expanded", true);
      $this.find(".dropdown-menu").addClass("show");
    },
    function () {
      var $this = $(this);
      $this.removeClass("show");
      $this.find("> a").attr("aria-expanded", false);
      $this.find(".dropdown-menu").removeClass("show");
    }
  );

  //NAVBAR MOBILE
  $(".navbar-toggler").click(function () {
    var $this = $(this);
    if ($(".navbar-collapse").hasClass("show")) {
      $(".navbar-collapse").removeClass("show");
    } else {
      $(".navbar-collapse").addClass("show");
    }
  });
})(jQuery);
