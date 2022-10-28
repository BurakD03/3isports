window.onload = () => {
  const FiltersForm = document.querySelector("#filters");
  document.querySelectorAll("#filters input").forEach((input) => {
    input.addEventListener("change", () => {
      console.log("clic");
      const Form = new FormData(FiltersForm);

      const Params = new URLSearchParams();
      Form.forEach((value, key) => {
        Params.append(key, value);
        console.log(Params.toString());
      });

      const Url = new URL(window.location.href);
      fetch(Url.pathname + "?" + Params.toString() + "&ajax=1", {
        headers: {
          "X-Requested-With": "XMLHttpRequest",
        },
      })
        .then((response) => response.json())
        .then((data) => {
          console.log(data);
          const content = document.querySelector("#home-block-news");
          content.innerHTML = data.content;
        })
        .catch((e) => alert(e));
    });
  });
};

jQuery(document).ready(function (a) {
  "use strict";
  var c = null,
    d,
    b,
    e;
  a(".news-tab-cat ul li").on("click", "label", function () {
    var d = a(this),
      f = d.parents(".rtin-tab-container"),
      e = d.parents(".news-tab-cat"),
      b = f.find(".rt-tab-news-holder"),
      j = b.outerHeight(),
      c = d.parents("ul");
    c.find("li").removeClass("active"), d.parent().addClass("active");
  });
});
