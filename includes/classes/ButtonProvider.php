<?php

    class ButtonProvider{
        public static function createButton($text, $imageSrc, $action, $class){

            $image = ($imageSrc == null) ? "" : "<img src='$imageSrc'>";

            return "
                <button class='$class btn btn-light' type='button' onclick='$action'>
                    $image
                    <span class='text'>$text</span>                
                </button>
            ";
        }
    }



?>