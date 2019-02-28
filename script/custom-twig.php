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
            new \Twig_SimpleFunction('getField', [$this,'getField']),
            new \Twig_SimpleFunction('loadAfter', [$this,'loadAfter']),
            new \Twig_SimpleFunction('client', [$this,'client'])
        ];
    }
    
    function getFilters(){
        return [
            new \Twig_SimpleFilter('normalize', [$this,'normalize']),
            new \Twig_SimpleFilter('summary', [$this,'summary']),
        ];
    }
    function getField(...$args){
        return get_field(...$args);
    }
    function getOptions(){
        if(!$this->isEnable("ACF")) return false;
        if(isset($this->_options)) return $this->_options;
        return $this->_options = get_fields( 'options' );
    }
    function getMenu(...$args){
        return new Timber\Menu(...$args);
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
        $content = strip_tags($content,"<strong><br><a>");
        return str_replace(
            "<br /><br>",
            "<br>",
            join("<br>",explode(PHP_EOL,$content))
        );
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
    function summary($string,$max, $end = "..."){
        $string = strip_tags($string);
        $word = explode(" ",$string);
        $size = 0;
        $words = [];
        $add = "";
        foreach($word as $value){
            $size += strlen($value);
            if($max < $size){
                $add = $end;
                break;
            }else{
                $words[] = $value;
            }
        }
        return ($size ? join(" ",$words) : $string).$add;
    }
    function loadAfter($url = false,$show = true){
        $this->_loadAfter =  $this->_loadAfter ?? [
            "script" => [],
            "style"  => [],
            "ignore" => []
        ];

        $ignore = &$this->_loadAfter["ignore"];
        
        if($url){
            $type = preg_match("/\.js$/",$url) ? "script" : "style";
            if(!in_array($url,$this->_loadAfter[$type])){
                array_push($this->_loadAfter[$type],$url);
            }
            if(!$show && !in_array($url,$ignore)){
                array_push($ignore,$url);
            }
        }else{
            $html = "";
            foreach($this->_loadAfter["script"] as $url){
                if(in_array($url,$ignore)) continue;
                $html.="<script src='{$url}'></script>";
                
            }
            foreach($this->_loadAfter["style"] as $url){
                if(in_array($url,$ignore)) continue;
                $html.="<link rel='stylesheet' type='text/css' href='{$url}'>";
            }
            return $html;
        }
    }
    function client($type){
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        switch($type){
            case "chrome":
                return preg_match("/(?:chrome|crios)\/(\d+)/i",$user_agent);
                case "safari":
                return preg_match("/version\/(\d+).+?safari/i",$user_agent);
            case "firefox":
                return preg_match("/(?:firefox|fxios)\/(\d+)/i",$user_agent);
            case "iphone":
                return preg_match("/iphone(?:.+?os (\d+))?/i",$user_agent);
            case "ipad":
                return preg_match("/ipad.+?os (\d+)/i",$user_agent);
            case "ie":
                return preg_match("/(?:msie |trident.+?; rv:)(\d+)/i",$user_agent);
            case "android":
                return preg_match("/android/i",$user_agent);
            case "edge":
                return preg_match("/edge\/(\d+)/i",$user_agent);
            default:
                return false;
        }
    }
}



add_filter( 'get_twig', function($twig){
    $twig->addExtension( new Twig_Extension_StringLoader() );
    $twig->addExtension( new CustomTwig );
    return $twig;
});