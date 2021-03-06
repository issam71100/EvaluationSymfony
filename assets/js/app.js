/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
import 'bootstrap/dist/css/bootstrap.min.css';
import 'slick-carousel/slick/slick-theme.css';
import 'slick-carousel/slick/slick.css';
require('../css/app.css');
import ArtworkForm from "./ArtworkForm";
import FileUpload from "./FileUpload";
import CategoryFilter from "./CategoryFilter";
import SlickSlider from "./SlickSlider";

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
import 'bootstrap';
import 'slick-carousel';

const $ = require('jquery');

console.log('Hello Webpack Encore! Edit me in assets/js/app.js');

const artworkForm = new ArtworkForm();
const fileUplaod = new FileUpload();
const categoryFilter = new CategoryFilter();
const slickSlider = new SlickSlider($);
