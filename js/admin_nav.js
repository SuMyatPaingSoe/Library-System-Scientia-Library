var menu_btn = document.querySelector('#menu-btn');
var sidebar = document.querySelector('#sidebar');
var container = document.querySelector(".my-container");

menu_btn.addEventListener("click", () => {
    sidebar.classList.toggle("active-nav")
    // container.classList.toggle("active-cont")
});


document.addEventListener('mouseup', function(e) {
    var container = document.getElementById('sidebar');
    if (!container.contains(e.target)) {
        sidebar.classList.remove("active-nav")
    }
});

document.addEventListener("DOMContentLoaded", function() {

    document.querySelectorAll('#sidebar .nav-link').forEach(function(element) {

        element.addEventListener('click', function(e) {

            let nextEl = element.nextElementSibling;
            let parentEl = element.parentElement;

            if (nextEl) {
                e.preventDefault();
                let mycollapse = new bootstrap.Collapse(nextEl);

                if (nextEl.classList.contains('show')) {
                    mycollapse.hide();
                } else {
                    mycollapse.show();
                    // find other submenus with class=show
                    var opened_submenu = parentEl.parentElement.querySelector('.submenu.show');
                    // if it exists, then close all of them
                    if (opened_submenu) {
                        new bootstrap.Collapse(opened_submenu);
                    }

                }
            }

        });
    })

});