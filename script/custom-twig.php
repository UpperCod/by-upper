<?php

class CustomTwig extends \Twig_Extension{
    function getFunctions(){
        return [
            new \Twig_SimpleFunction('getOptions', [$this,'getOptions']),
            new \Twig_SimpleFunction('getMenu', [$this,'getMenu']),
            new \Twig_SimpleFunction('isEnable', [$this,'isEnable']),
        ];
    }
    function getFilters(){
        return [
            // new \Twig_SimpleFilter('upper', [$this,'upper']),
        ];
    }
    function getOptions(){
        if(!$this->isEnable("ACF")) return false;
        if(isset($this->_options)) return $this->_options;
        return $this->_options = get_fields( 'options' );
    }
    function getMenu(){
        if(isset($this->_menu)) return $this->_menu;
        return $this->_menu = new Timber\Menu;
    }
    function isEnable($find){
        switch($find){
            case "acf":
            case "ACF":
                return function_exists("get_field");
            default:
                return function_exists($find);

        }
    }
}



add_filter( 'get_twig', function($twig){
    $twig->addExtension( new Twig_Extension_StringLoader() );
    $twig->addExtension( new CustomTwig );
    return $twig;
});