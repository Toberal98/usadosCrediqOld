<?php

class ImageUploader
{

    /**
     * Redimensionar imagen de vehículo.
     * Redimensiona y almacena en FS la imagen de un vehículo
     * Retorna el filename de la imagen y el url de la misma
     * @param  mixed       $data
     * @param  int         $width
     * @param  int         $height
     * @param  string|null $path
     * @param  boolean     $overwrite
     * @return string
     */
    public function doCarResizedImage(
        $data, $desired_width, $desired_height, $path = null, $overwrite = false
    ) {
        if (isset($data['imagen_path'])) {
            $imagen_path = $data['imagen_path'];
        } else {
            $imagen_path = $this->getCarImageFilename($data);
        }

        $image_dir = "imagenes/{$desired_width}x{$desired_height}/";
        $cached_path = FCPATH . "{$image_dir}";
        $cached_file = "{$cached_path}{$imagen_path}";
        $url = get_instance()->config->base_url("{$image_dir}{$imagen_path}");
        $write_file = !is_file($cached_path) || $overwrite;

        if ($write_file) {
            if (!is_dir($cached_path)) {
                $umask = umask(0);
                mkdir($cached_path, 777);
                umask($umask);
            }

            $source_file = FCPATH . "imagenes/original/{$imagen_path}";

            if ($data['imagen_file']) {
                $source = imagecreatefromstring($data['imagen_file']);
                $width = imagesx($source);
                $height = imagesy($source);
            } else {
                $source = imagecreatefromjpeg($source_file);
                list($width, $height) = getimagesize($source_file);
            }

            $width_based = ceil($height / $width * $desired_width);
            $height_based = ceil($width / $height * $desired_height);

            if ($width_based < $desired_height) {
                $dst_width = $height_based;
                $dst_height = ceil($height / $width * $height_based);
            } elseif ($height_based < $desired_width) {
                $dst_width = ceil($width / $height * $width_based);
                $dst_height = $width_based;
            } else {
                $dst_width = $height_based;
                $dst_height = $width_based;
            }

            $dest = imagecreatetruecolor($desired_width, $desired_height);

            $x = ceil(($desired_width - $dst_width) / 2);
            $y = ceil(($desired_height - $dst_height) / 2);

            imagecopyresampled(
                $dest, $source,
                $x, $y, 0, 0,
                $dst_width, $dst_height, $width, $height
            );
            imagejpeg($dest, $cached_file, 100);
        }

        return $url;
    }

    /**
     * Computar nombre de imagen a partir de datos.
     * @param  array $data
     * @return string
     */
    public function getCarImageFilename($data)
    {
        list($mime, $extension) = explode('/', $data['header']);
        $extension = strtolower(str_replace('e', '', $extension));

        return implode('-', array(
            $data['codigo_vehiculo'],
            $data['codigo_tipo_foto'],
            $data['desc_tipo_foto'],
        )) . ".{$extension}";
    }

}
