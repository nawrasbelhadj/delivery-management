/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.scss in this case)
import './css/app.scss';

// start the Stimulus application
import './bootstrap';
// loads the jquery package from node_modules
import $ from 'jquery';


import greet from './greet';

$(document).read(function (){
    $('body').prepend('<h1>'+greet('jill')+ '</h1>');
});