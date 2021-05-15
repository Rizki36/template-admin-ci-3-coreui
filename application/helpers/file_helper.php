<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('upload_file')) {

    /**
     * @param FILES $file berupa input file dengan nama ex. $_FILES['namainput']
     * @param string $path path upload file ex. 'assets/img/cabang'
     * @param string $name nama file pada database
     * @param string $allowed_types jenis file yang diperbolehkan ex. 'doc|docx|pdf|png|gif|jpg|jpeg|bmp'
     * @param string $conf config tambahan
     * @return string return digunakan untuk nama file pada database
     */

    function insert_file($file, $path, $name, $allowed_types = 'doc|docx|pdf|png|gif|jpg|jpeg|bmp', $conf = [])
    {
        if (!empty($file['name'])) {
            $CI = get_instance();
            $CI->load->library('upload');

            // config tambahan
            $config = $conf;

            // required config
            $config['upload_path'] = "./$path";
            $config['file_name'] = $name;
            $config['allowed_types'] = $allowed_types;

            $CI->upload->initialize($config);

            $_FILES['MYFILE'] = $file;

            if ($CI->upload->do_upload('MYFILE')) {
                $gbr = $CI->upload->data();
                $file_name = $gbr['file_name'];
            } else {
                $file_name = '';
            }
        } else {
            $file_name = '';
        }

        return $file_name;
    }
}

if (!function_exists('update_file')) {
    /**
     * @param FILES $file berupa input file dengan nama ex. $_FILES['namainput']
     * @param string $path path upload file ex. 'assets/img/cabang'
     * @param string $name nama file pada database
     * @param string $old_name nama file yang sudah ada pada database
     * @param string $allowed_types jenis file yang diperbolehkan ex. 'doc|docx|pdf|png|gif|jpg|jpeg|bmp'
     * @param string $conf config tambahan
     * @return string return digunakan untuk nama file pada database
     */
    function update_file($file, $path, $name, $old_name, $allowed_types = 'doc|docx|pdf|png|gif|jpg|jpeg|bmp', $conf = [])
    {
        if (!empty($file['name']) && $file['name'] != '') {
            $CI = get_instance();
            $CI->load->library('upload');

            // config tambahan
            $config = $conf;

            // required config
            $config['upload_path'] = "./$path";
            $config['file_name'] = $name;
            $config['allowed_types'] = $allowed_types;

            $CI->upload->initialize($config);

            $_FILES['MYFILE'] = $file;

            if ($CI->upload->do_upload('MYFILE')) {
                $gbr = $CI->upload->data();
                $file_name = $gbr['file_name'];
                $path = realpath(APPPATH . "../$path/$old_name");
                if (file_exists($path) && $old_name != '') {
                    unlink($path);
                }
            }
        } else {
            $file_name = $old_name;
        }
        return $file_name;
    }
}

if (!function_exists('delete_file')) {
    /**
     * @param string $path path file ex. 'assets/img/cabang'
     * @param string $name nama file pada database
     * @return bool return status
     */

    function delete_file($path, $name)
    {
        $path = realpath(APPPATH . "../$path/$name");
        if (file_exists($path)) {
            unlink($path);
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists('create_thumbnail')) {
    /**
     * @param string $path path upload file ex. 'assets/img/cabang'
     * @param string $name nama file pada database
     * @return void
     */
    function create_thumbnail($file, $path, $name)
    {
        if (!empty($file['name'])) {
            $CI = get_instance();
            // Image resizing config
            $config = [
                'image_library'  => 'GD2',
                'source_image'   => "./$path/$name",
                'maintain_ratio' => true,
                'width'          => 500,
                'height'         => 400,
                'new_image'      => "./$path/thum_$name"
            ];

            $CI->load->library('image_lib', $config);
            $CI->image_lib->initialize($config);

            if (!$CI->image_lib->resize()) {
                return false;
            }

            $CI->image_lib->clear();
        }
    }
}

if (!function_exists('update_thumbnail')) {
    /**
     * @param FILES $file berupa input file dengan nama ex. $_FILES['namainput']
     * @param string $path path upload file ex. 'assets/img/cabang'
     * @param string $name nama file pada database
     * @param string $old_name nama file yang sudah ada pada database
     * @return void
     */
    function update_thumbnail($file, $path, $name, $old_name)
    {
        if (!empty($file['name']) && $file['name'] != '') {
            $realpath = realpath(APPPATH . "../$path/thum_$old_name");
            if (file_exists($realpath) && $old_name != '') {
                unlink($realpath);
            }

            create_thumbnail($file, $path, $name);
        }
    }
}


if (!function_exists('load_image')) {
    /**
     * @param string $path path file ex. 'assets/img/cabang'
     * @param string $name nama file pada database
     * @return string return path file
     */

    function load_image($path, $name)
    {
        $imgpath = "$path/$name";
        $realpath = realpath(APPPATH . "../$imgpath");

        $imgNotFound = "assets/img/no_image.jpg";

        if (file_exists($realpath) && $name != null) {
            return base_url($imgpath);
        } else {
            return base_url($imgNotFound);
        }
    }
}

if (!function_exists('getYoutubeEmbedLink')) {
    function getYoutubeEmbedLink($url)
    {
        $shortUrlRegex = '/youtu.be\/([a-zA-Z0-9_]+)\??/i';
        $longUrlRegex = '/youtube.com\/((?:embed)|(?:watch))((?:\?v\=)|(?:\/))(\w+)/i';
        $youtube_id = '';
        if (preg_match($longUrlRegex, $url, $matches)) {
            $youtube_id = $matches[count($matches) - 1];
        }

        if (preg_match($shortUrlRegex, $url, $matches)) {
            $youtube_id = $matches[count($matches) - 1];
        }
        return 'https://www.youtube.com/embed/' . $youtube_id;
    }
}
