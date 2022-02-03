<?php

use Config\Services;

if (!function_exists('load_alerts'))
{
    /**
    * Returns standard folders for Class and namespace. For templating
    */
    function load_alerts($session) {
        $html = '';
        if(is_array($session) && count($session) > 0) {
            $html .= '<div class="message is-danger">
                        <div class="message-body">
                            <ul>';
                            foreach ($session as $error) :
                                $html .= '<li>'.$error.'</li>';
                            endforeach;
            $html .= '      </ul>
                        </div>
                    </div>';
        }
        else if($session->has('errors')) {
            $html .= '<div class="message is-danger">
                        <div class="message-body">
                            <ul>';
                            foreach ($session->get('errors') as $error) :
                                $html .= '<li>'.$error.'</li>';
                            endforeach;
            $html .= '      </ul>
                        </div>
                    </div>';
        }
        else if ($session->has('success')) {
            $html .= '<div class="alert alert-fill alert-success alert-icon">
                        <em class="icon ni ni-check-circle"></em>
                        <strong>'.session('success').'</strong>
                    </div>';
        }
        else if($session->has('error')) {
            $html .= '<div class="alert alert-fill alert-danger alert-icon">
                            <em class="icon ni ni-check-circle"></em>
                            <strong>'.session('error').'</strong>
                    </div>';
        }
        else if($session->has('info')) {
            $html .= '<div class="alert alert-fill alert-info alert-icon">
                        <em class="icon ni ni-check-circle"></em>
                        <strong>'.session('info').'</strong>
                    </div>';
        }
        return $html;
    }
}
