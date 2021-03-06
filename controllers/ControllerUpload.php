<?php

use Jennifer\Controller\Controller;
use Jennifer\File\SimpleImage;
use Jennifer\Sys\Globals;
use thedaysoflife\Com\Com;
use thedaysoflife\Sys\Configs;

class ControllerUpload extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Upload photos
     * @return string
     * @throws Exception
     */
    public function uploadPhotos()
    {
        $files = Globals::files("inputfile");
        $result = false;
        if ($files) {
            $image = new SimpleImage();
            $count = count($files['name']) >
            Configs::NUM_PHOTO_UPLOAD ? Configs::NUM_PHOTO_UPLOAD : count($files['name']);
            for ($i = 0; $i < $count; $i++) {
                $tempFile = $files['tmp_name'][$i];
                if ($tempFile) {
                    $fileType = exif_imagetype($tempFile);
                    $fileSize = filesize($tempFile);
                    $allowed = [IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG];

                    if (in_array($fileType, $allowed)) {
                        if ($fileSize <= Configs::PHOTO_MAX_SIZE * 1000000) {
                            list($photoDir, $name) = $this->initPhotoInfo();
                            $fullName = Com::getPhotoName($name, Configs::PHOTO_FULL_NAME);
                            $titleName = Com::getPhotoName($name, Configs::PHOTO_TITLE_NAME);
                            $thumbName = Com::getPhotoName($name, Configs::PHOTO_THUMB_NAME);

                            $image->load($tempFile);
                            $image->fit_to_width(Configs::PHOTO_FULL_WIDTH);
                            $image->save($photoDir . $fullName, 75);
                            $image->fit_to_width(Configs::PHOTO_TITLE_WIDTH);
                            $image->save($photoDir . $titleName);
                            $image->thumbnail(Configs::PHOTO_THUMB_WIDTH, Configs::PHOTO_THUMB_HEIGHT);
                            $image->save($photoDir . $thumbName);

                            $thumbURL = Com::getPhotoURL($name, Configs::PHOTO_THUMB_NAME);
                            $result .= $this->createPhotoHTML($name, $thumbURL);
                        } else {
                            $result = "File size is too big (Maximum size is " . Configs::PHOTO_MAX_SIZE . "MB)";
                        }
                    } else {
                        $result = "Invalid file extension (Only GIF, PNG, JPG, JPEG)";
                    }
                }
            }
        }

        return $result;
    }

    /**
     * Get photo dir, if not existing then create one
     * @return array
     */
    private function initPhotoInfo()
    {
        $year = date('Y');
        $month = date('m');
        $photoDir = DOC_ROOT . Configs::PHOTO_DIR . $year . "/" . $month . "/";
        if (!file_exists(str_replace('//', '/', $photoDir))) {
            mkdir(str_replace('//', '/', $photoDir), 0755, true);
        }

        $sessionID = Globals::sessionID();
        $rand = mt_rand();
        $name = $year . $month . "_" . time() . "_" . $sessionID . "_" . $rand;

        return [$photoDir, $name];
    }

    /**
     * Create photo HTML
     * @param string $name
     * @param string $thumbURL
     * @return string
     */
    private function createPhotoHTML($name, $thumbURL)
    {
        return '<li id="' . $name . '">
      							<div class="img-wrapper">
      								<img src="' . $thumbURL . '" class="photo-thumb"/>
      								<span class="glyphicon glyphicon-remove"></span>
      							</div>
      					</li>';
    }
}