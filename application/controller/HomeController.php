<?php


namespace DattaConsulting\CloudInitIso\Controller;


use Twig\Environment;
use Twig\Loader\ArrayLoader;
use Twig\Loader\FilesystemLoader;

class HomeController
{
    public function index() {

        $twig = new Environment(new FilesystemLoader('../template/'), []);
        echo $twig->render('home.html.twig');

    }
}
