<?php

global $phar;
$phar = false;

$file = Phar::running(false);
if(!$file)
    $file = __FILE__;

$path = binford_find_path($file);

function binford_find_path($path){
    if(file_exists($path . '/wp-load.php'))
        return $path;
    if($path == '/')
        throw new Exception("Error! Binford cannot find WordPress!\n", 1);
    return binford_find_path(dirname($path));
}

require_once( $path . '/wp-load.php' );
require_once( $path . '/wp-admin/includes/admin.php' );

if(!is_array($argv) || empty($argv))
    throw new Exception("Error! You can only use Binford from the command line!\n", 1);

array_shift($argv);

binford_run($argv);

function binford_run($ids = array()){

    $args = array(
        'post_type' => 'acf',
        'nopaging' => true
    );

    if(!empty($ids))
        $args['post__in'] = $ids;

    if(!is_array($ids))
        throw new Exception("Error! Can only pass IDs as an Array!\n", 1);

    $query = new WP_Query($args);

    while($query->have_posts()){
        $query->the_post();
        $rules = get_post_meta($query->post->ID, 'rule');
        
        if(!empty($rules)){
            foreach($rules as $rule){
                $single_php = null;
                $single_tpl = null;
                if($rule['param'] == 'post_type' && $rule['operator'] == '=='){
                    $single_php = get_template_directory() . '/single-' . $rule['value'] . '.php';
                    $single_tpl = get_template_directory() . '/templates/pages/single-' . $rule['value'] . '.tpl';
                    if(in_array($rule['value'], array('page'))){
                        $single_php = get_template_directory() . '/' . $rule['value'] . '.php';
                        $single_tpl = get_template_directory() . '/templates/pages/' . $rule['value'] . '.tpl';
                    }
                    if(in_array($rule['value'], array('post'))){
                        $single_php = get_template_directory() . '/single.php';
                        $single_tpl = get_template_directory() . '/templates/pages/single.tpl';
                    }
                }
                if($rule['param'] == 'page_template' && $rule['operator'] == '=='){
                    $single_php = get_template_directory() . '/' . $rule['value'];
                    $php_contents = file_get_contents($single_php);
                    $start = strpos($php_contents, "\$smarty->display(") + 18;
                    $substr = substr($php_contents, $start);
                    $end = strpos($substr, ");") - 1;
                    $substr = substr($substr, 0, $end);
                    $single_tpl = get_template_directory() . '/templates/' . $substr;
                }
                if($single_php && $single_tpl){
                    $meta = get_post_meta($query->post->ID);
                    
                    foreach($meta as $k => $v){
                        if(strpos($k, "field_") === 0){
                            $name = '';
                            $label = '';
                            $php_image = null;

                            $properties = unserialize($v[0]);
                            
                            $name = $properties['name'];
                            $label = $properties['label'];

                            switch ($properties['type']) {
                                case 'checkbox':
                                    //the basic ones with an array
                                    $php = 'partials/basic.php';
                                    $tpl = 'partials/array.tpl';
                                    break;
                                case 'color_picker':
                                case 'email':
                                case 'number':
                                case 'password':
                                case 'radio':
                                case 'text':
                                case 'textarea':
                                case 'true_false':
                                case 'wysiwyg':
                                    //the basic ones
                                    $php = 'partials/basic.php';
                                    $tpl = 'partials/basic.tpl';
                                    break;
                                case 'file':
                                    //the basic ones
                                    $php = 'partials/file.php';
                                    $tpl = 'partials/file.tpl';
                                    break;
                                case 'image':
                                    //the basic ones
                                    $php = 'partials/image.php';
                                    $tpl = 'partials/basic.tpl';
                                    $php_image = 'partials/image-size.php';
                                    break;
                                case 'page_link':
                                case 'select':
                                    //could be a sinlge or multiple
                                    $php = 'partials/basic.php';
                                    if(isset($properties['multiple']) && $properties['multiple'])
                                        $tpl = 'partials/array.tpl';
                                    else
                                        $tpl = 'partials/basic.tpl';
                                    break;
                                case 'post_object':
                                    //a little extra for the permalink
                                    $php = 'partials/post_object.php';
                                    if(isset($properties['multiple']) && $properties['multiple'])
                                        $tpl = 'partials/post_object_array.tpl';
                                    else
                                        $tpl = 'partials/post_object.tpl';
                                    break;
                                case 'relationship':
                                    //a little extra for the permalink
                                    $php = 'partials/post_object.php';
                                    $tpl = 'partials/post_object_array.tpl';
                                    break;
                                case 'repeater':
                                    //a little extra for the permalink
                                    $php = 'partials/basic.php';
                                    $tpl = 'partials/repeater.tpl';
                                    break;

                                case 'taxonomy':
                                    $php = 'partials/basic.php';
                                    if(isset($properties['return_format']) && $properties['return_format'] == 'object'){
                                        if(isset($properties['field_type']) && ($properties['field_type'] == 'checkbox' || $properties['field_type'] == 'multi_select') ){
                                            $tpl = 'partials/taxonomy_array.tpl';
                                        }else{
                                            $tpl = 'partials/taxonomy.tpl';
                                        }
                                    }else{
                                        if(isset($properties['field_type']) && ($properties['field_type'] == 'checkbox' || $properties['field_type'] == 'multi_select') ){
                                            $tpl = 'partials/array.tpl';
                                        }else{
                                            $tpl = 'partials/basic.tpl';
                                        }
                                    }
                                    break;

                                case 'user':
                                    //user
                                    $php = 'partials/basic.php';
                                    $tpl = 'partials/user.tpl';
                                    break;

                                default:
                                    $php = null;
                                    $tpl = null;
                                    break;
                            }
                            if($php && $tpl){

                                global $phar;
                                if($phar){
                                    $php = "phar://binford.phar/$php";
                                    $tpl = "phar://binford.phar/$tpl";
                                }

                                $e = explode('/', $single_php);
                                $php_file = array_pop($e);
                                if($php_file == 'page.php'){
                                    $files = new DirectoryIterator(implode('/', $e));
                                    foreach($files as $f){
                                        $single_php_sub = null;
                                        $single_tpl_sub = null;
                                        $filename = $f->getFilename();
                                        if($f->isFile()){
                                            if(strpos($filename, 'page-') !== false){
                                                //$filename IS a page template!
                                                $single_php_sub = implode('/', $e) . '/' . $filename;

                                                $php_contents = file_get_contents($single_php_sub);
                                                $start = strpos($php_contents, "\$smarty->display(") + 18;
                                                $substr = substr($php_contents, $start);
                                                $end = strpos($substr, ");") - 1;
                                                $substr = substr($substr, 0, $end);
                                                $single_tpl_sub = get_template_directory() . '/templates/' . $substr;

                                                if($single_php_sub && $single_tpl_sub){
                                                    binford_add_php($php, $single_php_sub, $k, $name, $label);

                                                    if($php_image){
                                                        $php_image_path = $php_image;
                                                        if($phar)
                                                            $php_image_path = "phar://binford.phar/$php_image";
                                                        binford_add_image_size($php_image_path, $single_php_sub, $k, $name, $label);
                                                    }
                                                    binford_add_tpl($tpl, $single_tpl_sub, $k, $name, $label);
                                                }
                                            }
                                        }
                                    }
                                }

                                binford_add_php($php, $single_php, $k, $name, $label);

                                if($php_image){
                                    $php_image_path = $php_image;
                                    if($phar)
                                        $php_image_path = "phar://binford.phar/$php_image";
                                    binford_add_image_size($php_image_path, $single_php, $k, $name, $label);
                                }
                                binford_add_tpl($tpl, $single_tpl, $k, $name, $label);
                            }
                        }
                    }
                }
            }
        }
    }
}

function binford_add_php($template, $destination, $key, $name, $label){
    $output_lines = array();
    $contents = array();
    $start_at = 0;
    if(file_exists($destination)){
        $fc = fopen($destination, "r");
        if($fc){
            while(!feof($fc)){
                $line = fgets($fc, 4096);
                if( strpos($line, 'get_header()') !== false && $start_at == 0 ){
                    $start_at = count($contents);
                }

                $contents[] = $line;

                if(strpos($line, '//binford:field_') !== false){
                    $start_at = count($contents);
                }
            }
            fclose($fc);
            if($start_at == 0)
                $start_at = count($contents);
        }

        $before = array();
        $after = array();

        if($start_at){
            $before = array_slice($contents, 0, $start_at);
            $after = array_slice($contents, $start_at);
        }

        $contents = array();
        $fc = fopen($template, "r");
        if($fc){
            while(!feof($fc)){
                $line = fgets($fc, 4096);
                $line = str_replace('[[field_name]]', $name, $line);
                $line = str_replace('[[field_label]]', $label, $line);
                $line = str_replace('[[field_key]]', $key, $line);
                $contents[] = $line;
            }
            fclose($fc);
        }

        $output = implode("", array_merge($before, $contents, $after));
        file_put_contents($destination, $output);
    }
}

function binford_add_image_size($template, $destination, $key, $name, $label){
    $output_lines = array();
    $contents = array();
    $start_at = 0;
    if(file_exists($destination)){
        $fc = fopen($destination, "r");
        if($fc){
            while(!feof($fc)){
                $line = fgets($fc, 4096);
                if( strpos($line, '$smarty = wp_smarty();') !== false && $start_at == 0 ){
                    $start_at = count($contents);
                }

                $contents[] = $line;
            }
            fclose($fc);
            if($start_at == 0)
                $start_at = count($contents);
        }

        $before = array();
        $after = array();

        if($start_at){
            $before = array_slice($contents, 0, $start_at);
            $after = array_slice($contents, $start_at);
        }

        $contents = array();
        $fc = fopen($template, "r");
        if($fc){
            while(!feof($fc)){
                $line = fgets($fc, 4096);
                $line = str_replace('[[field_name]]', $name, $line);
                $line = str_replace('[[field_label]]', $label, $line);
                $line = str_replace('[[field_key]]', $key, $line);
                $contents[] = $line;
            }
            fclose($fc);
        }

        $output = implode("", array_merge($before, $contents, $after));
        file_put_contents($destination, $output);
    }

}

function binford_add_tpl($template, $destination, $key, $name, $label){
    $output_lines = array();
    $contents = array();
    $start_at = 0;
    if(file_exists($destination)){
        $fc = fopen($destination, "r");
        if($fc){
            while(!feof($fc)){
                $line = fgets($fc, 4096);
                if( ( strpos($line, '<div class=\'container\'>') !== false || strpos($line, '<div class="container">') !== false ) && $start_at == 0 ){
                    $start_at = count($contents)+1;
                }

                $contents[] = $line;

                if(strpos($line, '{* binford:field_') !== false){
                    $start_at = count($contents)-1;
                }
            }
            fclose($fc);
            if($start_at == 0)
                $start_at = count($content);
        }

        $before = array();
        $after = array();

        if($start_at){
            $before = array_slice($contents, 0, $start_at);
            $after = array_slice($contents, $start_at);
        }

        $contents = array();
        $fc = fopen($template, "r");
        if($fc){
            while(!feof($fc)){
                $line = fgets($fc, 4096);
                $line = str_replace('[[field_name]]', $name, $line);
                $line = str_replace('[[field_label]]', $label, $line);
                $line = str_replace('[[field_key]]', $key, $line);
                $contents[] = $line;
            }
            fclose($fc);
        }

        $output = implode("", array_merge($before, $contents, $after));
        file_put_contents($destination, $output);
    }

}