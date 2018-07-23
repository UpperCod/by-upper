<?php

class CustomTwig extends \Twig_Extension{
    function getFunctions(){
        return [
            new \Twig_SimpleFunction('getMenu', [$this,'getMenu']),
            new \Twig_SimpleFunction('getPost', [$this,'getPost']),
            new \Twig_SimpleFunction('getPosts', [$this,'getPosts']),
            new \Twig_SimpleFunction('getTerm', [$this,'getTerm']),
            new \Twig_SimpleFunction('getTerms', [$this,'getTerms']),
            new \Twig_SimpleFunction('setAttrs', [$this,'setAttrs']),
            new \Twig_SimpleFunction('isEnable', [$this,'isEnable']),
            new \Twig_SimpleFunction('getOptions', [$this,'getOptions']),
            new \Twig_SimpleFunction('getClassBody', [$this,'getClassBody']),
            new \Twig_SimpleFunction('setStyleInline', [$this,'setStyleInline']),
        ];
    }
    function getFilters(){
        return [
            new \Twig_SimpleFilter('normalize', [$this,'normalize']),
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
    function getPosts($query){
        return Timber\Timber::get_posts($query);
    }
    function getTerm($query=null, $tax = null){
        return new Timber\Term($query,$tax);
    }
    function getTerms($type, $query=null){
        return Timber\Timber::get_terms($type,$query);
    }
    function getPost($post){
        return new Timber\Post($post);
    }
    function getClassBody(...$append){
        return join(" ",array_merge(get_body_class(), $append));
    }
    function setStyleInline(array $style){
        $props = [];
        foreach($style as $index => $value){
            if($value){
                $props[] = $index.":".$value;
            }
        }
        return count($props) > 0 ? "style=\"".join("; ",$props)."\"" : "";
    }
    function setAttrs(array $attrs,$prefix = ""){
        $props = [];
        $prefix = $prefix ? "{$prefix}-" : $prefix;
        foreach($attrs as $index => $value ){
            switch($index){
                case "style":
                    $style = $this->setStyleInline($value);
                    if($style) $props[] = $style;
                break;
                default:
                    if(is_array($value)){
                        $props[] = $this->setAttrs($value,$prefix.$index);
                    }else{
                        if( is_bool($value) ){
                            if($value){
                                $props[] = "{$prefix}{$index}";
                            }
                        }else{
                            $props[] = "{$prefix}{$index}".($value ? "=\"{$value}\"" : "");
                        }
                    }
            }
        }
        return join(" ",$props);
    }
    function normalize($content){
        $content = strip_tags($content,"<strong><br>");
        return join("<br>",explode(PHP_EOL,$content));
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