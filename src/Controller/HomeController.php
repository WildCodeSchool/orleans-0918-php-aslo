<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/10/17
 * Time: 16:07
 * PHP version 7
 */

namespace Controller;



use Model\HomeAddressManager;

/**
 * Class HomeController
 *
 */
class HomeController extends AbstractController
{


    /**
     * Display item listing
     *
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function index()
    {
        $HomeManager = new HomeAddressManager($this->getPdo());
        $addresses = $HomeManager->selectAll();
        return $this->twig->render('Home/index.html.twig', ['address'=>$addresses]);
    }
}