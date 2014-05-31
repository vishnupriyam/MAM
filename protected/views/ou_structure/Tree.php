<?php

$this->widget('application.widgets.JsTreeWidget',
             array('modelClassName' => 'Ou_structure',
                     'jstree_container_ID' => 'Ou_structure-wrapper',
                     'themes' => array('theme' => 'classic', 'dots' => true, 'icons' => false),
                     'plugins' => array('themes', 'html_data', 'contextmenu','search','crrm', 'dnd', 'cookies', 'ui'), 
             ));
?>
