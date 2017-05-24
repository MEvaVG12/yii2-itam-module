/**
 * Created by joao on 21/05/17.
 */

var
    // menuLeft = document.getElementById('cbp-spmenu-s1'),
    // showLeft = document.getElementById('showMenuLeft'),

    menuRight = document.getElementById('cbp-spmenu-s2'),
    showRight = document.getElementById('showMenuRight'),

    itamModule = document.getElementById('itamModule'),
    body = document.body;

console.log(itamModule);

body.classList.add('cbp-spmenu-push');

/*showLeft.onclick = function () {
    menuLeft.classList.toggle('cbp-spmenu-open');
};*/

showRight.onclick = function (e) {
    e.stopPropagation();
    body.classList.toggle('cbp-spmenu-push-toleft');
    menuRight.classList.toggle('cbp-spmenu-open');
};

itamModule.onclick = function (e) {
    if (body.classList.contains('cbp-spmenu-push-toleft')) {
        e.stopPropagation();
        body.classList.remove('cbp-spmenu-push-toleft');
        menuRight.classList.remove('cbp-spmenu-open');
    }
};

