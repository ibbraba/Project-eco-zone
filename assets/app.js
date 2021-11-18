/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */
const $ = require('jquery');
// this "modifies" the jquery module: adding behavior to it
// the bootstrap module doesn't export/return anything
require('bootstrap');
// any CSS you import will output into a single css file (app.scss in this case)
import './styles/app.scss';
import './styles/intg.css';
import './styles/article.css'
import './styles/responsive.css'


// start the Stimulus application
import './bootstrap';



document.addEventListener("DOMContentLoaded", function (){

    console.log("ok")

    const div = document.getElementById("selector-slide");
    const displayedDiv= div.firstChild.no

    console.log(div)
    console.log(displayedDiv)
})