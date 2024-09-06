$(function () {
  "use strict";

  // Fungsi untuk menyimpan cookie
  function setCookie(cname, cvalue, exdays) {
    const d = new Date();
    d.setTime(d.getTime() + exdays * 24 * 60 * 60 * 1000);
    const expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
  }

  // Fungsi untuk mendapatkan nilai cookie
  function getCookie(cname) {
    const name = cname + "=";
    const decodedCookie = decodeURIComponent(document.cookie);
    const ca = decodedCookie.split(";");
    for (let i = 0; i < ca.length; i++) {
      let c = ca[i];
      while (c.charAt(0) == " ") {
        c = c.substring(1);
      }
      if (c.indexOf(name) == 0) {
        return c.substring(name.length, c.length);
      }
    }
    return "";
  }

  // Fungsi untuk toggle tema berdasarkan cookie
  function toggleTheme() {
    const isDarkMode = $(".dark-mode-icon i").hasClass("bx-sun");
    $(".dark-mode-icon i").attr(
      "class",
      isDarkMode ? "bx bx-moon" : "bx bx-sun"
    );

    const newTheme = isDarkMode ? "light-theme" : "dark-theme";
    $("html").addClass(newTheme);

    // Simpan tema yang dipilih ke dalam cookie
    setCookie("simpedes-theme", newTheme, 7);
  }

  // Fungsi untuk menerapkan tema berdasarkan cookie saat halaman dimuat
  function applyThemeFromCookie() {
    const savedTheme = getCookie("simpedes-theme");

    // Jika ada tema tersimpan, terapkan tema tersebut
    if (savedTheme) {
      $("html").addClass(savedTheme);
      $(".dark-mode-icon i").attr(
        "class",
        savedTheme === "dark-theme" ? "bx bx-sun" : "bx bx-moon"
      );
    }
  }

  // Fungsi untuk toggle sidebar
  function toggleSidebar() {
    if ($(".wrapper").hasClass("toggled")) {
      $(".wrapper").removeClass("toggled");
      setCookie("sidebarToggled", "false", 7); // Simpan status ke cookie
    } else {
      $(".wrapper").addClass("toggled");
      setCookie("sidebarToggled", "true", 7); // Simpan status ke cookie
    }
  }

  applyThemeFromCookie();
  new PerfectScrollbar(".app-container"),
    new PerfectScrollbar(".header-message-list"),
    new PerfectScrollbar(".header-notifications-list"),
    $(".mobile-search-icon").on("click", function () {
      $(".search-bar").addClass("full-search-bar");
    }),
    $(".search-close").on("click", function () {
      $(".search-bar").removeClass("full-search-bar");
    }),
    $(".mobile-toggle-menu").on("click", function () {
      $(".wrapper").addClass("toggled");
    }),
    $(".dark-mode").on("click", toggleTheme),
    $(document).ready(function () {
      const toggled = getCookie("sidebarToggled");
      if (toggled === "true") {
        $(".wrapper").addClass("toggled");
      }
      $(".sidebar-wrapper").hover(
        function () {
          $(".wrapper").addClass("sidebar-hovered");
        },
        function () {
          $(".wrapper").removeClass("sidebar-hovered");
        }
      );
      $(".toggle-icon").click(toggleSidebar);
    }),
    $(document).ready(function () {
      $(window).on("scroll", function () {
        $(this).scrollTop() > 300
          ? $(".back-to-top").fadeIn()
          : $(".back-to-top").fadeOut();
      }),
        $(".back-to-top").on("click", function () {
          return (
            $("html, body").animate(
              {
                scrollTop: 0,
              },
              600
            ),
            !1
          );
        });
    }),
    $(function () {
      for (
        var e = window.location,
          o = $(".metismenu li a")
            .filter(function () {
              return this.href == e;
            })
            .addClass("")
            .parent()
            .addClass("mm-active");
        o.is("li");

      )
        o = o.parent("").addClass("mm-show").parent("").addClass("mm-active");
    }),
    $(function () {
      $("#menu").metisMenu();
    }),
    $(".chat-toggle-btn").on("click", function () {
      $(".chat-wrapper").toggleClass("chat-toggled");
    }),
    $(".chat-toggle-btn-mobile").on("click", function () {
      $(".chat-wrapper").removeClass("chat-toggled");
    }),
    $(".email-toggle-btn").on("click", function () {
      $(".email-wrapper").toggleClass("email-toggled");
    }),
    $(".email-toggle-btn-mobile").on("click", function () {
      $(".email-wrapper").removeClass("email-toggled");
    }),
    $(".compose-mail-btn").on("click", function () {
      $(".compose-mail-popup").show();
    }),
    $(".compose-mail-close").on("click", function () {
      $(".compose-mail-popup").hide();
    }),
    $(".switcher-btn").on("click", function () {
      $(".switcher-wrapper").toggleClass("switcher-toggled");
    }),
    $(".close-switcher").on("click", function () {
      $(".switcher-wrapper").removeClass("switcher-toggled");
    }),
    $("#lightmode").on("click", function () {
      $("html").attr("class", "light-theme");
      setCookie("simpedes-theme", "light-theme", 7);
    }),
    $("#darkmode").on("click", function () {
      $("html").attr("class", "dark-theme");
      setCookie("simpedes-theme", "dark-theme", 7);
    }),
    $("#semidark").on("click", function () {
      $("html").attr("class", "semi-dark");
      setCookie("simpedes-theme", "semi-dark", 7);
    }),
    $("#minimaltheme").on("click", function () {
      $("html").attr("class", "minimal-theme");
      setCookie("simpedes-theme", "minimal-theme", 7);
    }),
    // Header Colors
    $("#headercolor1").on("click", function () {
      $("html").addClass("color-header headercolor1"),
        $("html").removeClass(
          "headercolor2 headercolor3 headercolor4 headercolor5 headercolor6 headercolor7 headercolor8"
        ),
        setCookie("simpedes-color", "color-header headercolor1", 7);
    }),
    $("#headercolor2").on("click", function () {
      $("html").addClass("color-header headercolor2"),
        $("html").removeClass(
          "headercolor1 headercolor3 headercolor4 headercolor5 headercolor6 headercolor7 headercolor8"
        ),
        setCookie("simpedes-color", "color-header headercolor2", 7);
    }),
    $("#headercolor3").on("click", function () {
      $("html").addClass("color-header headercolor3"),
        $("html").removeClass(
          "headercolor1 headercolor2 headercolor4 headercolor5 headercolor6 headercolor7 headercolor8"
        ),
        setCookie("simpedes-color", "color-header headercolor3", 7);
    }),
    $("#headercolor4").on("click", function () {
      $("html").addClass("color-header headercolor4"),
        $("html").removeClass(
          "headercolor1 headercolor2 headercolor3 headercolor5 headercolor6 headercolor7 headercolor8"
        ),
        setCookie("simpedes-color", "color-header headercolor4", 7);
    }),
    $("#headercolor5").on("click", function () {
      $("html").addClass("color-header headercolor5"),
        $("html").removeClass(
          "headercolor1 headercolor2 headercolor4 headercolor3 headercolor6 headercolor7 headercolor8"
        ),
        setCookie("simpedes-color", "color-header headercolor5", 7);
    }),
    $("#headercolor6").on("click", function () {
      $("html").addClass("color-header headercolor6"),
        $("html").removeClass(
          "headercolor1 headercolor2 headercolor4 headercolor5 headercolor3 headercolor7 headercolor8"
        ),
        setCookie("simpedes-color", "color-header headercolor6", 7);
    }),
    $("#headercolor7").on("click", function () {
      $("html").addClass("color-header headercolor7"),
        $("html").removeClass(
          "headercolor1 headercolor2 headercolor4 headercolor5 headercolor6 headercolor3 headercolor8"
        ),
        setCookie("simpedes-color", "color-header headercolor7", 7);
    }),
    $("#headercolor8").on("click", function () {
      $("html").addClass("color-header headercolor8"),
        $("html").removeClass(
          "headercolor1 headercolor2 headercolor4 headercolor5 headercolor6 headercolor7 headercolor3"
        ),
        setCookie("simpedes-color", "color-header headercolor8", 7);
    }),
    $("#headercolor9").on("click", function () {
      $("html").addClass("color-header headercolor9"),
        $("html").removeClass(
          "headercolor1 headercolor2 headercolor4 headercolor5 headercolor6 headercolor7 headercolor3"
        ),
        setCookie("simpedes-color", "", 7);
    });

  // Sidebar colors
  $("#sidebarcolor1").click(theme1);
  $("#sidebarcolor2").click(theme2);
  $("#sidebarcolor3").click(theme3);
  $("#sidebarcolor4").click(theme4);
  $("#sidebarcolor5").click(theme5);
  $("#sidebarcolor6").click(theme6);
  $("#sidebarcolor7").click(theme7);
  $("#sidebarcolor8").click(theme8);
  $("#sidebarcolor9").click(theme9);

  function theme1() {
    $("html").addClass("color-sidebar sidebarcolor1"),
      $("html").removeClass(
        "sidebarcolor2 sidebarcolor3 sidebarcolor4 sidebarcolor5 sidebarcolor6 sidebarcolor7 sidebarcolor8"
      ),
      setCookie("sidebarColor", "color-sidebar sidebarcolor1", 7);
  }

  function theme2() {
    $("html").addClass("color-sidebar sidebarcolor2"),
      $("html").removeClass(
        "sidebarcolor1 sidebarcolor3 sidebarcolor4 sidebarcolor5 sidebarcolor6 sidebarcolor7 sidebarcolor8"
      ),
      setCookie("sidebarColor", "color-sidebar sidebarcolor2", 7);
  }

  function theme3() {
    $("html").addClass("color-sidebar sidebarcolor3"),
      $("html").removeClass(
        "sidebarcolor1 sidebarcolor2 sidebarcolor4 sidebarcolor5 sidebarcolor6 sidebarcolor7 sidebarcolor8"
      ),
      setCookie("sidebarColor", "color-sidebar sidebarcolor3", 7);
  }

  function theme4() {
    $("html").addClass("color-sidebar sidebarcolor4"),
      $("html").removeClass(
        "sidebarcolor1 sidebarcolor2 sidebarcolor3 sidebarcolor5 sidebarcolor6 sidebarcolor7 sidebarcolor8"
      ),
      setCookie("sidebarColor", "color-sidebar sidebarcolor4", 7);
  }

  function theme5() {
    $("html").addClass("color-sidebar sidebarcolor5"),
      $("html").removeClass(
        "sidebarcolor1 sidebarcolor2 sidebarcolor3 sidebarcolor4 sidebarcolor6 sidebarcolor7 sidebarcolor8"
      ),
      setCookie("sidebarColor", "color-sidebar sidebarcolor5", 7);
  }

  function theme6() {
    $("html").addClass("color-sidebar sidebarcolor6"),
      $("html").removeClass(
        "sidebarcolor1 sidebarcolor2 sidebarcolor3 sidebarcolor4 sidebarcolor5 sidebarcolor7 sidebarcolor8"
      ),
      setCookie("sidebarColor", "color-sidebar sidebarcolor6", 7);
  }

  function theme7() {
    $("html").addClass("color-sidebar sidebarcolor7"),
      $("html").removeClass(
        "sidebarcolor1 sidebarcolor2 sidebarcolor3 sidebarcolor4 sidebarcolor5 sidebarcolor6 sidebarcolor8"
      ),
      setCookie("sidebarColor", "color-sidebar sidebarcolor7", 7);
  }

  function theme8() {
    $("html").addClass("color-sidebar sidebarcolor8"),
      $("html").removeClass(
        "sidebarcolor1 sidebarcolor2 sidebarcolor3 sidebarcolor4 sidebarcolor5 sidebarcolor6 sidebarcolor7"
      ),
      setCookie("sidebarColor", "color-sidebar sidebarcolor8", 7);
  }
  function theme9() {
    $("html").removeClass(
      "color-sidebar sidebarcolor1 sidebarcolor2 sidebarcolor3 sidebarcolor4 sidebarcolor5 sidebarcolor6 sidebarcolor7 sidebarcolor8"
    ),
      setCookie("sidebarColor", "", 7);
  }
});
