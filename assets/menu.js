/**
 * Created by joao on 21/05/17.
 */

var menuLeft = document.getElementById('cbp-spmenu-s1'),
    showLeft = document.getElementById('showMenuLeft'),
    body = document.getElementsByClassName('itam-module');

showLeft.onclick = function () {
    menuLeft.classList.toggle('active');
    menuLeft.classList.toggle('cbp-spmenu-open');
};

body.onclick = function () {
    menuLeft.classList.remove('active', 'cbp-spmenu-open');
};

